@extends('layouts.admin')

@section('title', 'Page Add Hak Akses')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('permissions.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Tambah Hak Akses Pegawai</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="advancedForm">
                    Simpan Data
                </button>
            </div>
        </div>
    </header>

    <!-- [START] Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 p-2 py-md-3 py-xl-4 rounded-4 bg-body-tertiary">
                    <form method="POST" action="{{ route('permissions.store') }}" id="advancedForm"
                        class="qn-form w-100 position-relative">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Tambah Hak Akses Pegawai</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Perbarui hak akses menjadi Admin untuk pegawai yang ada.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Dropdown Pilih User -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name_karyawan" class="form-label">Pilih Pegawai <span
                                                        class="text-danger"> *</span></label>
                                                <select class="form-control form-select" id="name_karyawan"  style="width: 100%;"
                                                    name="name_karyawan" required>
                                                    <option value="" disabled selected>Pilih Pegawai</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name_karyawan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Role Radio Button -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                                @foreach ($roles as $role)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="role"
                                                            id="role_{{ $role }}" value="{{ $role }}">
                                                        <label class="form-check-label" for="role_{{ $role }}">
                                                            {{ ucfirst($role) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <!-- [START] Submit Button Mobile -->
    <div class="d-block d-md-none rounded-top-4 shadow-lg sticky-bottom">
        <div class="w-100 d-flex bg-white gap-2 p-3">
            <!-- Submit Form Mobile -->
            <button type="submit" class="btn w-100 btn-primary" form="advancedForm">
                Simpan
            </button>
        </div>
    </div>
    <!-- [END] Submit Button Mobile -->

@endsection

@section('footer', '')
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
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px !important;
}

.select2-dropdown {
    border-radius: 0.375rem !important;
    border: 1px solid #dee2e6 !important;
}
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2 for name_karyawan
        $('#name_karyawan').select2({
            placeholder: "Pilih Pegawai",
            allowClear: true,
            width: '100%'
        });
    });
</script>

<script>
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
            html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
        });
    @endif
</script>
