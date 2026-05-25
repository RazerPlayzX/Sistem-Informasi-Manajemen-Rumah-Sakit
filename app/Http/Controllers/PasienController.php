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
        // 1. Inisialisasi query builder dari model Pasien
        $query = Pasien::query();

        // 2. Logika Pencarian Real-time (Mengecek parameter query string 'search')
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_rm', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // 3. Urutkan berdasarkan data terbaru lalu batasi dengan pagination
        $pasiens = $query->latest()->paginate(10);

        // JIKA MENYIKAT LEWAT API / AJAX FETCH
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar data pasien berhasil diambil.',
                'data' => $pasiens
            ], 200);
        }

        // JIKA MENYIKAT LEWAT WEB BLADE PERTAMA KALI
        return view('pasien.index', compact('pasiens'));
    }

    /**
     * Menampilkan formulir tambah pasien baru.
     */
    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Menyimpan data pasien baru ke database.
     */
    public function store(Request $request)
    {
        // Gunakan Validator manual agar bisa dikontrol response-nya jika gagal di API
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
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem rumah sakit.',
            'nik.digits' => 'NIK harus berjumlah 16 digit angka.',
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        // JIKA VALIDASI GAGAL
        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Otomatis generate Nomor Rekam Medis (Format contoh: RM-202605-0001)
        $tahunBulan = date('Ym');
        $hitungPasienBulanIni = Pasien::where('nomor_rm', 'LIKE', "RM-$tahunBulan-%")->count();
        $nomorUrut = str_pad($hitungPasienBulanIni + 1, 4, '0', STR_PAD_LEFT);
        $nomor_rm = "RM-$tahunBulan-$nomorUrut";

        $data = $request->all();
        $data['nomor_rm'] = $nomor_rm;

        // Simpan data pasien
        $pasien = Pasien::create($data);

        // RESPONS SUKSES (DIBEDAKAN ANTARA API DAN WEB)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pasien baru berhasil didaftarkan.',
                'data' => $pasien
            ], 201);
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien baru berhasil didaftarkan dengan No. RM: ' . $nomor_rm);
    }

    /**
     * Menampilkan detail informasi satu pasien.
     */
    public function show(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pasien
            ], 200);
        }

        return view('pasien.show', compact('pasien'));
    }

    /**
     * Menampilkan formulir edit/ubah data pasien.
     */
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Memperbarui data pasien yang sudah ada di database.
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
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pasien->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil diperbarui.',
                'data' => $pasien
            ], 200);
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien ' . $pasien->nama_lengkap . ' berhasil diperbarui.');
    }

    /**
     * Menghapus data pasien dari database.
     */
    public function destroy(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $namaPasien = $pasien->nama_lengkap;
        
        $pasien->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pasien ' . $namaPasien . ' berhasil dihapus.'
            ], 200);
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien ' . $namaPasien . ' berhasil dihapus dari sistem.');
    }
}