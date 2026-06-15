@extends('layouts.admin')

@section('title', 'Page All Category')

@section('content')

<header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
    <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('jenis-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
            <span class="m-0 fs-6 fw-medium">Tambahkan Jenis Aset</span>
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
    <!-- [START] Content -->
    <div class="container-fluid p-0">
        <div class="w-100 p-2 bg-white">
            <div class="w-100 p-2 py-md-3 py-xl-4 rounded-4 bg-body-tertiary">

                <form method="POST" action="{{ route('jenis-aset.store') }}" id="advancedForm" class="qn-form w-100 position-relative">
                    @csrf
                    <div class="row px-3 row-cols-1 gy-4">
                        <div class="card p-0 border-0 rounded-4 shadow-sm">
                            <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-column gap-1 mb-2">
                                            <h1 class="fs-5 fw-medium mb-0">Data Jenis Aset</h1>
                                            <p class="fs-6 fw-medium text-secondary mb-0">
                                                Tambahkan jenis aset berdasarkan kategorinya. 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputNamaKategori" class="form-label">
                                            Nama Jenis Aset
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="inputNamaKategori" name="name_jenis" placeholder="Masukkan nama jenis" value="{{ old('name_jenis') }}" required />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">
                                            Kategori 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="endUserAset" value="end_user_aset" checked>
                                                    <label class="form-check-label" for="endUserAset">
                                                        End-User Aset
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="physicalHostAset" value="physical_host_aset">
                                                    <label class="form-check-label" for="physicalHostAset">
                                                        Physical Host Aset
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="officeAset" value="office_aset">
                                                    <label class="form-check-label" for="officeAset">
                                                        Office Aset
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="securityPeripheral" value="security_peripheral">
                                                    <label class="form-check-label" for="securityPeripheral">
                                                        Security Peripheral Aset
                                                    </label>
                                                </div>
                                            </div>
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
    <!-- [END] Content -->
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
@section('footer', '')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
        });
    @endif
</script>
@endsection



