<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien Baru - MedikaCenter</title>
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
                        <span class="text-slate-600">Tambah Pasien</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-blue-600"></i> Tambah Pasien Baru
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">Isi formulir di bawah ini dengan lengkap untuk mendaftarkan pasien baru.</p>
                </div>
                
                <div>
                    <a href="/pasien" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm transition-all">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <form id="form-pasien" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    
                    <div id="alert-container" class="hidden"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <div class="sm:col-span-2">
                            <label for="nik" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="text" name="nik" id="nik" placeholder="Contoh: 327501xxxxxxxxxx" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-nik" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nama_lengkap" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Pasien <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan nama sesuai KTP" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-nama_lengkap" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex-1 flex items-center justify-between px-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all select-none">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-mars text-blue-500"></i>
                                        <span class="text-sm font-medium text-slate-700">Laki-laki</span>
                                    </div>
                                    <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                </label>
                                <label class="flex-1 flex items-center justify-between px-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all select-none">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-venus text-pink-500"></i>
                                        <span class="text-sm font-medium text-slate-700">Perempuan</span>
                                    </div>
                                    <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                </label>
                            </div>
                            <p id="error-jenis_kelamin" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label for="golongan_darah" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Golongan Darah</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-droplet"></i>
                                </span>
                                <select name="golongan_darah" id="golongan_darah" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="-">Tidak Tahu (-)</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tempat Lahir <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-building"></i>
                                </span>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Contoh: Jakarta" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-tempat_lahir" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </span>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all text-slate-600">
                            </div>
                            <p id="error-tanggal_lahir" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label for="nomor_hp" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input type="text" name="nomor_hp" id="nomor_hp" placeholder="Contoh: 081234xxxxxx" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                            <p id="error-nomor_hp" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                        <div>
                            <label for="status_pernikahan" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Pernikahan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-heart"></i>
                                </span>
                                <select name="status_pernikahan" id="status_pernikahan" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="pekerjaan" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pekerjaan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-briefcase"></i>
                                </span>
                                <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Contoh: Pegawai Swasta, PNS, Wiraswasta" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="alamat_tinggal" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Alamat Tinggal Lengkap <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute top-3 left-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <textarea name="alamat_tinggal" id="alamat_tinggal" rows="3" placeholder="Masukkan alamat jalan, RT/RW, kelurahan, kecamatan, kota/kabupaten" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl focus:outline-none focus:ring-1 transition-all resize-none"></textarea>
                            </div>
                            <p id="error-alamat_tinggal" class="text-xs text-rose-600 mt-1.5 hidden items-center gap-1"><i class="fa-solid fa-circle-info text-[10px]"></i> <span class="msg"></span></p>
                        </div>

                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="reset" class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 border border-slate-200 transition-all">
                            Reset Form
                        </button>
                        <button type="submit" id="btn-simpan" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                            <i id="icon-simpan" class="fa-solid fa-floppy-disk"></i> Simpan Data Pasien
                        </button>
                    </div>

                </form>
            </div>

        </main>

        <footer class="bg-white border-t border-slate-100 py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} MedikaCenter Hospital System.
        </footer>
    </div>


    <div id="modal-sukses" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300" id="modal-content">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-50 text-emerald-500 mb-4 animate-bounce">
                <i class="fa-solid fa-circle-check text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Pendaftaran Sukses!</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed" id="modal-message">Data pasien baru telah berhasil disimpan ke dalam sistem rumah sakit.</p>
            
            <div class="mt-6">
                <button id="btn-modal-ok" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm py-2.5 px-4 rounded-xl shadow-lg shadow-emerald-200 transition-all">
                    Selesai & Lihat Data
                </button>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('form-pasien').addEventListener('submit', function(e) {
            e.preventDefault();

            // UI Loading state tombol simpan
            const btnSimpan = document.getElementById('btn-simpan');
            const iconSimpan = document.getElementById('icon-simpan');
            btnSimpan.disabled = true;
            iconSimpan.className = "fa-solid fa-circle-notch animate-spin";

            sembunyikanSemuaError();

            // Ambil data input form
            const formData = new FormData(this);
            const dataObjek = {};
            formData.forEach((value, key) => { dataObjek[key] = value });

            // Tembak murni ke endpoint API resource pasien
            fetch('/api/pasien', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                    // Tanpa CSRF token web karena ditangani via middleware API
                },
                body: JSON.stringify(dataObjek)
            })
            .then(response => {
                // Tangkap error validasi (422) agar bisa diproses ke kolom input merah
                if (!response.ok && response.status !== 422) {
                    throw new Error('Sistem bermasalah (Status: ' + response.status + ')');
                }
                return response.json();
            })
            .then(res => {
                btnSimpan.disabled = false;
                iconSimpan.className = "fa-solid fa-floppy-disk";

                // Jika validasi input gagal dari sistem
                if (res.errors || res.success === false) {
                    tampilkanAlertGagal();
                    if(res.errors) tampilkanDetailErrorKolom(res.errors);
                } 
                // JIKA BERHASIL SIMPAN DATA
                else if (res.success === true) {
                    const modal = document.getElementById('modal-sukses');
                    const modalContent = document.getElementById('modal-content');
                    const modalMessage = document.getElementById('modal-message');
                    const btnModalOk = document.getElementById('btn-modal-ok');

                    // Tempel teks pesan sukses khusus dari Controller (termasuk No. RM)
                    if(res.message) {
                        modalMessage.innerText = res.message;
                    }

                    // Tampilkan modal pop-up dengan transisi smooth
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0');
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }, 10);

                    // Pindah halaman ke index data pasien saat tombol diklik
                    btnModalOk.addEventListener('click', function() {
                        window.location.href = '/pasien';
                    });
                }
            })
            .catch(err => {
                btnSimpan.disabled = false;
                iconSimpan.className = "fa-solid fa-floppy-disk";
                console.error("Detail Log Error:", err);
                alert('Terjadi kesalahan sistem, silakan coba lagi.');
            });
        });

        function sembunyikanSemuaError() {
            document.getElementById('alert-container').classList.add('hidden');
            const fields = ['nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nomor_hp', 'alamat_tinggal'];
            fields.forEach(field => {
                const errorEl = document.getElementById(`error-${field}`);
                if(errorEl) errorEl.classList.add('hidden');
                
                const inputEl = document.getElementById(field);
                if(inputEl) inputEl.className = inputEl.className.replace('border-rose-400 focus:border-rose-500 focus:ring-rose-500', 'border-slate-200 focus:border-blue-500 focus:ring-blue-500');
            });
        }

        function tampilkanAlertGagal() {
            const alertBox = document.getElementById('alert-container');
            alertBox.classList.remove('hidden');
            alertBox.innerHTML = `
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl flex items-start gap-3 mb-4">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="text-sm font-semibold text-rose-800">Pendaftaran Gagal</h4>
                        <p class="text-xs text-rose-700 mt-0.5">Silakan periksa kembali isian form yang ditandai merah di bawah.</p>
                    </div>
                </div>`;
        }

        function tampilkanDetailErrorKolom(errors) {
            for (const key in errors) {
                const errorEl = document.getElementById(`error-${key}`);
                const inputEl = document.getElementById(key);

                if (errorEl) {
                    errorEl.classList.remove('hidden');
                    errorEl.querySelector('.msg').innerText = errors[key][0];
                }

                if (inputEl && inputEl.type !== 'radio') {
                    inputEl.className = inputEl.className.replace('border-slate-200 focus:border-blue-500 focus:ring-blue-500', 'border-rose-400 focus:border-rose-500 focus:ring-rose-500');
                }
            }
        }
    </script>
</body>
</html>