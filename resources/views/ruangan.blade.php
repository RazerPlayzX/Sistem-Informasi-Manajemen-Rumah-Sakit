@extends('layouts.app')
@section('title', 'Manajemen Ruangan & Kamar Rawat Inap')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-procedures text-sky-600"></i> Manajemen Ruangan Klinik
        </h1>
        <p class="text-sm text-slate-500 mt-1">Pantau okupansi kasur, kelas layanan rawat inap, dan status pemeliharaan fasilitas.</p>
    </div>
    
    <div>
        <button id="btnTambahRuangan" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-sky-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-square-plus"></i> Tambah Ruangan Baru
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Unit Ruangan</p>
            <h2 id="totalRuangan" class="text-3xl font-bold text-slate-800 mt-1">0</h2>
        </div>
        <span class="p-3 bg-sky-50 text-sky-600 rounded-xl text-xl"><i class="fa-solid fa-procedures"></i></span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Status Kamar Tersedia</p>
            <h2 id="totalTersedia" class="text-3xl font-bold text-emerald-600 mt-1">0</h2>
        </div>
        <span class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl"><i class="fa-solid fa-door-open"></i></span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Penuh / Sedang Maintenance</p>
            <h2 id="totalTidakTersedia" class="text-3xl font-bold text-rose-600 mt-1">0</h2>
        </div>
        <span class="p-3 bg-rose-50 text-rose-600 rounded-xl text-xl"><i class="fa-solid fa-triangle-exclamation"></i></span>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nama Ruangan</th>
                    <th class="p-4">Kode</th>
                    <th class="p-4">Jenis Kelas</th>
                    <th class="p-4">Okupansi Kasur</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4">Fasilitas/Ket</th>
                    <th class="p-4 text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody id="tableRuangan" class="divide-y divide-slate-100">
                <tr><td colspan="8" class="text-center py-8 text-slate-400"><i class="fa-solid fa-circle-notch animate-spin mr-2 text-sky-500"></i>Memuat data kamar klinik...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modalRuangan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 md:p-8 shadow-2xl border border-slate-200 relative">
        <span class="close-modal absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl">&times;</span>
        
        <h2 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
            <i class="fa-solid fa-hospital text-sky-600"></i> <span id="judulForm">Tambah Ruangan Baru</span>
        </h2>
        
        <form id="formRuangan" class="space-y-4">
            <input type="hidden" id="ruanganId">
            
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Ruangan / Kamar</label>
                <input type="text" id="nama_ruangan" placeholder="cth: Ruang Mawar Indah" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kode Unik Ruangan</label>
                <input type="text" id="kode_ruangan" placeholder="cth: R-001" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 font-mono" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis / Kelas Layanan</label>
                <select id="jenis_ruangan" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="ICU">ICU</option>
                    <option value="VIP">VIP</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                    <option value="UGD">UGD</option>
                    <option value="OK">OK (Ruang Operasi)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Keterisian</label>
                <select id="status" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Penuh">Penuh</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kapasitas Kasur</label>
                    <input type="number" id="kapasitas" min="1" placeholder="cth: 4" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kasur Terisi</label>
                    <input type="number" id="terisi" min="0" value="0" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan Tambahan</label>
                <textarea id="keterangan" rows="2" placeholder="Fasilitas AC, TV, dll (opsional)" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 resize-none"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="close-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl transition-all text-sm">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg text-sm">Simpan Data Kamar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const API_URL = '/api/ruangans'; // Tetap menembak endpoint API bawaan lama timmu

    function badgeStatus(status) {
        const map = {
            'Tersedia':    'bg-emerald-50 text-emerald-700 border-emerald-100',
            'Penuh':       'bg-rose-50 text-rose-700 border-rose-100',
            'Maintenance': 'bg-amber-50 text-amber-700 border-amber-100'
        };
        return `<span class="text-xs font-bold px-2.5 py-1 rounded-md border ${map[status] || 'bg-slate-50 text-slate-700 border-slate-100'}">${status}</span>`;
    }

    function loadData() {
        $.ajax({
            url: API_URL,
            method: 'GET',
            success: function(response) {
                const data = response.data;
                let html = '';
                let tersedia = 0, tidakTersedia = 0;

                data.forEach(function(item) {
                    if (item.status === 'Tersedia') tersedia++;
                    else tidakTersedia++;

                    html += `
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="p-4 text-slate-400">#${item.id}</td>
                            <td class="p-4 font-semibold text-slate-800">${item.nama_ruangan}</td>
                            <td class="p-4 font-mono text-xs"><code>${item.kode_ruangan}</code></td>
                            <td class="p-4 font-medium">${item.jenis_ruangan}</td>
                            <td class="p-4">
                                <span class="font-bold text-slate-700">${item.terisi}</span>
                                <span class="text-slate-400">/ ${item.kapasitas} Bed</span>
                            </td>
                            <td class="p-4 text-center">${badgeStatus(item.status)}</td>
                            <td class="p-4 text-slate-500 text-xs truncate max-w-[120px]" title="${item.keterangan || '-'}">${item.keterangan || '-'}</td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-1.5">
                                    <button class="bg-white hover:bg-amber-500 hover:text-white border border-amber-200 text-amber-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" onclick="editData(${item.id})"><i class="fa-solid fa-user-pen"></i> Edit</button>
                                    <button class="bg-white hover:bg-rose-500 hover:text-white border border-rose-200 text-rose-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" onclick="deleteData(${item.id}, '${item.nama_ruangan}')"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#tableRuangan').html(html || '<tr><td colspan="8" class="text-center py-8 text-slate-400">Belum ada data master ruangan.</td></tr>');
                $('#totalRuangan').text(data.length);
                $('#totalTersedia').text(tersedia);
                $('#totalTidakTersedia').text(tidakTersedia);
            },
            error: function() {
                $('#tableRuangan').html('<tr><td colspan="8" class="text-center text-danger py-8">Gagal memuat data pusat dari sistem cloud.</td></tr>');
            }
        });
    }

    // Trigger Pop-up Modal Box Tambah Baru
    $('#btnTambahRuangan').click(function() {
        $('#formRuangan')[0].reset();
        $('#ruanganId').val(''); // ID kosong berarti mode CREATE
        $('#terisi').val('0');
        $('#judulForm').text('Tambah Ruangan Baru');
        $('#btnSubmit').text('Simpan Kamar').removeClass('bg-amber-500 hover:bg-amber-600').addClass('bg-sky-600 hover:bg-sky-700');
        $('#modalRuangan').removeClass('hidden').addClass('flex');
    });

    // Submit Handler (Create & Update) via AJAX melayang di tengah
    $('#formRuangan').submit(function(e) {
        e.preventDefault();
        const id = $('#ruanganId').val();
        const data = {
            nama_ruangan:  $('#nama_ruangan').val(),
            kode_ruangan:  $('#kode_ruangan').val(),
            jenis_ruangan: $('#jenis_ruangan').val(),
            kapasitas:     $('#kapasitas').val(),
            terisi:        $('#terisi').val(),
            status:        $('#status').val(),
            keterangan:    $('#keterangan').val()
        };

        const method = id ? 'PUT' : 'POST';
        const url    = id ? `${API_URL}/${id}` : API_URL;

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(response) {
                Swal.fire({ title: 'Berhasil!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                $('#modalRuangan').addClass('hidden');
                loadData();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let msg = '';
                    Object.values(errors).forEach(e => msg += '- ' + e[0] + '<br>');
                    Swal.fire({ title: 'Validasi Gagal!', html: msg, icon: 'error', confirmButtonColor: '#ef4444' });
                } else {
                    Swal.fire({ title: 'Gagal!', text: xhr.responseJSON.message, icon: 'error' });
                }
            }
        });
    });

    // Ambil data tunggal ke Form Edit Pop-up melayang
    function editData(id) {
        $.ajax({
            url: `${API_URL}/${id}`,
            method: 'GET',
            success: function(response) {
                const d = response.data;
                $('#ruanganId').val(d.id);
                $('#nama_ruangan').val(d.nama_ruangan);
                $('#kode_ruangan').val(d.kode_ruangan);
                $('#jenis_ruangan').val(d.jenis_ruangan);
                $('#kapasitas').val(d.kapasitas);
                $('#terisi').val(d.terisi);
                $('#status').val(d.status);
                $('#keterangan').val(d.keterangan);
                
                $('#judulForm').text('Ubah Data Spesifikasi Kamar');
                $('#btnSubmit').text('Perbarui Kamar').removeClass('bg-sky-600 hover:bg-sky-700').addClass('bg-amber-500 hover:bg-amber-600');
                $('#modalRuangan').removeClass('hidden').addClass('flex');
            }
        });
    }

    function deleteData(id, nama) {
        Swal.fire({
            title: 'Hapus Unit Ruangan?',
            html: `Apakah anda yakin ingin menghapus <strong>${nama}</strong> dari denah klinik?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({ title: 'Terhapus!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                        loadData();
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        loadData();
        // Tutup Modal Box Controls
        $('.close-modal, .close-btn').click(function() { $('#modalRuangan').addClass('hidden'); });
    });
</script>
@endsection