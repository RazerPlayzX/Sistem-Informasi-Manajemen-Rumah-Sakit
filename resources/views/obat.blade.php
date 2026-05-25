@extends('layouts.app')
@section('title', 'Modul Data Obat & Farmasi')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-pills text-sky-600"></i> Gudang Farmasi & Obat
        </h1>
        <p class="text-sm text-slate-500 mt-1">Kelola sediaan obat, kontrol kapasitas stok, dan kalkulasi harga jual apotek.</p>
    </div>
    
    <div>
        <button id="btnTambahObat" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-sky-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-square-plus"></i> Tambah Obat Baru
        </button>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="overflow-x-auto">
        <table id="obatTable" class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                    <th class="p-4" style="width: 10%">ID</th>
                    <th class="p-4" style="width: 35%">Nama Obat</th>
                    <th class="p-4" style="width: 20%">Jenis</th>
                    <th class="p-4" style="width: 20%">Harga</th>
                    <th class="p-4" style="width: 15%">Stok</th>
                    <th class="p-4 text-center" style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td colspan="6" class="text-center py-8 text-slate-400">
                        <i class="fa-solid fa-circle-notch animate-spin mr-2 text-sky-500"></i>Memuat inventaris obat...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modalObat" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 md:p-8 shadow-2xl border border-slate-200 relative">
        <span class="close-modal absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl">&times;</span>
        
        <h2 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
            <i class="fa-solid fa-capsules text-sky-600"></i> <span id="modalTitle">Tambah Obat Baru</span>
        </h2>
        
        <form id="obatForm" class="space-y-4">
            <input type="hidden" id="obat_id">
            
            <div>
                <label for="nama_obat" class="block text-xs font-semibold text-slate-600 mb-1">Nama Obat</label>
                <div class="relative">
                    <i class="fa-solid fa-prescription-bottle-medical absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" id="nama_obat" name="nama_obat" placeholder="Contoh: Amoxicillin 500mg" class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
            </div>

            <div>
                <label for="jenis_obat" class="block text-xs font-semibold text-slate-600 mb-1">Jenis / Sediaan</label>
                <div class="relative">
                    <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <select id="jenis_obat" name="jenis_obat" class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Sirup">Sirup</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Salep">Salep</option>
                        <option value="Suntik">Cair / Suntik</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-xs font-semibold text-slate-600 mb-1">Harga Jual (Rp)</label>
                    <div class="relative">
                        <i class="fa-solid fa-money-bill-wave absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="number" id="harga" name="harga" min="1" placeholder="15000" class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                    </div>
                </div>
                <div>
                    <label for="stok" class="block text-xs font-semibold text-slate-600 mb-1">Stok Gudang</label>
                    <div class="relative">
                        <i class="fa-solid fa-boxes-stacked absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="number" id="stok" name="stok" min="0" placeholder="100" class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                    </div>
                </div>
            </div>
            
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="close-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl transition-all text-sm">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg text-sm">Simpan Data Obat</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // TETEP PAKE API LAMA KELOMPOKMU
        const apiUrl = '/api/obats'; 

        // 1. Ambil Data (GET)
        function muatDataObat() {
            $.ajax({
                url: apiUrl,
                type: 'GET',
                success: function(response) {
                    let rows = '';
                    $.each(response.data, function(index, obat) {
                        rows += `
                            <tr class="hover:bg-sky-50/30 transition-colors">
                                <td class="p-4 text-slate-500">#${obat.id}</td>
                                <td class="p-4 text-slate-800 font-semibold">${obat.nama_obat}</td>
                                <td class="p-4"><span class="bg-sky-50 text-sky-700 text-xs font-bold px-2.5 py-1 rounded-md border border-sky-100">${obat.jenis_obat}</span></td>
                                <td class="p-4 font-medium text-slate-700">Rp ${parseInt(obat.harga).toLocaleString('id-ID')}</td>
                                <td class="p-4"><strong class="text-slate-800">${obat.stok}</strong> Pcs</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button class="btn-edit inline-flex items-center gap-1 bg-white hover:bg-amber-500 hover:text-white border border-amber-200 text-amber-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" 
                                            data-id="${obat.id}" data-nama="${obat.nama_obat}" data-jenis="${obat.jenis_obat}" data-harga="${obat.harga}" data-stok="${obat.stok}">
                                            <i class="fa-solid fa-user-pen"></i> Edit
                                        </button>
                                        <button class="btn-delete inline-flex items-center gap-1 bg-white hover:bg-rose-500 hover:text-white border border-rose-200 text-rose-500 text-xs px-2.5 py-1.5 rounded-lg transition-all" 
                                            data-id="${obat.id}" data-nama="${obat.nama_obat}">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                    });
                    $('#obatTable tbody').html(rows || '<tr><td colspan="6" class="text-center py-8 text-slate-400">Belum ada data obat di gudang farmasi.</td></tr>');
                }
            });
        }

        muatDataObat();

        // Trigger Pop-up Modal Box Tambah Baru
        $('#btnTambahObat').click(function() {
            $('#obatForm')[0].reset();
            $('#obat_id').val(''); // Kosongkan ID berarti mode CREATE
            $('#modalTitle').text('Tambah Sediaan Obat Baru');
            $('#btnSubmit').text('Simpan Data Obat').removeClass('bg-amber-500 hover:bg-amber-600').addClass('bg-sky-600 hover:bg-sky-700');
            $('#modalObat').removeClass('hidden').addClass('flex');
        });

        // 2. Submit Handle via AJAX (Bisa POST / PUT otomatis sesuai ID)
        $('#obatForm').submit(function(e) {
            e.preventDefault();
            let id = $('#obat_id').val();
            let dataFormulir = {
                nama_obat: $('#nama_obat').val(),
                jenis_obat: $('#jenis_obat').val(),
                harga: $('#harga').val(),
                stok: $('#stok').val()
            };

            // Jika ada ID berarti PUT (Update), jika kosong berarti POST (Create)
            let typeMethod = id ? 'PUT' : 'POST';
            let targetUrl = id ? `${apiUrl}/${id}` : apiUrl;

            $.ajax({
                url: targetUrl,
                type: typeMethod,
                data: dataFormulir,
                success: function(response) {
                    Swal.fire({ title: 'Berhasil!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                    $('#modalObat').addClass('hidden');
                    muatDataObat(); 
                },
                error: function(err) {
                    let errMsg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : "Gagal memproses data.";
                    Swal.fire({ title: 'Gagal Validasi!', text: errMsg, icon: 'error', confirmButtonColor: '#ef4444' });
                }
            });
        });

        // 3. Catch Data untuk dimasukkan ke Form Edit Pop-up
        $('#obatTable').on('click', '.btn-edit', function() {
            $('#obat_id').val($(this).data('id'));
            $('#nama_obat').val($(this).data('nama'));
            $('#jenis_obat').val($(this).data('jenis'));
            $('#harga').val($(this).data('harga'));
            $('#stok').val($(this).data('stok'));

            $('#modalTitle').text('Ubah Formula Rincian Obat');
            $('#btnSubmit').text('Perbarui Data').removeClass('bg-sky-600 hover:bg-sky-700').addClass('bg-amber-500 hover:bg-amber-600');
            $('#modalObat').removeClass('hidden').addClass('flex');
        });

        // 4. Hapus Data (DELETE)
        $('#obatTable').on('click', '.btn-delete', function() {
            let idObat = $(this).data('id');
            let namaObat = $(this).data('nama');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data obat <strong>${namaObat}</strong> akan dihapus permanen dari sistem farmasi!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Data!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${apiUrl}/${idObat}`,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire({ title: 'Terhapus!', text: response.message, icon: 'success', confirmButtonColor: '#0284c7' });
                            muatDataObat();
                        }
                    });
                }
            });
        });

        // Tutup Modal Controls
        $('.close-modal, .close-btn').click(function() { $('#modalObat').addClass('hidden'); });
    });
</script>
@endsection