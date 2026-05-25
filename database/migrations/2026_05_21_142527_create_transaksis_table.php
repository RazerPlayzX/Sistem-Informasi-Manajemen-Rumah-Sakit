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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique();
        $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
        $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
        $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
        $table->integer('biaya_dokter');
        $table->integer('biaya_obat');
        $table->integer('total_bayar');
        $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
