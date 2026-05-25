<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // GET semua data ruangan
    public function index()
    {
        $ruangan = Ruangan::all();
        return response()->json([
            'success' => true,
            'data' => $ruangan
        ], 200);
    }

    // POST - tambah ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan'  => 'required|string|max:100',
            'kode_ruangan'  => 'required|unique:ruangans|max:10',
            'jenis_ruangan' => 'required|in:ICU,VIP,Kelas 1,Kelas 2,Kelas 3,UGD,OK',
            'kapasitas'     => 'required|integer|min:1',
            'terisi'        => 'nullable|integer|min:0',
            'status'        => 'nullable|in:Tersedia,Penuh,Maintenance',
            'keterangan'    => 'nullable|string',
        ]);

        $ruangan = Ruangan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil ditambahkan',
            'data'    => $ruangan
        ], 201);
    }

    // GET satu data ruangan
    public function show($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $ruangan
        ], 200);
    }

    // PUT - update data ruangan
    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_ruangan'  => 'required|string|max:100',
            'kode_ruangan'  => 'required|max:10|unique:ruangans,kode_ruangan,'.$id,
            'jenis_ruangan' => 'required|in:ICU,VIP,Kelas 1,Kelas 2,Kelas 3,UGD,OK',
            'kapasitas'     => 'required|integer|min:1',
            'terisi'        => 'nullable|integer|min:0',
            'status'        => 'nullable|in:Tersedia,Penuh,Maintenance',
            'keterangan'    => 'nullable|string',
        ]);

        $ruangan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil diupdate',
            'data'    => $ruangan
        ], 200);
    }

    // DELETE - hapus ruangan
    public function destroy($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan'
            ], 404);
        }

        $ruangan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil dihapus'
        ], 200);
    }
}