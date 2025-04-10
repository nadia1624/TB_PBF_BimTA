<?php


use App\Http\Controllers\Dosen\JadwalBimbinganController;
use App\Http\Controllers\Dosen\DokumenOnlineController;
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
    Route::get('dokumen-online', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'index'])
        ->name('dokumen.online');
    Route::put('dokumen-online/{id}', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'update'])
        ->name('dokumen.update');
    Route::get('dokumen-online/download-mahasiswa/{id}', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'downloadMahasiswaDocument'])
        ->name('dokumen.download-mahasiswa');
    Route::get('dokumen-online/download-dosen/{id}', [App\Http\Controllers\Dosen\DokumenOnlineController::class, 'downloadDosenDocument'])
        ->name('dokumen.download-dosen');
});
