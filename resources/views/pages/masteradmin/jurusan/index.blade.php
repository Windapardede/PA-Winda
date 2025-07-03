@extends('layouts.app')

@section('title', 'Jurusan')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7TBcVRBuKjXo/w1QkguhIyyLK4yrQX0Yv5i7k/tVElnXoltgFNnMqEzlnJwjnDHkz1NW0xPEaBwvsuJVksPdodPIFnFgzomxhJlY9lGqlTgfgcwKSjy23z4lwh9+nHm0Pdu7Z35wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
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
            padding: 0;
            margin: 0;
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
            color: #ffffff !important;
            font-weight: bold;
        }

        .table tbody td {
            padding-top: 10px;
            padding-bottom: 10px;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody td:last-child {
            text-align: center;
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

        .modal-backdrop.show {
            opacity: .25;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Jurusan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Jurusan</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="row mb-4">
                    <div class="col-md-12">
                        {{-- Tombol ini kembali membuka modal Bootstrap --}}
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahJurusanModal">
                            <i class="bi bi-plus-lg"></i> Tambah Jurusan
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-rounded " id="jurusan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurusan as $key => $jurusanItem)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $jurusanItem['nama'] }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="icon-button dropdown-toggle" type="button"
                                                id="aksiDropdownJurusan{{ $jurusanItem['id'] }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="aksiDropdownJurusan{{ $jurusanItem['id'] }}">
                                                {{-- Tombol Edit kembali membuka modal Bootstrap --}}
                                                <a class="dropdown-item edit-btn-jurusan" href="#" data-toggle="modal"
                                                    data-target="#editJurusanModal" data-id="{{ $jurusanItem['id'] }}"
                                                    data-nama="{{ $jurusanItem['nama'] }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                {{-- Tombol Hapus memicu SweetAlert2 --}}
                                                <a class="dropdown-item delete-btn-jurusan" href="#"
                                                    data-id="{{ $jurusanItem['id'] }}"
                                                    data-nama="{{ $jurusanItem['nama'] }}">
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

    {{-- MODAL LAMA (BOOTSTRAP) UNTUK TAMBAH JURUSAN --}}
    <div class="modal fade" id="tambahJurusanModal" tabindex="-1" role="dialog" aria-labelledby="tambahJurusanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJurusanModalLabel">Tambah Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- Form dihandle dengan AJAX --}}
                <form id="formTambahJurusan" action="{{ route('jurusan.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Jurusan</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
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

    {{-- MODAL LAMA (BOOTSTRAP) UNTUK EDIT JURUSAN --}}
    <div class="modal fade" id="editJurusanModal" tabindex="-1" role="dialog" aria-labelledby="editJurusanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJurusanModalLabel">Edit Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- Action form akan diisi oleh Javascript --}}
                <form id="editJurusanForm" method="POST" action="">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_jurusan_id">
                        <div class="form-group">
                            <label for="edit_nama_jurusan">Nama Jurusan</label>
                            <input type="text" class="form-control" id="edit_nama_jurusan" name="nama" required>
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
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk notifikasi sukses
            function showSuccessAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'Oke'
                }).then(() => {
                    location.reload(); // Muat ulang halaman setelah notifikasi ditutup
                });
            }

            // Fungsi untuk notifikasi error
            function showErrorAlert(message) {
                Swal.fire({
                    title: 'Gagal!',
                    text: message,
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            }

            // 1. TAMBAH JURUSAN (via AJAX dari Modal Bootstrap)
            $('#formTambahJurusan').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#tambahJurusanModal').modal('hide');
                        showSuccessAlert('Jurusan berhasil ditambahkan!');
                    },
                    error: function(xhr) {
                        $('#tambahJurusanModal').modal('hide');
                        showErrorAlert('Terjadi kesalahan saat menambahkan data.');
                    }
                });
            });

            // 2. EDIT JURUSAN (JS untuk mengisi & submit Modal Bootstrap)
            $('.edit-btn-jurusan').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let updateRoute = "{{ route('jurusan.update', ':id') }}".replace(':id', id);

                $('#edit_jurusan_id').val(id);
                $('#edit_nama_jurusan').val(nama);
                $('#editJurusanForm').attr('action', updateRoute);
            });

            $('#editJurusanForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST', // Method spoofing (_method: PUT)
                    data: formData,
                    success: function(response) {
                        $('#editJurusanModal').modal('hide');
                        showSuccessAlert('Jurusan berhasil diperbarui!');
                    },
                    error: function(xhr) {
                        $('#editJurusanModal').modal('hide');
                        showErrorAlert('Terjadi kesalahan saat memperbarui data.');
                    }
                });
            });


            // 3. HAPUS JURUSAN (menggunakan SweetAlert2 untuk konfirmasi)
            $('#jurusan-table').on('click', '.delete-btn-jurusan', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deleteUrl = `{{ url('jurusan') }}/${id}`;

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    html: `Apakah Anda yakin ingin menghapus jurusan <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EB2027',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim request hapus menggunakan AJAX
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST', // Laravel handle DELETE via POST with _method
                            data: {
                                '_method': 'DELETE',
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                showSuccessAlert('Jurusan berhasil dihapus!');
                            },
                            error: function(xhr) {
                                showErrorAlert(
                                    'Terjadi kesalahan saat menghapus jurusan.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
