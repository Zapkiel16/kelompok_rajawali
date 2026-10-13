<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StokAdminController;
use App\Http\Middleware\HarusAdaPemesan;
use App\Http\Middleware\HarusAdmin;
use Illuminate\Support\Facades\Route;

// Masuk, daftar, lupa password, dan masuk sebagai tamu
Route::get('/masuk', [AuthController::class, 'formMasuk'])->name('masuk');
Route::post('/masuk', [AuthController::class, 'masuk'])->name('masuk.proses');
Route::get('/daftar', [AuthController::class, 'formDaftar'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'daftar'])->name('daftar.proses');
Route::get('/lupa-password', [AuthController::class, 'formLupa'])->name('lupa');
Route::post('/lupa-password', [AuthController::class, 'kirimLink'])->name('lupa.kirim');
Route::get('/reset-password/{token}', [AuthController::class, 'formReset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
Route::get('/tamu', [AuthController::class, 'formTamu'])->name('tamu');
Route::post('/tamu', [AuthController::class, 'simpanTamu'])->name('tamu.simpan');
Route::post('/stok', [StokAdminController::class, 'store'])->name('admin.stok.tambah');

// Semua halaman di bawah ini hanya bisa dibuka setelah login atau masuk sebagai tamu.
// Pengunjung baru otomatis diarahkan ke halaman masuk.
Route::middleware(HarusAdaPemesan::class)->group(function () {
    // Halaman utama (dashboard) dan detail produk
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/detail/{id}', [DetailController::class, 'index'])
        ->whereNumber('id')
        ->name('product.detail');

    // Keranjang, checkout, pesanan
    Route::post('/menu/tambah', [MenuController::class, 'tambah'])->name('menu.tambah');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'perbarui'])->name('keranjang.perbarui');
    Route::post('/keranjang/contoh', [KeranjangController::class, 'isiContoh'])->name('keranjang.contoh');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');
    Route::post('/checkout/promo', [CheckoutController::class, 'terapkanPromo'])->name('checkout.promo');
    Route::post('/checkout/promo/hapus', [CheckoutController::class, 'hapusPromo'])->name('checkout.promo.hapus');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
});

// Khusus akun admin: lihat dan atur stok produk
Route::middleware(HarusAdmin::class)->prefix('admin')->group(function () {
    Route::get('/stok', [StokAdminController::class, 'index'])->name('admin.stok');
    Route::post('/stok/{id}', [StokAdminController::class, 'perbarui'])
        ->whereNumber('id')
        ->name('admin.stok.perbarui');
});

// Halaman status: hanya pemilik pesanan yang boleh membuka (dicek di controller)
Route::get('/checkout/status/{transaksi}', [CheckoutController::class, 'status'])->name('checkout.status');

Route::get('/profil', function () {
    return view('profil');
})->name('profil.index');

Route::get('/logout', [LogoutController::class, 'konfirmasi'])->name('logout.konfirmasi');
Route::post('/logout', [LogoutController::class, 'keluar'])->name('logout');