<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

// Rute Halaman Utama (Menampilkan Modul Obat Krisna)
Route::get('/', function () {
    return view('obat');
});

// Rute Modul Transaksi
Route::get('/transaksi', function () {
    return view('transaksi');
});

// Rute Modul Pasien (Menggunakan Controller agar Data Ter-render)
Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/create', function () {
    return view('pasien.create'); 
});
Route::get('/pasien/{id}', [PasienController::class, 'show']); // Untuk Detail Pasien
Route::get('/pasien/{id}/edit', [PasienController::class, 'edit']); // Untuk Form Edit Pasien