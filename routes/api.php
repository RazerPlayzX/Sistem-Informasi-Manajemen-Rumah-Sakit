<?php

use App\Http\Controllers\ObatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\RuanganController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\TransaksiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('transaksi', TransaksiController::class);
Route::apiResource('obats', ObatController::class);
Route::apiResource('dokter', DokterController::class);
Route::apiResource('/ruangans', RuanganController::class);
