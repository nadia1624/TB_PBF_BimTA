<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi query untuk data mahasiswa
        $query = Mahasiswa::with(['user']);

        // 2. Terapkan Filter Angkatan
        // Cek apakah ada parameter 'angkatan' di URL dan nilainya bukan 'all'
        if ($request->has('angkatan') && $request->input('angkatan') !== 'all') {
            $selectedAngkatan = $request->input('angkatan');
            $query->where('angkatan', $selectedAngkatan);
        }

        // 3. Terapkan Filter Pencarian (jika ada input pencarian)
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nim', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $searchTerm . '%')
                  ->orWhere('program_studi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('angkatan', 'like', '%' . $searchTerm . '%') // Bisa juga cari berdasarkan angkatan
                  ->orWhere('no_hp', 'like', '%' . $searchTerm . '%');
                // Tambahkan kolom lain yang ingin Anda cari
            });
        }

        // Ambil data mahasiswa yang sudah difilter
        $mahasiswa = $query->get();

        // 4. Siapkan Data untuk Dropdown Angkatan (dari tahun paling awal hingga sekarang)
        $earliestAngkatan = Mahasiswa::min('angkatan'); // Ambil angkatan terkecil dari database
        $currentYear = Carbon::now()->year; // Ambil tahun saat ini

        // Jika belum ada data mahasiswa sama sekali, set earliestAngkatan ke tahun sekarang
        if (is_null($earliestAngkatan)) {
            $earliestAngkatan = $currentYear;
        }

        // Buat array berisi tahun dari angkatan paling awal hingga tahun sekarang
        $allAngkatan = [];
        for ($year = $earliestAngkatan; $year <= $currentYear; $year++) {
            $allAngkatan[] = $year;
        }

        // 5. Teruskan semua data yang diperlukan ke view
        return view('admin.mahasiswa.index', compact('mahasiswa', 'allAngkatan'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users,email',
            'nim' => 'required|string|max:255|unique:mahasiswa',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password',

        ],
        [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'program_studi.required' => 'Program studi harus diisi',
            'angkatan.required' => 'Angkatan harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'password.required' => 'Password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.mahasiswa')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'mahasiswa';
            $user->save();

            $mahasiswa = new Mahasiswa();
            $mahasiswa->user_id = $user->id;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->nama_lengkap = $request->nama_lengkap;
            $mahasiswa->program_studi = $request->program_studi;
            $mahasiswa->angkatan = $request->angkatan;
            $mahasiswa->no_hp = $request->no_hp;
            $mahasiswa->save();
            DB::commit();

            return redirect()->route('admin.mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.mahasiswa')->with('error', 'Terjadi kesalahan saat menambahkan mahasiswa');
        }


    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
        ],
        [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nim.required' => 'NIM harus diisi',
            'program_studi.required' => 'Program studi harus diisi',
            'angkatan.required' => 'Angkatan harus diisi',
            'no_hp.required' => 'No HP harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.mahasiswa')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
            $mahasiswa->nama_lengkap = $request->nama_lengkap;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->program_studi = $request->program_studi;
            $mahasiswa->angkatan = $request->angkatan;
            $mahasiswa->no_hp = $request->no_hp;
            $mahasiswa->save();

            $user = User::findOrFail($mahasiswa->user_id);
            $userData = ['email' => $request->email];

            $user->update($userData);

            DB::commit();

            return redirect()->route('admin.mahasiswa')->with('success', 'Mahasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.mahasiswa')->with('error', 'Terjadi kesalahan saat memperbarui mahasiswa');
        }
    }
}
