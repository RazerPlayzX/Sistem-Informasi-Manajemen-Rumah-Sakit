<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    // GET semua data dokter via API JSON
// GET data dokter - Bisa membedakan Web Blade dan AJAX JSON
    public function index(Request $request)
    {
        $dokter = Dokter::all();

        // JIKA MENYIKAT LEWAT AJAX FETCH JAVASCRIPT (Latar Belakang)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $dokter
            ], 200);
        }

        // JIKA DIKetik LANGSUNG DI BROWSER / KLIK NAVBAR (Pintu Depan)
        // Menampilkan halaman utama dokter yang ada navbarnya
        return view('dokter'); 
    }

    // POST - tambah dokter baru dengan tabel validasi tunggal 'dokter'
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokter'  => 'required|string|max:100',
            'no_str'       => 'required|unique:dokter,no_str|max:20', // SINKRON TABEL DOKTER
            'spesialisasi' => 'required|in:Umum,Anak,Bedah,Penyakit Dalam,Kandungan,Jantung,Saraf,Mata,THT,Kulit,Gigi,Jiwa',
            'no_telp'      => 'required|max:15',
            'email'        => 'required|email|unique:dokter,email', // SINKRON TABEL DOKTER
            'status'       => 'nullable|in:Aktif,Tidak Atif',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dokter = Dokter::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data dokter baru berhasil diregistrasikan.',
            'data'    => $dokter
        ], 201);
    }

    // GET satu data dokter
    public function show($id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['success' => false, 'message' => 'Data dokter tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $dokter], 200);
    }

    // PUT - update data dokter
    public function update(Request $request, $id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_dokter'  => 'required|string|max:100',
            'no_str'       => 'required|max:20|unique:dokter,no_str,'.$id,
            'spesialisasi' => 'required|in:Umum,Anak,Bedah,Penyakit Dalam,Kandungan,Jantung,Saraf,Mata,THT,Kulit,Gigi,Jiwa',
            'no_telp'      => 'required|max:15',
            'email'        => 'required|email|unique:dokter,email,'.$id,
            'status'       => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dokter->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Profil data dokter berhasil diperbarui.',
            'data'    => $dokter
        ], 200);
    }

    // DELETE - hapus dokter
    public function destroy($id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $dokter->delete();
        return response()->json(['success' => true, 'message' => 'Data tenaga medis berhasil dihapus.'], 200);
    }
}