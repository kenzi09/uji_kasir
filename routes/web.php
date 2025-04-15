<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [UserController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [UserController::class, 'login_proses'])->name('login-proses');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'dashboardpetugas'])->name('dashboard');
    Route::get('/produks', [ProdukController::class, 'index'])->name('produks.index');

    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');

    Route::post('/pembelian/detail', [PembelianController::class, 'detail'])->name('pembelian.detail');
    Route::get('/pembelian/struk/{id}', [PembelianController::class, 'struk'])->name('pembelian.struk');

    Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::post('/pembelian/store-step2', [PembelianController::class, 'storeStep2'])->name('pembelian.storeStep2');

    Route::get('/pembelian/member', [PembelianController::class, 'member'])->name('pembelian.member');

    Route::get('/pembelian/{id}', [PembelianController::class, 'show'])->name('pembelian.show');
    
    Route::get('/pembelian/export', [PembelianController::class, 'export'])->name('pembelian.export');
    
    Route::get('/pembelian/{id}/download-pdf', [PembelianController::class, 'downloadPdf'])->name('pembelian.downloadPdf');

});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/produks', [ProdukController::class, 'index'])->name('produks.index');
    Route::get('/produks/create', [ProdukController::class, 'create'])->name('produks.create');
    Route::post('/produks/store', [ProdukController::class, 'store'])->name('produks.store');
    Route::get('/produks/show/{id}', [ProdukController::class, 'show'])->name('produks.show');
    Route::get('/produks/edit/{id}', [ProdukController::class, 'edit'])->name('produks.edit');
    Route::put('/produks/{id}', [ProdukController::class, 'update'])->name('produks.update');
    Route::post('/produk/updateStock/{id}', [ProdukController::class, 'updateStock'])->name('produk.updateStock');
    Route::delete('/produks/{id}', [ProdukController::class, 'destroy'])->name('produks.destroy');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [AkunController::class, 'index'])->name('index');
        Route::get('/create', [AkunController::class, 'create'])->name('create');
        Route::post('/store', [AkunController::class, 'store'])->name('store');
    });

    
    Route::get('/pembelian', [PembelianController::class, 'indexAdmin'])->name('pembelian.index');
    Route::get('/pembelian/export', [PembelianController::class, 'export'])->name('pembelian.export');
});