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
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan');
        }

        $statusFilter = $request->input('status', 'all');

        $query = PengajuanJudul::whereHas('detailDosen', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->with(['mahasiswa', 'detailDosen' => function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        }]);

        if ($statusFilter !== 'all') {
            $query->whereHas('detailDosen', function ($q) use ($dosen, $statusFilter) {
                $q->where('dosen_id', $dosen->id)
                  ->where('status', $statusFilter);
            });
        }

        $pengajuanList = $query->get();

        $totalPengajuan = $pengajuanList->count();
        $menungguVerifikasi = $pengajuanList->where('detailDosen.0.status', 'diproses')->count();
        $disetujui = $pengajuanList->where('detailDosen.0.status', 'diterima')->count();

        $pengajuan = $pengajuanList->where('detailDosen.0.status', 'diproses')->first();
        if (!$pengajuan && $pengajuanList->isNotEmpty()) {
            $pengajuan = $pengajuanList->first();
        }

        return view('dosen.pengajuanjudul', compact('pengajuanList', 'totalPengajuan', 'menungguVerifikasi', 'disetujui', 'pengajuan', 'statusFilter'));
    }

    public function detail($id)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan');
        }

        $pengajuan = PengajuanJudul::with(['mahasiswa'])
            ->whereHas('detailDosen', function ($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
            ->findOrFail($id);

        $detailDosen = DetailDosen::where('dosen_id', $dosen->id)
            ->where('pengajuan_judul_id', $id)
            ->first();

        if (!$detailDosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pengajuan ini');
        }

        return view('dosen.pengajuan.detail', compact('pengajuan', 'detailDosen', 'dosen'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:diterima,ditolak,dibatalkan', // Tambah 'dibatalkan'
        'komentar' => 'nullable|string',
    ]);

    try {
        DB::beginTransaction();

        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Data dosen tidak ditemukan'
            ], 400);
        }

        $updateData = [
            'updated_at' => now()
        ];

        if ($request->status === 'diterima') {
            $updateData['status'] = 'diterima';
            $updateData['komentar'] = $request->komentar;
            $updateData['alasan_dibatalkan'] = null;
        } elseif ($request->status === 'ditolak') {
            $updateData['status'] = 'ditolak';
            $updateData['alasan_dibatalkan'] = $request->komentar;
            $updateData['komentar'] = null;
        } elseif ($request->status === 'dibatalkan') {
            $updateData['status'] = 'dibatalkan';
            $updateData['alasan_dibatalkan'] = $request->komentar;
            $updateData['komentar'] = null;
        }

        $detailDosen = DetailDosen::where('dosen_id', $dosen->id)
            ->where('pengajuan_judul_id', $id)
            ->first();

        if (!$detailDosen) {
            return response()->json([
                'success' => false,
                'message' => 'Data detail dosen tidak ditemukan'
            ], 400);
        }

        // Batasi pembatalan hanya untuk status 'diterima'
        if ($request->status === 'dibatalkan' && $detailDosen->status !== 'diterima') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pengajuan yang disetujui dapat dibatalkan.'
            ], 400);
        }

        // Batasi penolakan hanya untuk status 'diproses'
        if ($request->status === 'ditolak' && $detailDosen->status !== 'diproses') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pengajuan yang sedang diproses dapat ditolak.'
            ], 400);
        }

        $updated = DB::table('detail_dosen')
            ->where('dosen_id', $dosen->id)
            ->where('pengajuan_judul_id', $id)
            ->update($updateData);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data yang diperbarui. Pastikan data Anda valid.'
            ], 400);
        }

        // Update approved_ta jika semua status detail_dosen adalah 'ditolak'
        $allRejected = DetailDosen::where('pengajuan_judul_id', $id)
            ->get()
            ->every(function ($detail) {
                return $detail->status === 'ditolak';
            });

        if ($allRejected) {
            PengajuanJudul::where('id', $id)->update(['approved_ta' => 'ditolak']);
        }

        DB::commit();

        $statusMessages = [
            'diterima' => 'Pengajuan berhasil disetujui',
            'ditolak' => 'Pengajuan telah ditolak',
            'dibatalkan' => 'Pengajuan telah dibatalkan'
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
