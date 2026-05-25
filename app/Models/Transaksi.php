<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_transaksi', 'nama_pasien', 'biaya_dokter', 'biaya_obat', 'total_bayar', 'status_pembayaran'];
}
