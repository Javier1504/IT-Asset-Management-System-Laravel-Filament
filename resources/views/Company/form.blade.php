@extends('layouts.admin')

@section('title', $company ? 'Edit Company' : 'Tambah Company')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('company-settings.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">{{ $company ? 'Edit Company' : 'Tambah Company' }}</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="d-none d-md-block btn btn-primary" form="companyForm">
                    Simpan Data
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 p-2 py-md-3 py-xl-4 rounded-4 bg-body-tertiary">

                    @if ($errors->any())
                        <div class="alert alert-danger mx-3 mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ $company ? route('company-settings.update', $company->id) : route('company-settings.store') }}"
                        id="companyForm" enctype="multipart/form-data" class="qn-form w-100 position-relative">
                        @csrf
                        @if ($company)
                            @method('PUT')
                        @endif

                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="d-flex flex-column gap-1 mb-3">
                                        <h1 class="fs-5 fw-medium mb-0">Informasi Company</h1>
                                        <p class="fs-6 fw-medium text-secondary mb-0">
                                            Isi nama dan kode unik untuk company ini.
                                        </p>
                                    </div>
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nama Company <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name"
                                                value="{{ old('name', $company?->name) }}"
                                                placeholder="Contoh: SEVIMA" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="code" class="form-label">Kode Company <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                id="code" name="code"
                                                value="{{ old('code', $company?->code) }}"
                                                placeholder="Contoh: SVM" required>
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Logo --}}
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="d-flex flex-column gap-1 mb-3">
                                        <h1 class="fs-5 fw-medium mb-0">Logo Company</h1>
                                        <p class="fs-6 fw-medium text-secondary mb-0">
                                            Upload logo company (JPG, PNG, SVG, WebP, maks. 2 MB).
                                        </p>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            @if ($company && $company->logo_url)
                                                <img src="{{ $company->logo_url }}" id="preview-logo"
                                                    alt="Logo" class="img-thumbnail" style="max-height:120px;">
                                            @else
                                                <img src="" id="preview-logo" alt="Preview Logo"
                                                    class="img-thumbnail d-none" style="max-height:120px;">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                name="logo" id="logo" accept="image/*"
                                                onchange="previewImage(this,'preview-logo')">
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($company && $company->logo)
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_logo"
                                                        id="remove_logo" value="1">
                                                    <label class="form-check-label text-danger" for="remove_logo">
                                                        Hapus logo saat ini
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Header --}}
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="d-flex flex-column gap-1 mb-3">
                                        <h1 class="fs-5 fw-medium mb-0">Header Dokumen</h1>
                                        <p class="fs-6 fw-medium text-secondary mb-0">
                                            Upload gambar header yang digunakan pada dokumen PDF (JPG, PNG, WebP, maks. 4 MB).
                                        </p>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            @if ($company && $company->header)
                                                <img src="{{ asset('storage/'.$company->header) }}" id="preview-header"
                                                    alt="Header" class="img-thumbnail w-100">
                                            @else
                                                <img src="" id="preview-header" alt="Preview Header"
                                                    class="img-thumbnail d-none w-100">
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" class="form-control @error('header') is-invalid @enderror"
                                                name="header" id="header" accept="image/*"
                                                onchange="previewImage(this,'preview-header')">
                                            @error('header')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($company && $company->header)
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_header"
                                                        id="remove_header" value="1">
                                                    <label class="form-check-label text-danger" for="remove_header">
                                                        Hapus header saat ini
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="d-flex flex-column gap-1 mb-3">
                                        <h1 class="fs-5 fw-medium mb-0">Footer Dokumen</h1>
                                        <p class="fs-6 fw-medium text-secondary mb-0">
                                            Upload gambar footer yang digunakan pada dokumen PDF (JPG, PNG, WebP, maks. 4 MB).
                                        </p>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            @if ($company && $company->footer)
                                                <img src="{{ asset('storage/'.$company->footer) }}" id="preview-footer"
                                                    alt="Footer" class="img-thumbnail w-100">
                                            @else
                                                <img src="" id="preview-footer" alt="Preview Footer"
                                                    class="img-thumbnail d-none w-100">
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" class="form-control @error('footer') is-invalid @enderror"
                                                name="footer" id="footer" accept="image/*"
                                                onchange="previewImage(this,'preview-footer')">
                                            @error('footer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($company && $company->footer)
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_footer"
                                                        id="remove_footer" value="1">
                                                    <label class="form-check-label text-danger" for="remove_footer">
                                                        Hapus footer saat ini
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mobile submit --}}
                            <div class="d-md-none px-1 pb-3">
                                <button type="submit" form="companyForm" class="btn btn-primary w-100">
                                    Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
