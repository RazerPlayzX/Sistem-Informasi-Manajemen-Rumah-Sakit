<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // 1. Ambil semua data obat (READ)
    public function index()
    {
        $obat = Obat::all();
        return response()->json([
            'status' => 'success',
            'data' => $obat
        ], 200);
    }

    // 2. Simpan data obat baru (CREATE)
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $obat = Obat::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data obat berhasil ditambahkan!',
            'data' => $obat
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:0'
        ]);

        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data obat tidak ditemukan!'
            ], 404);
        }

        $obat->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data obat berhasil diperbarui!',
            'data' => $obat
        ], 200);
    }
    // 3. Hapus data obat berdasarkan ID (DELETE)
    public function destroy(Request $request, $id)
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data obat tidak ditemukan!'
            ], 404);
        }

        $obat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data obat berhasil dihapus.'
        ], 200);
        }
    }