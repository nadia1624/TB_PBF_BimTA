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

        if ($pengajuanJudul) {
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

        return view('mahasiswa.jadwal-bimbingan.index', compact('dosenPembimbing', 'pengajuanJudul', 'jadwalBimbingan'));
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
            'metode' => 'required|in:online,offline',
        ]);

        // Create new guidance schedule
        $jadwalBimbingan = new JadwalBimbingan();
        $jadwalBimbingan->dosen_id = $request->dosen_id;
        $jadwalBimbingan->pengajuan_judul_id = $request->pengajuan_judul_id;
        $jadwalBimbingan->tanggal_pengajuan = $request->tanggal_pengajuan;
        $jadwalBimbingan->waktu_pengajuan = $request->waktu_pengajuan;
        $jadwalBimbingan->status = 'diproses';
        $jadwalBimbingan->keterangan = $request->keterangan;
        $jadwalBimbingan->metode = $request->metode; // Save the meeting method
        $jadwalBimbingan->save();

        return redirect()->route('mahasiswa.jadwal-bimbingan.index')
            ->with('success', 'Jadwal bimbingan berhasil diajukan.');
    }

    /**
     * Display the specified guidance schedule.
     */
    public function show($id)
    {
        $jadwal = JadwalBimbingan::with(['dosen', 'pengajuanJudul.mahasiswa', 'dokumenOnline'])
            ->findOrFail($id);

        // Security check - only allow if this belongs to the logged in student
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwal->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

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

        $jadwal = JadwalBimbingan::with('dokumenOnline')->findOrFail($jadwalId);

        // Security check - only allow if this belongs to the logged in student
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwal->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the jadwal is accepted and online
        if ($jadwal->status != 'diterima') {
            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('error', 'Hanya jadwal bimbingan yang sudah disetujui yang dapat mengunggah dokumen.');
        }

        if ($jadwal->metode != JadwalBimbingan::METODE_ONLINE) {
            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('error', 'Hanya jadwal bimbingan online yang dapat mengunggah dokumen.');
        }

        // Upload file
        $file = $request->file('dokumen');
        $fileName = time() . '_' . $jadwal->id . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen_bimbingan', $fileName, 'public');

        // Check if there's an existing document for this bab
        $existingDokumen = DokumenOnline::where('jadwal_bimbingan_id', $jadwal->id)
            ->where('bab', $request->bab)
            ->first();

        if ($existingDokumen) {
            // Update existing document
            if ($existingDokumen->dokumen_mahasiswa) {
                Storage::disk('public')->delete($existingDokumen->dokumen_mahasiswa);
            }

            $existingDokumen->dokumen_mahasiswa = $path;
            $existingDokumen->keterangan_mahasiswa = $request->keterangan;
            $existingDokumen->status = 'diproses';
            $existingDokumen->save();

            return redirect()->route('mahasiswa.jadwal-bimbingan.show', $jadwal->id)
                ->with('success', 'Dokumen bimbingan berhasil diperbarui.');
        } else {
            // Create new document
            $dokumen = new DokumenOnline();
            $dokumen->jadwal_bimbingan_id = $jadwal->id;
            $dokumen->bab = $request->bab;
            $dokumen->dokumen_mahasiswa = $path;
            $dokumen->keterangan_mahasiswa = $request->keterangan;
            $dokumen->status = 'menunggu';
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
}
