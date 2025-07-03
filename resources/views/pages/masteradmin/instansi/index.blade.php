@extends('layouts.app')

@section('title', 'Mitra')

@push('style')
    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7TBcVRBuKjXo/w1QkguhIyyLK4yrQX0Yv5i7k/tVElnXoltgFNnMqEzlnJwjnDHkz1NW0xPEaBwvsuJVksPdodPIFnFgzomxhJlY9lGqlTgfgcwKSjy23z4lwh9+nHm0Pdu7Z35wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Custom Styles --}}
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
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .icon-button i {
            font-size: 18px;
            color: #64748b;
        }

        .icon-button:hover {
            background: #e2e8f0;
        }

        .table thead th {
            background-color: #3c4b64 !important;
            /* !important to ensure style is applied */
            color: #ffffff !important;
            font-weight: bold;
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

        .align-middle {
            vertical-align: middle !important;
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

        /* Mengatur agar background modal form tidak terlalu gelap */
        .modal-backdrop.show {
            opacity: .25;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Mitra</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Mitra</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="row mb-4">
                    <div class="col-md-12">
                        {{-- Tombol ini membuka modal Bootstrap untuk Tambah Data --}}
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahInstansiModal">
                            <i class="bi bi-plus-lg"></i> Tambah Mitra
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-rounded" id="mitra-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th class="text-center">Kuota</th>
                                <th class="text-center">Tersedia</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instansi as $key => $instansiItem)
                                <tr>
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $instansiItem['nama'] }}</td>
                                    <td class="text-center align-middle">{{ $instansiItem['kuota'] }}</td>
                                    <td class="text-center align-middle">{{ $instansiItem['kuota_tersedia'] }}</td>
                                    <td class="text-center align-middle">
                                        @if ($instansiItem['is_active'])
                                            <span class="badge-status badge-active">Active</span>
                                        @else
                                            <span class="badge-status badge-inactive">Non Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropdown">
                                            <button class="icon-button dropdown-toggle" type="button"
                                                id="aksiDropdownInstansi{{ $instansiItem['id'] }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="aksiDropdownInstansi{{ $instansiItem['id'] }}">
                                                {{-- Tombol ini memicu SweetAlert2 untuk konfirmasi status --}}
                                                <a class="dropdown-item status-btn-instansi" href="#"
                                                    data-id="{{ $instansiItem['id'] }}"
                                                    data-nama="{{ $instansiItem['nama'] }}"
                                                    data-status="{{ $instansiItem['is_active'] }}">
                                                    @if ($instansiItem['is_active'])
                                                        <i class="fas fa-ban"></i> Non Aktifkan
                                                    @else
                                                        <i class="fas fa-check"></i> Aktifkan
                                                    @endif
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                {{-- Tombol ini membuka modal Bootstrap untuk Edit Data --}}
                                                <a class="dropdown-item edit-btn-instansi" href="#"
                                                    data-id="{{ $instansiItem['id'] }}"
                                                    data-nama="{{ $instansiItem['nama'] }}"
                                                    data-kuota="{{ $instansiItem['kuota'] }}"
                                                    data-kuota_tersedia="{{ $instansiItem['kuota_tersedia'] }}"
                                                    data-toggle="modal" data-target="#editInstansiModal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                {{-- Tombol ini memicu SweetAlert2 untuk konfirmasi hapus --}}
                                                <a class="dropdown-item delete-btn-instansi" href="#"
                                                    data-id="{{ $instansiItem['id'] }}"
                                                    data-nama="{{ $instansiItem['nama'] }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>

    {{-- MODAL BOOTSTRAP UNTUK TAMBAH MITRA (FORM) --}}
    <div class="modal fade" id="tambahInstansiModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahInstansiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahInstansiModalLabel">Tambah Mitra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahInstansi" method="POST" action="{{ route('instansi.store') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Mitra</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Total Kuota</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" min="0"
                                required>
                            <div id="totalKuotaError" class="text-danger small"></div>
                        </div>
                        <div class="form-group">
                            <label for="kuota_tersedia">Kuota Tersedia</label>
                            <input type="number" class="form-control" id="kuota_tersedia" name="kuota_tersedia"
                                min="0" required>
                            <div id="kuotaTersediaError" class="text-danger small"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL BOOTSTRAP UNTUK EDIT MITRA (FORM) --}}
    <div class="modal fade" id="editInstansiModal" tabindex="-1" role="dialog"
        aria-labelledby="editInstansiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInstansiModalLabel">Edit Mitra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editInstansiForm" method="POST" action="">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_instansi_id">
                        <div class="form-group">
                            <label for="edit_nama_instansi">Nama Mitra</label>
                            <input type="text" class="form-control" id="edit_nama_instansi" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kuota_instansi">Total Kuota</label>
                            <input type="number" class="form-control" id="edit_kuota_instansi" name="kuota"
                                min="0" required>
                            <div id="editTotalKuotaError" class="text-danger small"></div>
                        </div>
                        <div class="form-group">
                            <label for="edit_kuota_tersedia_instansi">Kuota Tersedia</label>
                            <input type="number" class="form-control" id="edit_kuota_tersedia_instansi"
                                name="kuota_tersedia" min="0" required>
                            <div id="editKuotaTersediaError" class="text-danger small"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- JS Libraries --}}
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    {{-- Custom Script --}}
    <script>
        $(document).ready(function() {

            // --- FUNGSI GLOBAL ---
            function showSuccessAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'Oke'
                }).then(() => {
                    location.reload();
                });
            }

            function showErrorAlert(message) {
                Swal.fire({
                    title: 'Gagal!',
                    html: message,
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            }

            function getCsrfToken() {
                return "{{ csrf_token() }}";
            }

            // --- VALIDASI KUOTA PADA FORM MODAL ---
            function validateQuota(totalKuotaInputId, kuotaTersediaInputId, totalErrorDivId, tersediaErrorDivId) {
                const totalKuota = parseInt($(totalKuotaInputId).val());
                const kuotaTersedia = parseInt($(kuotaTersediaInputId).val());
                let isValid = true;

                $(totalErrorDivId).text('');
                $(tersediaErrorDivId).text('');

                if (isNaN(totalKuota) || totalKuota < 0) {
                    $(totalErrorDivId).text('Total Kuota harus angka positif.');
                    isValid = false;
                }
                if (isNaN(kuotaTersedia) || kuotaTersedia < 0) {
                    $(tersediaErrorDivId).text('Kuota Tersedia harus angka positif.');
                    isValid = false;
                }
                if (isValid && totalKuota < kuotaTersedia) {
                    $(tersediaErrorDivId).text('Kuota Tersedia tidak boleh lebih besar dari Total Kuota.');
                    isValid = false;
                }
                return isValid;
            }

            // --- HANDLE FORM TAMBAH MITRA (MODAL BOOTSTRAP) ---
            $('#formTambahInstansi').on('submit', function(e) {
                e.preventDefault();
                if (!validateQuota('#kuota', '#kuota_tersedia', '#totalKuotaError',
                    '#kuotaTersediaError')) {
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: (response) => {
                        $('#tambahInstansiModal').modal('hide');
                        showSuccessAlert('Mitra berhasil ditambahkan!');
                    },
                    error: (xhr) => {
                        $('#tambahInstansiModal').modal('hide');
                        showErrorAlert('Terjadi kesalahan saat menambahkan data.');
                    }
                });
            });

            // --- PENGISIAN DATA PADA FORM EDIT (MODAL BOOTSTRAP) ---
            $('.edit-btn-instansi').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const kuota = $(this).data('kuota');
                const kuota_tersedia = $(this).data('kuota_tersedia');
                const updateRoute = `{{ url('instansi') }}/${id}`;

                $('#edit_instansi_id').val(id);
                $('#edit_nama_instansi').val(nama);
                $('#edit_kuota_instansi').val(kuota);
                $('#edit_kuota_tersedia_instansi').val(kuota_tersedia);
                $('#editInstansiForm').attr('action', updateRoute);

                // Bersihkan pesan error sebelumnya
                $('#editTotalKuotaError').text('');
                $('#editKuotaTersediaError').text('');
            });

            // --- HANDLE FORM EDIT MITRA (MODAL BOOTSTRAP) ---
            $('#editInstansiForm').on('submit', function(e) {
                e.preventDefault();
                if (!validateQuota('#edit_kuota_instansi', '#edit_kuota_tersedia_instansi',
                        '#editTotalKuotaError', '#editKuotaTersediaError')) {
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST', // Method spoofing (_method: 'PUT') handled by blade
                    data: $(this).serialize(),
                    success: (response) => {
                        $('#editInstansiModal').modal('hide');
                        showSuccessAlert('Mitra berhasil diperbarui!');
                    },
                    error: (xhr) => {
                        $('#editInstansiModal').modal('hide');
                        showErrorAlert('Terjadi kesalahan saat memperbarui data.');
                    }
                });
            });

            // --- KONFIRMASI AKTIF/NON-AKTIF (SWEETALERT2) ---
            $('#mitra-table').on('click', '.status-btn-instansi', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const isActive = $(this).data('status');
                const newStatus = isActive ? 0 : 1;
                const actionText = isActive ? 'Non Aktifkan' : 'Aktifkan';
                const icon = isActive ? 'warning' : 'info';

                Swal.fire({
                    title: `Konfirmasi ${actionText}`,
                    html: `Apakah Anda yakin ingin <strong>${actionText.toLowerCase()}</strong> mitra <strong>${nama}</strong>?`,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: isActive ? '#dc3545' : '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Ya, ${actionText}!`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('instansi.blacklistunblacklist') }}",
                            type: 'POST',
                            data: {
                                _token: getCsrfToken(),
                                id: id,
                                is_active: newStatus
                            },
                            success: (response) => showSuccessAlert(
                                `Status mitra berhasil diubah.`),
                            error: (xhr) => showErrorAlert(
                                'Terjadi kesalahan saat mengubah status.')
                        });
                    }
                });
            });

            // --- KONFIRMASI HAPUS (SWEETALERT2) ---
            $('#mitra-table').on('click', '.delete-btn-instansi', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deleteUrl = `{{ url('instansi') }}/${id}`;

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    html: `Apakah Anda yakin ingin menghapus mitra <strong>${nama}</strong>? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                '_method': 'DELETE',
                                '_token': getCsrfToken()
                            },
                            success: (response) => showSuccessAlert(
                                'Mitra berhasil dihapus!'),
                            error: (xhr) => showErrorAlert(
                                'Terjadi kesalahan saat menghapus data.')
                        });
                    }
                });
            });
        });
    </script>
@endpush
