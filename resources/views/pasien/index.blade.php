<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - MedikaCenter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-6 sm:p-10 max-w-7xl mx-auto w-full">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-hospital-user text-blue-600"></i> Master Data Pasien
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">Kelola dan pantau seluruh data pasien MedikaCenter.</p>
                </div>
                
                <div>
                    <a href="/pasien/create" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-3 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-user-plus"></i> Tambah Pasien Baru
                    </a>
                </div>
            </div>

            <div id="alert-container"></div>

            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="input-cari" placeholder="Cari nomor RM atau nama..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
                <div class="flex gap-2 w-full sm:w-auto justify-end">
                    <button class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-all flex items-center gap-2">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                <th class="px-6 py-4">No. Rekam Medis</th>
                                <th class="px-6 py-4">Nama Lengkap / NIK</th>
                                <th class="px-6 py-4">L/P</th>
                                <th class="px-6 py-4">Kontak & Alamat</th>
                                <th class="px-6 py-4">Gol. Darah</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-pasien" class="divide-y divide-slate-100 text-sm">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <i class="fa-solid fa-circle-notch animate-spin text-2xl mb-2 text-blue-500"></i>
                                    <p>Sedang memuat data pasien...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="pagination-container" class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-between items-center hidden"></div>
            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} MedikaCenter Hospital System.
        </footer>
    </div>


    <div id="modal-hapus" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300" id="modal-content">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-50 text-rose-500 mb-4 animate-pulse">
                <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Hapus Data Pasien?</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">Tindakan ini tidak bisa dibatalkan. Seluruh riwayat rekam medis pasien terkait akan terhapus permanen.</p>
            
            <div class="mt-6 flex items-center gap-3">
                <button id="btn-batal-hapus" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-sm py-2.5 px-4 rounded-xl transition-all">
                    Batal
                </button>
                <button id="btn-konfirmasi-hapus" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-medium text-sm py-2.5 px-4 rounded-xl shadow-lg shadow-rose-200 transition-all">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>


