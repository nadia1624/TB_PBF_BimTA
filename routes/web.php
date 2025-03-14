<?php

use App\Http\Controllers\JadwalBimbinganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
    });

    // Routes for Dosen
    Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        // Jadwal Bimbingan routes for Dosen
        // These will be implemented later
    });
});

require __DIR__.'/auth.php';
