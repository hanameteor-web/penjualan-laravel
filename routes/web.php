<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    return view('welcome');
});

// 🌸 Rute CRUD Penjualan (otomatis lengkap)
Route::resource('penjualan', PenjualanController::class);
