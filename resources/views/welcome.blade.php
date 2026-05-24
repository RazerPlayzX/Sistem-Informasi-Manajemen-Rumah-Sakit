<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedikaCenter - Layanan Kesehatan Modern</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <i class="fa-solid fa-heart-pulse text-blue-600 text-3xl"></i>
                        <span class="text-2xl font-bold text-blue-900">Medika<span class="text-blue-500">Center</span></span>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="#" class="border-blue-500 text-blue-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Beranda</a>
                        
                        <!-- SAMBUNGAN KE DAFTAR PASIEN -->
                        <a href="{{ route('pasien.index') }}" class="border-transparent text-slate-500 hover:text-blue-600 hover:border-blue-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">
                            <i class="fa-solid fa-hospital-user mr-1.5 text-blue-500"></i> Data Pasien
                        </a>
                        
                        <a href="#fasilitas" class="border-transparent text-slate-500 hover:text-blue-600 hover:border-blue-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">Fasilitas</a>
                        <a href="#dokter" class="border-transparent text-slate-500 hover:text-blue-600 hover:border-blue-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">Jadwal Dokter</a>
                        <a href="#kontak" class="border-transparent text-slate-500 hover:text-blue-600 hover:border-blue-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all">Kontak</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        <div class="space-x-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-all">Dashboard</a>
                                <a href="{{ route('pasien.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-md shadow-blue-200">Kelola Pasien</a>
                            @else
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 px-4 py-2 text-sm font-medium transition-all">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-md shadow-blue-200">Daftar Pasien</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white overflow-hidden py-24 lg:py-32">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:w-2/3">
                <span class="bg-blue-500/20 text-blue-300 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-6 inline-block border border-blue-500/30">
                    <i class="fa-solid fa-star mr-1"></i> Layanan Kesehatan Terpercaya
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                    Kesehatan Anda adalah <br><span class="text-blue-400">Prioritas Utama Kami</span>
                </h1>
                <p class="text-lg text-blue-100 mb-10 max-w-xl leading-relaxed">
                    MedikaCenter menghadirkan fasilitas medis modern, laboratorium mutakhir, dan tim dokter spesialis yang siap melayani Anda dengan sepenuh hati.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- SAMBUNGAN TOMBOL UTAMA KE REKAPAN PASIEN -->
                    <a href="{{ route('pasien.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white text-center px-8 py-4 rounded-xl font-medium shadow-lg shadow-blue-900/40 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-hospital-user mr-2"></i> Buka Manajemen Pasien
                    </a>
                    <a href="#fasilitas" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white text-center px-8 py-4 rounded-xl font-medium backdrop-blur-sm transition-all">
                        Pelajari Fasilitas
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- QUICK INFO CARDS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 flex items-start gap-5">
                <div class="bg-blue-100 p-4 rounded-xl text-blue-600">
                    <i class="fa-solid fa-truck-medical text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-xl text-slate-900 mb-1">Gawat Darurat 24/7</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Layanan IGD tanggap darurat siap sedia 24 jam penuh setiap hari.</p>
                    <span class="text-blue-600 font-semibold text-sm mt-2 inline-block">Hubungi: (0736) 12345</span>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 flex items-start gap-5">
                <div class="bg-emerald-100 p-4 rounded-xl text-emerald-600">
                    <i class="fa-solid fa-user-doctor text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-xl text-slate-900 mb-1">Dokter Spesialis</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Didukung oleh jajaran dokter spesialis berpengalaman di bidangnya.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 flex items-start gap-5">
                <div class="bg-amber-100 p-4 rounded-xl text-amber-600">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-xl text-slate-900 mb-1">Jam Operasional</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Poliklinik Buka: Senin - Sabtu<br>Pukul: 08.00 WIB - 20.00 WIB</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAKTA SINGKAT / STATISTIK -->
    <section id="fasilitas" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-slate-950 sm:text-4xl mb-4">Layanan & Fasilitas Unggulan</h2>
            <p class="text-slate-500">Kami mengintegrasikan teknologi medis mutakhir untuk memberikan diagnosis yang akurat dan perawatan yang nyaman bagi pasien.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="text-4xl font-extrabold text-blue-600 mb-2">50+</div>
                <div class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1">Dokter Ahli</div>
                <div class="text-xs text-slate-400">Siap menangani berbagai keluhan medis</div>
            </div>
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="text-4xl font-extrabold text-blue-600 mb-2">20+</div>
                <div class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1">Fasilitas Poli</div>
                <div class="text-xs text-slate-400">Layanan poliklinik yang spesifik dan lengkap</div>
            </div>
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="text-4xl font-extrabold text-blue-600 mb-2">24 Jam</div>
                <div class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1">Laboratorium</div>
                <div class="text-xs text-slate-400">Pemeriksaan klinis cepat dan akurat</div>
            </div>
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="text-4xl font-extrabold text-blue-600 mb-2">98%</div>
                <div class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1">Kepuasan Pasien</div>
                <div class="text-xs text-slate-400">Berdasarkan survei berkala layanan kami</div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak" class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-heart-pulse text-blue-500 text-3xl"></i>
                        <span class="text-2xl font-bold text-white">Medika<span class="text-blue-500">Center</span></span>
                    </div>
                    <p class="text-sm leading-relaxed mb-4">
                        Menyediakan standar pelayanan medis tertinggi dengan pendekatan yang berpusat pada kenyamanan dan kesembuhan pasien.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-6">Navigasi Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-all">Beranda</a></li>
                        <li><a href="{{ route('pasien.index') }}" class="hover:text-blue-400 transition-all">Data Pasien</a></li>
                        <li><a href="#fasilitas" class="hover:text-blue-400 transition-all">Fasilitas Medis</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-all">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-blue-500"></i> Jl. Raya Kesehatan No. 12, Bengkulu</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-blue-500"></i> (0736) 12345 / 54321</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-blue-500"></i> info@medikacenter.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-slate-800 text-center text-xs">
            <p>&copy; {{ date('Y') }} MedikaCenter. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>