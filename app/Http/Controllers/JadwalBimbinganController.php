<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\DokumenOnline;
use App\Models\JadwalBimbingan;
use App\Models\PengajuanJudul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JadwalBimbinganController extends Controller
{
    /**
     * Display a listing of the guidance schedules and form for creating a new guidance.
     */
    public function index()
    {
        // Get the authenticated user's student ID
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Get the student's thesis topic submission
        $pengajuanJudul = PengajuanJudul::where('mahasiswa_id', $mahasiswa->id)->first();

        // Set default values
        $dosenPembimbing = collect();
        $jadwalBimbingan = collect();
        $canSubmitSchedule = false; // Flag untuk mengecek apakah bisa mengajukan jadwal

        if ($pengajuanJudul) {
            // Cek apakah approved_ta masih pending (belum disetujui/ditolak)
            $canSubmitSchedule = $pengajuanJudul->approved_ta === 'pending';

            // Get the assigned supervising lecturers for this thesis
            $dosenPembimbing = Dosen::whereHas('pengajuanJudul', function($query) use ($pengajuanJudul) {
                $query->where('pengajuan_judul_id', $pengajuanJudul->id);
            })->get();

            // Get all guidance schedules for this thesis
            $jadwalBimbingan = JadwalBimbingan::where('pengajuan_judul_id', $pengajuanJudul->id)
                ->with('dosen')
                ->orderBy('tanggal_pengajuan', 'desc')
                ->orderBy('waktu_pengajuan', 'desc')
                ->get();
        }

        return view('mahasiswa.jadwal-bimbingan.index', compact(
            'dosenPembimbing',
            'pengajuanJudul',
            'jadwalBimbingan',
            'canSubmitSchedule'
        ));
    }

    /**
     * Store a newly created guidance schedule in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'tanggal_pengajuan' => 'required|date|after_or_equal:today',
            'waktu_pengajuan' => 'required',
            'keterangan' => 'required|string|max:1000',
            'pengajuan_judul_id' => 'required|exists:pengajuan_judul,id',
            // 'metode' => 'required|in:online,offline',
        ]);

        // Create new guidance schedule
        $jadwalBimbingan = new JadwalBimbingan();
        $jadwalBimbingan->dosen_id = $request->dosen_id;
        $jadwalBimbingan->pengajuan_judul_id = $request->pengajuan_judul_id;
        $jadwalBimbingan->tanggal_pengajuan = $request->tanggal_pengajuan;
        $jadwalBimbingan->waktu_pengajuan = $request->waktu_pengajuan;
        $jadwalBimbingan->status = 'diproses';
        $jadwalBimbingan->keterangan = $request->keterangan;
        $jadwalBimbingan->metode = null;
        // $jadwalBimbingan->metode = $request->metode;
        $jadwalBimbingan->save();

        return redirect()->route('mahasiswa.jadwal-bimbingan.index')
            ->with('success', 'Jadwal bimbingan berhasil diajukan.');
    }

    /**
     * Display the specified guidance schedule.
     */
    public function show($id)
    {
        // Mengambil detail jadwal bimbingan dengan relasi dosen, mahasiswa, dan dokumen online
        $jadwal = JadwalBimbingan::with(['dosen', 'pengajuanJudul.mahasiswa', 'dokumenOnline'])
            ->findOrFail($id);

        // Memeriksa apakah user yang sedang login adalah mahasiswa yang sesuai dengan jadwal ini
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwal->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        // Jika metode bimbingan adalah online dan status bimbingan adalah diterima, maka tampilkan form upload dokumen
        if ($jadwal->metode == 'online' && $jadwal->status == 'diterima') {
            return view('mahasiswa.jadwal-bimbingan.show', compact('jadwal'));
        }

        // Jika metode bukan online atau bimbingan belum diterima, tampilkan halaman tanpa opsi upload
        return view('mahasiswa.jadwal-bimbingan.show', compact('jadwal'));
    }


    /**
     * Cancel a guidance schedule
     */
    public function destroy($id)
    {
        $jadwalBimbingan = JadwalBimbingan::findOrFail($id);

        // Security check - only allow if this belongs to the logged in student
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwalBimbingan->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation if the status is still 'diproses'
        if ($jadwalBimbingan->status != 'diproses') {
            return redirect()->route('mahasiswa.jadwal-bimbingan.index')
                ->with('error', 'Hanya jadwal yang masih diproses yang dapat dibatalkan.');
        }

        $jadwalBimbingan->delete();

        return redirect()->route('mahasiswa.jadwal-bimbingan.index')
            ->with('success', 'Jadwal bimbingan berhasil dibatalkan.');
    }

    /**
     * Upload dokumen bimbingan
     */
    public function uploadDokumen(Request $request, $jadwalId)
    {
        $request->validate([
            'bab' => 'required|in:bab 1,bab 2,bab 3,bab 4,bab 5,lengkap',
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'keterangan' => 'required|string|max:1000',
        ]);

        // Ambil jadwal bimbingan berdasarkan ID
        $jadwal = JadwalBimbingan::with('dokumenOnline')->findOrFail($jadwalId);

        // Memeriksa apakah user yang sedang login adalah mahasiswa yang sesuai dengan jadwal ini
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwal->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan status bimbingan diterima dan metode online
        if ($jadwal->status != 'diterima' || $jadwal->metode != 'online') {
            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('error', 'Hanya jadwal bimbingan yang sudah diterima dan online yang dapat mengunggah dokumen.');
        }

        // Upload dokumen yang diunggah mahasiswa
        $file = $request->file('dokumen');
        $fileName = time() . '_' . $jadwal->id . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen_bimbingan', $fileName, 'public');

        // Cek apakah sudah ada dokumen untuk jadwal bimbingan ini
        $existingDokumen = DokumenOnline::where('jadwal_bimbingan_id', $jadwal->id)->first();

        if ($existingDokumen) {
            // Jika dokumen sudah ada, update dokumen yang lama
            if ($existingDokumen->dokumen_mahasiswa) {
                Storage::disk('public')->delete($existingDokumen->dokumen_mahasiswa);
            }

            $existingDokumen->bab = $request->bab; // Tambahkan ini untuk mengubah bab jika perlu
            $existingDokumen->dokumen_mahasiswa = $path;
            $existingDokumen->keterangan_mahasiswa = $request->keterangan;
            $existingDokumen->status = 'diproses'; // Status berubah menjadi diproses setelah upload
            $existingDokumen->save();

            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('success', 'Dokumen bimbingan berhasil diperbarui.');
        } else {
            // Jika dokumen belum ada, buat dokumen baru
            $dokumen = new DokumenOnline();
            $dokumen->jadwal_bimbingan_id = $jadwal->id;
            $dokumen->bab = $request->bab;
            $dokumen->dokumen_mahasiswa = $path;
            $dokumen->keterangan_mahasiswa = $request->keterangan;
            $dokumen->status = 'diproses'; // Set status to 'diproses' right away (not 'menunggu')
            $dokumen->save();

            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('success', 'Dokumen bimbingan berhasil diunggah.');
        }
    }


    /**
     * Show dokumen detail
     */
    public function showDokumen($jadwalId, $dokumenId)
    {
        $jadwal = JadwalBimbingan::findOrFail($jadwalId);
        $dokumen = DokumenOnline::where('jadwal_bimbingan_id', $jadwalId)
            ->findOrFail($dokumenId);

        // Security check - only allow if this belongs to the logged in student
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwal->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('mahasiswa.jadwal-bimbingan.dokumen', compact('jadwal', 'dokumen'));
    }

    public function downloadReviewDocument($id)
    {
        $dokumen = DokumenOnline::findOrFail($id);

        // Verifikasi bahwa dokumen review ini terkait dengan mahasiswa yang sedang login
        // Mahasiswa dapat mengunduh dokumen review hanya jika:
        // 1. DokumenOnline terkait dengan jadwal bimbingan mereka.
        // 2. Jadwal bimbingan tersebut terkait dengan pengajuan judul mereka.
        // (Asumsi relasi: DokumenOnline -> JadwalBimbingan -> PengajuanJudul -> Mahasiswa)
        $mahasiswaId = Auth::user()->mahasiswa->id ?? null;

        if (!$mahasiswaId ||
            !$dokumen->jadwalBimbingan ||
            !$dokumen->jadwalBimbingan->pengajuanJudul ||
            $dokumen->jadwalBimbingan->pengajuanJudul->mahasiswa_id != $mahasiswaId)
        {
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

}
