<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import semua Controller API/Resource Kelompok
use App\Http\Controllers\PasienController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RuanganController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- ENDPOINT DATA CRUD KELOMPOK (Ditembak lewat AJAX) ---
Route::apiResource('pasien', PasienController::class);
Route::apiResource('transaksi', TransaksiController::class);
Route::apiResource('obats', ObatController::class);
Route::apiResource('dokter', DokterController::class);
Route::apiResource('ruangans', RuanganController::class);