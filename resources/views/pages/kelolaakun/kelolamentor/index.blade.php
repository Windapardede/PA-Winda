@extends('layouts.app')

@section('title', 'Kelola Mentor')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    {{-- Memperbaiki atribut xintegrity menjadi integrity --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7TBcVRBuKjXo/w1QkguhIyyLK4yrQX0Yv5i7k/tVElnXoltgFNnMqEzlnJwjnDHkz1NW0xPEaBwvsuJVksPdodPIFnFgzomxhJlY9lGqlTgfgcwKSjy23z4lwh9+nHm0Pdu7Z35wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tambahkan link SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .badge-status {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-active {
            background-color: #bbf7d0;
            color: #22c55e;
        }

        .badge-inactive {
            background-color: #fce7f3;
            color: #db2777;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border: none;
            display: inline-flex;
            /* Gunakan inline-flex untuk perataan di dalamnya */
            align-items: center;
            /* Ratakan item (ikon) secara vertikal di tengah tombol */
            justify-content: center;
            /* Ratakan item (ikon) secara horizontal di tengah tombol */
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            padding: 0;
            /* Reset padding agar perataan flex bekerja baik */
            margin: 0;
            /* Reset margin */
        }

        .icon-button i {
            font-size: 18px;
            color: #64748b;
        }

        .icon-button:hover {
            background: #e2e8f0;
        }

        .table thead th {
            background-color: #3c4b64;
            color: #ffffff !important;
            font-weight: bold;
        }

        .table thead {
            background-color: #3c4b64;
            color: white;
        }

        .table thead th {
            background-color: #3c4b64;
            color: #ffffff !important;
            font-weight: bold;
            vertical-align: middle;
            /* Tambahkan ini */
            text-align: center;
            /* Pastikan teks header tetap di tengah jika diinginkan */
        }

        .table thead th:first-child {
            text-align: left;
            /* Kembalikan teks "No" ke kiri */
        }

        .table tbody td {
            vertical-align: middle;
            /* Pastikan semua isi sel berada di tengah vertikal */
        }

        .table tbody td:last-child {
            text-align: center;
            /* Tengahkan konten di kolom "Aksi" */
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .main-content {
            margin-top: 30px;
        }

        .table-rounded {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-rounded thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table-rounded thead th:last-child {
            border-top-right-radius: 12px;
        }

        .table-rounded tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        .table-rounded tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

        .dropdown {
            display: inline-block;
            /* Pastikan dropdown tidak mengambil baris penuh */
        }

        .dropdown-menu.show {
            background-color: #ffffff !important;
            border: none;
            border-radius: 12px !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
            padding: 10px 0 !important;
            min-width: 150px;
        }

        .dropdown-item {
            color: #334155 !important;
            font-weight: 500 !important;
            padding: 10px 20px !important;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.4);
            /* Slightly darker for better contrast */
            z-index: 1040;
            /* Standard Bootstrap z-index for backdrop */
        }

        .modal {
            z-index: 1050;
            /* Standard Bootstrap z-index for modal content */
            overflow: hidden;
            /* Ensure content inside modal doesn't cause body scroll */
        }

        .modal.show {
            display: block;
            /* Ensure it's displayed when shown */
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - (0.5rem * 2));
            width: auto;
            max-width: 90%;
            margin: 0.5rem auto;
        }

        @media (min-width: 576px) {
            .modal-dialog-centered {
                min-height: calc(100% - (1.75rem * 2));
                max-width: 450px;
                margin: 1.75rem auto;
            }
        }

        .modal-content-custom {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ffe0b2;
            color: #f57c00;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 60px;
            margin: 0 auto 15px;
        }

        .modal-icon.bg-success {
            background-color: #c3e6cb !important;
            color: #155724 !important;
        }

        .modal-icon.bg-warning {
            background-color: #ffeeba !important;
            color: #85640a !important;
        }

        .modal-icon.bg-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }

        .modal-title-custom {
            font-size: 25px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .modal-message-custom {
            color: #555;
            margin-bottom: 0px;
            font-size: 15px;
        }

        .modal-buttons-custom {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 0px;
            flex-direction: row-reverse;
        }

        .btn-primary-custom {
            background-color: #1758B9;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-secondary-custom {
            background-color: #EB2027;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary-custom:hover {
            background-color: #134a96;
        }

        .btn-secondary-custom:hover {
            background-color: #b8181e;
            color: #fff;
        }

        .modal-tambah-mentor .modal-dialog-centered {
            max-width: 400px;
            /* Lebar modal tambah mentor */
        }

        .modal-tambah-mentor .modal-content {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .modal-tambah-mentor .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .modal-tambah-mentor .modal-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .modal-tambah-mentor .modal-body {
            padding: 15px 0;
            overflow-y: auto;
            /* Allow vertical scrolling within the modal body */
        }

        .modal-tambah-mentor .form-group {
            margin-bottom: 15px;
        }

        .modal-tambah-mentor label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
        }

        .modal-tambah-mentor .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .modal-tambah-mentor .modal-footer {
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .table thead th {
            background-color: #3c4b64;
            color: #ffffff !important;
            font-weight: bold;
            vertical-align: middle;
            /* Tambahkan ini */
        }

        /* Styles for SweetAlert2 */
        .swal2-popup {
            border-radius: 8px !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .swal2-icon {
            margin-top: 20px !important;
            margin-bottom: 15px !important;
        }

        .swal2-title {
            font-size: 25px !important;
            font-weight: bold !important;
            color: #333 !important;
            margin-bottom: 10px !important;
        }

        .swal2-html-container {
            font-size: 16px !important;
            color: #555 !important;
            margin-bottom: 20px !important;
        }

        .swal2-confirm.swal2-styled {
            background-color: #1758B9 !important;
            color: #fff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 10px 20px !important;
            font-size: 15px !important;
            cursor: pointer !important;
            transition: background-color 0.2s ease-in-out !important;
        }

        .swal2-confirm.swal2-styled:focus {
            box-shadow: none !important;
        }

        .swal2-confirm.swal2-styled:hover {
            background-color: #134a96 !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Kelola Mentor</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Kelola Mentor</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="row mb-4">
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="btnTambahMentor" data-toggle="modal"
                            data-target="#modalTambahMentor">
                            <i class="bi bi-plus-lg"></i> Tambah Mentor
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-rounded" id="mentor-table"> {{-- Added ID for easier targeting --}}
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th class="text-center">Total Mentee</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>



            </div>
        </section>
    </div>

    {{-- Modal Tambah Mentor - Diambil dari struktur modal Posisi dan disesuaikan --}}
    <div class="modal fade modal-tambah-mentor" id="modalTambahMentor" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahMentorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMentorLabel">Tambah Mentor Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Action form diubah ke route kelolamentor.store --}}
                    <form id="formTambahMentor" action="{{ route('kelolamentor.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="posisi">Posisi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="posisi" name="posisi" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="{{ url('kelolamentor') }}">Batal</a>
                    <button type="submit" class="btn btn-primary" form="formTambahMentor">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Aksi (Aktif/Nonaktif) --}}
    <div class="modal fade" id="modalKonfirmasiAksi" tabindex="-1" role="dialog"
        aria-labelledby="modalKonfirmasiAksiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-custom">
                <div class="modal-icon bg-warning text-white">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h5 class="modal-title modal-title-custom" id="modalKonfirmasiAksiLabel">Konfirmasi Aksi</h5>
                <div class="modal-body modal-message-custom">
                    Anda yakin ingin <span id="konfirmasiAksiContent"></span> mentor <strong><span
                            id="namaMentorAksi"></span></strong>?
                </div>
                <div class="modal-footer modal-buttons-custom">
                    <button type="button" class="btn btn-primary btn-primary-custom" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-secondary btn-secondary-custom"
                        id="btnKonfirmasi">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Konfirmasi Hapus (perlu diulang untuk setiap mentor jika menggunakan ID unik) --}}
    <div class="modal fade" id="modalKonfirmasiHapusGlobal" tabindex="-1" role="dialog"
        aria-labelledby="modalKonfirmasiHapusGlobalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-custom">
                <div class="modal-icon bg-danger text-white">
                    <i class="bi bi-trash"></i>
                </div>
                <h5 class="modal-title modal-title-custom" id="modalKonfirmasiHapusGlobalLabel">Konfirmasi Hapus</h5>
                <div class="modal-body modal-message-custom">
                    Apakah Anda yakin ingin menghapus akun mentor <strong><span
                            id="namaMentorHapusGlobal"></span></strong>?
                    {{-- Action form diubah ke route kelolamentor.destroy --}}
                    <form id="hapusFormMentorGlobal" action="#" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        {{-- Action akan diisi oleh JavaScript --}}
                    </form>
                </div>
                <div class="modal-footer modal-buttons-custom">
                    <button type="button" class="btn btn-primary btn-primary-custom" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary btn-secondary-custom"
                        form="hapusFormMentorGlobal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    {{-- Tambahkan SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Dummy Data for Mentors
            let dummyMentors = <?php echo $mentors; ?>;

            // Function to render table with dummy data
            function renderTable() {
                const tableBody = $('#mentor-table tbody');
                tableBody.empty(); // Clear existing rows

                dummyMentors.forEach((mentor, index) => {
                    console.log(mentor);
                    const statusBadgeClass = mentor.is_active === 1 ? 'badge-active' : 'badge-inactive';
                    const statusText = mentor.is_active === 1 ? 'AKTIF' : 'TIDAK AKTIF';
                    const toggleIconClass = mentor.is_active === 1 ? 'fas fa-toggle-off text-secondary' :
                        'fas fa-toggle-on text-success';
                    const toggleText = mentor.is_active === 1 ? 'Tidak Aktifkan' : 'Aktifkan';

                    const row = `
                    <tr data-id="${mentor.id}">
                        <td class="align-middle">${index + 1}</td>
                        <td class="align-middle">${mentor.nama}</td>
                        <td class="align-middle">${mentor.email}</td>
                        <td class="align-middle">${mentor.posisi_mentor ?? 'N/A'}</td>
                        <td class="text-center align-middle">${mentor.total_mentee}</td>
                        <td class="text-center align-middle">
                            <span class="badge-status ${statusBadgeClass}">${statusText}</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="dropdown">
                                <button class="icon-button dropdown-toggle" type="button"
                                    id="aksiDropdownMentor${mentor.id}" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"
                                    aria-label="Tampilkan opsi aksi untuk mentor ${mentor.nama}">
                                    <i class="fas fa-align-justify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="aksiDropdownMentor${mentor.id}">
                                    <a class="dropdown-item btn-aktif-nonaktif" href="#" data-id="${mentor.id}" data-status="${mentor.is_active}">
                                        <i class="${toggleIconClass} mr-2"></i> ${toggleText}
                                    </a>
                                    <a class="dropdown-item btn-hapus-akun" href="#"
                                        data-target="#modalKonfirmasiHapusGlobal"
                                        data-id="${mentor.id}" data-nama="${mentor.nama}">
                                        <i class="fas fa-trash text-danger mr-2"></i> Hapus
                                    </a>
                                    {{-- Menggunakan rute kelolamentor.show --}}
                                    <a class="dropdown-item" href="/kelolamentor/${mentor.id}"><i class="fas fa-users text-info mr-2"></i> Lihat Mentee</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                    tableBody.append(row);
                });

                // Re-bind events after rendering
                bindButtonEvents();
            }

            // Function to bind all necessary event listeners
            function bindButtonEvents() {
                // Activate/Deactivate button functionality
                $('.btn-aktif-nonaktif').off('click').on('click', function() {
                    var id = $(this).data('id');
                    var statusSaatIni = $(this).data('status'); // 0 atau 1
                    var nama = $(this).closest('tr').find('td:nth-child(2)').text();
                    var teksKonfirmasi = statusSaatIni === 1 ? 'tidak aktifkan' :
                        'aktifkan'; // If active, offer to deactivate

                    // Tentukan nilai string 'status' yang akan dikirim ke backend
                    var statusUntukBackend = statusSaatIni === 1 ? 'tidak aktif' : 'aktif';

                    $('#namaMentorAksi').text(nama);
                    $('#konfirmasiAksiContent').html(teksKonfirmasi);
                    $('#btnKonfirmasi').data('action', 'ubah-status');
                    $('#btnKonfirmasi').data('id', id);
                    // Simpan nilai string 'status' yang sesuai untuk backend
                    $('#btnKonfirmasi').data('status-baru', statusUntukBackend);
                    $('#modalKonfirmasiAksi').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                });

                // Delete button functionality
                $('.btn-hapus-akun').off('click').on('click', function() {
                    var id = $(this).data('id');
                    var nama = $(this).data('nama');

                    $('#namaMentorHapusGlobal').text(nama);
                    // Set the form action dynamically, menggunakan rute kelolamentor.destroy
                    $('#hapusFormMentorGlobal').attr('action', `/kelolamentor/${id}`);
                    $('#modalKonfirmasiHapusGlobal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                });

                // Handle "Lanjutkan" button click in confirmation modal (Aktif/Nonaktif)
                $('#btnKonfirmasi').off('click').on('click', function() {
                    var action = $(this).data('action');
                    var id = $(this).data('id');

                    if (action === 'ubah-status') {
                        // Ambil nilai string 'status' yang sudah disimpan
                        var newStatusString = $(this).data('status-baru'); // 'aktif' atau 'tidak aktif'
                        // Konversi kembali ke 0 atau 1 untuk update di dummyMentors
                        var newStatusBoolean = (newStatusString === 'aktif' ? 1 : 0);

                        $.ajax({
                            url: '/kelolamentor/' + id,
                            method: 'PUT',
                            data: {
                                // Kirim 'status' sesuai harapan backend
                                status: newStatusString,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                let mentorIndex = dummyMentors.findIndex(m => m.id === id);
                                if (mentorIndex !== -1) {
                                    // Update dummyMentors dengan nilai boolean 0 atau 1
                                    dummyMentors[mentorIndex].is_active = newStatusBoolean;
                                    renderTable(); // Re-render table to reflect changes
                                }
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: `Status mentor berhasil diubah menjadi ${newStatusString.toUpperCase()}.`,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#modalKonfirmasiAksi').modal('hide');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                let errorMessage =
                                    'Terjadi kesalahan saat mengubah status mentor.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        });
                    }
                });

                // Handle "Hapus" button click in confirmation modal (Modal Konfirmasi Hapus Global)
                $('#hapusFormMentorGlobal').off('submit').on('submit', function(e) {
                    e.preventDefault(); // Stop default form submission

                    var form = $(this);
                    var url = form.attr('action');

                    $.ajax({
                        url: url,
                        method: 'POST', // Menggunakan POST karena method DELETE disimulasikan dengan _method
                        data: form.serialize(), // Mengirim semua data form, termasuk _method
                        success: function(response) {
                            // Perbarui dummyMentors setelah penghapusan
                            var deletedId = form.attr('action').split('/')
                                .pop(); // Get ID from URL
                            dummyMentors = dummyMentors.filter(mentor => mentor.id !=
                                deletedId);
                            renderTable(); // Render ulang tabel
                            $('#modalKonfirmasiHapusGlobal').modal(
                                'hide'); // Tutup modal konfirmasi
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Dihapus!',
                                text: 'Mentor berhasil dihapus dari daftar.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            let errorMessage = 'Terjadi kesalahan saat menghapus mentor.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                            });
                        }
                    });
                });


                // Handle "Tambah Mentor" form submission
                $('#formTambahMentor').off('submit').on('submit', function(e) {
                    e.preventDefault();

                    const nama = $('#nama').val();
                    const email = $('#email').val();
                    const posisi = $('#posisi').val();
                    const password = $('#password').val();
                    const konfirmasi_password = $('#konfirmasi_password').val();

                    if (password !== konfirmasi_password) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Password dan Konfirmasi Password tidak sama!',
                        });
                        return false;
                    }

                    $.ajax({
                        url: '/kelolamentor',
                        method: 'POST',
                        data: {
                            nama: nama,
                            email: email,
                            posisi: posisi,
                            password: password
                        },
                        success: function(response) {
                            dummyMentors =
                                response; // Asumsi response adalah data mentor terbaru
                            renderTable();
                            $('#modalTambahMentor').modal('hide');
                            $('#formTambahMentor')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Ditambahkan!',
                                text: 'Mentor baru berhasil ditambahkan ke daftar.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            let errorMessage = 'Terjadi kesalahan saat menambahkan mentor.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = '';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += value + '\n';
                                });
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                html: errorMessage.replace(/\n/g,
                                    '<br>'), // Untuk menampilkan newline di SweetAlert
                            });
                        }
                    });
                });

            }

            // Initial render of the table
            renderTable();

            // Event listener for ALL Bootstrap modals when they are fully hidden
            $(document).on('hidden.bs.modal', function(e) {
                // Check if there are no other modals currently open.
                if ($('.modal.show').length === 0) {
                    // Explicitly remove modal backdrop
                    $('.modal-backdrop').remove();
                    // Remove modal-open class from body to restore scroll and interaction
                    $('body').removeClass('modal-open');
                }
            });
        });
    </script>
@endpush
