<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index() {
        return response()->json(['success' => true, 'data' => Transaksi::all()], 200);
    }

    public function store(Request $request) {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksis',
            'nama_pasien' => 'required',
            'biaya_dokter' => 'required|numeric',
            'biaya_obat' => 'required|numeric',
            'status_pembayaran' => 'required'
        ]);
        $total = $request->biaya_dokter + $request->biaya_obat;
        $transaksi = Transaksi::create(array_merge($request->all(), ['total_bayar' => $total]));
        return response()->json(['success' => true, 'message' => 'Transaksi berhasil dicatat', 'data' => $transaksi], 201);
    }

    public function show($id) {
        $transaksi = Transaksi::find($id);
        return $transaksi ? response()->json(['success' => true, 'data' => $transaksi], 200) : response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $transaksi = Transaksi::find($id);
        if(!$transaksi) return response()->json(['success' => false], 404);
        $total = $request->biaya_dokter + $request->biaya_obat;
        $transaksi->update(array_merge($request->all(), ['total_bayar' => $total]));
        return response()->json(['success' => true, 'message' => 'Transaksi diperbarui'], 200);
    }

    public function destroy($id) {
        $transaksi = Transaksi::find($id);
        if($transaksi) $transaksi->delete();
        return response()->json(['success' => true, 'message' => 'Transaksi dihapus'], 200);
    }
}