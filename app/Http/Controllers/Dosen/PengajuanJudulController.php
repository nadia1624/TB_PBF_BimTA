<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanJudul;
use App\Models\DetailDosen;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengajuanJudulController extends Controller
{
    /**
     * Display a listing of the pengajuan TA for logged in dosen.
     */
    public function index()
{
    // Get current dosen
    $user = Auth::user();
    $dosen = Dosen::where('user_id', $user->id)->first();

    if (!$dosen) {
        return redirect()->back()->with('error', 'Data dosen tidak ditemukan');
    }

    // Get all pengajuan judul where this dosen is assigned
    $pengajuanList = PengajuanJudul::whereHas('detailDosen', function ($query) use ($dosen) {
        $query->where('dosen_id', $dosen->id);
    })->with(['mahasiswa', 'detailDosen' => function ($query) use ($dosen) {
        $query->where('dosen_id', $dosen->id);
    }])->get();

    // Count statistics
    $totalPengajuan = $pengajuanList->count();
    $menungguVerifikasi = $pengajuanList->where('detailDosen.0.status', 'diproses')->count();
    $disetujui = $pengajuanList->where('detailDosen.0.status', 'diterima')->count();

    // Tambahkan ini: Ambil satu pengajuan untuk ditampilkan di card
    // Prioritaskan pengajuan dengan status 'diproses'
    $pengajuan = $pengajuanList->where('detailDosen.0.status', 'diproses')->first();

    // Jika tidak ada pengajuan dengan status 'diproses', ambil yang pertama saja (jika ada)
    if (!$pengajuan && $pengajuanList->isNotEmpty()) {
        $pengajuan = $pengajuanList->first();
    }

    return view('dosen.pengajuanjudul', compact('pengajuanList', 'totalPengajuan', 'menungguVerifikasi', 'disetujui', 'pengajuan'));
}

    /**
     * Display the detail of a pengajuan TA.
     */
    public function detail($id)
    {
        // Get current dosen
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan');
        }

        // Get the pengajuan data
        $pengajuan = PengajuanJudul::with(['mahasiswa'])
            ->whereHas('detailDosen', function ($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->findOrFail($id);

        // Get the specific detail_dosen record for this dosen and pengajuan
        DetailDosen::where('dosen_id', $dosen->id)
    ->where('pengajuan_judul_id', $id)
    ->update([
        'status' => $request->status,
        'komentar' => $request->filled('komentar') ? $request->komentar : null,
        'alasan_dibatalkan' => $request->status === 'ditolak' ? $request->komentar : null
    ]);

        if (!$detailDosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pengajuan ini');
        }

        return view('dosen.pengajuan.detail', compact('pengajuan', 'detailDosen', 'dosen'));
    }

    /**
     * Update the status of a pengajuan TA (approve/reject).
     */
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:diterima,ditolak',
        'komentar' => 'nullable|string',
    ]);

    try {
        DB::beginTransaction();

        // Get current dosen
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Data dosen tidak ditemukan'
            ], 400);
        }

        // Gunakan query builder langsung untuk menghindari masalah pivot
        $updated = DB::table('detail_dosen')
            ->where('dosen_id', $dosen->id)
            ->where('pengajuan_judul_id', $id)
            ->update([
                'status' => $request->status,
                'komentar' => $request->status === 'diterima' ? $request->komentar : null,
                'alasan_dibatalkan' => $request->status === 'ditolak' ? $request->komentar : null,
                'updated_at' => now()
            ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data yang diperbarui. Pastikan data Anda valid.'
            ], 400);
        }

        DB::commit();

        $statusMessages = [
            'diterima' => 'Pengajuan berhasil disetujui',
            'ditolak' => 'Pengajuan telah ditolak'
        ];

        return response()->json([
            'success' => true,
            'message' => $statusMessages[$request->status] ?? 'Status berhasil diperbarui'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}
