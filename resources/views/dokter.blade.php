@extends('layouts.app')
@section('title', 'Manajemen Data Kepegawaian Dokter')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-user-md text-sky-600"></i> Manajemen Tenaga Medis
        </h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data kepegawaian, nomor STR, dan spesialisasi dokter rumah sakit.</p>
    </div>
    
    <div>
        <button id="btnTambahDokter" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-sky-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-user-plus"></i> Tambah Dokter Baru
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Tenaga Medis</p>
            <h2 id="totalDokter" class="text-3xl font-bold text-slate-800 mt-1">0</h2>
        </div>
        <span class="p-3 bg-sky-50 text-sky-600 rounded-xl text-xl"><i class="fa-solid fa-user-md"></i></span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Dokter Status Aktif</p>
            <h2 id="totalAktif" class="text-3xl font-bold text-emerald-600 mt-1">0</h2>
        </div>
        <span class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl"><i class="fa-solid fa-circle-check"></i></span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Sedang Non-Aktif / Cuti</p>
            <h2 id="totalTidakAktif" class="text-3xl font-bold text-rose-600 mt-1">0</h2>
        </div>
        <span class="p-3 bg-rose-50 text-rose-600 rounded-xl text-xl"><i class="fa-solid fa-circle-xmark"></i></span>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nama Dokter</th>
                    <th class="p-4">No STR</th>
                    <th class="p-4">Spesialisasi</th>
                    <th class="p-4">Kontak Info</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody id="tableDokter" class="divide-y divide-slate-100">
                <tr><td colspan="7" class="text-center py-8 text-slate-400"><i class="fa-solid fa-circle-notch animate-spin mr-2 text-sky-500"></i>Memuat data dokter...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modalDokter" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl border border-slate-200 relative">
        <span class="close-modal absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl">&times;</span>
        
        <h2 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
            <i class="fa-solid fa-user-md text-sky-600"></i> <span id="judulForm">Tambah Dokter Baru</span>
        </h2>
        
        <form id="formDokter" class="space-y-4">
            <input type="hidden" id="dokterId">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Dokter</label>
                    <input type="text" id="nama_dokter" placeholder="cth: dr. Budi Santoso, Sp.A" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor STR</label>
                    <input type="text" id="no_str" placeholder="cth: STR-001-2024" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 font-mono" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Spesialisasi Klinik</label>
                    <select id="spesialisasi" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="">-- Pilih Spesialisasi --</option>
                        <option value="Umum">Umum</option>
                        <option value="Anak">Anak</option>
                        <option value="Bedah">Bedah</option>
                        <option value="Penyakit Dalam">Penyakit Dalam</option>
                        <option value="Kandungan">Kandungan</option>
                        <option value="Jantung">Jantung</option>
                        <option value="Saraf">Saraf</option>
                        <option value="Mata">Mata</option>
                        <option value="THT">THT</option>
                        <option value="Kulit">Kulit</option>
                        <option value="Gigi">Gigi</option>
                        <option value="Jiwa">Jiwa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Kepegawaian</label>
                    <select id="status" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" id="no_telp" placeholder="cth: 081234567890" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email Resmi SIMRS</label>
                    <input type="email" id="email" placeholder="cth: dokter@simrs.com" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="close-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl transition-all text-sm">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-sky-100 text-sm">Simpan Data Dokter</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const API_URL = '/api/dokter';

        function badgeStatus(status) {
            return status === 'Aktif'
                ? '<span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-md border border-emerald-100">Aktif</span>'
                : '<span class="bg-rose-50 text-rose-700 text-xs font-bold px-2.5 py-1 rounded-md border border-rose-100">Tidak Aktif</span>';
        }

        function loadData() {
            $.ajax({
                url: API_URL,
                method: 'GET',
                success: function(response) {
                    const data = response.data;
                    let html = '';
                    let aktif = 0, tidakAktif = 0;

                    data.forEach(function(item) {
                        if (item.status === 'Aktif') aktif++;
                        else tidakAktif++;

                        html += `
                            <tr class="hover:bg-sky-50/30 transition-colors">
                                <td class="p-4 text-slate-400">#${item.id}</td>
                                <td class="p-4 font-semibold text-slate-800">${item.nama_dokter}</td>
                                <td class="p-4 font-mono text-xs"><code>${item.no_str}</code></td>
                                <td class="p-4"><span class="bg-sky-50 text-sky-700 text-xs font-bold px-2 py-0.5 rounded border border-sky-100">${item.spesialisasi}</span></td>
                                <td class="p-4 text-xs space-y-0.5 text-slate-600">
                                    <div><i class="fa-solid fa-phone text-slate-400 mr-1"></i>${item.no_telp}</div>
                                    <div><i class="fa-solid fa-envelope text-slate-400 mr-1"></i>${item.email}</div>
                                </td>
                                <td class="p-4 text-center">${badgeStatus(item.status)}</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button class="bg-white hover:bg-amber-500 hover:text-white border border-amber-200 text-amber-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" onclick="editData(${item.id})"><i class="fa-solid fa-user-pen"></i> Edit</button>
                                        <button class="bg-white hover:bg-rose-500 hover:text-white border border-rose-200 text-rose-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" onclick="deleteData(${item.id}, '${item.nama_dokter}')"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                    </div>
                                </td>
                            </tr>`;
                    });

                    $('#tableDokter').html(html || '<tr><td colspan="7" class="text-center py-8 text-slate-400">Belum ada data dokter terdaftar.</td></tr>');
                    $('#totalDokter').text(data.length);
                    $('#totalAktif').text(aktif);
                    $('#totalTidakAktif').text(tidakAktif);
                }
            });
        }

        loadData();

        // Trigger Modal Tambah Baru
        $('#btnTambahDokter').click(function() {
            $('#formDokter')[0].reset();
            $('#dokterId').val('');
            $('#judulForm').text('Tambah Dokter Baru');
            $('#btnSubmit').text('Simpan Data').removeClass('bg-amber-500 hover:bg-amber-600').addClass('bg-sky-600 hover:bg-sky-700');
            $('#modalDokter').removeClass('hidden').addClass('flex');
        });

        // Simpan / Update via AJAX
        $('#formDokter').submit(function(e) {
            e.preventDefault();
            const id = $('#dokterId').val();
            const data = {
                nama_dokter:  $('#nama_dokter').val(),
                no_str:       $('#no_str').val(),
                spesialisasi: $('#spesialisasi').val(),
                no_telp:      $('#no_telp').val(),
                email:        $('#email').val(),
                status:       $('#status').val()
            };

            const method = id ? 'PUT' : 'POST';
            const url    = id ? `${API_URL}/${id}` : API_URL;

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    Swal.fire({ title: 'Berhasil!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                    $('#modalDokter').addClass('hidden');
                    loadData();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        let msg = '';
                        Object.values(errors).forEach(e => msg += '- ' + e[0] + '<br>');
                        Swal.fire({ title: 'Validasi Gagal!', html: msg, icon: 'error', confirmButtonColor: '#ef4444' });
                    }
                }
            });
        });

        // Kontrol Tutup Modal
        $('.close-modal, .close-btn').click(function() { $('#modalDokter').addClass('hidden'); });
    });

    // Tarik data tunggal ke Modal Edit
    function editData(id) {
        $.ajax({
            url: `/api/dokter/${id}`,
            method: 'GET',
            success: function(response) {
                const d = response.data;
                $('#dokterId').val(d.id);
                $('#nama_dokter').val(d.nama_dokter);
                $('#no_str').val(d.no_str);
                $('#spesialisasi').val(d.spesialisasi);
                $('#no_telp').val(d.no_telp);
                $('#email').val(d.email);
                $('#status').val(d.status);
                
                $('#judulForm').text('Ubah Profil Tenaga Medis');
                $('#btnSubmit').text('Perbarui Data').removeClass('bg-sky-600 hover:bg-sky-700').addClass('bg-amber-500 hover:bg-amber-600');
                $('#modalDokter').removeClass('hidden').addClass('flex');
            }
        });
    }

    function deleteData(id, nama) {
        Swal.fire({
            title: 'Hapus Tenaga Medis?',
            html: `Apakah anda yakin ingin menghapus data <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/dokter/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({ title: 'Terhapus!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                        location.reload();
                    }
                });
            }
        });
    }
</script>
@endsection