<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pasien - MedikaCenter</title>
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
                        <span class="text-slate-600">Ubah Pasien</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-user-gear text-amber-500"></i> Ubah Data Pasien
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">Perbarui data rekam medis <span class="font-semibold text-slate-700">{{ $pasien->nama_lengkap }}</span> ({{ $pasien->nomor_rm }}).</p>
                </div>
                
                <div>
                    <a href="/pasien" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm transition-all">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Batal
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <form id="form-edit-pasien" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    
                    <div id="alert-container" class="hidden"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <div class="sm:col-span-2">
                            <label for="nik" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">NIK <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-id-card"></i></span>
                                <input type="text" name="nik" id="nik" value="{{ $pasien->nik }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-nik" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nama_lengkap" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $pasien->nama_lengkap }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-nama_lengkap" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex-1 flex items-center justify-between px-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all select-none">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-mars text-blue-500"></i> <span class="text-sm font-medium text-slate-700">Laki-laki</span>
                                    </div>
                                    <input type="radio" name="jenis_kelamin" value="L" {{ $pasien->jenis_kelamin === 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                </label>
                                <label class="flex-1 flex items-center justify-between px-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all select-none">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-venus text-pink-500"></i> <span class="text-sm font-medium text-slate-700">Perempuan</span>
                                    </div>
                                    <input type="radio" name="jenis_kelamin" value="P" {{ $pasien->jenis_kelamin === 'P' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="golongan_darah" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Golongan Darah</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-droplet"></i></span>
                                <select name="golongan_darah" id="golongan_darah" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all appearance-none cursor-pointer">
                                    <option value="A" {{ $pasien->golongan_darah == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ $pasien->golongan_darah == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ $pasien->golongan_darah == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ $pasien->golongan_darah == 'O' ? 'selected' : '' }}>O</option>
                                    <option value="-" {{ $pasien->golongan_darah == '-' ? 'selected' : '' }}>Tidak Tahu (-)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tempat Lahir <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-building"></i></span>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ $pasien->tempat_lahir }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ $pasien->tanggal_lahir }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all text-slate-600">
                            </div>
                        </div>

                        <div>
                            <label for="nomor_hp" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nomor HP <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="nomor_hp" id="nomor_hp" value="{{ $pasien->nomor_hp }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="status_pernikahan" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Pernikahan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-heart"></i></span>
                                <select name="status_pernikahan" id="status_pernikahan" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all appearance-none">
                                    <option value="Belum Kawin" {{ $pasien->status_pernikahan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ $pasien->status_pernikahan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ $pasien->status_pernikahan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ $pasien->status_pernikahan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="pekerjaan" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pekerjaan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-briefcase"></i></span>
                                <input type="text" name="pekerjaan" id="pekerjaan" value="{{ $pasien->pekerjaan }}" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="alamat_tinggal" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Alamat Tinggal Lengkap <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute top-3 left-3.5 pointer-events-none text-slate-400"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="alamat_tinggal" id="alamat_tinggal" rows="3" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all resize-none">{{ $pasien->alamat_tinggal }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="submit" id="btn-update" class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-6 py-2.5 rounded-xl shadow-lg shadow-amber-100 transition-all transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                            <i id="icon-update" class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} MedikaCenter Hospital System.
        </footer>
    </div>

    <div id="modal-update-sukses" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300" id="modal-content">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-50 text-amber-500 mb-4 animate-bounce">
                <i class="fa-solid fa-circle-check text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Perubahan Disimpan!</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed" id="modal-message">Data master pasien berhasil diperbarui dalam server database.</p>
            
            <div class="mt-6">
                <button id="btn-modal-ok" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-2.5 px-4 rounded-xl transition-all">
                    Kembali ke Halaman Utama
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('form-edit-pasien').addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('btn-update');
            const icon = document.getElementById('icon-update');
            btn.disabled = true;
            icon.className = "fa-solid fa-circle-notch animate-spin";

            const formData = new FormData(this);
            const dataObjek = {};
            formData.forEach((value, key) => { dataObjek[key] = value });

            // Gunakan metode PUT dengan menembak langsung ke Endpoint API Resource
            fetch('/api/pasien/{{ $pasien->id }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(dataObjek)
            })
            .then(response => {
                if (!response.ok && response.status !== 422) {
                    throw new Error('Gagal memperbarui sistem.');
                }
                return response.json();
            })
            .then(res => {
                btn.disabled = false;
                icon.className = "fa-solid fa-floppy-disk";

                if (res.success === true) {
                    const modal = document.getElementById('modal-update-sukses');
                    const content = document.getElementById('modal-content');
                    
                    if(res.message) {
                        document.getElementById('modal-message').innerText = res.message;
                    }

                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0');
                        content.classList.remove('scale-95');
                        content.classList.add('scale-100');
                    }, 10);

                    document.getElementById('btn-modal-ok').addEventListener('click', function() {
                        window.location.href = '/pasien';
                    });
                } else {
                    alert('Terjadi kesalahan validasi data.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                icon.className = "fa-solid fa-floppy-disk";
                alert('Gagal memperbarui data pasien.');
            });
        });
    </script>
</body>
</html>