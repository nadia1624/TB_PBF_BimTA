<?php


use App\Http\Controllers\Dosen\JadwalBimbinganController;
use App\Http\Controllers\Dosen\DokumenOnlineController;
use App\Http\Controllers\Dosen\PengajuanJudulController;
use Illuminate\Support\Facades\Route;


// Semua route di sini akan dikelompokkan dengan prefix 'dosen'
// Perhatikan bahwa Anda tidak perlu menambahkan middleware dan prefix lagi
// karena sudah ada di web.php


Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    // Dashboard dosen
    Route::get('/dashboard', [JadwalBimbinganController::class, 'dashboard'])->name('dashboard');


    // Jadwal Bimbingan
    Route::get('/jadwal-bimbingan', [JadwalBimbinganController::class, 'jadwalBimbingan'])->name('jadwal-bimbingan');


    // Accept/Reject jadwal
    Route::post('/jadwal-bimbingan/accept/{id}', [JadwalBimbinganController::class, 'accept'])->name('jadwal-accept');
    Route::post('/jadwal-bimbingan/reject/{id}', [JadwalBimbinganController::class, 'reject'])->name('jadwal-reject');


    // Dokumen Online
    Route::get('/dokumen-online', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'index'])
        ->name('dokumen.online');
    Route::post('/dokumen-online/{id}', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'update'])
        ->name('dokumen.online.update');
    Route::get('/dokumen-online/{id}/view', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'viewMahasiswaDocument'])
        ->name('dokumen.online.view');
    Route::get('/dokumen-online/{id}/download', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'downloadMahasiswaDocument'])
        ->name('dokumen.online.download');
    Route::get('/dokumen-online/{id}/download-dosen', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'downloadDosenDocument'])
        ->name('dokumen.online.download.dosen');

      // Pengajuan Judul routes
    Route::get('/pengajuanjudul', [PengajuanJudulController::class, 'index'])->name('dosen.pengajuan.index');
    Route::get('/pengajuanjudul/{id}', [PengajuanJudulController::class, 'detail'])->name('dosen.pengajuan.detail');
    Route::put('/pengajuanjudul/{id}/status', [PengajuanJudulController::class, 'updateStatus'])->name('dosen.pengajuan.status');

    // Tambahan route untuk pengajuan judul
    Route::get('/pengajuanjudul/create', [PengajuanJudulController::class, 'create'])->name('dosen.pengajuan.create');
    Route::post('/pengajuanjudul', [PengajuanJudulController::class, 'store'])->name('dosen.pengajuan.store');
    Route::get('/pengajuanjudul/{id}/edit', [PengajuanJudulController::class, 'edit'])->name('dosen.pengajuan.edit');
    Route::put('/pengajuanjudul/{id}', [PengajuanJudulController::class, 'update'])->name('dosen.pengajuan.update');
    Route::delete('/pengajuanjudul/{id}', [PengajuanJudulController::class, 'destroy'])->name('dosen.pengajuan.destroy');
});
