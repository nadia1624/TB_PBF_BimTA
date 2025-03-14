<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\PengajuanJudulController;
use App\Http\Controllers\Mahasiswa\JadwalBimbinganController;
use App\Http\Controllers\Mahasiswa\BimbinganController;

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->group(function () {
    // Menampilkan daftar pengajuan judul
    Route::get('/pengajuan-judul', [PengajuanJudulController::class, 'index'])->name('pengajuan-judul');

    // Menampilkan form pengajuan judul
    Route::get('/pengajuan-judul/create', [PengajuanJudulController::class, 'create'])->name('pengajuan-judul.create');

    // Menyimpan pengajuan judul
    Route::post('/pengajuan-judul', [PengajuanJudulController::class, 'store'])->name('pengajuan-judul.store');
});

Route::get('/jadwal-bimbingan', [JadwalBimbinganController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('jadwal-bimbingan');

Route::get('/bimbingan', [BimbinganController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('bimbingan');

