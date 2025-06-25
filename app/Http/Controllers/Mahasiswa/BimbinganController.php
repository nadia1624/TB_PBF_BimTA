<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\PengajuanJudul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Mengambil pengajuan judul terakhir mahasiswa, termasuk relasi detailDosen dan dosen
        $pengajuanJudul = PengajuanJudul::with(['detailDosen.dosen'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Inisialisasi variabel status dan pesan
        $statusBimbingan = 'belum_mengajukan'; // Default
        $messageBimbingan = 'Anda belum melakukan pengajuan judul.';
        $pembimbing1 = 'Belum ditentukan';
        $pembimbing2 = 'Tidak ada Pembimbing 2';

        if ($pengajuanJudul) {
            // Ambil data dosen pembimbing dari detailDosen
            $details = $pengajuanJudul->detailDosen;

            // Prioritize fetching Pembimbing 1
            $pembimbing1Detail = $details->where('pembimbing', 'pembimbing 1')->first();
            if ($pembimbing1Detail && isset($pembimbing1Detail->dosen->nama_lengkap)) {
                $pembimbing1 = $pembimbing1Detail->dosen->nama_lengkap;
            }

            // Fetch Pembimbing 2 if available
            $pembimbing2Detail = $details->where('pembimbing', 'pembimbing 2')->first();
            if ($pembimbing2Detail && isset($pembimbing2Detail->dosen->nama_lengkap)) {
                $pembimbing2 = $pembimbing2Detail->dosen->nama_lengkap;
            }

            // Cek status approved_ta
            if ($pengajuanJudul->approved_ta === 'disetujui') {
                $statusBimbingan = 'selesai';
                $messageBimbingan = 'Judul tugas akhir Anda telah disetujui.';
            } elseif ($pengajuanJudul->approved_ta === 'ditolak') {
                $statusBimbingan = 'dibatalkan';
                $messageBimbingan = 'Pengajuan judul tugas akhir Anda telah ditolak secara keseluruhan.';
            } elseif ($pengajuanJudul->approved_ta === 'pending') {
                $statusBimbingan = 'pending';
                // Cek status penerimaan dari pembimbing
                $pembimbing1Detail = $details->where('pembimbing', 'pembimbing 1')->first();
                $pembimbing2Detail = $details->where('pembimbing', 'pembimbing 2')->first();
                $pembimbing1Accepted = $pembimbing1Detail ? $pembimbing1Detail->status !== 'ditolak' : false;
                $pembimbing2Accepted = $pembimbing2Detail ? $pembimbing2Detail->status !== 'ditolak' : true; // Default true if no Pembimbing 2

                if ($pembimbing1Accepted && $pembimbing2Accepted) {
                    $messageBimbingan = 'Masih dalam tahap bimbingan.';
                } else {
                    $messageBimbingan = 'Pengajuan judul ditolak oleh salah satu dosen pembimbing.';
                }
            }
        }

        return view('mahasiswa.bimbingan', compact('pengajuanJudul', 'statusBimbingan', 'messageBimbingan', 'pembimbing1', 'pembimbing2'));
    }
}