<script>
        const API_URL = '/api/pasien';
        let idPasienYangAkanDihapus = null;
        let kataKunciPencarian = ''; // Menyimpan kata kunci global agar pagination tidak mereset pencarian
        let timeoutPencarian = null;  // Untuk mengontrol debounce pencarian realtime

        document.addEventListener("DOMContentLoaded", function() {
            // Memuat data awal saat halaman pertama kali dibuka
            muatDataPasien(API_URL);

            // Fitur Pencarian Real-time dengan Debounce (Menunggu user selesai mengetik 300ms)
            document.getElementById('input-cari').addEventListener('input', function(e) {
                kataKunciPencarian = e.target.value;
                
                // Bersihkan timeout lama jika user masih mengetik huruf baru
                clearTimeout(timeoutPencarian);
                
                // Setel timeout baru agar tidak membebani server API secara berlebihan
                timeoutPencarian = setTimeout(() => {
                    muatDataPasien(`${API_URL}?search=${encodeURIComponent(kataKunciPencarian)}`);
                }, 300);
            });

            // Handler tombol batal di dalam modal hapus
            document.getElementById('btn-batal-hapus').addEventListener('click', tutupModalHapus);
        });

        // Fungsi Mengambil Data dari API
        function muatDataPasien(url) {
            if(!url || url === 'null') return;

            // Tampilkan kembali skeleton loader saat mengambil data baru/pindah halaman
            const tbody = document.getElementById('tabel-pasien');
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="fa-solid fa-circle-notch animate-spin text-2xl mb-2 text-blue-500"></i>
                        <p>Sedang memuat data pasien...</p>
                    </td>
                </tr>`;

            fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal memuat respon dari server.');
                }
                return response.json();
            })
            .then(res => {
                tbody.innerHTML = '';

                // Ambil data pagination wrapper dan array utama data pasien
                const paginationData = res.data; 
                const daftarPasien = paginationData.data;

                // Jika data kosong atau tidak ada pasien sama sekali dari hasil pencarian
                if (!daftarPasien || daftarPasien.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-folder-open text-slate-300 text-4xl mb-3"></i>
                                    <p class="text-slate-500 font-medium">Data pasien tidak ditemukan.</p>
                                    ${kataKunciPencarian ? `<p class="text-xs text-slate-400 mt-1">Kata kunci: "${kataKunciPencarian}"</p>` : ''}
                                </div>
                            </td>
                        </tr>`;
                    document.getElementById('pagination-container').classList.add('hidden');
                    return;
                }

                // Loop rendering data JSON ke baris tabel HTML
                daftarPasien.forEach(pasien => {
                    const jkBadge = pasien.jenis_kelamin === 'L' 
                        ? '<span class="text-blue-600 bg-blue-100/60 px-2.5 py-0.5 rounded text-xs font-medium">Laki-laki</span>' 
                        : '<span class="text-pink-600 bg-pink-100/60 px-2.5 py-0.5 rounded text-xs font-medium">Perempuan</span>';

                    tbody.innerHTML += `
                        <tr class="hover:bg-blue-50/30 transition-all border-b border-slate-100" id="row-${pasien.id}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    ${pasien.nomor_rm}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900 text-sm">${pasien.nama_lengkap}</div>
                                <div class="text-xs text-slate-400 font-mono mt-0.5">NIK: ${pasien.nik}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${jkBadge}</td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700 text-xs"><i class="fa-solid fa-phone text-xs text-slate-400 mr-1"></i> ${pasien.nomor_hp}</div>
                                <div class="text-xs text-slate-400 truncate max-w-xs mt-0.5" title="${pasien.alamat_tinggal}">${pasien.alamat_tinggal}</div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="px-2.5 py-0.5 bg-slate-100 rounded-md font-bold text-xs text-slate-700">
                                    ${pasien.golongan_darah || '-'}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-1">
                                <a href="/pasien/${pasien.id}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition-all" title="Detail"><i class="fa-solid fa-eye text-xs"></i></a>
                                <a href="/pasien/${pasien.id}/edit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 transition-all" title="Ubah"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                                <button onclick="bukaModalHapus(${pasien.id})" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition-all" title="Hapus"><i class="fa-solid fa-trash-can text-xs"></i></button>
                            </td>
                        </tr>`;
                });

                tampilkanPagination(paginationData);
            })
            .catch(err => {
                console.error("Gagal mengambil data dari API:", err);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-rose-600 font-medium">
                            <i class="fa-solid fa-triangle-exclamation text-xl mb-2"></i>
                            <p>Gagal memuat data dari server pusat.</p>
                        </td>
                    </tr>`;
            });
        }

        // Fungsi Navigasi Halaman (Pagination) dengan Mempertahankan Query Pencarian
        function tampilkanPagination(dataPagination) {
            const container = document.getElementById('pagination-container');
            if (dataPagination.last_page <= 1) {
                container.classList.add('hidden');
                return;
            }

            // Memastikan URL pagination tetap membawa parameter filter ?search jika ada keyword pencarian
            let prevUrl = dataPagination.prev_page_url;
            let nextUrl = dataPagination.next_page_url;

            if (kataKunciPencarian) {
                if (prevUrl && !prevUrl.includes('search=')) prevUrl += `&search=${encodeURIComponent(kataKunciPencarian)}`;
                if (nextUrl && !nextUrl.includes('search=')) nextUrl += `&search=${encodeURIComponent(kataKunciPencarian)}`;
            }

            container.classList.remove('hidden');
            container.innerHTML = `
                <span class="text-xs text-slate-500">Menampilkan halaman ${dataPagination.current_page} dari ${dataPagination.last_page}</span>
                <div class="inline-flex space-x-1">
                    <button onclick="muatDataPasien('${prevUrl}')" ${!prevUrl ? 'disabled' : ''} class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium hover:bg-slate-50 disabled:opacity-40 disabled:hover:bg-white transition-all">Sebelumnya</button>
                    <button onclick="muatDataPasien('${nextUrl}')" ${!nextUrl ? 'disabled' : ''} class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium hover:bg-slate-50 disabled:opacity-40 disabled:hover:bg-white transition-all">Selanjutnya</button>
                </div>
            `;
        }

        // Logika Pemicu Custom Modal Hapus
        function bukaModalHapus(id) {
            idPasienYangAkanDihapus = id;
            const modal = document.getElementById('modal-hapus');
            const content = document.getElementById('modal-content');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);

            document.getElementById('btn-konfirmasi-hapus').onclick = eksekusiHapusPasien;
        }

        function tutupModalHapus() {
            const modal = document.getElementById('modal-hapus');
            const content = document.getElementById('modal-content');

            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                idPasienYangAkanDihapus = null;
            }, 300);
        }

        // Fungsi Eksekusi Hapus via Endpoint API
        function eksekusiHapusPasien() {
            if (!idPasienYangAkanDihapus) return;

            fetch(`${API_URL}/${idPasienYangAkanDihapus}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                tutupModalHapus();
                if (res.success) {
                    const row = document.getElementById(`row-${idPasienYangAkanDihapus}`);
                    if(row) row.remove();
                    
                    const alertBox = document.getElementById('alert-container');
                    alertBox.innerHTML = `
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm animate-fade-in">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                            <p class="text-sm text-emerald-800 font-medium">${res.message}</p>
                        </div>`;
                    
                    // Segarkan data tabel pelan-pelan untuk memperbarui state pagination terbaru
                    setTimeout(() => {
                        muatDataPasien(`${API_URL}?search=${encodeURIComponent(kataKunciPencarian)}`);
                    }, 800);
                }
            })
            .catch(err => {
                tutupModalHapus();
                alert("Gagal menghapus data pasien.");
            });
        }
    </script>
</body>
</html>