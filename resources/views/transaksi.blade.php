<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMRS - Modul Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="max-w-6xl mx-auto p-4 md:p-8">
        <div class="bg-gradient-to-r from-sky-600 to-blue-700 text-white p-8 rounded-3xl shadow-xl mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight"><i class="fa-solid fa-file-invoice-dollar mr-3"></i>Modul Transaksi</h1>
                <p class="text-sky-100 mt-1 opacity-90">Manajemen Pembayaran Rumah Sakit Modern</p>
            </div>
            <div class="hidden md:block">
                <i class="fa-solid fa-hospital text-6xl opacity-20"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-white p-7 rounded-3xl shadow-sm border border-slate-200 h-fit hover:shadow-md transition-shadow">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <span class="bg-sky-100 p-2 rounded-lg text-sky-600 mr-3"><i class="fa-solid fa-plus"></i></span>
                    Input Data Baru
                </h2>
                <form id="formTransaksi" class="space-y-4">
                    <div class="relative">
                        <input type="text" id="kode_transaksi" placeholder="Kode Transaksi (e.g. TRX001)" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-sky-100 outline-none transition" required>
                    </div>
                    <input type="text" id="nama_pasien" placeholder="Nama Pasien" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-sky-100 outline-none transition" required>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" id="biaya_dokter" placeholder="Biaya Dokter" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-sky-100 outline-none transition" required>
                        <input type="number" id="biaya_obat" placeholder="Biaya Obat" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-sky-100 outline-none transition" required>
                    </div>
                    <select id="status_pembayaran" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-sky-100 outline-none transition">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-semibold hover:bg-slate-800 active:scale-[0.98] transition">
                        Simpan Data Transaksi
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white p-7 rounded-3xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <span class="bg-blue-100 p-2 rounded-lg text-blue-600 mr-3"><i class="fa-solid fa-list"></i></span>
                    Daftar Transaksi
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="p-4 text-left rounded-l-xl">Kode</th>
                                <th class="p-4 text-left">Pasien</th>
                                <th class="p-4 text-right">Total</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelTransaksi" class="divide-y divide-slate-100">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const apiUrl = '/api/transaksi';

            function loadData() {
                $.get(apiUrl, function(res) {
                    let rows = '';
                    res.data.forEach(item => {
                        rows += `<tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 font-medium text-slate-700">${item.kode_transaksi}</td>
                            <td class="p-4 text-slate-600">${item.nama_pasien}</td>
                            <td class="p-4 text-right font-semibold text-slate-800">Rp ${parseInt(item.total_bayar).toLocaleString()}</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold ${item.status_pembayaran === 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'}">
                                    ${item.status_pembayaran}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <button onclick="hapus(${item.id})" class="text-slate-400 hover:text-red-500 transition"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>`;
                    });
                    $('#tabelTransaksi').html(rows);
                });
            }

            $('#formTransaksi').on('submit', function(e) {
                e.preventDefault();
                $.post(apiUrl, $(this).serialize(), function() {
                    loadData();
                    $('#formTransaksi')[0].reset();
                });
            });

            loadData();
        });

        function hapus(id) {
            if(confirm('Hapus data transaksi ini?')) {
                $.ajax({ url: `/api/transaksi/${id}`, type: 'DELETE', success: () => loadData() });
            }
        }
    </script>
</body>
</html>