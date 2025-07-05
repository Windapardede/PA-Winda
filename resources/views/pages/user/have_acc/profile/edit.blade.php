@extends('components.user.header1')

@section('title', 'Edit Profile')

{{-- Menambahkan CSS untuk SweetAlert2 & style lainnya --}}
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-photo-label {
            position: relative;
            display: inline-block;
        }

        .camera-icon-circle {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: #f1f5f9;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
        }
    </style>
@endpush


@section('content')
    <section class="notifikasi py-5">
        <div class="container mt-5 poppins">
            <div class="mb-4">
                <h4 class="fw-bold" style="margin-top: 80px">Edit Profile</h4>
            </div>

            {{-- FORM HTML ANDA (TIDAK ADA PERUBAHAN) --}}
            <form id="profileForm" action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="text-center mb-4 position-relative" style="width: 120px; margin: auto;">
                    <label for="photo" class="upload-photo-label" title="Pilih Foto Profil" style="cursor: pointer;">
                        <img id="photoPreview"
                            src="{{ asset('file?page=' . $user->image) ?? asset('default-profile.png') }} "
                            alt="Foto Profil" class="profile-img" />
                        <div class="camera-icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-camera">
                                <path d="M23 19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </div>
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="d-none"
                        onchange="previewPhoto(event)">
                </div>

                <div class="card p-4 mb-4">
                    <h5 class="fw-semibold mb-4">Data Pribadi</h5>
                    <div class="row gx-5 gy-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label"><strong>Nama :</strong></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
                                class="form-control" disabled>

                            <label for="nim" class="form-label mt-3"><strong>NIM :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nim" id="nim" value="{{ old('nim', $user->nim ?? '') }}"
                                class="form-control" required>

                            <label for="religion" class="form-label mt-3"><strong>Agama :</strong><span
                                    class="text-danger">*</span></label>
                            <select name="religion" id="religion" class="form-select" required>
                                <option value="" disabled selected hidden style="color: #6c757d;">Pilih Agama</option>
                                @php
                                    $religionOptions = [
                                        'Islam',
                                        'Kristen',
                                        'Katolik',
                                        'Hindu',
                                        'Budha',
                                        'Konghucu',
                                        'Lainnya',
                                    ];
                                @endphp
                                @foreach ($religionOptions as $religion)
                                    <option value="{{ $religion }}"
                                        {{ old('religion', $user->religion ?? '') == $religion ? 'selected' : '' }}>
                                        {{ $religion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label"><strong>Email :</strong></label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $user->email ?? '') }}" class="form-control" disabled>

                            <label for="phone" class="form-label mt-3"><strong>No.Telepon :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $user->phone ?? '') }}" class="form-control" required>

                            <label for="gender" class="form-label mt-3"><strong>Jenis Kelamin :</strong><span
                                    class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="" disabled selected hidden style="color: #6c757d;">Pilih Jenis Kelamin
                                </option>
                                <option value="Laki-laki"
                                    {{ old('gender', $user->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('gender', $user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                                <option value="Lainnya"
                                    {{ old('gender', $user->gender ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h5 class="fw-semibold mb-4">Data Akademik</h5>
                    <div class="row gx-5 gy-3">
                        <div class="col-md-6">
                            <label for="institution" class="form-label"><strong>Asal Institusi :</strong><span
                                    class="text-danger">*</span></label>
                            <select name="instansi_id" id="institution" class="form-select" required>
                                <option value="" disabled selected hidden style="color: #6c757d;">Pilih Institusi
                                </option>
                                @foreach ($institusiOptions as $institusi)
                                    <option value="{{ $institusi->id }}"
                                        {{ old('instansi_id', $user->instansi_id ?? '') == $institusi->id ? 'selected' : '' }}>
                                        {{ $institusi->nama }}</option>
                                @endforeach
                            </select>

                            <label for="cv" class="form-label mt-3"><strong>Curriculum Vitae (PDF) :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="file" name="cv" id="cv" accept="application/pdf"
                                class="form-control" onchange="validateFile(this)"
                                @if (empty($user->cv)) required @endif>
                            <small class="text-muted fst-italic">* Maksimal file 10MB, hanya format PDF. Biarkan kosong
                                jika tidak ingin mengubah.</small>
                            @if (isset($user->cv))
                                <small>File saat ini: <a href="{{ asset('file?page=' . $user->cv) ?? asset('#') }}"
                                        target="_blank">{{ $user->cv }}</a></small>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="jurusan" class="form-label"><strong>Jurusan :</strong><span
                                    class="text-danger">*</span></label>
                            <select name="jurusan_id" id="jurusan" class="form-select" required>
                                <option value="" disabled selected hidden style="color: #6c757d;">Pilih Jurusan
                                </option>
                                @foreach ($jurusanOptions as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ old('jurusan_id', $user->jurusan_id ?? '') == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}</option>
                                @endforeach
                            </select>

                            <label for="surat" class="form-label mt-3"><strong>Surat Rekomendasi (PDF) :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="file" name="surat" id="surat" accept="application/pdf"
                                class="form-control" onchange="validateFile(this)"
                                @if (empty($user->surat)) required @endif>
                            <small class="text-muted fst-italic">* Maksimal file 10MB, hanya format PDF. Biarkan kosong
                                jika tidak ingin mengubah.</small>
                            @if (isset($user->surat))
                                <small>File saat ini: <a href="{{ asset('file?page=' . $user->surat) ?? asset('#') }}"
                                        target="_blank">{{ $user->surat }}</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h5 class="fw-semibold mb-4">Periode Magang</h5>
                    <div class="row gx-5 gy-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label"><strong>Tanggal Mulai Magang :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="date" name="mulai_magang" id="start_date"
                                value="{{ old('mulai_magang', $user->mulai_magang) }}" class="form-control" required
                                min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label"><strong>Tanggal Selesai Magang :</strong><span
                                    class="text-danger">*</span></label>
                            <input type="date" name="selesai_magang" id="end_date"
                                value="{{ old('selesai_magang', $user->selesai_magang) }}" class="form-control" required
                                min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>

    {{-- Inline script lama dihapus dari sini --}}

    @include('components.user.footer')
@endsection


{{-- Semua JavaScript dipindahkan ke sini untuk memastikan urutan loading yang benar --}}
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi validasi file yang sudah ada
        function validateFile(input) {
            const file = input.files[0];
            if (file) {
                const isPdf = file.type === 'application/pdf';
                const isTooLarge = file.size > 10 * 1024 * 1024;

                if (!isPdf) {
                    alert("File harus dalam format PDF.");
                    input.value = '';
                } else if (isTooLarge) {
                    alert("Ukuran file maksimal 10MB.");
                    input.value = '';
                }
            }
        }

        // Fungsi preview foto yang sudah ada
        function previewPhoto(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Menjalankan skrip setelah seluruh halaman HTML selesai dimuat
        $(document).ready(function() {
            // Menambahkan event listener pada form submit
            $('#profileForm').on('submit', function(e) {
                // Mencegah form untuk langsung submit
                e.preventDefault();

                // Menampilkan dialog konfirmasi SweetAlert2
                Swal.fire({
                    title: 'Konfirmasi Perubahan',
                    text: "Apakah Anda yakin ingin menyimpan perubahan pada profil?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    // Jika pengguna menekan tombol "Ya, Simpan!"
                    if (result.isConfirmed) {
                        // Lanjutkan proses submit form secara normal
                        // 'e.target' merujuk ke form yang sedang disubmit
                        e.target.submit();
                    }
                });
            });
        });
    </script>
@endpush
