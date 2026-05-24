<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $fillable = [
        'nama_ruangan',
        'kode_ruangan',
        'jenis_ruangan',
        'kapasitas',
        'terisi',
        'status',
        'keterangan'
    ];
}
