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
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->string('kode_ruangan', 10)->unique();
            $table->enum('jenis_ruangan', ['ICU', 'VIP', 'Kelas 1', 'Kelas 2', 'Kelas 3', 'UGD', 'OK']);
            $table->integer('kapasitas');
            $table->integer('terisi')->default(0);
            $table->enum('status', ['Tersedia', 'Penuh', 'Maintenance'])->default('Tersedia');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
