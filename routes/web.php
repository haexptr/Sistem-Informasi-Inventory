<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\QRCodeController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Fallback untuk logout via GET (Sidebar Menu AdminLTE)
Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('barang', BarangController::class);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/barang', [LaporanController::class, 'barang'])->name('laporan.barang');
        Route::get('laporan/masuk', [LaporanController::class, 'masuk'])->name('laporan.masuk');
        Route::get('laporan/keluar', [LaporanController::class, 'keluar'])->name('laporan.keluar');
    });

    // Transactions (Accessible by both Admin and Petugas)
    Route::resource('transaksi-masuk', TransaksiMasukController::class);
    Route::resource('transaksi-keluar', TransaksiKeluarController::class);
    
    // AJAX
    Route::get('/api/barang/{kode}', [QRCodeController::class, 'getBarang']);
});
