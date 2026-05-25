<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // GET semua data dokter
    public function index()
    {
        $dokter = Dokter::all();
        return response()->json([
            'success' => true,
            'data'    => $dokter
        ], 200);
    }

    // POST - tambah dokter baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter'  => 'required|string|max:100',
            'no_str'       => 'required|unique:dokters|max:20',
            'spesialisasi' => 'required|in:Umum,Anak,Bedah,Penyakit Dalam,Kandungan,Jantung,Saraf,Mata,THT,Kulit,Gigi,Jiwa',
            'no_telp'      => 'required|max:15',
            'email'        => 'required|email|unique:dokters',
            'status'       => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        $dokter = Dokter::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil ditambahkan',
            'data'    => $dokter
        ], 201);
    }

    // GET satu data dokter
    public function show($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $dokter
        ], 200);
    }

    // PUT - update data dokter
    public function update(Request $request, $id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_dokter'  => 'required|string|max:100',
            'no_str'       => 'required|max:20|unique:dokters,no_str,'.$id,
            'spesialisasi' => 'required|in:Umum,Anak,Bedah,Penyakit Dalam,Kandungan,Jantung,Saraf,Mata,THT,Kulit,Gigi,Jiwa',
            'no_telp'      => 'required|max:15',
            'email'        => 'required|email|unique:dokters,email,'.$id,
            'status'       => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        $dokter->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil diupdate',
            'data'    => $dokter
        ], 200);
    }

    // DELETE - hapus dokter
    public function destroy($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan'
            ], 404);
        }

        $dokter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil dihapus'
        ], 200);
    }
}