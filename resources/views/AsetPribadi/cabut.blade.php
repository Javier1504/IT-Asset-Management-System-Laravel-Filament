@extends('layouts.admin')

@section('title', 'Cabut Aset Pribadi')

@section('content')

    @use(Illuminate\Support\Facades\Auth)
    <!-- Main -->
    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-pribadi.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Pencabutan Aset Pribadi</span>
            </div>
        </div>
    </header>
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Master</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('aset-pribadi.index') }}">Aset Pribadi</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Cabut</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0 mb-2 text-danger">Formulir Pencabutan Aset Pribadi</h4>
                        <span class="text-muted">Lengkapi form pencabutan aset pribadi di bawah ini.</span>

                        <form action="{{ route('aset-pribadi.cabut-proses', $asetpribadi->id) }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf

                            <!-- Informasi Aset (Read Only) -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Informasi Aset</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_aset" class="form-label">Nama Aset</label>
                                        <input type="text" class="form-control" id="nama_aset"
                                            value="{{ $asetpribadi->nama_aset }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_user" class="form-label">Nama User</label>
                                        <input type="text" class="form-control" id="nama_user"
                                            value="{{ $asetpribadi->user->name_karyawan }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="merk" class="form-label">Merk</label>
                                        <input type="text" class="form-control" id="merk"
                                            value="{{ $asetpribadi->merk }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe</label>
                                        <input type="text" class="form-control" id="tipe"
                                            value="{{ $asetpribadi->tipe }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="mac_address" class="form-label">MAC Address</label>
                                        <input type="text" class="form-control" id="mac_address"
                                            value="{{ $asetpribadi->mac_address }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Pencabutan Section -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-danger mb-3">Informasi Pencabutan</h5>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nomor_pencabutan_user" class="form-label">Nomor Pencabutan</label>
                                        <input type="text" class="form-control" id="nomor_pencabutan_user"
                                            name="nomor_pencabutan_user"
                                            value="{{ old('nomor_pencabutan_user', $asetpribadi->id . '/FRM.CPAP.1/TIS/SVM/' . now()->year) }}"
                                            readonly>
                                        <p class="form-text">Nomor pencabutan di-generate otomatis dan tidak dapat diubah.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="alasan_pencabutan_user" class="form-label">Alasan Pencabutan<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alasan_pencabutan_user" name="alasan_pencabutan_user" rows="4"
                                            placeholder="Masukkan alasan pencabutan aset pribadi..." required>{{ old('alasan_pencabutan_user', $asetpribadi->alasan_pencabutan_user) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="id_manager" class="form-label">Manager / PJ Data<span
                                                class="text-danger">*</span></label>
                                        <select id="manager-selected" class="form-select" name="id_manager" required>
                                            <option value="">Pilih Manager / PJ Data</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}"
                                                    data-job-role="{{ $manager->job_role }}"
                                                    {{ old('id_manager', $asetpribadi->id_manager) == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name_karyawan }} - {{ $manager->job_role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-text">Pilih manager atau penanggung jawab data yang akan melakukan
                                            verifikasi data dan proses persetujuan pencabutan aset.</p>
                                        <input type="hidden" class="form-control" id="jabatan_manager"
                                            name="jabatan_manager"
                                            value="{{ old('jabatan_manager', $asetpribadi->jabatan_manager) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_manager"
                                                name="is_manager" value="1"
                                                {{ old('is_manager', $asetpribadi->is_manager) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_manager">
                                                Personel adalah seorang Manager / Leader Divisi
                                                <p class="form-text mb-0">
                                                    {{ 'Centang jika user ' . $asetpribadi->user->name_karyawan . ' adalah seorang manager divisi.' }}
                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('aset-pribadi.show', $asetpribadi->id) }}"
                                    class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="sym sym-trash"></i> Proses Pencabutan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom Select2 styling for better integration */
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            padding-left: 12px !important;
            color: #495057 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        .select2-dropdown {
            border-radius: 0.375rem !important;
            border: 1px solid #dee2e6 !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for manager selection
            $('#manager-selected').select2({
                placeholder: "Pilih PJ Data / Manager",
                allowClear: true,
                width: '100%'
            });

            // Handle manager selection change with Select2
            $('#manager-selected').on('change', function() {
                const selectedValue = $(this).val();
                const jabatanManagerInput = document.getElementById('jabatan_manager');

                if (selectedValue) {
                    const selectedOption = $(this).find('option:selected');
                    const jobRole = selectedOption.data('job-role');
                    jabatanManagerInput.value = jobRole || '';
                } else {
                    jabatanManagerInput.value = '';
                }
            });

            // Auto-fill jabatan manager jika ada old value
            const managerSelect = $('#manager-selected');
            const selectedValue = managerSelect.val();
            const jabatanManagerInput = document.getElementById('jabatan_manager');

            if (selectedValue) {
                const selectedOption = managerSelect.find('option:selected');
                const jobRole = selectedOption.data('job-role');
                jabatanManagerInput.value = jobRole || '';
            }
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endsection
