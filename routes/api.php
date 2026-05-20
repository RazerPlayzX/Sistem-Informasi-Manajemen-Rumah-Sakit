<?php

use App\Http\Controllers\ObatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Kode bawaan Laravel (Biarkan saja, tidak usah dihapus)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. Tambahkan rute Modul Obat milikmu di bawah sini
Route::apiResource('obats', ObatController::class);