<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Biar bisa buat login Auth
use Illuminate\Notifications\Notifiable;

class Dokter extends Authenticatable
{
    use Notifiable;

    protected $table = 'dokter';

    protected $fillable = [
        'nama_dokter', 'no_str', 'spesialisasi', 'no_telp', 'email', 'password', 'status'
    ];

    protected $hidden = ['password'];
}