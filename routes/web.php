<?php

use App\Http\Controllers\JasaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin CRUD Cari Jasa
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route untuk Cari Jasa
    Route::get('/cari_jasa', [JasaController::class, 'index'])->name('cari_jasa.index'); // Tambahkan ini
    Route::get('/cari_jasa/create', [JasaController::class, 'create'])->name('cari_jasa.create');
    Route::post('/cari_jasa', [JasaController::class, 'store'])->name('cari_jasa.store'); // Tambahkan ini
    Route::get('/cari_jasa/{cari_jasa}', [JasaController::class, 'show'])->name('cari_jasa.show'); // Perbaiki ini
    Route::get('/cari_jasa/{cari_jasa}/edit', [JasaController::class, 'edit'])->name('cari_jasa.edit');
    Route::put('/cari_jasa/{cari_jasa}', [JasaController::class, 'update'])->name('cari_jasa.update');
    Route::delete('/cari_jasa/{cari_jasa}', [JasaController::class, 'destroy'])->name('cari_jasa.destroy'); // Perbaiki ini
});

require __DIR__.'/auth.php';
