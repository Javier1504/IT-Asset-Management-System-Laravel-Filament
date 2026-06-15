@extends('layouts.admin')

@section('title', 'Tambah Template Penomoran')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('numbering-template.index') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Tambah Template Penomoran</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="createForm">
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

                    <form method="POST" action="{{ route('numbering-template.store') }}" id="createForm"
                        class="qn-form w-100 position-relative">
                        @csrf

                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Tambah Template Penomoran</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Buat template penomoran baru untuk dokumen.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="module" class="form-label">
                                                Module
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="module" name="module"
                                                placeholder="e.g., bast_asets, bast_pengembalian_asets"
                                                list="document-model-options" value="{{ old('module') }}" required />
                                            <small class="text-muted">Gunakan nama module yang konsisten dengan trait model,
                                                default-nya nama tabel model</small>
                                            <datalist id="document-model-options">
                                                @foreach ($documentModels as $documentModel)
                                                    <option value="{{ $documentModel['module'] }}">
                                                        {{ $documentModel['model'] }} ({{ $documentModel['table'] }})
                                                    </option>
                                                @endforeach
                                            </datalist>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Model Tersedia</label>
                                            <div class="border rounded-3 bg-light p-3 small">
                                                @forelse($documentModels as $documentModel)
                                                    <div>
                                                        <strong>{{ $documentModel['model'] }}</strong> -
                                                        {{ $documentModel['module'] }}
                                                    </div>
                                                @empty
                                                    <div class="text-muted">Belum ada model yang memakai trait
                                                        HasDocumentNumbering.</div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="company_id" class="form-label">
                                                Perusahaan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="company_id" name="company_id" required>
                                                <option value="" disabled selected>Pilih Perusahaan</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }} ({{ $company->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="reset_type" class="form-label">
                                                Tipe Reset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="reset_type" name="reset_type" required>
                                                <option value="" disabled selected>Pilih Tipe Reset</option>
                                                <option value="yearly"
                                                    {{ old('reset_type') == 'yearly' ? 'selected' : '' }}>
                                                    Tahunan (Reset setiap tahun)
                                                </option>
                                                <option value="monthly"
                                                    {{ old('reset_type') == 'monthly' ? 'selected' : '' }}>
                                                    Bulanan (Reset setiap bulan)
                                                </option>
                                                <option value="none" {{ old('reset_type') == 'none' ? 'selected' : '' }}>
                                                    Tidak Reset
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="no_template" class="form-label">
                                                Nomor Template
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="no_template" name="no_template"
                                                placeholder="e.g., 035/TMP.RO.BRT/TIS/SVM" value="{{ old('no_template') }}"
                                                required />
                                            <small class="text-muted">Format: [nomor]/[kode]/[dept]/[company]</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="no_sop" class="form-label">
                                                Nomor SOP
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="no_sop" name="no_sop"
                                                placeholder="e.g., 001/PO.SOP/TIS/SVM" value="{{ old('no_sop') }}"
                                                required />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="no_version" class="form-label">
                                                Versi
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="no_version" name="no_version"
                                                placeholder="e.g., 1.0 - 2025.07.10" value="{{ old('no_version') }}"
                                                required />
                                        </div>

                                        <div class="col-md-12">
                                            <label for="format" class="form-label">
                                                Format Penomoran
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="format" name="format"
                                                placeholder="e.g., {number}/{company}/SERAH TERIMA BARANG/{month}/{year}"
                                                value="{{ old('format') }}" required />
                                            <small class="text-muted">
                                                Gunakan placeholder: {number}, {company}, {month}, {year}
                                            </small>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <strong>Informasi:</strong>
                                                <ul class="mb-0 mt-2">
                                                    <li><code>{number}</code> - Nomor urut (akan di-padding menjadi 3 digit)
                                                    </li>
                                                    <li><code>{company}</code> - Kode perusahaan dari session</li>
                                                    <li><code>{month}</code> - Bulan dalam angka romawi (I-XII)</li>
                                                    <li><code>{year}</code> - Tahun (YYYY)</li>
                                                </ul>
                                                <p class="mb-0 mt-2"><strong>Contoh hasil:</strong> 001/SVM/SERAH TERIMA
                                                    BARANG/IV/2026</p>
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

        <!-- [START] Mobile Submit FAB -->
        <div class="qn-fab d-md-none" role="group" aria-label="FAB Group">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-lg" form="createForm">
                <i class="sym sym-save"></i>
                <span>Simpan Data</span>
            </button>
        </div>
        <!-- [END] Mobile Submit FAB -->
    </main>
    <!-- [END] Main -->

@endsection
