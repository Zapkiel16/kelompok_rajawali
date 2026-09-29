<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');
Route::get('/checkout/status/{transaksi}', [CheckoutController::class, 'status'])->name('checkout.status');