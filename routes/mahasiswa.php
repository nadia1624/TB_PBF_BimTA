<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\PengajuanJudulController;
use App\Http\Controllers\Mahasiswa\JadwalBimbinganController;
use App\Http\Controllers\Mahasiswa\BimbinganController;

Route::middleware(['auth', 'verified', 'role:mahasiswa'])
    ->prefix('mahasiswa')  // Add this
    ->name('mahasiswa.')   // Add this
    ->group(function () {
        Route::get('/pengajuan-judul', [PengajuanJudulController::class, 'index'])->name('pengajuan-judul.index');
        Route::get('/pengajuan-judul/create', [PengajuanJudulController::class, 'create'])->name('pengajuan-judul.create');
        Route::post('/pengajuan-judul', [PengajuanJudulController::class, 'store'])->name('pengajuan-judul.store');
        Route::delete('/pengajuan-judul/{id}', [PengajuanJudulController::class, 'destroy'])->name('pengajuan-judul.destroy');
    });

