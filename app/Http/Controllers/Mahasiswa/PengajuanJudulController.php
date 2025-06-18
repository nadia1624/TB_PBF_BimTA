<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailDosen;
use App\Models\Dosen;
use App\Models\PengajuanJudul;
use App\Models\BidangKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $allPengajuan = collect(); // Pastikan ini diinisialisasi
        $pembimbing1 = null;
        $pembimbing2 = null;
        $rejectedDosenId = null;
        $acceptedDosenId = null;
        $rejectedBy = null;
        $rejectedDetailDosen = null;
        $hasAccepted = false;
        $hasRejected = false;
        $action = $request->query('action');
        $displayForm = true;

        if ($isData) {
            $allPengajuan = PengajuanJudul::with(['detailDosen.dosen', 'mahasiswa'])
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $pengajuan = $allPengajuan->first();

            if ($pengajuan) {
                $detailDosen = $pengajuan->detailDosen;

                $pembimbing1Detail = $detailDosen->where('pembimbing', 'pembimbing 1')->first();
                $pembimbing2Detail = $detailDosen->where('pembimbing', 'pembimbing 2')->first();

                $pembimbing1 = $pembimbing1Detail->dosen_id ?? null;
                $pembimbing2 = $pembimbing2Detail->dosen_id ?? null;

                $p1Status = $pembimbing1Detail->status ?? null;
                $p2Status = $pembimbing2Detail->status ?? null;

                $allAccepted = true;
                $anyRejected = false;
                $anyPending = false;

                foreach ($detailDosen as $detail) {
                    if ($detail->status === 'ditolak') {
                        $anyRejected = true;
                        if ($detail->pembimbing === 'pembimbing 1' || ($detail->pembimbing === 'pembimbing 2' && !$rejectedBy)) {
                            $rejectedDosenId = $detail->dosen_id;
                            $rejectedBy = $detail->pembimbing;
                            $rejectedDetailDosen = $detail;
                        }
                    } elseif ($detail->status === 'diproses') {
                        $anyPending = true;
                        $allAccepted = false;
                    } elseif ($detail->status === 'diterima') {
                        $hasAccepted = true;
                    }
                }

                $hasRejected = $anyRejected;

                if ($p1Status === 'diterima' && ($p2Status === 'diterima' || $pembimbing2 === null)) {
                    $displayForm = false;
                } elseif ($hasRejected) {
                    $displayForm = true;
                } elseif ($anyPending) {
                    $displayForm = false;
                } else {
                    $displayForm = true;
                }

                if ($action === 'resubmit') {
                    $displayForm = true;
                }

            } else {
                $displayForm = true;
            }
        } else {
            // Jika isData false (mahasiswa belum lengkap), maka tidak ada pengajuan
            // dan form harus disembunyikan sampai data lengkap
            $displayForm = false;
            // Penting: Pastikan $allPengajuan tetap Collection kosong di sini
            // $allPengajuan = collect(); // Ini sudah diinisialisasi di awal, jadi tidak perlu lagi
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
            'allPengajuan', // Pastikan ini selalu dikirim
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
            'displayForm'
        ));
    }
    public function create(Request $request)
    {

        $user = Auth::user();
        $dosenList = Dosen::all();
        $isData = $user && !empty($user->mahasiswa);
        $pengajuan = null;
        $pembimbing1 = null;
        $pembimbing2 = null;
        $rejectedDosenId = null;
        $acceptedDosenId = null;
        $hasAccepted = false;
        $hasRejected = false;
        $rejectedBy = null;
        $rejectedDetailDosen = null;
        $action = $request->query('action'); // Get action from query parameter if any

        if ($isData) {
            $pengajuan = PengajuanJudul::with('detailDosen')
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($pengajuan) {
                $detailDosen = $pengajuan->detailDosen;

                $pembimbing1Detail = $detailDosen->where('pembimbing', 'pembimbing 1')->first();
                $pembimbing2Detail = $detailDosen->where('pembimbing', 'pembimbing 2')->first();

                if ($pembimbing1Detail) {
                    $pembimbing1 = $pembimbing1Detail->dosen_id;
                    if ($pembimbing1Detail->status === 'ditolak') {
                        $rejectedDosenId = $pembimbing1Detail->dosen_id;
                        $rejectedBy = 'pembimbing 1';
                        $rejectedDetailDosen = $pembimbing1Detail;
                        $hasRejected = true;
                    } elseif ($pembimbing1Detail->status === 'diterima') {
                        $acceptedDosenId = $pembimbing1Detail->dosen_id;
                        $hasAccepted = true;
                    }
                }

                if ($pembimbing2Detail) {
                    $pembimbing2 = $pembimbing2Detail->dosen_id;
                    if ($pembimbing2Detail->status === 'ditolak') {
                        if (!$rejectedBy) { // Only set if pembimbing 1 didn't reject
                            $rejectedDosenId = $pembimbing2Detail->dosen_id;
                            $rejectedBy = 'pembimbing 2';
                            $rejectedDetailDosen = $pembimbing2Detail;
                        }
                        $hasRejected = true;
                    } elseif ($pembimbing2Detail->status === 'diterima') {
                        $acceptedDosenId = $pembimbing2Detail->dosen_id;
                        $hasAccepted = true;
                    }
                }

                // Logic based on requested action for pre-filling form
                if ($action === 'promote-advisor' && $pembimbing2Detail && $pembimbing2Detail->status === 'diterima') {
                    $pembimbing1 = $pembimbing2Detail->dosen_id;
                    $pembimbing2 = null; // Clear pembimbing 2 as it's promoted
                    $rejectedDosenId = null; // Clear rejection if promotion happens
                    $rejectedBy = null;
                    $rejectedDetailDosen = null;
                } elseif ($action === 'remove-advisor2' && $pembimbing2Detail && $pembimbing2Detail->status === 'ditolak') {
                    $pembimbing2 = null; // Clear pembimbing 2
                    $rejectedDosenId = null; // Clear rejection as it's removed
                    $rejectedBy = null;
                    $rejectedDetailDosen = null;
                }
            }
        }

        return view('mahasiswa.pengajuan-judul', compact(
            'dosenList',
            'isData',
            'pengajuan',
            'pembimbing1',
            'pembimbing2',
            'rejectedDosenId',
            'acceptedDosenId',
            'action', // Pass action to the view to guide JS behavior
            'hasAccepted',
            'hasRejected',
            'rejectedBy',
            'rejectedDetailDosen'
        ));
    }


