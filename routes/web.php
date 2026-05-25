<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Transaksi;

// --- SISTEM OTENTIKASI DOKTER ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ZONE PROTEKSI (Wajib Login untuk Masuk Halaman SIMRS) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard Utama (Tampilan Statistik)
    Route::get('/', function () {
        $stats = [
            'pasien' => Pasien::count(),
            'dokter' => Dokter::count(),
            'obat' => Obat::count(),
            'transaksi' => Transaksi::where('status_pembayaran', 'Lunas')->sum('total_bayar')
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // 2. Modul Tampilan HTML Pasien (Hanya render View, proses CRUD via API)
    Route::get('/pasien', function () { return view('pasien'); })->name('pasien.index');
    // 3. Modul Tampilan HTML Obat (Krisna)
    Route::get('/obat', function () { return view('obat'); })->name('obat.index');

    // 4. Modul Tampilan HTML Transaksi
    Route::get('/transaksi', function () { return view('transaksi'); })->name('transaksi.index');

    // 5. Modul Tampilan HTML Ruangan
    Route::get('/ruangan', function () { return view('ruangan'); })->name('ruangan.index');

    // 6. Modul Tampilan HTML Dokter
    Route::get('/dokter', function () { return view('dokter'); })->name('dokter.index');
});