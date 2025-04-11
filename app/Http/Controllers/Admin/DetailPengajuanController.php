<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanJudul;
use App\Models\DetailDosen;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class DetailPengajuanController extends Controller
{
    /**
     * Display the detail of pengajuan TA.
     */
    public function index($id)
    {
        // Fetch the pengajuan data with all relationships needed
        $pengajuan = PengajuanJudul::with([
            'mahasiswa',
            'detailDosen.dosen'  // Make sure this relationship is properly defined
        ])->findOrFail($id);

        // Get the specific dosen assigned to this pengajuan as pembimbing
        $dosenPembimbing = null;

        // Look through all the detailDosen records for this pengajuan
        if ($pengajuan->detailDosen->isNotEmpty()) {
            // First, try to find a dosen with pembimbing flag = 1
            $detailDosen = $pengajuan->detailDosen
                ->where('pembimbing', 1)
                ->first();

            // If found one with pembimbing flag, use its dosen
            if ($detailDosen && $detailDosen->dosen) {
                $dosenPembimbing = $detailDosen->dosen;
            }
            // If no specific pembimbing flag, just use the first dosen assigned
            elseif ($pengajuan->detailDosen->first() && $pengajuan->detailDosen->first()->dosen) {
                $dosenPembimbing = $pengajuan->detailDosen->first()->dosen;
            }
        }

        return view('admin.detailpengajuanta', compact('pengajuan', 'dosenPembimbing'));
    }

    /**
     * Update the status of a pengajuan TA.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,diterima,ditolak',
            'reason' => 'nullable|string|required_if:status,ditolak'
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = PengajuanJudul::with('detailDosen')->findOrFail($id);

            // Check if detail_dosen exists
            if ($pengajuan->detailDosen->isEmpty()) {
                // No dosen has been assigned yet
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada dosen pembimbing yang terpilih. Silakan pilih dosen pembimbing terlebih dahulu.'
                ], 400);
            }

            // Update all associated detail_dosen records
            foreach ($pengajuan->detailDosen as $detailDosen) {
                $detailDosen->status = $request->status;

                // If status is 'ditolak', save the reason
                if ($request->status === 'ditolak' && $request->filled('reason')) {
                    $detailDosen->alasan_dibatalkan = $request->reason;
                }

                $detailDosen->save();
            }

            DB::commit();

            $statusMessages = [
                'diproses' => 'Pengajuan sedang diproses',
                'diterima' => 'Pengajuan telah disetujui',
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