public function store(Request $request)
{
    // Cek data yang dikirim dari form
    // dd($request->all());

    $user = Auth::user();

    if (!$user->mahasiswa) {
        return redirect()->route('mahasiswa.pengajuan-judul.index')
            ->with('error', 'Data mahasiswa belum lengkap. Silakan lengkapi profil Anda terlebih dahulu.');
    }

    $rules = [
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tanda_tangan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
    ];

    // Dapatkan pengajuan yang ada (jika ada) untuk menentukan validasi dosen
    $mahasiswa = $user->mahasiswa;
    $pengajuan = PengajuanJudul::where('mahasiswa_id', $mahasiswa->id)->first();
    $detailDosen = $pengajuan ? $pengajuan->detailDosen : collect();

    // ... (kode validasi rules yang lain)

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        DB::beginTransaction();

        // Handle file upload
        $tandaTanganPath = $pengajuan ? $pengajuan->tanda_tangan : null;
        if ($request->hasFile('tanda_tangan')) {
            if ($tandaTanganPath && Storage::disk('public')->exists($tandaTanganPath)) {
                Storage::disk('public')->delete($tandaTanganPath);
            }
            $file = $request->file('tanda_tanda'); // Perhatikan, ini harusnya 'tanda_tangan'
            $fileName = time() . '_' . $file->getClientOriginalName();
            $tandaTanganPath = $file->storeAs('tanda_tangan', $fileName, 'public');
        }

        // Cek apakah $pengajuan ditemukan atau tidak
        // dd('Pengajuan sebelum update:', $pengajuan); // Periksa objek $pengajuan di sini

        if ($pengajuan) { // Update existing submission
            // Cek apakah semua dosen sudah menerima
            $currentDetailDosen = $pengajuan->detailDosen;
            $allCurrentAccepted = $currentDetailDosen->where('status', 'diterima')->count() === $currentDetailDosen->count() && $currentDetailDosen->isNotEmpty();

            if ($allCurrentAccepted && empty($request->action)) {
                return redirect()->route('mahasiswa.pengajuan-judul.index')
                    ->with('error', 'Anda sudah memiliki judul yang disetujui. Tidak dapat mengajukan perubahan dosen.');
            }

            // Update judul, deskripsi, tanda tangan
            $pengajuan->judul = $request->judul;
            $pengajuan->deskripsi = $request->deskripsi;
            $pengajuan->tanda_tangan = $tandaTanganPath;
            $pengajuan->save(); // Pastikan ini berhasil dieksekusi

            // dd('Pengajuan setelah update:', $pengajuan); // Periksa objek $pengajuan setelah update

            $message = 'Pengajuan judul berhasil diperbarui.';

            // --- Handle different actions based on what the student chose ---
            if ($request->action === 'replace-advisor1') {
                $pembimbing1Detail = $detailDosen->where('pembimbing', 'pembimbing 1')->first();
                if ($pembimbing1Detail) {
                    $pembimbing1Detail->update([
                        'dosen_id' => $request->dosen_pembimbing1,
                        'status' => 'diproses',
                        'alasan_dibatalkan' => null,
                    ]);
                }
                // dd('Setelah replace-advisor1:', $pembimbing1Detail); // Cek apakah detail dosen terupdate
                $message = 'Dosen Pembimbing 1 berhasil diganti. Pengajuan diperbarui.';
            } elseif ($request->action === 'promote-advisor') {
                $pembimbing1Detail = $detailDosen->where('pembimbing', 'pembimbing 1')->first();
                $pembimbing2Detail = $detailDosen->where('pembimbing', 'pembimbing 2')->first();

                if ($pembimbing1Detail && $pembimbing2Detail && $pembimbing2Detail->status === 'diterima') {
                    $pembimbing1Detail->update([
                        'dosen_id' => $pembimbing2Detail->dosen_id,
                        'status' => 'diterima',
                        'alasan_dibatalkan' => null,
                    ]);
                    $pembimbing2Detail->delete();
                    $message = 'Dosen Pembimbing 2 berhasil dipromosikan menjadi Pembimbing 1. Pengajuan diperbarui.';
                } else {
                    throw new \Exception("Kondisi promosi dosen pembimbing tidak terpenuhi.");
                }
            } elseif ($request->action === 'replace-advisor2') {
                $pembimbing2Detail = $detailDosen->where('pembimbing', 'pembimbing 2')->first();
                if ($pembimbing2Detail) {
                    $pembimbing2Detail->update([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'status' => 'diproses',
                        'alasan_dibatalkan' => null,
                    ]);
                } else {
                    $pengajuan->detailDosen()->create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
                // dd('Setelah replace-advisor2:', $pembimbing2Detail); // Cek apakah detail dosen terupdate
                $message = 'Dosen Pembimbing 2 berhasil diganti. Pengajuan diperbarui.';
            } elseif ($request->action === 'remove-advisor2') {
                $pengajuan->detailDosen()->where('pembimbing', 'pembimbing 2')->delete();
                $message = 'Dosen Pembimbing 2 berhasil dihapus dari pengajuan. Pengajuan diperbarui.';
            } elseif ($request->action === 'resubmit') {
                $pengajuan->detailDosen()->delete();

                $pengajuan->detailDosen()->create([
                    'dosen_id' => $request->dosen_pembimbing1,
                    'pembimbing' => 'pembimbing 1',
                    'status' => 'diproses',
                ]);

                if ($request->dosen_pembimbing2) {
                    $pengajuan->detailDosen()->create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
                // dd('Setelah resubmit:', $pengajuan->detailDosen); // Cek detail dosen setelah resubmit
                $message = 'Pengajuan judul dan dosen pembimbing berhasil diajukan ulang.';
            } else {
                // Skenario default jika action tidak terdeteksi atau pengajuan baru
                // Ini akan terjadi jika mahasiswa mengklik "Ajukan Judul" tanpa action spesifik
                // dan $pengajuan sudah ada (mungkin hanya update judul/deskripsi tanpa perubahan dosen)
                $message = 'Pengajuan judul berhasil diperbarui.';
            }

        } else { // New submission
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'mahasiswa_id' => $mahasiswa->id,
                'approved_ta' => 'pending',
                'tanda_tangan' => $tandaTanganPath,
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajuan = PengajuanJudul::with(['detailDosen.dosen', 'mahasiswa'])->findOrFail($id);

        // Check if the current user is authorized to view this submission
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat pengajuan ini.');
        }

        $dosenList = Dosen::all();

        // Get pembimbing information
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengajuan = PengajuanJudul::with('detailDosen')->findOrFail($id);

        // Check if the current user is authorized to edit this submission
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit pengajuan ini.');
        }

        // Check if the submission can be edited (only pending or rejected can be edited)
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

        // Get pembimbing information
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengajuan = PengajuanJudul::with('detailDosen')->findOrFail($id);

        // Check if the current user is authorized to update this submission
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate pengajuan ini.');
        }

        // Check if the submission can be updated (only pending or rejected can be updated)
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
            'tanda_tangan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Upload tanda tangan if provided
            if ($request->hasFile('tanda_tangan')) {
                // Delete old file if exists
                if ($pengajuan->tanda_tangan) {
                    Storage::disk('public')->delete($pengajuan->tanda_tangan);
                }

                $file = $request->file('tanda_tangan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $tandaTanganPath = $file->storeAs('tanda_tangan', $fileName, 'public');
                $pengajuan->tanda_tangan = $tandaTanganPath;
            }

            // Update pengajuan
            $pengajuan->judul = $request->judul;
            $pengajuan->deskripsi = $request->deskripsi;
            $pengajuan->save();

            // Reset status for all detail dosen to diproses
            foreach ($pengajuan->detailDosen as $detail) {
                $detail->status = 'diproses';
                $detail->alasan_dibatalkan = null;
                $detail->save();
            }

            // Update pembimbing 1 if changed
            $pembimbing1Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 1')->first();
            if ($pembimbing1Detail && $pembimbing1Detail->dosen_id != $request->dosen_pembimbing1) {
                $pembimbing1Detail->dosen_id = $request->dosen_pembimbing1;
                $pembimbing1Detail->save();
            }

            // Update pembimbing 2 if provided
            $pembimbing2Detail = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 2')->first();
            if ($request->has('dosen_pembimbing2') && $request->dosen_pembimbing2) {
                if ($pembimbing2Detail) {
                    $pembimbing2Detail->dosen_id = $request->dosen_pembimbing2;
                    $pembimbing2Detail->save();
                } else {
                    // Create if not exists
                    DetailDosen::create([
                        'dosen_id' => $request->dosen_pembimbing2,
                        'pengajuan_judul_id' => $pengajuan->id,
                        'pembimbing' => 'pembimbing 2',
                        'status' => 'diproses',
                    ]);
                }
            } else if ($pembimbing2Detail) {
                // Remove if exists but not provided anymore
                $pembimbing2Detail->delete();
            }

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', 'Pengajuan judul berhasil diperbarui dan sedang diproses ulang.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Error saat mengupdate pengajuan judul: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Terjadi kesalahan saat mengupdate pengajuan judul. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);

        // Check if the current user is authorized to delete this submission
        $user = Auth::user();
        if ($user->mahasiswa->id != $pengajuan->mahasiswa_id) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus pengajuan ini.');
        }

        try {
            DB::beginTransaction();

            // Delete tanda tangan file if exists
            if ($pengajuan->tanda_tangan) {
                Storage::disk('public')->delete($pengajuan->tanda_tangan);
            }

            // DetailDosen records will be automatically deleted by cascade
            $pengajuan->delete();

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', 'Pengajuan judul berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
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
