<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIMRS Medika Portal</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        /* Efek Transisi Halus Global */
        .smooth-nav {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 selection:bg-sky-500 selection:text-white">

    <nav class="bg-gradient-to-r from-sky-950 via-sky-900 to-slate-900 text-white shadow-xl sticky top-0 z-50 border-b border-sky-800/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-md shadow-emerald-900/40 transform group-hover:rotate-12 transition-transform duration-300">
                        <i class="fa-solid fa-house-medical text-xl text-sky-950"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tight">
                        SIMRS <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 to-teal-300">Medika</span>
                    </span>
                </div>
                
                <div class="hidden lg:flex items-center gap-2 font-medium text-sm">
                    
                    <a href="{{ route('dashboard') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('dashboard') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie text-base"></i> Dashboard
                    </a>
                    
                    <a href="{{ route('pasien.index') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('pasien.*') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-user-injured text-base"></i> Pasien
                    </a>
                    
                    <a href="{{ route('dokter.index') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('dokter.*') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-user-md text-base"></i> Dokter
                    </a>
                    
                    <a href="{{ route('obat.index') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('obat.*') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-pills text-base"></i> Farmasi & Obat
                    </a>
                    
                    <a href="{{ route('ruangan.index') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('ruangan.*') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-procedures text-base"></i> Ruangan
                    </a>
                    
                    <a href="{{ route('transaksi.index') }}" class="smooth-nav px-4 py-2 rounded-xl flex items-center gap-2 {{ Route::is('transaksi.*') ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-file-invoice-dollar text-base"></i> Kasir
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
    <div class="text-right hidden sm:block border-r border-slate-700/60 pr-4">
        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Petugas Aktif</p>
        <p class="text-sm font-semibold text-emerald-400 flex items-center gap-1.5 justify-end">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Admin SIMRS </p>
    </div>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="smooth-nav bg-rose-500/10 border border-rose-500/20 hover:bg-rose-600 text-rose-400 hover:text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-power-off"></i> Keluar
        </button>
    </form>
</div>
                
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto p-4 md:p-8 animate-[fadeIn_0.4s_ease-out]">
        @yield('content')
    </main>

    <footer class="bg-slate-950 text-slate-400 py-8 border-t border-slate-900 text-center text-xs">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-semibold text-slate-300 text-sm">Portal SIMRS Medika Kelompok Terintegrasi &copy; 2026</p>
            <p class="text-slate-500">
                Sistem Informasi Manajemen Rumah Sakit &bull; Didukung Keamanan Enkripsi Lapisan Core API v11
            </p>
            <div class="flex justify-center gap-4 pt-2 text-slate-600 text-base">
                <i class="fa-solid fa-shield-halved" title="Secure Database Connection"></i>
                <i class="fa-solid fa-server" title="Cloud Server Active"></i>
                <i class="fa-solid fa-user-shield" title="Protected Guard Platform"></i>
            </div>
        </div>
    </footer>

</body>
</html>