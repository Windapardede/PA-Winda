@extends('layouts.app')

@section('title', 'Posisi')

@push('style')
    {{-- Ikon dan Font --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7TBcVRBuKjXo/w1QkguhIyyLK4yrQX0Yv5i7k/tVElnXoltgFNnMqEzlnJwjnDHkz1NW0xPEaBwvsuJVksPdodPIFnFgzomxhJlY9lGqlTgfgcwKSjy23z4lwh9+nHm0Pdu7Z35wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .badge-status {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-publish {
            background-color: #bbf7d0;
            color: #22c55e;
        }

        .badge-unpublish {
            background-color: #fce7f3;
            color: #db2777;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border: none;
            display: flex;
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
            /* Memastikan style diterapkan */
            color: #ffffff !important;
            font-weight: bold;
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

        .main-content {
            margin-top: 30px;
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
                <h1 class="section-title">Posisi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Posisi</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="row mb-4">
                    <div class="col-md-12">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahPosisiModal">
                            <i class="bi bi-plus-lg"></i> Tambah Posisi
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-rounded" id="posisi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Posisi</th>
                                <th>Total Kuota</th>
                                <th>Tersedia</th>
                                <th>Deskripsi</th>
                                <th>Persyaratan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posisi as $key => $posisiItem)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $posisiItem['nama'] }}</td>
                                    <td>{{ $posisiItem['total_kuota'] }}</td>
                                    <td>{{ $posisiItem['kuota_tersedia'] }}</td>
                                    <td>{{ Str::limit($posisiItem['deskripsi'], 30) }}</td>
                                    <td>{{ Str::limit($posisiItem['persyaratan'], 30) }}</td>
                                    <td>
                                        @if ($posisiItem['status'] == 'publish')
                                            <span class="badge-status badge-publish">Publish</span>
                                        @else
                                            <span class="badge-status badge-unpublish">Unpublish</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="icon-button dropdown-toggle" type="button"
                                                id="aksiDropdownPosisi{{ $posisiItem['id'] }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="aksiDropdownPosisi{{ $posisiItem['id'] }}">
                                                <a class="dropdown-item toggle-status-btn-posisi" href="#"
                                                    data-id="{{ $posisiItem['id'] }}" data-nama="{{ $posisiItem['nama'] }}"
                                                    data-status="{{ $posisiItem['status'] }}">
                                                    @if ($posisiItem['status'] == 'publish')
                                                        <i class="fas fa-times-circle"></i> Unpublish
                                                    @else
                                                        <i class="fas fa-check-circle"></i> Publish
                                                    @endif
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit-btn-posisi" href="#"
                                                    data-id="{{ $posisiItem['id'] }}"
                                                    data-nama="{{ $posisiItem['nama'] }}"
                                                    data-total_kuota="{{ $posisiItem['total_kuota'] }}"
                                                    data-kuota_tersedia="{{ $posisiItem['kuota_tersedia'] }}"
                                                    data-deskripsi="{{ $posisiItem['deskripsi'] }}"
                                                    data-persyaratan="{{ $posisiItem['persyaratan'] }}" data-toggle="modal"
                                                    data-target="#editPosisiModal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete-btn-posisi" href="#"
                                                    data-id="{{ $posisiItem['id'] }}"
                                                    data-nama="{{ $posisiItem['nama'] }}">
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

    {{-- MODAL BOOTSTRAP UNTUK TAMBAH POSISI --}}
    <div class="modal fade" id="tambahPosisiModal" tabindex="-1" role="dialog" aria-labelledby="tambahPosisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPosisiModalLabel">Tambah Posisi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahPosisi" action="{{ route('masterposisi.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Posisi</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="total_kuota">Total Kuota</label>
                            <input type="number" class="form-control" id="total_kuota" name="total_kuota" min="1"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="kuota_tersedia">Kuota Tersedia</label>
                            <input type="number" class="form-control" id="kuota_tersedia" name="kuota_tersedia"
                                min="1" required>
                            <div id="tambahKuotaError" class="text-danger small"></div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="persyaratan">Persyaratan</label>
                            <textarea class="form-control" id="persyaratan" name="persyaratan" rows="5"></textarea>
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

    {{-- MODAL BOOTSTRAP UNTUK EDIT POSISI --}}
    <div class="modal fade" id="editPosisiModal" tabindex="-1" role="dialog" aria-labelledby="editPosisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPosisiModalLabel">Edit Posisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPosisiForm" method="POST" action="">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_nama">Nama Posisi</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_total_kuota">Total Kuota</label>
                            <input type="number" class="form-control" id="edit_total_kuota" name="total_kuota"
                                min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kuota_tersedia">Kuota Tersedia</label>
                            <input type="number" class="form-control" id="edit_kuota_tersedia" name="kuota_tersedia"
                                min="1" required>
                            <div id="editKuotaError" class="text-danger small"></div>
                        </div>
                        <div class="form-group">
                            <label for="edit_deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_persyaratan">Persyaratan</label>
                            <textarea class="form-control" id="edit_persyaratan" name="persyaratan" rows="5"></textarea>
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
    {{-- Core JS Libraries --}}
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

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

            function validateQuota(totalKuotaInputId, kuotaTersediaInputId, errorDivId) {
                const totalKuota = parseInt($(totalKuotaInputId).val());
                const kuotaTersedia = parseInt($(kuotaTersediaInputId).val());
                let isValid = true;

                $(errorDivId).text('');

                if (!isNaN(totalKuota) && !isNaN(kuotaTersedia) && kuotaTersedia > totalKuota) {
                    $(errorDivId).text('Kuota Tersedia tidak boleh lebih besar dari Total Kuota.');
                    isValid = false;
                }
                return isValid;
            }

            // --- HANDLE FORM TAMBAH (MODAL BOOTSTRAP) ---
            $('#formTambahPosisi').on('submit', function(e) {
                e.preventDefault();
                if (!validateQuota('#total_kuota', '#kuota_tersedia', '#tambahKuotaError')) {
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: (response) => {
                        $('#tambahPosisiModal').modal('hide');
                        showSuccessAlert('Posisi baru berhasil ditambahkan!');
                    },
                    error: (xhr) => {
                        $('#tambahPosisiModal').modal('hide');
                        let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                        showErrorAlert(errorMessage);
                    }
                });
            });

            // --- PENGISIAN DATA PADA FORM EDIT (MODAL BOOTSTRAP) ---
            $('.edit-btn-posisi').on('click', function() {
                const data = $(this).data();
                const updateRoute = "{{ route('masterposisi.update', ':id') }}".replace(':id', data.id);

                $('#edit_nama').val(data.nama);
                $('#edit_total_kuota').val(data.total_kuota);
                $('#edit_kuota_tersedia').val(data.kuota_tersedia);
                $('#edit_deskripsi').val(data.deskripsi);
                $('#edit_persyaratan').val(data.persyaratan);
                $('#editPosisiForm').attr('action', updateRoute);

                $('#editKuotaError').text(''); // Clear previous error messages
            });

            // --- HANDLE FORM EDIT (MODAL BOOTSTRAP) ---
            $('#editPosisiForm').on('submit', function(e) {
                e.preventDefault();
                if (!validateQuota('#edit_total_kuota', '#edit_kuota_tersedia', '#editKuotaError')) {
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST', // Method spoofing _method:'PUT' handled by Blade
                    data: $(this).serialize(),
                    success: (response) => {
                        $('#editPosisiModal').modal('hide');
                        showSuccessAlert('Posisi berhasil diperbarui!');
                    },
                    error: (xhr) => {
                        $('#editPosisiModal').modal('hide');
                        let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                        showErrorAlert(errorMessage);
                    }
                });
            });

            // --- KONFIRMASI HAPUS (SWEETALERT2) ---
            $('#posisi-table').on('click', '.delete-btn-posisi', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deleteUrl = "{{ url('masterposisi') }}/" + id;

                Swal.fire({
                    title: 'Anda Yakin?',
                    html: `Apakah Anda yakin ingin menghapus posisi <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
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
                                `Posisi ${nama} telah berhasil dihapus.`),
                            error: (xhr) => showErrorAlert(
                                'Terjadi kesalahan saat menghapus data.')
                        });
                    }
                });
            });

            // --- KONFIRMASI PUBLISH/UNPUBLISH (SWEETALERT2) ---
            $('#posisi-table').on('click', '.toggle-status-btn-posisi', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const currentStatus = $(this).data('status');
                const newStatus = currentStatus === 'publish' ? 'unpublish' : 'publish';
                const actionText = newStatus === 'publish' ? 'mem-publish' : 'meng-unpublish';
                const url = "{{ route('masterposisi.publishUnpublish') }}";

                Swal.fire({
                    title: 'Konfirmasi Status',
                    html: `Apakah Anda yakin ingin <strong>${actionText}</strong> posisi <strong>${nama}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: `Ya, ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}`,
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                id: id,
                                status: newStatus,
                                _token: getCsrfToken()
                            },
                            success: (response) => showSuccessAlert(
                                `Status posisi ${nama} berhasil diubah.`),
                            error: (xhr) => showErrorAlert(
                                'Terjadi kesalahan saat mengubah status.')
                        });
                    }
                });
            });
        });
    </script>
@endpush
