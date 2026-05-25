@extends('layouts.app')
@section('title', 'Dashboard Klinis Utama')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Ringkasan Operasional Rumah Sakit</h1>
    <p class="text-sm text-slate-500 mt-1">Statistik real-time data rekam medis dan pelayanan administrasi terintegrasi hari ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Registrasi Pasien</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['pasien'] }} <span class="text-sm font-normal text-slate-400">Jiwa</span></h3>
        </div>
        <span class="p-3 bg-sky-50 text-sky-600 rounded-xl text-xl"><i class="fa-solid fa-hospital-user"></i></span>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Tenaga Medis Aktif</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['dokter'] }} <span class="text-sm font-normal text-slate-400">Dokter</span></h3>
        </div>
        <span class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl"><i class="fa-solid fa-user-md"></i></span>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Stok Komoditas Obat</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['obat'] }} <span class="text-sm font-normal text-slate-400">Sediaan</span></h3>
        </div>
        <span class="p-3 bg-amber-50 text-amber-600 rounded-xl text-xl"><i class="fa-solid fa-capsules"></i></span>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase">Pendapatan Kasir (Lunas)</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-2">Rp {{ number_format($stats['transaksi'], 0, ',', '.') }}</h3>
        </div>
        <span class="p-3 bg-purple-50 text-purple-600 rounded-xl text-xl"><i class="fa-solid fa-wallet"></i></span>
    </div>
</div>

<div class="bg-gradient-to-r from-sky-700 to-indigo-800 text-white rounded-2xl p-6 shadow-lg shadow-sky-700/10 flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-lg font-bold">Akses Modul Apotek & Inventaris Obat</h2>
        <p class="text-xs text-sky-200 mt-0.5">Kelola data obat farmasi, update stok gudang, dan sinkronisasi harga jual obat.</p>
    </div>
    <a href="{{ route('obat.index') }}" class="bg-white text-sky-900 px-5 py-2.5 rounded-xl text-xs font-bold shadow hover:bg-sky-50 transition-all transform hover:-translate-y-0.5">
        Buka Manajemen Obat &rarr;
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-line text-sky-600"></i> Grafik Tren Kunjungan Medis
        </h3>
        <div class="relative h-64 w-full">
            <canvas id="grafikKunjungan"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-500"></i> Log Aktivitas Sistem
            </h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3 border-l-2 border-emerald-500 pl-3">
                    <div>
                        <p class="text-xs font-bold text-slate-800">Billing Invoice Lunas</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Kasir baru saja mencetak struk invoice lunas #TRX-2026-004</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 border-l-2 border-sky-500 pl-3">
                    <div>
                        <p class="text-xs font-bold text-slate-800">Registrasi Pasien Baru</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Sistem berhasil menerbitkan nomor rekam medis RM-202605-0012</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 border-l-2 border-amber-500 pl-3">
                    <div>
                        <p class="text-xs font-bold text-slate-800">Sinkronisasi Sediaan Farmasi</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Admin apotek memperbarui kapasitas stok obat Paracetamol 500mg</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-4 border-t border-slate-100 text-center">
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-md">
                <i class="fa-solid fa-circle-check animate-pulse mr-1"></i> Seluruh Engine SIMRS Normal
            </span>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Konfigurasi Render Grafik Tren Medis
        const ctx = document.getElementById('grafikKunjungan').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Registrasi Pasien Masuk',
                    data: [12, 19, 3, 5, 2, 24, {{ $stats['pasien'] }}], // Data terakhir otomatis membaca stats database pasien kamu
                    borderColor: '#0284c7',
                    backgroundColor: 'rgba(2, 132, 199, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0284c7'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection