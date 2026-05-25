@extends('layouts.app')
@section('title', 'Kalkulasi & Kasir Transaksi Medis')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-file-invoice-dollar text-sky-600"></i> Kasir Pembayaran SIMRS
        </h1>
        <p class="text-sm text-slate-500 mt-1">Kalkulasi otomatis biaya tindakan dokter, tebus obat apotek, dan cetak invoice lunas.</p>
    </div>
    
    <div>
        <button id="btnTambahTransaksi" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-sky-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Catat Transaksi Baru
        </button>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                <tr>
                    <th class="p-4">Kode Invoice</th>
                    <th class="p-4">Pasien / Dokter</th>
                    <th class="p-4 text-right">Total Tagihan</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody id="tabelTransaksi" class="divide-y divide-slate-100">
                <tr><td colspan="5" class="text-center py-8 text-slate-400"><i class="fa-solid fa-circle-notch animate-spin mr-2 text-sky-500"></i>Menghubungkan ke server kasir...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modalTransaksi" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl border border-slate-200 relative">
        <span class="close-modal absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl">&times;</span>
        
        <h2 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
            <i class="fa-solid fa-receipt text-sky-600"></i> <span>Pencatatan Billing Invoice</span>
        </h2>
        
        <form id="formTransaksi" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kode Invoice Transaksi</label>
                <input type="text" id="kode_transaksi" placeholder="Contoh: TRX-2026-001" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 font-mono" required>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Pasien Terdaftar</label>
                    <select id="pasien_id" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="">-- Pilih Pasien Rekam Medis --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Dokter Pemeriksa</label>
                    <select id="dokter_id" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                        <option value="">-- Pilih Dokter --</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Resep Obat yang Diberikan</label>
                <select id="obat_id" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer" required>
                    <option value="">-- Pilih Obat Farmasi --</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tarif Jasa dr. (Rp)</label>
                    <input type="number" id="biaya_dokter" placeholder="150000" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Total Biaya Obat (Rp)</label>
                    <input type="number" id="biaya_obat" placeholder="45000" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                <select id="status_pembayaran" class="w-full p-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 cursor-pointer">
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" class="close-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl transition-all text-sm">Batal</button>
                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg text-sm">Simpan Data Transaksi</button>
            </div>
        </form>
    </div>
</div>

<div id="modalResi" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative">
        <span class="close-modal-resi absolute right-6 top-6 text-slate-400 hover:text-rose-500 cursor-pointer text-2xl no-print">&times;</span>
        
        <div id="notaCetak" class="p-2 font-mono text-xs text-slate-800 space-y-4">
            <div class="text-center border-b border-dashed border-slate-300 pb-3 space-y-1">
                <h3 class="text-sm font-bold uppercase tracking-wider">SIMRS MEDIKA PORTAL</h3>
                <p class="text-[10px] text-slate-500">Jl. Kesehatan Medika No. 12, Kota Terintegrasi</p>
                <p class="text-[10px] text-slate-400">Telp: (021) 555-MEDIKA</p>
            </div>
            
            <div class="space-y-1">
                <div class="flex justify-between"><span>No. Invoice:</span><span id="res_kode" class="font-bold"></span></div>
                <div class="flex justify-between"><span>Tanggal:</span><span id="res_tanggal"></span></div>
                <div class="flex justify-between"><span>Kasir:</span><span>Admin SIMRS</span></div>
            </div>

            <div class="border-t border-b border-dashed border-slate-300 py-2 space-y-1">
                <div class="flex justify-between"><span>Pasien:</span><span id="res_pasien" class="font-bold"></span></div>
                <div class="flex justify-between"><span>Dokter Pemeriksa:</span><span id="res_dokter"></span></div>
                <div class="flex justify-between"><span>Resep Obat:</span><span id="res_obat"></span></div>
            </div>

            <div class="space-y-1">
                <div class="flex justify-between"><span>Jasa Tindakan Medis</span><span id="res_sub_dokter"></span></div>
                <div class="flex justify-between"><span>Tebus Obat Apotek</span><span id="res_sub_obat"></span></div>
                <div class="flex justify-between font-bold text-sm border-t border-dotted border-slate-300 pt-2 mt-1">
                    <span>TOTAL TAGIHAN</span>
                    <span id="res_total" class="text-slate-900"></span>
                </div>
            </div>

            <div class="text-center border-t border-dashed border-slate-300 pt-4 space-y-1">
                <div class="inline-block px-4 py-1 text-[10px] font-bold uppercase rounded" id="res_status_badge"></div>
                <p class="text-[10px] text-slate-400 pt-2">~ Terima kasih atas kunjungan Anda ~</p>
                <p class="text-[9px] text-slate-300">Semoga lekas sembuh dan sehat selalu</p>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex gap-2 no-print">
            <button type="button" class="close-btn-resi flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-xl transition-all text-sm">Tutup</button>
            <button type="button" onclick="window.print()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-lg flex items-center justify-center gap-1 text-sm">
                <i class="fa-solid fa-print"></i> Cetak Struk
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; background: transparent !important; }
        #modalResi, #modalResi * { visibility: visible; }
        #modalResi { position: absolute; left: 0; top: 0; width: 100%; min-height: 100vh; background: white !important; display: flex !important; justify-content: center; align-items: start; padding: 0; }
        .no-print { display: none !important; }
        .bg-white { border: none !important; shadow: none !important; }
    }
</style>

<script>
    $(document).ready(function() {
        const apiUrl = '/api/transaksi';
        let seluruhDataCache = []; // Variabel untuk menyimpan rincian relasi objek obat/pasien/dokter

        // Ambil data dropdown relasi otomatis
        function muatDropdownRelasi() {
            $.get('/api/pasien', function(res) {
                const pasiens = res.data.data || res.data;
                pasiens.forEach(p => $('#pasien_id').append(`<option value="${p.id}">${p.nomor_rm} - ${p.nama_lengkap}</option>`));
            });
            $.get('/api/dokter', function(res) {
                res.data.forEach(d => $('#dokter_id').append(`<option value="${d.id}">${d.nama_dokter} (${d.spesialisasi})</option>`));
            });
            $.get('/api/obats', function(res) {
                res.data.forEach(o => $('#obat_id').append(`<option value="${o.id}">${o.nama_obat}</option>`));
            });
        }

        // Ambil Data Transaksi Utama (GET)
        function loadData() {
            $.get(apiUrl, function(res) {
                seluruhDataCache = res.data; // Simpan ke cache lokal untuk keperluan print
                let rows = '';
                res.data.forEach(item => {
                    const namaPasien = item.pasien ? item.pasien.nama_lengkap : 'Umum/Luar';
                    const namaDokter = item.dokter ? item.dokter.nama_dokter : '-';

                    rows += `
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-mono font-medium text-slate-700">${item.kode_transaksi}</td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-800">${namaPasien}</div>
                                <div class="text-xs text-slate-400 mt-0.5"><i class="fa-solid fa-user-md mr-1 text-[10px]"></i>${namaDokter}</div>
                            </td>
                            <td class="p-4 text-right font-bold text-slate-800">Rp ${parseInt(item.total_bayar).toLocaleString('id-ID')}</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-lg text-xs font-bold ${item.status_pembayaran === 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'}">
                                    ${item.status_pembayaran}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-1">
                                    <button onclick="bukaResi(${item.id})" class="bg-white hover:bg-emerald-500 border border-emerald-200 text-emerald-500 hover:text-white p-2 text-xs rounded-lg transition-all" title="Cetak Resi Struk"><i class="fa-solid fa-print"></i></button>
                                    <button onclick="hapus(${item.id}, '${item.kode_transaksi}')" class="bg-white hover:bg-rose-500 border border-rose-200 text-rose-500 hover:text-white p-2 text-xs rounded-lg transition-all" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>`;
                });
                $('#tabelTransaksi').html(rows || '<tr><td colspan="5" class="text-center py-8 text-slate-400">Belum ada riwayat transaksi kasir hari ini.</td></tr>');
            });
        }

        // Trigger Pop-up Modal Input Baru
        $('#btnTambahTransaksi').click(function() {
            $('#formTransaksi')[0].reset();
            $('#modalTransaksi').removeClass('hidden').addClass('flex');
        });

        // Submit Form Input Transaksi (POST)
        $('#formTransaksi').on('submit', function(e) {
            e.preventDefault();
            let payload = {
                kode_transaksi:    $('#kode_transaksi').val(),
                pasien_id:         $('#pasien_id').val(),
                dokter_id:         $('#dokter_id').val(),
                obat_id:           $('#obat_id').val(),
                biaya_dokter:      $('#biaya_dokter').val(),
                biaya_obat:        $('#biaya_obat').val(),
                status_pembayaran: $('#status_pembayaran').val(),
            };

            $.ajax({
                url: apiUrl,
                type: 'POST',
                data: payload,
                success: function(response) {
                    Swal.fire({ title: 'Tercatat!', text: response.message, icon: 'success', confirmButtonColor: '#0c4a6e' });
                    $('#modalTransaksi').addClass('hidden');
                    loadData();
                },
                error: function() {
                    Swal.fire({ title: 'Gagal!', text: 'Gagal menyimpan transaksi, periksa kecocokan kode unik invoice.', icon: 'error' });
                }
            });
        });

        // Jalankan inisialisasi
        muatDropdownRelasi();
        loadData();

        // Kontrol Tutup Modal
        $('.close-modal, .close-btn').click(function() { $('#modalTransaksi').addClass('hidden'); });
        $('.close-modal-resi, .close-btn-resi').click(function() { $('#modalResi').addClass('hidden'); });

        // Fungsi Global untuk panggil Resi Cetak
        window.bukaResi = function(id) {
            const dataItem = seluruhDataCache.find(x => x.id == id);
            if(!dataItem) return;

            // Masukkan data detail dinamis ke elemen struk resi
            $('#res_kode').text(dataItem.kode_transaksi);
            $('#res_tanggal').text(new Date(dataItem.created_at || new Date()).toLocaleString('id-ID'));
            $('#res_pasien').text(dataItem.pasien ? dataItem.pasien.nama_lengkap : 'Umum/Luar');
            $('#res_dokter').text(dataItem.dokter ? dataItem.dokter.nama_dokter : '-');
            $('#res_obat').text(dataItem.obat ? dataItem.obat.nama_obat : '-');
            $('#res_sub_dokter').text('Rp ' + parseInt(dataItem.biaya_dokter).toLocaleString('id-ID'));
            $('#res_sub_obat').text('Rp ' + parseInt(dataItem.biaya_obat).toLocaleString('id-ID'));
            $('#res_total').text('Rp ' + parseInt(dataItem.total_bayar).toLocaleString('id-ID'));

            // Konfigurasi Badge Status Lunas/Belum Lunas di resi
            const badge = $('#res_status_badge');
            badge.text(dataItem.status_pembayaran);
            if(dataItem.status_pembayaran === 'Lunas') {
                badge.removeClass().addClass('inline-block px-4 py-1 text-[10px] font-bold uppercase rounded bg-emerald-100 text-emerald-800');
            } else {
                badge.removeClass().addClass('inline-block px-4 py-1 text-[10px] font-bold uppercase rounded bg-amber-100 text-amber-800');
            }

            $('#modalResi').removeClass('hidden').addClass('flex');
        }
    });

    // Hapus Data Transaksi (DELETE)
    function hapus(id, kode) {
        Swal.fire({
            title: 'Hapus Rekaman Invoice?',
            html: `Apakah anda yakin ingin menghapus data invoice <strong>${kode}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({ 
                    url: `/api/transaksi/${id}`, 
                    type: 'DELETE', 
                    success: function(response) {
                        Swal.fire({ title: 'Terhapus!', text: response.message, icon: 'success', confirmButtonColor: '#0c4a6e' });
                        location.reload();
                    } 
                });
            }
        });
    }
</script>
@endsection