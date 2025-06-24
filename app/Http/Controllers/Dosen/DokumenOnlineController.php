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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokumenOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id(); // Get the authenticated user ID

        // Get the dosen ID associated with this user
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        // Jika dosen tidak ditemukan, redirect atau tampilkan pesan error
        if (!$dosenId) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        // PENTING: Cek apakah ada jadwal bimbingan online yang sudah diterima
        // dan belum memiliki entri di DokumenOnline.
        $jadwalDiterimaOnline = JadwalBimbingan::where('dosen_id', $dosenId)
            ->where('status', 'diterima') // Status jadwal bimbingan yang diterima
            ->where('metode', 'online')
            ->get();

        // Buat atau perbarui entri DokumenOnline untuk setiap jadwal yang relevan
        foreach ($jadwalDiterimaOnline as $jadwal) {
            DokumenOnline::firstOrCreate(
                ['jadwal_bimbingan_id' => $jadwal->id],
                [ // Default values if a new record is created
                    'status' => 'menunggu', // Status awal dokumen online
                    'bab' => null, // Bab mungkin belum diketahui di sini, akan diupdate oleh mahasiswa
                    'dokumen_mahasiswa' => null,
                    'keterangan_mahasiswa' => null,
                    'dokumen_dosen' => null,
                    'keterangan_dosen' => null,
                    'tanggal_review' => null,
                ]
            );
        }

        // Query semua dokumen online yang relevan dengan dosen ini
        // Eager load relasi jadwalBimbingan, pengajuanJudul, dan mahasiswa
        $dokumen = DokumenOnline::whereHas('jadwalBimbingan', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId)
                  ->where('status', 'diterima')
                  ->where('metode', 'online');
        })
        ->with(['jadwalBimbingan.pengajuanJudul.mahasiswa'])
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
        ->get();

        // Statistics - hitung berdasarkan status dokumen_online
        $totalDokumen = $dokumen->count();
        $perluReview = $dokumen->where('status', 'diproses')->count(); // Dokumen yang diunggah mahasiswa dan butuh review
        $sudahReview = $dokumen->where('status', 'selesai')->count(); // Dokumen yang sudah selesai direview

        return view('dosen.dokumen-online', compact(
            'dokumen',
            'totalDokumen',
            'perluReview',
            'sudahReview'
        ));
    }

    /**
     * Handle the review submission from the modal.
     * This method is mapped to the 'dokumen.online.update' route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id DokumenOnline ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan_review' => 'nullable|string', // Catatan dari dosen
            'dokumen_review' => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120', // File review opsional (5MB)
        ]);

        $dokumen = DokumenOnline::findOrFail($id);

        // Verifikasi bahwa dosen yang login berhak mereview dokumen ini
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        if (!$dosenId || $dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return redirect()->route('dosen.dokumen.online')
                ->with('error', 'Anda tidak memiliki akses untuk mereview dokumen ini.');
        }

        try {
            DB::beginTransaction();

            // Handle file upload for dosen's review document
            if ($request->hasFile('dokumen_review')) {
                // Hapus file review dosen lama jika ada
                if ($dokumen->dokumen_dosen && Storage::disk('public')->exists($dokumen->dokumen_dosen)) {
                    Storage::disk('public')->delete($dokumen->dokumen_dosen);
                }

                $file = $request->file('dokumen_review');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumen_review_dosen', $filename, 'public'); // Simpan di folder khusus

                $dokumen->dokumen_dosen = $path; // Update kolom dokumen_dosen
            }

            // Tidak mengubah status menjadi 'selesai' di sini, biarkan method acc yang menanganinya
            $dokumen->keterangan_dosen = $request->catatan_review; // Catatan dari textarea
            $dokumen->tanggal_review = Carbon::now(); // Tanggal review saat ini

            $dokumen->save();

            DB::commit();

            return redirect()->route('dosen.dokumen.online')->with('success', 'Review dokumen berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan review dokumen: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan review: ' . $e->getMessage());
        }
    }

    /**
     * Display student's document (for viewing in browser).
     *
     * @param int $id DokumenOnline ID
     * @return \Illuminate\Http\Response
     */
    public function viewMahasiswaDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        if (!$dosenId || $dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!$dokumen->dokumen_mahasiswa || !Storage::disk('public')->exists($dokumen->dokumen_mahasiswa)) {
            return redirect()->back()
                ->with('error', 'Dokumen mahasiswa tidak ditemukan atau belum diunggah.');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_mahasiswa);
        return response()->file($path);
    }

    /**
     * Download student's document.
     *
     * @param int $id DokumenOnline ID
     * @return \Illuminate\Http\Response
     */
    public function downloadMahasiswaDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        if (!$dosenId || $dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!$dokumen->dokumen_mahasiswa || !Storage::disk('public')->exists($dokumen->dokumen_mahasiswa)) {
            return redirect()->back()
                ->with('error', 'Dokumen mahasiswa tidak ditemukan atau belum diunggah.');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_mahasiswa);
        $filename = basename($dokumen->dokumen_mahasiswa);

        return response()->download($path, $filename);
    }

    /**
     * Download lecturer's review document.
     *
     * @param int $id DokumenOnline ID
     * @return \Illuminate\Http\Response
     */
    public function downloadDosenDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        if (!$dosenId || $dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!$dokumen->dokumen_dosen || !Storage::disk('public')->exists($dokumen->dokumen_dosen)) {
            return redirect()->back()
                ->with('error', 'Dokumen review dosen tidak ditemukan atau belum diunggah.');
        }

        $path = Storage::disk('public')->path($dokumen->dokumen_dosen);
        $filename = basename($dokumen->dokumen_dosen);

        return response()->download($path, $filename);
    }

    /**
     * Handle the ACC action by the lecturer.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id DokumenOnline ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function acc(Request $request, $id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Verifikasi bahwa dosen yang login berhak mereview dokumen ini
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->first();
        $dosenId = $dosen ? $dosen->id : null;

        if (!$dosenId || $dokumen->jadwalBimbingan->dosen_id != $dosenId) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk meng-ACC dokumen ini.'], 403);
        }

        // Cek syarat: dokumen ada dan bab harus lengkap
        if (!$dokumen->dokumen_mahasiswa || $dokumen->bab !== 'lengkap') {
            return response()->json(['success' => false, 'message' => 'Dokumen harus lengkap (bab lengkap) untuk di-ACC.'], 400);
        }

        try {
            DB::beginTransaction();

            // Ubah status menjadi 'selesai' dan tambahkan keterangan
            $dokumen->status = 'selesai';
            $dokumen->keterangan_dosen = $request->input('keterangan', 'Dokumen telah di-ACC pada ' . Carbon::now());
            $dokumen->tanggal_review = Carbon::now();
            $dokumen->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Dokumen telah di-ACC dan ditandai selesai.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat meng-ACC dokumen: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat meng-ACC dokumen.'], 500);
        }
    }
}
