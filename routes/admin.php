<?php

use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\DetailPengajuanController;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [MahasiswaController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');

    Route::post('/admin/mahasiswa', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');

    Route::patch('/admin/mahasiswa/update', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');

    Route::get('/admin/dosen', [DosenController::class, 'index'])->name('admin.dosen');

    Route::post('/admin/bidang', [DosenController::class, 'create'])->name('admin.bidang.create');

    Route::post('/admin/dosen', [DosenController::class, 'store'])->name('admin.dosen.store');

    Route::put('/admin/dosen/update', [DosenController::class, 'update'])->name('admin.dosen.update');

    Route::delete('/admin/dosen/delete', [DosenController::class, 'delete'])->name('admin.dosen.delete');

    Route::delete('/admin/keahlian/delete', [DosenController::class, 'destroy'])->name('admin.keahlian.delete');

    Route::put('/admin/keahlian/update', [DosenController::class, 'edit'])->name('admin.keahlian.update');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pengajuan-ta', [App\Http\Controllers\Admin\PengajuanController::class, 'index'])->name('pengajuanta');
    Route::post('/pengajuan-ta/filter', [App\Http\Controllers\Admin\PengajuanController::class, 'filter'])->name('pengajuanta.filter');
     // Detail Pengajuan TA routes
     Route::get('/pengajuan-ta/{id}/detail', [DetailPengajuanController::class, 'index'])->name('pengajuanta.detail');
     Route::put('/pengajuan-ta/{id}/status', [DetailPengajuanController::class, 'updateStatus'])->name('pengajuanta.status');
 });


});

