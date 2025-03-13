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

class DosenController extends Controller
{
    /**
     * Display the list of lecturers with their expertise fields
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dosen = Dosen::with(['user', 'detailBidang.bidangKeahlian'])->get();
        $bidang_keahlian = BidangKeahlian::all();

        return view('admin.dosen.index', compact('dosen', 'bidang_keahlian'));
    }

    /**
     * Create a new expertise field
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Store a newly created lecturer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:dosen,nip',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'bidang_keahlian_id' => 'required|exists:bidang_keahlian,id',
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
                ->withInput();
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
            $detailBidang = new DetailBidang();
            $detailBidang->bidang_keahlian_id = $request->bidang_keahlian_id;
            $detailBidang->dosen_id = $dosen->id;
            $detailBidang->save();

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal menambahkan dosen: ' . $e->getMessage());
        }
    }

    /**
     * Get lecturer data for editing
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $dosen = Dosen::with(['user', 'detailBidang.bidangKeahlian'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'dosen' => $dosen
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dosen tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified lecturer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'dosen_id' => 'required|exists:dosen,id',
            'nip' => ['required', 'string', 'max:50', Rule::unique('dosen', 'nip')->ignore($request->dosen_id)],
            'nama_lengkap' => 'required|string|max:100',
            'bidang_keahlian_id' => 'required|exists:bidang_keahlian,id',
            'email' => 'required|email',
        ];

        // Add password validation if provided
        if ($request->filled('password')) {
            $rules['password'] = 'min:8';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $validator = Validator::make($request->all(), $rules, [
            'dosen_id.required' => 'ID dosen tidak valid',
            'dosen_id.exists' => 'Dosen tidak ditemukan',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah digunakan oleh dosen lain',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'bidang_keahlian_id.required' => 'Bidang keahlian wajib dipilih',
            'bidang_keahlian_id.exists' => 'Bidang keahlian tidak valid',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dosen')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Update lecturer data
            $dosen = Dosen::findOrFail($request->dosen_id);
            $dosen->nip = $request->nip;
            $dosen->nama_lengkap = $request->nama_lengkap;
            $dosen->save();

            // Update user data
            $user = User::findOrFail($dosen->user_id);
            $user->email = $request->email;

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Update expertise relation
            $detailBidang = DetailBidang::where('dosen_id', $dosen->id)->first();
            if ($detailBidang) {
                $detailBidang->bidang_keahlian_id = $request->bidang_keahlian_id;
                $detailBidang->save();
            } else {
                $detailBidang = new DetailBidang();
                $detailBidang->dosen_id = $dosen->id;
                $detailBidang->bidang_keahlian_id = $request->bidang_keahlian_id;
                $detailBidang->save();
            }

            DB::commit();

            return redirect()->route('admin.dosen')
                ->with('success', 'Data dosen berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.dosen')
                ->with('error', 'Gagal memperbarui data dosen: ' . $e->getMessage());
        }
    }

    /**
     * Delete the specified lecturer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
}
