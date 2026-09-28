<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/detail/{id}', [DetailController::class, 'index']);