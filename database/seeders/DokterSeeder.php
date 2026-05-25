<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokter;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run()
    {
        Dokter::create([
            'nama_dokter' => 'dr. Krisna Prabowo, Sp.F',
            'no_str' => 'STR-123456-2026',
            'spesialisasi' => 'Umum',
            'no_telp' => '08123456789',
            'email' => 'krisna@simrs.com',
            'password' => Hash::make('password123'), // Password login kamu
            'status' => 'Aktif'
        ]);
    }
}