<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controller dari Modul Pasien
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PasienApiController;

// Import Controller dari Modul Obat, Dokter, Ruangan, dan Transaksi
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\RuanganController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\TransaksiController;

// Rute Bawaan Sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- DAFTAR RUTE API SIMRS KELOMPOK ---

// Rute Modul Pasien
Route::apiResource('pasien', PasienController::class);

// Rute Modul Transaksi, Obat, Dokter, dan Ruangan
Route::apiResource('transaksi', TransaksiController::class);
Route::apiResource('obats', ObatController::class);
Route::apiResource('dokter', DokterController::class);
Route::apiResource('ruangans', RuanganController::class); // Tanda '/' di depan sudah dihapus agar standar