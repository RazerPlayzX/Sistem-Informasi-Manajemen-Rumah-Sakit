<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database secara eksplisit
    protected $table = 'pasien';

    protected $fillable = [
        'nomor_rm',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_tinggal',
        'nomor_hp',
        'golongan_darah',
        'pekerjaan',
        'status_pernikahan',
        'user_id'
    ];
}