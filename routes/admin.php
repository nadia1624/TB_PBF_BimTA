<?php

use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');

    Route::get('/admin/dosen', [DosenController::class, 'index'])->name('admin.dosen');

    Route::post('/admin/bidang', [DosenController::class, 'create'])->name('admin.bidang.create');

    Route::post('/admin/dosen', [DosenController::class, 'store'])->name('admin.dosen.store');

    Route::get('/admin/dosen/{id}/edit', [DosenController::class, 'edit'])->name('admin.dosen.edit');

    Route::put('/admin/dosen/update', [DosenController::class, 'update'])->name('admin.dosen.update');
    Route::delete('/admin/dosen/delete', [DosenController::class, 'delete'])->name('admin.dosen.delete');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pengajuan-ta', [App\Http\Controllers\Admin\PengajuanController::class, 'index'])->name('pengajuanta');
    Route::post('/pengajuan-ta/filter', [App\Http\Controllers\Admin\PengajuanController::class, 'filter'])->name('pengajuanta.filter');
    Route::get('/pengajuan-ta/{id}/detail', [App\Http\Controllers\Admin\PengajuanController::class, 'detail'])->name('pengajuanta.detail');
    Route::put('/pengajuan-ta/{id}/status', [App\Http\Controllers\Admin\PengajuanController::class, 'updateStatus'])->name('pengajuanta.status');
});


});

