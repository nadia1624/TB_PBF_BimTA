<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\JadwalBimbingan;
use App\Models\PengajuanJudul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $jadwalBimbingan = JadwalBimbingan::with(['dosen.bidangKeahlian', 'pengajuanJudul.mahasiswa', 'dokumenOnline'])
            ->findOrFail($id);

        // Security check - only allow if this belongs to the logged in student
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($jadwalBimbingan->pengajuanJudul->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('mahasiswa.jadwal-bimbingan.show', compact('jadwalBimbingan'));
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
}
