<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    /**
     * Menampilkan halaman utama obat / menyuplai data JSON untuk AJAX.
     */
    public function index(Request $request)
    {
        $obat = Obat::all();

        // JIKA MEMINTA LEWAT AJAX (Proses load tabel data di latar belakang)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $obat
            ], 200);
        }

        // JIKA DIAKSES BIASA LEWAT BROWSER / KLIK NAVBAR (Render Tampilan)
        // Disesuaikan dengan rute kelompokmu: view('obat')
        return view('obat'); 
    }

    /**
     * Menyimpan data obat baru via AJAX.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $obat = Obat::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data komoditas obat berhasil ditambahkan ke gudang farmasi!',
            'data' => $obat
        ], 201);
    }

    /**
     * Mengambil detail satu data obat untuk modal edit melayang.
     */
    public function show($id)
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data komponen obat tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $obat
        ], 200);
    }

    /**
     * Memperbarui data obat via AJAX.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data spesifikasi obat tidak ditemukan!'
            ], 404);
        }

        $obat->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Stok dan rincian data obat berhasil diperbarui!',
            'data' => $obat
        ], 200);
    }

    /**
     * Menghapus data obat berdasarkan ID via AJAX.
     */
    public function destroy($id)
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data batch obat tidak ditemukan!'
            ], 404);
        }

        $obat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data komoditas obat berhasil dihapus dari sistem apotek.'
        ], 200);
    }
}