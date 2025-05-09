<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalBimbingan;
use App\Models\DokumenOnline;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DokumenOnlineController extends Controller
{
    /**
     * Display the list of all online documents
     */
    public function index()
    {
        // Get the authenticated user ID
        $userId = Auth::id();

        // Get the dosen ID associated with this user
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // PENTING: Cek apakah ada jadwal yang sudah diterima tapi belum ada dokumennya
        $jadwalDiterima = JadwalBimbingan::where('dosen_id', $dosenId)
            ->where('status', 'diterima')
            ->where('metode', 'online')
            ->get();

        // Buat dokumen online untuk jadwal yang belum punya
        foreach ($jadwalDiterima as $jadwal) {
            DokumenOnline::firstOrCreate(
                ['jadwal_bimbingan_id' => $jadwal->id],
                ['status' => 'menunggu']
            );
        }

        // Query dokumen online, TANPA filter dokumen_mahasiswa
        $dokumen = DokumenOnline::whereHas('jadwalBimbingan', function($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId)
                  ->where('status', 'diterima')
                  ->where('metode', 'online');
        })
        ->with(['jadwalBimbingan.pengajuanJudul.mahasiswa'])
        ->get();

        // Statistics - hitung berdasarkan status
        $totalDokumen = $dokumen->count();
        $perluReview = $dokumen->where('status', 'diproses')->count();
        $sudahReview = $dokumen->where('status', 'selesai')->count();

        return view('dosen.dokumen-online', compact(
            'dokumen',
            'totalDokumen',
            'perluReview',
            'sudahReview',
        ));
    }

    /**
     * Update document with lecturer's review
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan_dosen' => 'required',
            'dokumen_dosen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $dokumen = DokumenOnline::findOrFail($id);

        // Get the authenticated user's dosen ID
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        // Upload document if provided
        if ($request->hasFile('dokumen_dosen')) {
            // Delete old file if exists
            if ($dokumen->dokumen_dosen) {
                Storage::disk('public')->delete($dokumen->dokumen_dosen);
            }

            $file = $request->file('dokumen_dosen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen_dosen', $filename, 'public');

            $dokumen->dokumen_dosen = $path;
        }

        $dokumen->keterangan_dosen = $request->keterangan_dosen;
        $dokumen->tanggal_review = Carbon::now()->format('Y-m-d');
        $dokumen->status = 'selesai';
        $dokumen->save();

        return redirect()->route('dosen.dokumen.online')
            ->with('success', 'Review dokumen berhasil disimpan');
    }

    /**
     * Display student's document
     */
    public function viewMahasiswaDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Get the authenticated user's dosen ID
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        if (!$dokumen->dokumen_mahasiswa) {
            return redirect()->back()
                ->with('error', 'Dokumen mahasiswa belum diunggah');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_mahasiswa);

        return response()->file($path);
    }

    /**
     * Download student's document
     */
    public function downloadMahasiswaDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Get the authenticated user's dosen ID
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        if (!$dokumen->dokumen_mahasiswa) {
            return redirect()->back()
                ->with('error', 'Dokumen mahasiswa belum diunggah');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_mahasiswa);
        $filename = basename($dokumen->dokumen_mahasiswa);

        return response()->download($path, $filename);
    }

    /**
     * Download lecturer's document
     */
    public function downloadDosenDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Get the authenticated user's dosen ID
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        if (!$dokumen->dokumen_dosen) {
            return redirect()->back()
                ->with('error', 'Dokumen dosen belum diunggah');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_dosen);
        $filename = basename($dokumen->dokumen_dosen);

        return response()->download($path, $filename);
    }
}
