<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

Route::get('/', function () {
    return view('welcome');
});

// Mengarahkan ke halaman index utama
Route::get('/pasien', function () {
    return view('pasien.index'); 
});

// Mengarahkan ke halaman formulir tambah data baru
Route::get('/pasien/create', function () {
    return view('pasien.create'); 
});


Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/{id}', [PasienController::class, 'show']); // Untuk Detail
Route::get('/pasien/{id}/edit', [PasienController::class, 'edit']); // Untuk Form Edit