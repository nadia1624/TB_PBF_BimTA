<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalBimbingan;
use App\Models\DokumenOnline;
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
        // Get the authenticated lecturer ID
        $dosenId = Auth::id();

        // Log untuk debugging
        Log::info('Current Dosen ID: ' . $dosenId);

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

        // Log untuk debugging
        Log::info('Found documents count: ' . $dokumen->count());
        foreach ($dokumen as $index => $doc) {
            Log::info("Dokumen #{$index}: ID={$doc->id}, Jadwal ID={$doc->jadwal_bimbingan_id}, Status={$doc->status}, Dokumen=" .
                     ($doc->dokumen_mahasiswa ? 'Ada' : 'Tidak ada'));
        }

        // Statistics - hitung berdasarkan status
        $totalDokumen = $dokumen->count();
        $perluReview = $dokumen->where('status', 'diproses')->count();
        $sudahReview = $dokumen->where('status', 'selesai')->count();

        return view('dosen.dokumen-online', compact(
            'dokumen',
            'totalDokumen',
            'perluReview',
            'sudahReview'
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

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != Auth::id()) {
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
     * Download student's document
     */
    public function downloadMahasiswaDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != Auth::id()) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        if (!$dokumen->dokumen_mahasiswa) {
            return redirect()->back()
                ->with('error', 'Dokumen mahasiswa belum diunggah');
        }

        return Storage::download('dokumen_mahasiswa/' . $dokumen->dokumen_mahasiswa);
    }

    /**
     * Download lecturer's document
     */
    public function downloadDosenDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Check if jadwal belongs to authenticated lecturer
        if ($dokumen->jadwalBimbingan->dosen_id != Auth::id()) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses ke dokumen ini');
        }

        if (!$dokumen->dokumen_dosen) {
            return redirect()->back()
                ->with('error', 'Dokumen dosen belum diunggah');
        }

        return Storage::download('dokumen_dosen/' . $dokumen->dokumen_dosen);
    }
}
