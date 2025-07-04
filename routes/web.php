<?php

use App\Http\Controllers\DaftarJasaController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Backward compatibility redirects
Route::get('/cari_jasa', function () {
    return redirect()->route('jasa.index');
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - PENTING: Letakkan route spesifik SEBELUM route dengan parameter
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Direct admin routes (route spesifik harus di atas)
    Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
    Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
    Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
    Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
    Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');
    Route::patch('/jasa/{jasa}/toggle-status', [JasaController::class, 'toggleStatus'])->name('jasa.toggle-status');
    
    // Alternative admin routes dengan prefix
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/jasa', [JasaController::class, 'index'])->name('jasa.index');
        Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
        Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
        Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
        Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
        Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');
        Route::patch('/jasa/{jasa}/toggle-status', [JasaController::class, 'toggleStatus'])->name('jasa.toggle-status');
    });
    
    // Admin specific routes untuk daftar jasa
    Route::get('/daftar_jasa/{daftar_jasa}', [DaftarJasaController::class, 'show'])->name('daftar_jasa.show');
    Route::patch('/daftar_jasa/{daftar_jasa}/mark-read', [DaftarJasaController::class, 'markAsRead'])->name('daftar_jasa.mark-read');
    Route::delete('/daftar_jasa/{daftar_jasa}', [DaftarJasaController::class, 'destroy'])->name('daftar_jasa.destroy');
    Route::delete('/daftar_jasa/{daftar_jasa}/gambar', [DaftarJasaController::class, 'destroyGambar'])->name('daftar_jasa.gambar.destroy');
});

// Routes untuk daftar jasa - accessible untuk semua authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/daftar_jasa', [DaftarJasaController::class, 'index'])->name('daftar_jasa.index');
    Route::post('/daftar_jasa', [DaftarJasaController::class, 'store'])->name('daftar_jasa.store');
});

// Public routes - PENTING: Letakkan route dengan parameter di bawah route spesifik
Route::get('/jasa', [JasaController::class, 'index'])->name('jasa.index');
Route::get('/jasa/{jasa}', [JasaController::class, 'show'])->name('jasa.show');

// Redirect routes
Route::get('/admin/jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

Route::get('/cari_jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';