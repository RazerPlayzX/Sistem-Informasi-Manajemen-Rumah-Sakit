<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');     // Nama Obat
            $table->string('jenis_obat');    // Jenis Obat (Tablet, Sirup, dll)
            $table->integer('harga');        // Harga Obat
            $table->integer('stok');         // Stok Obat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};