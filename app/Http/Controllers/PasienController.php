<?php

namespace App\Http\Controllers;

use App\Models\Pasien; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    /**
     * Menampilkan daftar semua pasien dengan fitur pencarian real-time & pagination.
     */
    public function index(Request $request)
    {
        $query = Pasien::query();

        // Logika Pencarian Real-time
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_rm', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // Ambil data terbaru dan batasi pagination
        $pasiens = $query->latest()->paginate(10);

        // RESPONS UNTUK AJAX FETCH (Membaca data mentah JSON)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar data pasien berhasil diambil.',
                'data' => $pasiens
            ], 200);
        }

        // RESPONS UNTUK AKSES PERTAMA BROWSER (Render View Tunggal)
        // Mengarah langsung ke file resources/views/pasien.blade.php
        return view('pasien', compact('pasiens'));
    }

    /**
     * Menyimpan data pasien baru ke database via API/AJAX.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:pasien,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_tinggal' => 'required|string',
            'nomor_hp' => 'required|string|max:15',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'pekerjaan' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Otomatis generate Nomor Rekam Medis (Format: RM-YYYYMM-0001)
        $tahunBulan = date('Ym');
        $hitungPasienBulanIni = Pasien::where('nomor_rm', 'LIKE', "RM-$tahunBulan-%")->count();
        $nomorUrut = str_pad($hitungPasienBulanIni + 1, 4, '0', STR_PAD_LEFT);
        $nomor_rm = "RM-$tahunBulan-$nomorUrut";

        $data = $request->all();
        $data['nomor_rm'] = $nomor_rm;

        $pasien = Pasien::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data pasien baru dengan No. RM: ' . $nomor_rm . ' berhasil terdaftar.',
            'data' => $pasien
        ], 201);
    }

    /**
     * Mengambil detail satu informasi pasien untuk form Edit Pop-up.
     */
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $pasien
        ], 200);
    }

    /**
     * Memperbarui data pasien via AJAX modal.
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:pasien,nik,' . $pasien->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_tinggal' => 'required|string',
            'nomor_hp' => 'required|string|max:15',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'pekerjaan' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pasien->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Rekam medis pasien ' . $pasien->nama_lengkap . ' berhasil diperbarui.',
            'data' => $pasien
        ], 200);
    }

    /**
     * Menghapus data pasien secara permanen dari database.
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $namaPasien = $pasien->nama_lengkap;
        $pasien->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data rekam medis pasien ' . $namaPasien . ' berhasil dihapus dari sistem.'
        ], 200);
    }
}