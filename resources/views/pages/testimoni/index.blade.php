@extends('layouts.app')

@section('title', 'Testimoni')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            position: relative;
            /* Untuk menjadi containing block bagi ikon yang diposisikan absolute */
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin: 0 5px;
            display: inline-flex;
            /* Atau display: inline-block; jika tidak ingin flexbox mempengaruhi layout lain */
            align-items: center;
            justify-content: center;
        }

        .icon-button i {
            font-size: 18px;
            color: #64748b;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .icon-button:hover {
            background: #e2e8f0;
        }

        .table thead th {
            background-color: #3c4b64;
            color: #ffffff !important;
            font-weight: bold;
            text-align: left;
        }

        .table thead {
            background-color: #3c4b64;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
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

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.2);
            background-color: transparent !important;
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
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Testimoni</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Testimoni</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="table-responsive">
                    <table class="table table-striped table-rounded">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th class="text-center align-middle-header">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimoni as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama->name ?? '-' }}</td>
                                    <td>{{ $item->nama->posisi->nama ?? '-' }}</td>

                                    <td class="text-center">
                                        <button class="icon-button detail-btn-testimoni" data-toggle="modal"
                                            data-target="#detailTestimoniModal" data-nama="{{ @$item->nama->name }}"
                                            data-instansi="{{ @$item->nama->posisi->nama }}"
                                            data-posisi="{{ @$item->nama->posisi->nama }}"
                                            data-testimoni="{{ @$item->content }}"
                                            aria-label="Lihat detail testimoni {{ $item['id'] }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Jika ada pagination --}}
                {{-- <div class="float-right mt-3">
                    {{ $item->links() }}
        </div> --}}

            </div>
        </section>
    </div>

    <div class="modal fade" id="detailTestimoniModal" tabindex="-1" role="dialog"
        aria-labelledby="detailTestimoniModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTestimoniModalLabel">Detail Testimoni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="detail-nama"></span></p>
                    <p><strong>Instansi:</strong> <span id="detail-instansi"></span></p>
                    <p><strong>Posisi:</strong> <span id="detail-posisi"></span></p>
                    <p><strong>Testimoni:</strong> <span id="detail-testimoni"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

    <script>
        $(document).ready(function() {
            $('.detail-btn-testimoni').on('click', function() {
                var nama = $(this).data('nama');
                var instansi = $(this).data('instansi');
                var posisi = $(this).data('posisi');
                var testimoni = $(this).data('testimoni');
                var modalId = $(this).data('target');

                $(modalId).find('#detail-nama').text(nama);
                $(modalId).find('#detail-instansi').text(instansi);
                $(modalId).find('#detail-posisi').text(posisi);
                $(modalId).find('#detail-testimoni').text(testimoni);

                // Tampilkan modal detail testimoni TANPA backdrop statis
                $(modalId).modal({
                    backdrop: false
                });
            });
        });
    </script>
@endpush
