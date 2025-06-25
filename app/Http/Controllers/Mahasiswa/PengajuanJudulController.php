<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailDosen;
use App\Models\Dosen;
use App\Models\PengajuanJudul;
use App\Models\BidangKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanJudulController extends Controller
{
     public function index(Request $request)
    {
        $user = Auth::user();
        $dosenList = Dosen::all();

        $isData = !empty($user->mahasiswa);

        // Inisialisasi SEMUA variabel untuk view di awal
        $pengajuan = null;
        $allPengajuan = collect();
        $pembimbing1 = null;
        $pembimbing2 = null;
        $rejectedDosenId = null;
        $rejectedBy = null;
        $rejectedDetailDosen = null;
        $hasAccepted = false;
        $hasRejected = false;
        $overallStatusText = 'Belum Mengajukan';
        $statusColor = 'gray';
        $statusMessage = 'Anda belum memiliki pengajuan judul. Silakan ajukan judul tugas akhir Anda.';
        $action = $request->query('action');
        $displayForm = true;

        if ($isData) {
            $allPengajuan = PengajuanJudul::with(['detailDosen.dosen', 'mahasiswa'])
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Ambil pengajuan terakhir yang aktif (bukan dibatalkan) untuk status utama
            $pengajuan = $allPengajuan->where('approved_ta', '!=', 'dibatalkan')->first();

            if ($pengajuan) {
                $detailDosen = $pengajuan->detailDosen;

                // Pastikan $pembimbing1Detail dan $pembimbing2Detail selalu diinisialisasi
                $pembimbing1Detail = $detailDosen->where('pembimbing', 'pembimbing 1')->first();
                $pembimbing2Detail = $detailDosen->where('pembimbing', 'pembimbing 2')->first();

                $pembimbing1 = $pembimbing1Detail->dosen_id ?? null;
                $pembimbing2 = $pembimbing2Detail->dosen_id ?? null;

                $p1Status = $pembimbing1Detail->status ?? null;
                $p2Status = $pembimbing2Detail->status ?? null;

                // Determine overall status
                $p1Rejected = $pembimbing1Detail && $pembimbing1Detail->status === 'ditolak';
                $p2Rejected = $pembimbing2Detail && $pembimbing2Detail->status === 'ditolak';
                $p1Accepted = $pembimbing1Detail && $pembimbing1Detail->status === 'diterima';
                $p2Accepted = $pembimbing2Detail && $pembimbing2Detail->status === 'diterima';

                $hasRejected = false;
                $rejectedDetailDosen = null;
                $rejectedBy = null;
                $rejectedDosenId = null;

                if ($pengajuan->approved_ta === 'dibatalkan') {
                    $overallStatusText = 'Dibatalkan';
                    $statusColor = 'gray';
                    $statusMessage = 'Pengajuan judul ini telah Anda batalkan.';
                } elseif ($p1Rejected && $p2Rejected) {
                    $overallStatusText = 'Ditolak oleh Kedua Dosen Pembimbing';
                    $statusColor = 'red';
                    $hasRejected = true;
                    $rejectedDetailDosen = $pembimbing1Detail;
                    $rejectedBy = 'keduanya';
                    $rejectedDosenId = [$pembimbing1, $pembimbing2];
                } elseif ($p1Rejected) {
                    $overallStatusText = 'Ditolak oleh Pembimbing 1';
                    $statusColor = 'red';
                    $hasRejected = true;
                    $rejectedDetailDosen = $pembimbing1Detail;
                    $rejectedBy = 'pembimbing 1';
                    $rejectedDosenId = $pembimbing1;
                } elseif ($p2Rejected) {
                    $overallStatusText = 'Ditolak oleh Pembimbing 2';
                    $statusColor = 'red';
                    $hasRejected = true;
                    $rejectedDetailDosen = $pembimbing2Detail;
                    $rejectedBy = 'pembimbing 2';
                    $rejectedDosenId = $pembimbing2;
                } elseif ($p1Accepted && ($p2Accepted || !$pembimbing2Detail)) {
                    $overallStatusText = 'Diterima';
                    $statusColor = 'green';
                    $hasAccepted = true;
                } elseif ($p1Accepted && $p2Status === 'diproses') {
                    $overallStatusText = 'Diterima Pembimbing 1, Pembimbing 2 Diproses';
                    $statusColor = 'yellow';
                    $hasAccepted = true;
                } elseif ($p1Status === 'diproses' || $p2Status === 'diproses') {
                    $overallStatusText = 'Diproses';
                    $statusColor = 'yellow';
                }

                // Logic for displayForm
                if ($overallStatusText === 'Diterima' || $overallStatusText === 'Diproses' || $overallStatusText === 'Dibatalkan') {
                    $displayForm = false;
                } elseif ($hasRejected) {
                    $displayForm = true;
                } else {
                    $displayForm = true;
                }

                // Override displayForm if an explicit action is requested via query parameter
                if (in_array($action, ['resubmit', 'replace-advisor1', 'promote-advisor', 'replace-advisor2', 'remove-advisor2', 'new-submission'])) {
                    $displayForm = true;
                }

                // Set initial status message based on computed overallStatusText
                if ($overallStatusText === 'Diproses') {
                    $statusMessage = 'Anda sudah mengajukan judul dan masih dalam proses review. Silakan tunggu respons dari dosen pembimbing atau hubungi admin jika diperlukan.';
                } elseif ($overallStatusText === 'Ditolak oleh Kedua Dosen Pembimbing') {
                    $rejectedByDosenNames = [];
                    $reasons = [];

                    if ($pembimbing1Detail) {
                        $rejectedByDosenNames[] = optional($pembimbing1Detail->dosen)->nama_lengkap . ' (Pembimbing 1)';
                        if ($pembimbing1Detail->alasan_dibatalkan) $reasons[] = 'P1: ' . $pembimbing1Detail->alasan_dibatalkan;
                    }
                    // Safe check for $pembimbing2Detail before accessing properties
                    if ($pembimbing2Detail) {
                        $rejectedByDosenNames[] = optional($pembimbing2Detail->dosen)->nama_lengkap . ' (Pembimbing 2)';
                        if ($pembimbing2Detail->alasan_dibatalkan) $reasons[] = 'P2: ' . $pembimbing2Detail->alasan_dibatalkan;
                    }
                    $statusMessage = "Judul tugas akhir Anda ditolak oleh " . implode(' dan ', $rejectedByDosenNames) . ".";
                    if (!empty($reasons)) {
                        $statusMessage .= " Alasan: " . implode('; ', $reasons);
                    } else {
                        $statusMessage .= " Tidak ada alasan spesifik diberikan.";
                    }
                } elseif ($p1Rejected || $p2Rejected) {
                    $rejectedName = '';
                    $reason = '';
                    if ($p1Rejected) {
                        $rejectedName = optional($pembimbing1Detail->dosen)->nama_lengkap . ' (Pembimbing 1)';
                        $reason = $pembimbing1Detail->alasan_dibatalkan;
                    } elseif ($p2Rejected) {
                        $rejectedName = optional($pembimbing2Detail->dosen)->nama_lengkap . ' (Pembimbing 2)';
                        $reason = $pembimbing2Detail->alasan_dibatalkan;
                    }
                    $reason = $reason ?? 'Tidak ada alasan spesifik diberikan.';
                    $statusMessage = "Judul tugas akhir Anda ditolak oleh dosen " . $rejectedName . ". Alasan: " . $reason;
                } elseif ($overallStatusText === 'Diterima') {
                    $statusMessage = 'Anda sudah mengajukan judul dan sudah disetujui oleh kedua dosen pembimbing.';
                }
            } else {
                $displayForm = true;
                $overallStatusText = 'Belum Mengajukan';
                $statusColor = 'gray';
                $statusMessage = 'Anda belum memiliki pengajuan judul. Silakan ajukan judul tugas akhir Anda.';
            }
        } else {
            $displayForm = false;
            $overallStatusText = 'Data Belum Lengkap';
            $statusColor = 'yellow';
            $statusMessage = 'Perhatian! Data mahasiswa Anda belum lengkap. Silakan lengkapi profil Anda terlebih dahulu sebelum mengajukan judul.';
        }

        $bidang_keahlian = BidangKeahlian::all();
        $dosenQuery = Dosen::with(['user', 'detailBidang.bidangKeahlian']);

        if ($request->has('bidang') && $request->bidang !== 'all') {
            $bidangId = $request->bidang;
            $dosenQuery->whereHas('detailBidang', function($query) use ($bidangId) {
                $query->where('bidang_keahlian_id', $bidangId);
            });
        }
        $dosen = $dosenQuery->get();

        return view('mahasiswa.pengajuan-judul', compact(
            'dosenList',
            'isData',
            'pengajuan',
            'allPengajuan',
            'pembimbing1',
            'pembimbing2',
            'bidang_keahlian',
            'dosen',
            'rejectedDosenId',
            'rejectedBy',
            'rejectedDetailDosen',
            'hasAccepted',
            'hasRejected',
            'action',
            'displayForm',
            'overallStatusText',
            'statusColor',
            'statusMessage'
        ));
    }

    public function create(Request $request)
    {
        return $this->index($request);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Data mahasiswa belum lengkap. Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $rules = [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ];

        $pengajuan = PengajuanJudul::where('mahasiswa_id', $user->mahasiswa->id)
                                    ->where('approved_ta', '!=', 'dibatalkan')
                                    ->orderBy('created_at', 'desc')
                                    ->first();

        $action = $request->input('action');

        if ($action === 'replace-advisor1' || $action === 'resubmit' || $action === 'new-submission') {
            $rules['dosen_pembimbing1'] = 'required|exists:dosen,id';
        }
        if ($action === 'replace-advisor2' || $action === 'resubmit' || $action === 'new-submission') {
            $rules['dosen_pembimbing2'] = 'nullable|exists:dosen,id|different:dosen_pembimbing1';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $mahasiswa = $user->mahasiswa;
            $message = 'Pengajuan judul berhasil disimpan.';

            if ($action === 'resubmit' || $action === 'new-submission') {
                $data = [
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'mahasiswa_id' => $mahasiswa->id,
                    'approved_ta' => 'pending',
                ];

                $newPengajuan = PengajuanJudul::create($data);
                $newPengajuan->detailDosen()->create([
                    'dosen_id' => $request->dosen_pembimbing1,
                    'pembimbing' => 'pembimbing 1',
                    'status' => 'diproses',
                ]);

                if ($request->dosen_pembimbing2) {
                    $newPengajuan->detailDosen()->create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
                $message = 'Pengajuan judul baru berhasil disimpan dan sedang diproses.';

            } elseif ($pengajuan) {
                // Fetch detailDosen again here to ensure $p1Detail and $p2Detail are fresh for this specific $pengajuan
                // This is important if $pengajuan was loaded earlier in the method (which it is)
                // and its relations might not reflect the most recent state if other logic paths modify them.
                // However, since we're operating on $pengajuan (which is `first()`), its detailDosen should be fine.
                // The crucial part is to ensure these are always defined before use.
                $p1Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 1')->first();
                $p2Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 2')->first();


                $p1Accepted = $p1Detail && $p1Detail->status === 'diterima';
                $p2Accepted = $p2Detail && $p2Detail->status === 'diterima';

                if ($p1Accepted && ($p2Accepted || !$p2Detail) && empty($request->action)) {
                    DB::rollBack();
                    return redirect()->route('mahasiswa.pengajuan-judul.index')
                        ->with('error', 'Anda sudah memiliki judul yang disetujui. Tidak dapat mengajukan perubahan tanpa memilih aksi.');
                }

                $pengajuan->judul = $request->judul;
                $pengajuan->deskripsi = $request->deskripsi;
                $pengajuan->save();
                $message = 'Pengajuan judul berhasil diperbarui.';

                if ($action === 'replace-advisor1') {
                    if ($p1Detail) {
                        DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                                   ->where('pembimbing', 'pembimbing 1')
                                   ->update([
                                       'dosen_id' => $request->dosen_pembimbing1,
                                       'status' => 'diproses',
                                       'alasan_dibatalkan' => null,
                                   ]);
                        $message = 'Dosen Pembimbing 1 berhasil diganti. Pengajuan diperbarui dan menunggu persetujuan baru.';
                    } else {
                        $pengajuan->detailDosen()->create([
                            'dosen_id' => $request->dosen_pembimbing1,
                            'pembimbing' => 'pembimbing 1',
                            'status' => 'diproses',
                        ]);
                        $message = 'Dosen Pembimbing 1 berhasil ditambahkan. Pengajuan diperbarui dan menunggu persetujuan.';
                    }
                } elseif ($action === 'promote-advisor') {
                    if ($p1Detail && $p2Detail && $p2Detail->status === 'diterima') {
                        DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                                   ->where('pembimbing', 'pembimbing 1')
                                   ->update([
                                       'dosen_id' => $p2Detail->dosen_id,
                                       'status' => 'diterima',
                                       'alasan_dibatalkan' => null,
                                   ]);
                        $p2Detail->delete();
                        $message = 'Dosen Pembimbing 2 berhasil dipromosikan menjadi Pembimbing 1. Pengajuan diperbarui.';
                    } else {
                        throw new \Exception("Kondisi promosi dosen pembimbing tidak terpenuhi atau Pembimbing 2 belum diterima.");
                    }
                } elseif ($action === 'replace-advisor2') {
                    // Make sure $p2Detail is checked before trying to update it
                    if ($p2Detail) {
                        DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                                   ->where('pembimbing', 'pembimbing 2')
                                   ->update([
                                       'dosen_id' => $request->dosen_pembimbing2,
                                       'status' => 'diproses',
                                       'alasan_dibatalkan' => null,
                                   ]);
                        $message = 'Dosen Pembimbing 2 berhasil diganti. Pengajuan diperbarui dan menunggu persetujuan baru.';
                    } else { // If there was no P2 previously, create it
                        $pengajuan->detailDosen()->create([
                            'dosen_id' => $request->dosen_pembimbing2,
                            'pembimbing' => 'pembimbing 2',
                            'status' => 'diproses',
                        ]);
                        $message = 'Dosen Pembimbing 2 berhasil ditambahkan. Pengajuan diperbarui dan menunggu persetujuan.';
                    }
                } elseif ($action === 'remove-advisor2') {
                    if ($p2Detail) {
                        $p2Detail->delete();
                        $message = 'Dosen Pembimbing 2 berhasil dihapus dari pengajuan. Pengajuan diperbarui.';
                    } else {
                        throw new \Exception("Tidak ada dosen pembimbing 2 untuk dihapus.");
                    }
                } else {
                    foreach ($pengajuan->detailDosen as $detail) {
                        if ($detail->status !== 'diterima') {
                           DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                                      ->where('pembimbing', $detail->pembimbing)
                                      ->update([
                                          'status' => 'diproses',
                                          'alasan_dibatalkan' => null,
                                      ]);
                        }
                    }
                    $message = 'Pengajuan judul berhasil diperbarui.';
                }
            } else { // Jika belum ada pengajuan sama sekali yang aktif (dan bukan resubmit/new-submission)
                $data = [
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'mahasiswa_id' => $mahasiswa->id,
                    'approved_ta' => 'pending',
                ];

                $pengajuanJudul = PengajuanJudul::create($data);
                $pengajuanJudul->detailDosen()->create([
                    'dosen_id' => $request->dosen_pembimbing1,
                    'pembimbing' => 'pembimbing 1',
                    'status' => 'diproses',
                ]);

                if ($request->dosen_pembimbing2) {
                    $pengajuanJudul->detailDosen()->create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
                $message = 'Pengajuan judul baru berhasil disimpan dan sedang diproses.';
            }

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan pengajuan judul: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengajuan judul: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $pengajuan = PengajuanJudul::with(['detailDosen.dosen', 'mahasiswa'])->findOrFail($id);
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat pengajuan ini.');
        }

        $dosenList = Dosen::all();
        $pembimbing1 = null;
        $pembimbing2 = null;

        foreach ($pengajuan->detailDosen as $dosen) {
            if ($dosen->pembimbing == 'pembimbing 1') {
                $pembimbing1 = $dosen->dosen_id;
            } else if ($dosen->pembimbing == 'pembimbing 2') {
                $pembimbing2 = $dosen->dosen_id;
            }
        }

        return view('mahasiswa.pengajuan-judul-detail', compact(
            'pengajuan',
            'dosenList',
            'pembimbing1',
            'pembimbing2'
        ));
    }

    public function edit(string $id)
    {
        $pengajuan = PengajuanJudul::with('detailDosen')->findOrFail($id);
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit pengajuan ini.');
        }

        $canBeEdited = true;
        foreach ($pengajuan->detailDosen as $detail) {
            if ($detail->status == 'diterima') {
                $canBeEdited = false;
                break;
            }
        }

        if (!$canBeEdited) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Pengajuan yang sudah disetujui tidak dapat diedit.');
        }

        $dosenList = Dosen::all();
        $pembimbing1 = null;
        $pembimbing2 = null;

        foreach ($pengajuan->detailDosen as $dosen) {
            if ($dosen->pembimbing == 'pembimbing 1') {
                $pembimbing1 = $dosen->dosen_id;
            } else if ($dosen->pembimbing == 'pembimbing 2') {
                $pembimbing2 = $dosen->dosen_id;
            }
        }

        return view('mahasiswa.pengajuan-judul-edit', compact(
            'pengajuan',
            'dosenList',
            'pembimbing1',
            'pembimbing2'
        ));
    }

    public function update(Request $request, string $id)
    {
        $pengajuan = PengajuanJudul::with('detailDosen')->findOrFail($id);
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate pengajuan ini.');
        }

        $canBeUpdated = true;
        foreach ($pengajuan->detailDosen as $detail) {
            if ($detail->status == 'diterima') {
                $canBeUpdated = false;
                break;
            }
        }

        if (!$canBeUpdated) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Pengajuan yang sudah disetujui tidak dapat diupdate.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dosen_pembimbing1' => 'required|exists:dosen,id',
            'dosen_pembimbing2' => 'nullable|exists:dosen,id|different:dosen_pembimbing1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $pengajuan->judul = $request->judul;
            $pengajuan->deskripsi = $request->deskripsi;
            $pengajuan->save();

            foreach ($pengajuan->detailDosen as $detail) {
                if ($detail->status == 'ditolak' || $detail->status == 'diproses') {
                   DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                              ->where('pembimbing', $detail->pembimbing)
                              ->update([
                                  'status' => 'diproses',
                                  'alasan_dibatalkan' => null,
                              ]);
                }
            }

            $pembimbing1Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 1')->first();
            if ($pembimbing1Detail) {
                DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                           ->where('pembimbing', 'pembimbing 1')
                           ->update([
                               'dosen_id' => $request->dosen_pembimbing1,
                               'status' => 'diproses',
                               'alasan_dibatalkan' => null,
                           ]);
            } else {
                DetailDosen::create([
                    'dosen_id' => $request->dosen_pembimbing1,
                    'pengajuan_judul_id' => $pengajuan->id,
                    'pembimbing' => 'pembimbing 1',
                    'status' => 'diproses',
                ]);
            }

            $pembimbing2Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 2')->first();
            if ($request->has('dosen_pembimbing2') && $request->dosen_pembimbing2) {
                if ($pembimbing2Detail) {
                    DetailDosen::where('pengajuan_judul_id', $pengajuan->id)
                               ->where('pembimbing', 'pembimbing 2')
                               ->update([
                                   'dosen_id' => $request->dosen_pembimbing2,
                                   'status' => 'diproses',
                                   'alasan_dibatalkan' => null,
                               ]);
                } else {
                    DetailDosen::create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pengajuan_judul_id' => $pengajuan->id,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
            } else if ($pembimbing2Detail) {
                $pembimbing2Detail->delete();
            }

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', 'Pengajuan judul berhasil diperbarui dan sedang diproses ulang.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat mengupdate pengajuan judul: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Terjadi kesalahan saat mengupdate pengajuan judul. ' . $e->getMessage());
        }
    }

public function destroy(string $id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus pengajuan ini.');
        }

        try {
            DB::beginTransaction();

            $pengajuan->delete(); // Ini seharusnya akan menghapus detailDosen jika telah dikonfigurasi di model

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', 'Pengajuan judul berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat menghapus pengajuan judul: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pengajuan judul. ' . $e->getMessage());
        }
    }
}
