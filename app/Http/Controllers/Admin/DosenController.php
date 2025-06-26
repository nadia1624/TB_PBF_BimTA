<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;
use App\Models\BidangKeahlian;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\DetailBidang;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $bidang_keahlian = BidangKeahlian::all();
        $dosenQuery = Dosen::with([
        'user',
        'detailBidang.bidangKeahlian',
        'detailDosen.pengajuanJudul.mahasiswa',
        ]);

    // Filter berdasarkan bidang keahlian jika ada
    if ($request->has('bidang') && $request->bidang !== 'all') {
        $bidangId = $request->bidang;
        $dosenQuery->whereHas('detailBidang', function($query) use ($bidangId) {
            $query->where('bidang_keahlian_id', $bidangId);
        });
    }

    $dosen = Dosen::with('detailDosen.pengajuanJudul.mahasiswa')->get();

    foreach ($dosen as $item) {
        $mahasiswaList = [];

        foreach ($item->detailDosen ?? [] as $detail) {
            if (
                strtolower($detail->status ?? '') === 'diterima' &&
                $detail->pengajuanJudul &&
                $detail->pengajuanJudul->mahasiswa
            ) {
                $mahasiswa = $detail->pengajuanJudul->mahasiswa;
                $mahasiswaList[$mahasiswa->id] = $mahasiswa; // pakai ID sebagai key untuk hindari duplikat
            }
        }

        // Simpan ke properti dosen
        $item->mahasiswa_bimbingan = collect($mahasiswaList)->values(); // konversi ke collection indexed
        $item->mahasiswa_count = $item->mahasiswa_bimbingan->count();
    }


    return view('admin.dosen.index', compact('dosen', 'bidang_keahlian'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_keahlian' => 'required|string|max:100|unique:bidang_keahlian,nama_keahlian'
        ], [
            'nama_keahlian.required' => 'Nama keahlian wajib diisi',
            'nama_keahlian.unique' => 'Nama keahlian sudah ada'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $bidang = new BidangKeahlian();
            $bidang->nama_keahlian = $request->nama_keahlian;
            $bidang->save();

            return redirect()->route('admin.dosen')
                ->with('success', 'Bidang keahlian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal menambahkan bidang keahlian: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:dosen,nip',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'bidang_keahlian_id' => 'required|array|exists:bidang_keahlian,id',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'bidang_keahlian_id.required' => 'Bidang keahlian wajib dipilih',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator)
                ->withInput()
                ->with('openModal', 'tambahDosenModal');
        }

        DB::beginTransaction();

        try {
            // Create user first
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'dosen';
            $user->save();

            // Create lecturer data with user relation
            $dosen = new Dosen();
            $dosen->user_id = $user->id;
            $dosen->nip = $request->nip;
            $dosen->nama_lengkap = $request->nama_lengkap;
            $dosen->save();

            // Create expertise relation
            foreach ($request->bidang_keahlian_id as $bidangId) {
                $detailBidang = new DetailBidang();
                $detailBidang->bidang_keahlian_id = $bidangId;
                $detailBidang->dosen_id = $dosen->id;
                $detailBidang->save();
            }

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal menambahkan dosen: ' . $e->getMessage())
                ->withInput()
                ->with('openModal', 'tambahDosenModal');
        }
    }
    public function update(Request $request)
    {
        // Validasi input
        $rules = [
            'dosen_id' => 'required|exists:dosen,id',
            'nip' => ['required', 'string', 'max:50', Rule::unique('dosen', 'nip')->ignore($request->dosen_id)],
            'nama_lengkap' => 'required|string|max:100',
            'bidang_keahlian_id' => 'required|array|exists:bidang_keahlian,id',
            'email' => 'required|email|unique:users,email,' . optional(Dosen::find($request->dosen_id))->user_id,
        ];

        $messages = [
            'dosen_id.required' => 'ID dosen tidak valid',
            'dosen_id.exists' => 'Dosen tidak ditemukan',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'bidang_keahlian_id.required' => 'Bidang keahlian wajib dipilih',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        try {
            // Update data dosen
            $dosen = Dosen::findOrFail($request->dosen_id);
            $dosen->update([
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
            ]);

            // Update data user
            $user = User::findOrFail($dosen->user_id);
            $userData = ['email' => $request->email];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Hapus bidang keahlian lama dan tambahkan yang baru
            DetailBidang::where('dosen_id', $dosen->id)->delete();

            // Tambahkan bidang keahlian baru (untuk setiap bidang yang dipilih)
            foreach ($request->bidang_keahlian_id as $bidangId) {
                DetailBidang::create([
                    'dosen_id' => $dosen->id,
                    'bidang_keahlian_id' => $bidangId,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Data dosen berhasil diperbarui')
                ->with('openModal', 'messageModal');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal update dosen: ' . $e->getMessage());

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal memperbarui data dosen. Silakan coba lagi.');
        }
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dosen_id' => 'required|exists:dosen,id',
        ], [
            'dosen_id.required' => 'ID dosen tidak valid',
            'dosen_id.exists' => 'Dosen tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            $dosen = Dosen::findOrFail($request->dosen_id);
            $userId = $dosen->user_id;

            // Delete related expertise first (foreign key constraint)
            DetailBidang::where('dosen_id', $dosen->id)->delete();

            // Delete lecturer
            $dosen->delete();

            // Delete associated user
            if ($userId) {
                User::destroy($userId);
            }

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Dosen berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal menghapus dosen: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bidang_keahlian_id' => 'required|exists:bidang_keahlian,id',
        ], [
            'bidang_keahlian_id.required' => 'ID bidang keahlian tidak valid',
            'bidang_keahlian_id.exists' => 'Bidang keahlian tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            // Delete bidang keahlian
            BidangKeahlian::destroy($request->bidang_keahlian_id);

            // Delete related expertise
            DetailBidang::where('bidang_keahlian_id', $request->bidang_keahlian_id)->delete();

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Bidang keahlian berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal menghapus bidang keahlian: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bidang_keahlian_id' => 'required|exists:bidang_keahlian,id',
            'nama_keahlian' => 'required|string|max:100|unique:bidang_keahlian,nama_keahlian,' . $request->bidang_keahlian_id,
        ], [
            'bidang_keahlian_id.required' => 'ID bidang keahlian tidak valid',
            'bidang_keahlian_id.exists' => 'Bidang keahlian tidak ditemukan',
            'nama_keahlian.required' => 'Nama keahlian wajib diisi',
            'nama_keahlian.unique' => 'Nama keahlian sudah ada'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator);
        }

        try {
            // Update bidang keahlian
            $bidang = BidangKeahlian::findOrFail($request->bidang_keahlian_id);
            $bidang->nama_keahlian = $request->nama_keahlian;
            $bidang->save();

            return redirect()->route('admin.dosen')
                ->with('success', 'Bidang keahlian berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal memperbarui bidang keahlian: ' . $e->getMessage());
        }
    }
}
