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
        $isDataComplete = !empty($user->mahasiswa);

        // Get the latest submission for this student
        $pengajuan = null;
        $pembimbing1 = null;
        $pembimbing2 = null;

        if ($isDataComplete) {
            $pengajuan = PengajuanJudul::with('detailDosen')
                ->where('mahasiswa_id', $user->mahasiswa->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($pengajuan) {
                $detailDosen = DetailDosen::where('pengajuan_judul_id', $pengajuan->id)->get();

                foreach ($detailDosen as $dosen) {
                    if ($dosen->pembimbing == 'pembimbing 1') {
                        $pembimbing1 = $dosen->dosen_id;
                    } else if ($dosen->pembimbing == 'pembimbing 2') {
                        $pembimbing2 = $dosen->dosen_id;
                    }
                }
            }
        }

        $bidang_keahlian = BidangKeahlian::all();
        $dosenQuery = Dosen::with(['user', 'detailBidang.bidangKeahlian']);

    // Filter berdasarkan bidang keahlian jika ada
    if ($request->has('bidang') && $request->bidang !== 'all') {
        $bidangId = $request->bidang;
        $dosenQuery->whereHas('detailBidang', function($query) use ($bidangId) {
            $query->where('bidang_keahlian_id', $bidangId);
        });
    }

    $dosen = $dosenQuery->get();

        return view('mahasiswa.pengajuan-judul', compact(
            'dosenList',
            'isDataComplete',
            'pengajuan',
            'pembimbing1',
            'pembimbing2',
            'bidang_keahlian',
            'dosen'
        ));
    }

    public function create()
    {
        $user = Auth::user();

        // Check if user has an approved submission
        if ($user->mahasiswa) {
            $pengajuan = PengajuanJudul::whereHas('detailDosen', function($query) {
                $query->where('status', 'diterima');
            })->where('mahasiswa_id', $user->mahasiswa->id)
              ->first();

            if ($pengajuan) {
                return redirect()->route('mahasiswa.pengajuan-judul.index')
                    ->with('error', 'Anda sudah memiliki judul yang disetujui. Tidak dapat mengajukan judul baru.');
            }
        }

        $dosenList = Dosen::all();
        $isDataComplete = !empty($user->mahasiswa);

        // Reset the pengajuan to null to show the form for resubmission
        $pengajuan = null;
        $pembimbing1 = null;
        $pembimbing2 = null;

        return view('mahasiswa.pengajuan-judul', compact(
            'dosenList',
            'isDataComplete',
            'pengajuan',
            'pembimbing1',
            'pembimbing2'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Periksa apakah user memiliki data mahasiswa
        if (!$user->mahasiswa) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Data mahasiswa belum lengkap. Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // Check if user already has an approved submission
        $pengajuanDiterima = PengajuanJudul::whereHas('detailDosen', function($query) {
            $query->where('status', 'diterima');
        })->where('mahasiswa_id', $user->mahasiswa->id)
          ->first();

        if ($pengajuanDiterima) {
            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Anda sudah memiliki judul yang disetujui. Tidak dapat mengajukan judul baru.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dosen_pembimbing1' => 'required|exists:dosen,id',
            'dosen_pembimbing2' => 'nullable|exists:dosen,id|different:dosen_pembimbing1',
            'tanda_tangan' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Upload tanda tangan
            $tandaTanganPath = null;
            if ($request->hasFile('tanda_tangan')) {
                $file = $request->file('tanda_tangan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $tandaTanganPath = $file->storeAs('tanda_tangan', $fileName, 'public');
            }

            // Simpan pengajuan judul
            $mahasiswa = $user->mahasiswa;

            $pengajuanJudul = new PengajuanJudul();
            $pengajuanJudul->judul = $request->judul;
            $pengajuanJudul->deskripsi = $request->deskripsi;
            $pengajuanJudul->tanda_tangan = $tandaTanganPath;
            $pengajuanJudul->mahasiswa_id = $mahasiswa->id;
            $pengajuanJudul->approved_ta = 'pending'; // This is still needed for backwards compatibility
            $pengajuanJudul->save();

            // Log untuk debugging
            Log::info('Pengajuan judul berhasil disimpan', ['id' => $pengajuanJudul->id]);

            // Simpan detail dosen pembimbing 1
            DetailDosen::create([
                'dosen_id' => $request->dosen_pembimbing1,
                'pengajuan_judul_id' => $pengajuanJudul->id,
                'pembimbing' => 'pembimbing 1',
                'status' => 'diproses',
            ]);

            // Simpan detail dosen pembimbing 2 jika ada
            if ($request->has('dosen_pembimbing2') && $request->dosen_pembimbing2) {
                DetailDosen::create([
                    'dosen_id' => $request->dosen_pembimbing2,
                    'pengajuan_judul_id' => $pengajuanJudul->id,
                    'pembimbing' => 'pembimbing 2',
                    'status' => 'diproses',
                ]);
            }

            DB::commit();

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('success', 'Pengajuan judul berhasil disimpan dan sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Error saat menyimpan pengajuan judul: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('mahasiswa.pengajuan-judul.index')
                ->with('error', 'Terjadi kesalahan saat menyimpan pengajuan judul. ' . $e->getMessage());
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
