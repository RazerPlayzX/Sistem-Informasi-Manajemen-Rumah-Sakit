<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pasien - MedikaCenter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen flex flex-col justify-between">
        
        <main class="p-6 sm:p-10 max-w-4xl mx-auto w-full">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-2 text-xs text-slate-400 font-medium mb-1">
                        <a href="/pasien" class="hover:text-blue-600 transition-all">Data Pasien</a>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <span class="text-slate-600">Detail Informasi</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-address-card text-blue-600"></i> Profil & Informasi Pasien
                    </h1>
                </div>
                
                <div class="flex gap-2">
                    <a href="/pasien" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm transition-all text-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <a href="/pasien/{{ $pasien->id }}/edit" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium px-4 py-2.5 rounded-xl shadow-sm transition-all text-sm">
                        <i class="fa-solid fa-pen-to-square"></i> Ubah Data
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center justify-center">
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-4 border-2 border-slate-200 shadow-inner">
                        <i class="fa-solid fa-user-neutral text-5xl"></i>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 mb-2 tracking-wide">
                        {{ $pasien->nomor_rm }}
                    </span>
                    <h2 class="text-lg font-bold text-slate-900 leading-snug">{{ $pasien->nama_lengkap }}</h2>
                    <p class="text-xs font-mono text-slate-400 mt-1">NIK: {{ $pasien->nik }}</p>

                    <div class="w-full border-t border-slate-100 my-4 pt-4 grid grid-cols-2 gap-2 text-left">
                        <div class="bg-slate-50 p-2.5 rounded-xl text-center">
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Gol. Darah</span>
                            <span class="text-base font-bold text-slate-700">{{ $pasien->golongan_darah ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 p-2.5 rounded-xl text-center">
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Jenis Kelamin</span>
                            <span class="text-xs font-semibold text-slate-700">{{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800">Informasi Pribadi & Kontak</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tempat / Tanggal Lahir</span>
                                <span class="text-sm font-medium text-slate-800 mt-0.5 block">
                                    {{ $pasien->tempat_lahir }}, {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nomor HP / WhatsApp</span>
                                <span class="text-sm font-medium text-slate-800 mt-0.5 block flex items-center gap-1.5">
                                    <i class="fa-solid fa-phone text-slate-400 text-xs"></i> {{ $pasien->nomor_hp }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Status Pernikahan</span>
                                <span class="text-sm font-medium text-slate-800 mt-0.5 block">{{ $pasien->status_pernikahan ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Pekerjaan</span>
                                <span class="text-sm font-medium text-slate-800 mt-0.5 block">{{ $pasien->pekerjaan ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Alamat Lengkap</span>
                            <p class="text-sm font-medium text-slate-700 mt-1 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">
                                {{ $pasien->alamat_tinggal }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} MedikaCenter Hospital System.
        </footer>
    </div>

</body>
</html>