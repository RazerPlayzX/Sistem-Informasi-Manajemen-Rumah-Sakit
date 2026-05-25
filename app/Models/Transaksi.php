<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi', 
        'pasien_id', 
        'dokter_id', 
        'obat_id', 
        'biaya_dokter', 
        'biaya_obat', 
        'total_bayar', 
        'status_pembayaran'
    ];

    public function pasien() { return $this->belongsTo(Pasien::class, 'pasien_id'); }
    public function dokter() { return $this->belongsTo(Dokter::class, 'dokter_id'); }
    public function obat() { return $this->belongsTo(Obat::class, 'obat_id'); }
}