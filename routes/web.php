<?php

use App\Http\Controllers\DaftarJasaController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Debug route - untuk mengecek apakah route berfungsi
Route::get('/test-route', function () {
    return 'Route test berhasil!';
});

// Public routes - HARUS di atas sebelum middleware auth
Route::get('/jasa', [JasaController::class, 'index'])->name('jasa.index');
Route::get('/jasa/{jasa}', [JasaController::class, 'show'])->name('jasa.show');

// Backward compatibility redirects
Route::get('/cari_jasa', function () {
    return redirect()->route('jasa.index');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes untuk daftar jasa - accessible untuk authenticated users
Route::middleware(['auth'])->group(function () {
    // Route utama untuk daftar jasa - akan handle berdasarkan role di controller
    Route::get('/daftar_jasa', [DaftarJasaController::class, 'index'])->name('daftar_jasa.index');
    Route::post('/daftar_jasa', [DaftarJasaController::class, 'store'])->name('daftar_jasa.store');
    
    // Route dengan case variations untuk compatibility
    Route::get('/Daftar_jasa', function () {
        return redirect()->route('daftar_jasa.index');
    });
    Route::get('/daftar-jasa', function () {
        return redirect()->route('daftar_jasa.index');
    });
});

// Admin routes - untuk admin saja
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes untuk daftar jasa
    Route::get('/daftar_jasa/{daftar_jasa}/show', [DaftarJasaController::class, 'show'])->name('daftar_jasa.show');
    Route::get('/daftar_jasa/{daftar_jasa}/edit', [DaftarJasaController::class, 'edit'])->name('daftar_jasa.edit');
    Route::put('/daftar_jasa/{daftar_jasa}', [DaftarJasaController::class, 'update'])->name('daftar_jasa.update');
    Route::delete('/daftar_jasa/{daftar_jasa}', [DaftarJasaController::class, 'destroy'])->name('daftar_jasa.destroy');
    Route::patch('/daftar_jasa/{daftar_jasa}/mark-read', [DaftarJasaController::class, 'markAsRead'])->name('daftar_jasa.mark-read');
    Route::delete('/daftar_jasa/{daftar_jasa}/gambar', [DaftarJasaController::class, 'destroyGambar'])->name('daftar_jasa.gambar.destroy');
    
    // Admin routes untuk jasa
    Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
    Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
    Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
    Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
    Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');
    Route::patch('/jasa/{jasa}/toggle-status', [JasaController::class, 'toggleStatus'])->name('jasa.toggle-status');
    
    // Admin prefix routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/daftar_jasa', [DaftarJasaController::class, 'adminIndex'])->name('daftar_jasa.index');
        Route::get('/jasa', [JasaController::class, 'adminIndex'])->name('jasa.index');
    });
});

// Redirect routes untuk backward compatibility
Route::get('/admin/jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

Route::get('/cari_jasa/create', function () {
    return redirect()->route('jasa.create');
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';