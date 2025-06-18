<?php

use App\Http\Controllers\JadwalBimbinganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for Mahasiswa
    Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        // Jadwal Bimbingan routes
        Route::get('/jadwal-bimbingan', [JadwalBimbinganController::class, 'index'])
            ->name('jadwal-bimbingan.index');
        Route::post('/jadwal-bimbingan', [JadwalBimbinganController::class, 'store'])
            ->name('jadwal-bimbingan.store');
        Route::get('/jadwal-bimbingan/{id}', [JadwalBimbinganController::class, 'show'])
            ->name('jadwal-bimbingan.show');
        Route::delete('/jadwal-bimbingan/{id}', [JadwalBimbinganController::class, 'destroy'])
            ->name('jadwal-bimbingan.destroy');

        // Dokumen Online routes
        Route::post('/jadwal-bimbingan/{jadwalId}/dokumen', [JadwalBimbinganController::class, 'uploadDokumen'])
            ->name('jadwal-bimbingan.upload-dokumen');
        Route::get('/jadwal-bimbingan/{jadwalId}/dokumen/{dokumenId}', [JadwalBimbinganController::class, 'showDokumen'])
            ->name('jadwal-bimbingan.show-dokumen');
        Route::get('/dokumen-review/download/{id}', [JadwalBimbinganController::class, 'downloadReviewDocument'])->name('dokumen.review.download');
    });

    // Routes for Dosen

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/mahasiswa.php';
require __DIR__ . '/dosen.php';
