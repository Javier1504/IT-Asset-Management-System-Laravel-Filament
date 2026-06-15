@extends('layouts.admin')

@section('title', 'Edit Aset Pribadi')

@section('content')

    @use(Illuminate\Support\Facades\Auth)
    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-pribadi.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Data Aset Pribadi</span>
            </div>
        </div>
    </header>
    <!-- Main -->
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
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                        <h4 class="m-0 mb-2">Edit Data Aset Pribadi</h4>
                        <span class="text-muted">Edit data aset pribadi di bawah ini.</span>

                        <form action="{{ route('aset-pribadi.update', $asetpribadi->id) }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi Aset</h5>

                                    <div class="mb-3">
                                        <label for="nama_aset" class="form-label">Nama Aset</label>
                                        <input type="text" class="form-control" id="nama_aset" name="nama_aset"
                                            value="{{ old('nama_aset', $asetpribadi->nama_aset) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="merk" class="form-label">Merk</label>
                                        <input type="text" class="form-control" id="merk" name="merk"
                                            value="{{ old('merk', $asetpribadi->merk) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe</label>
                                        <input type="text" class="form-control" id="tipe" name="tipe"
                                            value="{{ old('tipe', $asetpribadi->tipe) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_seri" class="form-label">No. Seri</label>
                                        <input type="text" class="form-control" id="no_seri" name="no_seri"
                                            value="{{ old('no_seri', $asetpribadi->no_seri) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sistem_os" class="form-label">Sistem OS</label>
                                        <input type="text" class="form-control" id="sistem_os" name="sistem_os"
                                            value="{{ old('sistem_os', $asetpribadi->sistem_os) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mac_address" class="form-label">MAC Address</label>
                                        <input type="text" class="form-control" id="mac_address" name="mac_address"
                                            value="{{ old('mac_address', $asetpribadi->mac_address) }}" required>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi Karyawan</h5>

                                    <div class="mb-3">
                                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="nama_karyawan"
                                            name="nama_karyawan" value="{{ $asetpribadi->user->name_karyawan }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jabatan_user" class="form-label">Jabatan User</label>
                                        <input type="text" class="form-control" id="jabatan_user" name="jabatan_user"
                                            value="{{ $asetpribadi->jabatan_user }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="divisi" class="form-label">Divisi</label>
                                        <input type="text" class="form-control" id="divisi" name="divisi"
                                            value="{{ $asetpribadi->divisi }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('aset-pribadi.index') }}" class="btn btn-secondary ">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="sym sym-save"></i> Update Data
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
    <!-- SweetAlert2 -->
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
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endsection
