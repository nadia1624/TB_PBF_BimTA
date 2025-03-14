<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanJudul;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\DetailDosen;
use App\Models\BidangKeahlian;
use App\Models\DetailBidang;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengajuan judul beserta relasi mahasiswa dan dosen
        $pengajuan = PengajuanJudul::with(['mahasiswa', 'detailDosen.dosen'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Mengambil semua dosen untuk filter
        $dosen = Dosen::all();

        // Mengambil semua bidang keahlian untuk filter
        $bidang_keahlian = BidangKeahlian::orderBy('nama_keahlian', 'asc')->get();

        return view('admin.pengajuanta', compact('pengajuan', 'dosen', 'bidang_keahlian'));
    }

    public function filter(Request $request)
    {
        $query = PengajuanJudul::with(['mahasiswa', 'detailDosen.dosen']);

        // Filter berdasarkan bidang
        if ($request->has('bidang') && $request->bidang != 'all') {
            $bidangId = $request->bidang;

            // Mencari ID dosen yang memiliki bidang keahlian tertentu
            $dosenIds = DetailBidang::where('bidang_keahlian_id', $bidangId)
                ->pluck('dosen_id')
                ->toArray();

            // Filter pengajuan berdasarkan dosen yang memiliki bidang keahlian tersebut
            $query->whereHas('detailDosen', function($q) use ($dosenIds) {
                $q->whereIn('dosen_id', $dosenIds);
            });
        }

        // Filter berdasarkan status - menggunakan approved_ta dari pengajuan_judul
        if ($request->has('status') && $request->status != 'all') {
            $status = $request->status;

            // Map status UI ke nilai db
            $dbStatus = 'pending';
            if ($status == 'Disetujui') {
                $dbStatus = 'disetujui';
            } elseif ($status == 'Ditolak') {
                $dbStatus = 'ditolak';
            } elseif ($status == 'Diproses') {
                $dbStatus = 'pending';
            }

            $query->where('approved_ta', $dbStatus);
        }

        // Filter berdasarkan pencarian (mahasiswa atau judul)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function($subq) use ($search) {
                      $subq->where('nama_lengkap', 'like', "%{$search}%")
                           ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Disetujui,Ditolak',
            'komentar' => 'nullable|string',
        ]);

        $pengajuan = PengajuanJudul::findOrFail($id);

        // Map status UI ke nilai db
        $dbStatus = 'pending';
        if ($request->status == 'Disetujui') {
            $dbStatus = 'disetujui';
        } elseif ($request->status == 'Ditolak') {
            $dbStatus = 'ditolak';
        }

        $pengajuan->approved_ta = $dbStatus;

        // Jika ada komentar, simpan di kolom komentar
        if ($request->has('komentar') && !empty($request->komentar)) {
            $pengajuan->komentar = $request->komentar;
        }

        $pengajuan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pengajuan berhasil diperbarui'
        ]);
    }

    public function detail($id)
    {
        $pengajuan = PengajuanJudul::with(['mahasiswa', 'detailDosen.dosen'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }
}
