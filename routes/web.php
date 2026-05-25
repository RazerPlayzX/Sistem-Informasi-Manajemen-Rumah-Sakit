<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('obat');
});
Route::get('/transaksi', function () {
    return view('transaksi');
});