<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    // Mengizinkan kolom diisi melalui query massal
    protected $fillable = ['nama_obat', 'jenis_obat', 'harga', 'stok'];
}