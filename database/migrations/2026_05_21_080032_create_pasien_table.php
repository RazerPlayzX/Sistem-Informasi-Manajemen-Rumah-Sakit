<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nama tabel diubah menjadi 'pasien'
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rm')->unique(); // Nomor Rekam Medis
            $table->string('nik', 16)->unique(); // Nomor Induk Kependudukan
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_tinggal');
            $table->string('nomor_hp', 15);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_pernikahan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            
            // Relasi ke tabel users (opsional)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};