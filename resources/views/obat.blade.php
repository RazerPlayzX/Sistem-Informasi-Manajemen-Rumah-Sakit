<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMRS - Modul Data Obat</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0c4a6e;    /* Biru Tua Medis */
            --secondary-color: #0284c7;  /* Biru Terang Rumah Sakit */
            --accent-color: #10b981;     /* Hijau Sehat/Farmasi */
            --warning-color: #f59e0b;    /* Kuning Edit */
            --danger-color: #ef4444;     /* Merah Peringatan */
            --bg-color: #f0f4f8;         /* Abu-abu Kebiruan Sangat Muda */
            --text-main: #1e293b;        /* Hitam Keabuan */
            --text-muted: #64748b;       /* Abu-abu Teks */
        }

        body { 
            font-family: 'Inter', sans-serif; 
            padding: 40px 20px; 
            max-width: 1200px; 
            margin: auto; 
            background-color: var(--bg-color); 
            color: var(--text-main);
        }

        /* Header Tema Rumah Sakit */
        .app-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border-left: 6px solid var(--secondary-color);
        }

        .app-header i {
            font-size: 2.5rem;
            color: var(--secondary-color);
        }

        .app-header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        .app-header p {
            margin: 5px 0 0 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Tata Letak Grid Konten */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 25px;
        }

        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
        }

        /* Kapsul Kartu Komponen */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .card-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }

        /* Gaya Formulir Modern */
        .form-group { 
            margin-bottom: 18px; 
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        input, select { 
            width: 100%; 
            padding: 11px 12px 11px 38px; 
            border: 1.5px solid #cbd5e1; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 14px; 
            font-family: inherit;
            transition: all 0.2s;
            background-color: #f8fafc;
        }

        input:focus, select:focus { 
            outline: none; 
            border-color: var(--secondary-color); 
            background-color: white;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.15); 
        }

        /* Tombol Utama */
        button[type="submit"] { 
            padding: 12px; 
            background-color: var(--secondary-color); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            width: 100%; 
            font-size: 14px; 
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
        }

        button[type="submit"]:hover { 
            background-color: var(--primary-color); 
        }

        /* Desain Tabel Medis */
        .table-responsive {
            overflow-x: auto;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            font-size: 14px;
        }

        th, td { 
            padding: 14px 16px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0; 
        }

        th { 
            background-color: #f8fafc; 
            color: var(--primary-color); 
            font-weight: 600; 
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Label Indikator / Badge Jenis Obat */
        .badge-type {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Tombol Aksi */
        .action-btns {
            display: flex;
            gap: 6px;
        }

        .btn-edit {
            background-color: white;
            color: var(--warning-color);
            border: 1.5px solid #fef3c7;
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit:hover {
            background-color: var(--warning-color);
            color: white;
            border-color: var(--warning-color);
        }

        .btn-delete { 
            background-color: white; 
            color: var(--danger-color);
            border: 1.5px solid #fee2e2; 
            padding: 6px 10px; 
            font-size: 13px; 
            border-radius: 6px; 
            cursor: pointer; 
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-delete:hover { 
            background-color: var(--danger-color); 
            color: white;
            border-color: var(--danger-color);
        }

        /* DESAIN MODAL POP-UP EDIT */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(15, 23, 42, 0.6); 
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            position: relative;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            position: absolute;
            right: 20px; top: 20px;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-modal:hover { color: var(--danger-color); }

        .btn-secondary {
            background-color: #e2e8f0;
            color: var(--text-main);
            border: none; padding: 12px; border-radius: 8px;
            font-weight: 600; width: 100%; font-size: 14px; cursor: pointer;
            margin-top: 10px; text-align: center; display: block;
        }
        .btn-secondary:hover { background-color: #cbd5e1; }
    </style>
</head>
<body>

    <div class="app-header">
        <i class="fa-solid fa-laptop-medical"></i>
        <div>
            <h1>Sistem Informasi Manajemen Rumah Sakit</h1>
            <p><i class="fa-solid fa-pills"></i> Modul Pengelolaan Data Inventaris Farmasi & Obat (PIC: Krisna)</p>
        </div>
    </div>

    <div class="main-grid">
        
        <div class="card">
            <h2 class="card-title"><i class="fa-solid fa-square-plus"></i> Tambah Obat Baru</h2>
            <form id="obatForm">
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                        <input type="text" id="nama_obat" name="nama_obat" placeholder="Contoh: Amoxicillin 500mg" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jenis_obat">Jenis / Sediaan</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-filter"></i>
                        <select id="jenis_obat" name="jenis_obat" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Sirup">Sirup</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Salep">Salep</option>
                            <option value="Suntik">Cair / Suntik</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga">Harga Jual (Rp)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <input type="number" id="harga" name="harga" min="1" placeholder="Contoh: 15000" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok Gudang</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <input type="number" id="stok" name="stok" min="0" placeholder="Contoh: 100" required>
                    </div>
                </div>
                <button type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Data Obat</button>
            </form>
        </div>

        <div class="card">
            <h2 class="card-title"><i class="fa-solid fa-table-list"></i> Inventaris Obat Aktif</h2>
            <div class="table-responsive">
                <table id="obatTable">
                    <thead>
                        <tr>
                            <th style="width: 8%">ID</th>
                            <th style="width: 30%">Nama Obat</th>
                            <th style="width: 18%">Jenis</th>
                            <th style="width: 16%">Harga</th>
                            <th style="width: 10%">Stok</th>
                            <th style="width: 18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>
        </div>

    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="card-title" style="color: var(--warning-color); border-color: #fef3c7;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Obat
            </h2>
            <form id="editObatForm">
                <input type="hidden" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_nama_obat">Nama Obat</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                        <input type="text" id="edit_nama_obat" name="nama_obat" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_jenis_obat">Jenis / Sediaan</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-filter"></i>
                        <select id="edit_jenis_obat" name="jenis_obat" required>
                            <option value="Tablet">Tablet</option>
                            <option value="Sirup">Sirup</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Salep">Salep</option>
                            <option value="Suntik">Cair / Suntik</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_harga">Harga Jual (Rp)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <input type="number" id="edit_harga" name="harga" min="1" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_stok">Stok Gudang</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <input type="number" id="edit_stok" name="stok" min="0" required>
                    </div>
                </div>
                <button type="submit" style="background-color: var(--warning-color);">
                    <i class="fa-solid fa-pen-to-square"></i> Perbarui Data
                </button>
                <button type="button" class="btn-secondary close-btn">Batal</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Setup CSRF Token Keamanan Laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const apiUrl = '/api/obats';

            // FUNCTION 1: Mengambil Data dari API (GET)
            function muatDataObat() {
                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    success: function(response) {
                        let rows = '';
                        $.each(response.data, function(index, obat) {
                            rows += `
                                <tr>
                                    <td>#${obat.id}</td>
                                    <td><strong>${obat.nama_obat}</strong></td>
                                    <td><span class="badge-type">${obat.jenis_obat}</span></td>
                                    <td>Rp ${parseInt(obat.harga).toLocaleString('id-ID')}</td>
                                    <td><strong>${obat.stok}</strong></td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-edit" data-id="${obat.id}" data-nama="${obat.nama_obat}" data-jenis="${obat.jenis_obat}" data-harga="${obat.harga}" data-stok="${obat.stok}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <button class="btn-delete" data-id="${obat.id}" data-nama="${obat.nama_obat}">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#obatTable tbody').html(rows);
                    },
                    error: function(err) {
                        console.error("Gagal mengambil data obat dari API", err);
                    }
                });
            }

            // Panggil data saat halaman pertama dimuat
            muatDataObat();

            // FUNCTION 2: Mengirimkan Data Form Tambah ke API (POST) dengan SweetAlert2
            $('#obatForm').submit(function(e) {
                e.preventDefault();
                
                let dataFormulir = {
                    nama_obat: $('#nama_obat').val(),
                    jenis_obat: $('#jenis_obat').val(),
                    harga: $('#harga').val(),
                    stok: $('#stok').val()
                };

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    data: dataFormulir,
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#0284c7'
                        });
                        $('#obatForm')[0].reset();
                        muatDataObat(); 
                    },
                    error: function(err) {
                        let errMsg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : "Gagal memproses data.";
                        Swal.fire({
                            title: 'Gagal Validasi!',
                            text: errMsg,
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                });
            });

            // FUNCTION 3: Klik Tombol Edit -> Membuka Modal Pop-up
            $('#obatTable').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let jenis = $(this).data('jenis');
                let harga = $(this).data('harga');
                let stok = $(this).data('stok');

                $('#edit_id').val(id);
                $('#edit_nama_obat').val(nama);
                $('#edit_jenis_obat').val(jenis);
                $('#edit_harga').val(harga);
                $('#edit_stok').val(stok);

                $('#editModal').css('display', 'flex');
            });

            // FUNCTION 4: Mengirimkan Data Hasil Edit ke API (PUT) dengan SweetAlert2
            $('#editObatForm').submit(function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                
                let dataUpdate = {
                    nama_obat: $('#edit_nama_obat').val(),
                    jenis_obat: $('#edit_jenis_obat').val(),
                    harga: $('#edit_harga').val(),
                    stok: $('#edit_stok').val()
                };

                $.ajax({
                    url: `${apiUrl}/${id}`,
                    type: 'PUT',
                    data: dataUpdate,
                    success: function(response) {
                        Swal.fire({
                            title: 'Diperbarui!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#0284c7'
                        });
                        $('#editModal').css('display', 'none'); 
                        muatDataObat(); 
                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal memperbarui data obat sistem.',
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                });
            });

            // FUNCTION 5: Menghapus Data via API (DELETE) dengan Konfirmasi SweetAlert2 Modern
            $('#obatTable').on('click', '.btn-delete', function() {
                let idObat = $(this).data('id');
                let namaObat = $(this).data('nama');
                
                // Ganti confirm() jadul dengan SweetAlert2
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data obat "${namaObat}" akan dihapus permanen dari sistem farmasi!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Merah untuk aksi hapus
                    cancelButtonColor: '#64748b',  // Abu-abu untuk batal
                    confirmButtonText: 'Ya, Hapus Data!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user klik tombol konfirmasi hapus, jalankan AJAX
                        $.ajax({
                            url: `${apiUrl}/${idObat}`,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#0284c7'
                                });
                                muatDataObat();
                            },
                            error: function(err) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Gagal menghapus data dari sistem.',
                                    icon: 'error',
                                    confirmButtonColor: '#ef4444'
                                });
                            }
                        });
                    }
                });
            });

            // Kontrol Penutup Modal
            $('.close-modal, .close-btn').click(function() {
                $('#editModal').css('display', 'none');
            });

            $(window).click(function(e) {
                if ($(e.target).is('#editModal')) {
                    $('#editModal').css('display', 'none');
                }
            });
        });
    </script>
</body>
</html>