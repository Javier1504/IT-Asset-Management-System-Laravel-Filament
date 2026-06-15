@extends('layouts.admin')

@section('title', 'Page Edit Hak Akses')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('permissions.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Hak Akses Pegawai</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="editForm">
                    Perbarui Data
                </button>
            </div>
        </div>
    </header>

    <!-- [START] Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 p-2 py-md-3 py-xl-4 rounded-4 bg-body-tertiary">
                    <form method="POST" action="{{ route('permissions.update', $user->id) }}" id="editForm"
                        class="qn-form w-100 position-relative">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Edit Hak Akses Pegawai</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Perbarui hak akses untuk pegawai yang dipilih.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Info Pegawai -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Nama Pegawai</label>
                                                <input type="text" class="form-control" value="{{ $user->name_karyawan }}" readonly>
                                                <small class="text-muted">Email: {{ $user->email ?? $user->corporate_email }}</small>
                                            </div>
                                        </div>

                                        <!-- Role Radio Button -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                                @foreach ($roles as $role)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="role"
                                                            id="role_{{ $role }}" value="{{ $role }}"
                                                            {{ $user->role == $role ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="role_{{ $role }}">
                                                            {{ ucfirst($role) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Current Role Info -->
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <strong>Role Saat Ini:</strong> {{ ucfirst($user->role ?? 'Belum ada role') }}
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
            <button type="submit" class="btn w-100 btn-primary" form="editForm">
                Perbarui Data
            </button>
        </div>
    </div>
    <!-- [END] Submit Button Mobile -->
@section('footer', '')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += '{{ $error }}\n';
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Validasi Error',
            text: errorMessages,
        });
    @endif
</script>
@endsection
