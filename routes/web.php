<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo')->name('home');

/*
 * Demo TDA Connect Depok. Data statis dari DemoController, belum ada auth —
 * ini scaffold presentasi, bukan integrasi ke bizmap_app produksi.
 */
Route::prefix('demo')->name('demo.')->group(function () {
    Route::get('/', [DemoController::class, 'beranda'])->name('beranda');
    Route::get('bisnis', [DemoController::class, 'bisnis'])->name('bisnis');
    Route::get('level-usaha', [DemoController::class, 'levelUsaha'])->name('level-usaha');
    Route::get('pengadaan', [DemoController::class, 'pengadaan'])->name('pengadaan');
    Route::get('pengurus/verifikasi', [DemoController::class, 'verifikasi'])->name('pengurus.verifikasi');
});

Route::inertia('dashboard', 'Dashboard')->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Authenticated app routes can be added here when this demo becomes a full MVP.
});

require __DIR__.'/settings.php';
