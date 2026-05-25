@extends('layouts.app')
@section('title', 'Master Inventaris Data Pasien')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-hospital-user text-sky-600"></i> Master Registrasi Pasien
        </h1>
        <p class="text-sm text-slate-500 mt-1">Manajemen rekam medis, profil pribadi, dan pencarian pasien terintegrasi.</p>
    </div>
    
    <div>
        <button id="btnTambahPasien" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-sky-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-user-plus"></i> Registrasi Pasien Baru
        </button>
    </div>
</div>

<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
    <div class="relative w-full sm:w-80">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="text" id="input-cari" placeholder="Cari nomor RM, NIK, atau nama..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                    <th class="p-4">No. Rekam Medis</th>
                    <th class="p-4">Nama Lengkap / NIK</th>
                    <th class="p-4">Gender</th>
                    <th class="p-4">Kontak & Alamat</th>
                    <th class="p-4 text-center">Gol. Darah</th>
                    <th class="p-4 text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody id="tabel-pasien" class="divide-y divide-slate-100">
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="fa-solid fa-circle-notch animate-spin text-2xl mb-2 text-sky-500"></i>
                        <p>Sedang sinkronisasi data rekam medis...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="pagination-container" class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-between items-center hidden"></div>
</div>

<div id="modalPasien" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl border border-slate-200 relative max-h-[90vh] overflow-y-auto">
        <span class="close-modal absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl">&times;</span>
        
        <h2 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
            <i class="fa-solid fa-user-injured text-sky-600"></i> <span id="modalTitle">Registrasi Pasien Baru</span>
        </h2>
        
        <form id="formPasien" class="space-y-5">
            <input type="hidden" id="pasienId">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" id="nik" maxlength="16" placeholder="16 digit angka KTP" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Pasien</label>
                    <input type="text" id="nama_lengkap" placeholder="Sesuai kartu identitas" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Kelamin</label>
                    <select id="jenis_kelamin" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="">-- Pilih Gender --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Golongan Darah</label>
                    <select id="golongan_darah" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer">
                        <option value="-">Tidak Tahu (-)</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" placeholder="Kota Kelahiran" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 text-slate-600" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">No. HP / WhatsApp Kontak</label>
                    <input type="text" id="nomor_hp" placeholder="Contoh: 08123456xxx" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pernikahan</label>
                    <select id="status_pernikahan" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500">
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pekerjaan</label>
                <input type="text" id="pekerjaan" placeholder="Contoh: Karyawan Swasta" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Tinggal Tetap</label>
                <textarea id="alamat_tinggal" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, Kecamatan" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 resize-none" required></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="close-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl transition-all text-sm">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-sky-100 text-sm">Simpan Rekam Medis</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const baseApiUrl = '/api/pasien';
        let kataKunciPencarian = '';
        let timeoutPencarian = null;

        function loadData(url) {
            let targetUrl = url || baseApiUrl;
            
            $.ajax({
                url: targetUrl,
                type: 'GET',
                success: function(response) {
                    let rows = '';
                    const paginationData = response.data;
                    const daftarPasien = paginationData.data;

                    $.each(daftarPasien, function(index, p) {
                        const genderBadge = p.jenis_kelamin === 'L' 
                            ? '<span class="text-sky-700 bg-sky-50 text-xs font-bold px-2.5 py-1 rounded border border-sky-100">Laki-laki</span>' 
                            : '<span class="text-pink-700 bg-pink-50 text-xs font-bold px-2.5 py-1 rounded border border-pink-100">Perempuan</span>';

                        rows += `
                            <tr class="hover:bg-sky-50/20 transition-colors">
                                <td class="p-4"><span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 font-mono">${p.nomor_rm}</span></td>
                                <td class="p-4">
                                    <div class="font-semibold text-slate-800">${p.nama_lengkap}</div>
                                    <div class="text-xs text-slate-400 font-mono mt-0.5">NIK: ${p.nik}</div>
                                </td>
                                <td class="p-4">${genderBadge}</td>
                                <td class="p-4 text-xs space-y-0.5 text-slate-600">
                                    <div><i class="fa-solid fa-phone text-slate-400 mr-1"></i>${p.nomor_hp}</div>
                                    <div class="truncate max-w-[180px]" title="${p.alamat_tinggal}"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>${p.alamat_tinggal}</div>
                                </td>
                                <td class="p-4 text-center"><span class="px-2.5 py-1 bg-slate-50 text-slate-700 font-bold text-xs rounded border border-slate-200">${p.golongan_darah || '-'}</span></td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button class="btn-edit inline-flex items-center gap-1 bg-white hover:bg-amber-500 hover:text-white border border-amber-200 text-amber-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" data-id="${p.id}"><i class="fa-solid fa-user-pen"></i> Edit</button>
                                        <button class="btn-delete inline-flex items-center gap-1 bg-white hover:bg-rose-500 hover:text-white border border-rose-200 text-rose-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" data-id="${p.id}" data-nama="${p.nama_lengkap}"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                    </div>
                                </td>
                            </tr>`;
                    });

                    $('#tabel-pasien').html(rows || '<tr><td colspan="6" class="text-center py-8 text-slate-400">Belum ada data pasien terdaftar.</td></tr>');
                    renderPagination(paginationData);
                }
            });
        }

        function renderPagination(data) {
            const container = document.getElementById('pagination-container');
            if (data.last_page <= 1) { $(container).addClass('hidden'); return; }

            let prevUrl = data.prev_page_url;
            let nextUrl = data.next_page_url;

            if (kataKunciPencarian) {
                if (prevUrl && !prevUrl.includes('search=')) prevUrl += `&search=${encodeURIComponent(kataKunciPencarian)}`;
                if (nextUrl && !nextUrl.includes('search=')) nextUrl += `&search=${encodeURIComponent(kataKunciPencarian)}`;
            }

            $(container).removeClass('hidden').html(`
                <span class="text-xs text-slate-500">Halaman ${data.current_page} dari ${data.last_page}</span>
                <div class="inline-flex space-x-1">
                    <button id="btnPrev" class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium hover:bg-slate-50 disabled:opacity-40 transition-all" ${!prevUrl ? 'disabled' : ''}>Sebelumnya</button>
                    <button id="btnNext" class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium hover:bg-slate-50 disabled:opacity-40 transition-all" ${!nextUrl ? 'disabled' : ''}>Selanjutnya</button>
                </div>`);

            $('#btnPrev').click(function() { if(prevUrl) loadData(prevUrl); });
            $('#btnNext').click(function() { if(nextUrl) loadData(nextUrl); });
        }

        // Jalankan load data awal
        loadData();

        // Handler Real-time Search
        $('#input-cari').on('input', function() {
            kataKunciPencarian = $(this).val();
            clearTimeout(timeoutPencarian);
            timeoutPencarian = setTimeout(() => {
                loadData(`${baseApiUrl}?search=${encodeURIComponent(kataKunciPencarian)}`);
            }, 300);
        });

        // Trigger Pop-up Modal Registrasi Baru
        $('#btnTambahPasien').click(function() {
            $('#formPasien')[0].reset();
            $('#pasienId').val('');
            $('#modalTitle').text('Registrasi Pasien Baru');
            $('#btnSubmit').text('Simpan Rekam Medis').removeClass('bg-amber-500 hover:bg-amber-600').addClass('bg-sky-600 hover:bg-sky-700');
            $('#modalPasien').removeClass('hidden').addClass('flex');
        });

        // Submit Form AJAX (Create / Update)
        $('#formPasien').submit(function(e) {
            e.preventDefault();
            let id = $('#pasienId').val();
            
            let payload = {
                nik: $('#nik').val(),
                nama_lengkap: $('#nama_lengkap').val(),
                jenis_kelamin: $('#jenis_kelamin').val(),
                golongan_darah: $('#golongan_darah').val(),
                tempat_lahir: $('#tempat_lahir').val(),
                tanggal_lahir: $('#tanggal_lahir').val(),
                nomor_hp: $('#nomor_hp').val(),
                status_pernikahan: $('#status_pernikahan').val(),
                pekerjaan: $('#pekerjaan').val(),
                alamat_tinggal: $('#alamat_tinggal').val()
            };

            let method = id ? 'PUT' : 'POST';
            let url = id ? `${baseApiUrl}/${id}` : baseApiUrl;

            $.ajax({
                url: url,
                type: method,
                data: payload,
                success: function(response) {
                    Swal.fire({ title: 'Berhasil!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                    $('#modalPasien').addClass('hidden');
                    loadData();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors) {
                        let msg = '';
                        Object.values(errors).forEach(e => msg += '- ' + e[0] + '<br>');
                        Swal.fire({ title: 'Validasi Gagal!', html: msg, icon: 'error', confirmButtonColor: '#ef4444' });
                    }
                }
            });
        });

        // Edit Button AJAX (GET Single Data untuk dimasukkan ke Modal)
        $('#tabel-pasien').on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.get(`${baseApiUrl}/${id}`, function(response) {
                const p = response.data;
                $('#pasienId').val(p.id);
                $('#nik').val(p.nik);
                $('#nama_lengkap').val(p.nama_lengkap);
                $('#jenis_kelamin').val(p.jenis_kelamin);
                $('#golongan_darah').val(p.golongan_darah || '-');
                $('#tempat_lahir').val(p.tempat_lahir);
                $('#tanggal_lahir').val(p.tanggal_lahir);
                $('#nomor_hp').val(p.nomor_hp);
                $('#status_pernikahan').val(p.status_pernikahan);
                $('#pekerjaan').val(p.pekerjaan);
                $('#alamat_tinggal').val(p.alamat_tinggal);

                $('#modalTitle').text('Ubah Data Rekam Medis Pasien');
                $('#btnSubmit').text('Perbarui Data').removeClass('bg-sky-600 hover:bg-sky-700').addClass('bg-amber-500 hover:bg-amber-600');
                $('#modalPasien').removeClass('hidden').addClass('flex');
            });
        });

        // Delete Button AJAX (DELETE)
        $('#tabel-pasien').on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Pasien?',
                html: `Apakah anda yakin ingin menghapus data rekam medis <strong>${nama}</strong> secara permanen?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseApiUrl}/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire({ title: 'Terhapus!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                            loadData();
                        }
                    });
                }
            });
        });

        // Kontrol Tutup Modal Pop-up
        $('.close-modal, .close-btn').click(function() { $('#modalPasien').addClass('hidden'); });
    });
</script>
@endsection