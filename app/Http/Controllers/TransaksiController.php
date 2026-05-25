<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    // GET semua data transaksi - Bisa membedakan Web Blade dan AJAX
    public function index(Request $request)
    {
        // Ambil data transaksi beserta relasi pasien, dokter, dan obatnya
        $transaksi = Transaksi::with(['pasien', 'dokter', 'obat'])->get();

        // JIKA MENYIKAT LEWAT AJAX FETCH JAVASCRIPT
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $transaksi
            ], 200);
        }

        // JIKA DIKETIK LANGSUNG DI BROWSER / NAVBAR
        return view('transaksi');
    }

    // POST - Catat transaksi baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_transaksi'    => 'required|unique:transaksis,kode_transaksi',
            'pasien_id'         => 'required|exists:pasien,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'obat_id'           => 'required|exists:obats,id',
            'biaya_dokter'      => 'required|numeric|min:0',
            'biaya_obat'        => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Belum Lunas,Lunas'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $total = $request->biaya_dokter + $request->biaya_obat;
        
        $transaksi = Transaksi::create(array_merge($request->all(), [
            'total_bayar' => $total
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Invoice transaksi berhasil dicatat di kasir.',
            'data'    => $transaksi
        ], 201);
    }

    // GET satu data transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with(['pasien', 'dokter', 'obat'])->find($id);
        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $transaksi], 200);
    }

    // PUT - update data transaksi
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_transaksi'    => 'required|unique:transaksis,kode_transaksi,' . $id,
            'pasien_id'         => 'required|exists:pasien,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'obat_id'           => 'required|exists:obats,id',
            'biaya_dokter'      => 'required|numeric|min:0',
            'biaya_obat'        => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Belum Lunas,Lunas'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $total = $request->biaya_dokter + $request->biaya_obat;
        $transaksi->update(array_merge($request->all(), ['total_bayar' => $total]));

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran invoice berhasil diperbarui.'
        ], 200);
    }

    // DELETE - hapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $transaksi->delete();
        return response()->json(['success' => true, 'message' => 'Nota invoice berhasil dihapus.'], 200);
    }
}