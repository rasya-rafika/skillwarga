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

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - PENTING: Letakkan route dengan parameter paling atas
Route::middleware(['auth', 'role:admin'])->group(function () {
    // CRUD operations untuk jasa
    Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
    Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
    Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
    Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
    Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');
    
    // Toggle status jasa
    Route::patch('/jasa/{jasa}/toggle-status', [JasaController::class, 'toggleStatus'])->name('jasa.toggle-status');
    
    // Alternative admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/jasa', [JasaController::class, 'index'])->name('jasa.index');
        Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
        Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
        Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
        Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
        Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');
        Route::patch('/jasa/{jasa}/toggle-status', [JasaController::class, 'toggleStatus'])->name('jasa.toggle-status');
    });
});

// Public routes - Letakkan route dengan parameter di bawah route spesifik
Route::get('/jasa', [JasaController::class, 'index'])->name('jasa.index');
Route::get('/jasa/{jasa}', [JasaController::class, 'show'])->name('jasa.show');

// Backward compatibility - redirect old routes
Route::get('/cari_jasa', function () {
    return redirect()->route('jasa.index');
});

Route::get('/admin/jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

Route::get('/cari_jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';