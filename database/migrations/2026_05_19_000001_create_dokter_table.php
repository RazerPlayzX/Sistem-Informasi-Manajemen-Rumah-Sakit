<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('dokter', function (Blueprint $table) {
        $table->id();
        $table->string('nama_dokter');
        $table->string('no_str', 20)->unique(); // Surat Tanda Registrasi
        $table->enum('spesialisasi', [
            'Umum', 'Anak', 'Bedah', 'Penyakit Dalam',
            'Kandungan', 'Jantung', 'Saraf', 'Mata',
            'THT', 'Kulit', 'Gigi', 'Jiwa'
        ]);
        $table->string('no_telp', 15);
        $table->string('email')->unique();
        $table->string('password'); // <-- Tambahkan ini untuk fitur login dokter
        $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
        $table->timestamps();
    });
}
};
