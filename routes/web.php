<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Middleware\HarusAdaPemesan;

// Halaman utama: langsung menu jajanan, tanpa login
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

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

// Masukin ke keranjang, keranjang, checkout, pesanan: harus login atau sudah isi biodata tamu
Route::middleware(HarusAdaPemesan::class)->group(function () {
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

// Halaman status: hanya pemilik pesanan yang boleh membuka (dicek di controller)
Route::get('/checkout/status/{transaksi}', [CheckoutController::class, 'status'])->name('checkout.status');

Route::get('/profil', function () {
    return view('profil');
})->name('profil.index');

Route::get('/logout', [LogoutController::class, 'konfirmasi'])->name('logout.konfirmasi');
Route::post('/logout', [LogoutController::class, 'keluar'])->name('logout');