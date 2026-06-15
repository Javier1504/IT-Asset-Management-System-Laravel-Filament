@extends('layouts.admin')

@section('title', 'Page All Category')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Aset</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data End-User Aset</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data End-User Aset</h4>

                        <div class="row mt-4 mb-3">
                            <div class="col-12">
                                <form action="{{ route('end-user-aset.index') }}" method="GET" id="filterForm">
                                    <!-- Preserve other filter parameters -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="jenis_aset_id" value="{{ request('jenis_aset_id') }}">
                                    <input type="hidden" name="klasifikasi_laptop_id"
                                        value="{{ request('klasifikasi_laptop_id') }}">
                                    <input type="hidden" name="company" value="{{ request('company') }}">
                                    <input type="hidden" name="job_family" value="{{ request('job_family') }}">
                                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                                    <input type="hidden" name="periode_from" value="{{ request('periode_from') }}">
                                    <input type="hidden" name="periode_to" value="{{ request('periode_to') }}">
                                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">

                                    <label class="form-label fw-semibold mb-2">Filter Status Aset</label>
                                    <div class="d-flex flex-wrap justify-content-between gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="stock" id="stock"
                                                @if (in_array('stock', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="stock">Stock</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="terpakai" id="terpakai"
                                                @if (in_array('terpakai', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="terpakai">Terpakai</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="dipinjam" id="dipinjam"
                                                @if (in_array('dipinjam', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="dipinjam">Dipinjam</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="diperbaiki" id="diperbaiki"
                                                @if (in_array('diperbaiki', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="diperbaiki">Diperbaiki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="retirement" id="retirement"
                                                @if (in_array('retirement', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="retirement">Retirement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                value="dihibahkan" id="dihibahkan"
                                                @if (in_array('dihibahkan', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="dihibahkan">Dihibahkan</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr class="my-3">

                        <form method="GET" action="{{ route('end-user-aset.index') }}" id="mainFilterForm">
                            <!-- Preserve subcategories filter -->
                            @if (request('subcategories'))
                                @foreach (request('subcategories') as $subcategory)
                                    <input type="hidden" name="subcategories[]" value="{{ $subcategory }}">
                                @endforeach
                            @endif

                            {{-- Row 1: Search and Dropdown Filters --}}
                            <div class="row g-3 mb-3">
                                {{-- Job family --}}
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold mb-2">Job Family</label>
                                    <select name="job_family" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Job Family</option>

                                        @foreach ($jobFamilies as $jobFamily)
                                            <option value="{{ $jobFamily }}"
                                                {{ request('job_family') === $jobFamily ? 'selected' : '' }}>
                                                {{ $jobFamily }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filter Jenis Aset --}}
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold mb-2">Jenis Aset</label>
                                    <select name="jenis_aset_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Jenis Aset</option>
                                        @foreach ($jenisAsets as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ request('jenis_aset_id') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->name_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filter Klasifikasi Laptop --}}
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold mb-2">Klasifikasi Laptop</label>
                                    <select class="form-select" name="klasifikasi_laptop_id"
                                        onchange="this.form.submit()">
                                        <option value="">Semua Klasifikasi</option>
                                        @foreach ($klasifikasiLaptops as $klasifikasi)
                                            <option value="{{ $klasifikasi->id }}"
                                                {{ request('klasifikasi_laptop_id') == $klasifikasi->id ? 'selected' : '' }}>
                                                {{ $klasifikasi->klasifikasi_laptop }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @can('super_admin')
                                    {{-- Filter Company --}}
                                    <div class="col-lg-2 col-md-6">
                                        <label class="form-label fw-semibold mb-2">Company</label>
                                        <select class="form-select" name="company" onchange="this.form.submit()">
                                            <option value="">Semua Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company }}"
                                                    {{ request('company') == $company ? 'selected' : '' }}>
                                                    {{ ucfirst($company) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcan
                            </div>

                            <div class="row g-3 mb-3 align-items-center">
                                {{-- Kolom Pencarian --}}
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold mb-2">Pencarian</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Cari aset..." value="{{ request('search') }}"
                                            autocomplete="off">
                                        <button type="submit" class="btn btn-primary" style="z-index: 1;">
                                            <i class="sym sym-search me-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-6">
                                    <label class="form-label fw-semibold mb-2">Filter Tanggal Pembelian</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="date" class="form-control" style="max-width: 180px;"
                                            name="date_from" value="{{ request('date_from') }}">
                                        <span class="text-muted">sampai</span>
                                        <input type="date" class="form-control" style="max-width: 180px;"
                                            name="date_to" value="{{ request('date_to') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="sym sym-filter me-1"></i> Terapkan Filter
                                        </button>
                                        @if (request('date_from') || request('date_to'))
                                            <a href="{{ route('end-user-aset.index', request()->except(['date_from', 'date_to'])) }}"
                                                class="btn btn-outline-secondary">
                                                <i class="sym sym-x me-1"></i> Reset Tanggal
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @can('akses-admin-superadmin-finance')
                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold mb-2">Filter Periode Data</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="date" class="form-control" style="max-width: 180px;"
                                                name="periode_from" value="{{ request('periode_from') }}"
                                                placeholder="Dari tanggal">
                                            <span class="text-muted">sampai</span>
                                            <input type="date" class="form-control" style="max-width: 180px;"
                                                name="periode_to" value="{{ request('periode_to') }}"
                                                placeholder="Sampai tanggal">
                                            @if (request('periode_from') || request('periode_to'))
                                                <a href="{{ route('end-user-aset.index', request()->except(['periode_from', 'periode_to'])) }}"
                                                    class="btn btn-outline-secondary">
                                                    <i class="sym sym-x me-1"></i> Reset Periode
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </form>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
                                    @can('akses-admin-superadmin')
                                        <a href="{{ route('end-user-aset.download-template') }}"
                                            class="btn btn-outline-success">
                                            <i class="sym sym-download me-1"></i> Unduh Template
                                        </a>

                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#importModal">
                                            <i class="sym sym-upload me-1"></i> Import
                                        </button>
                                    @endcan

                                    @can('akses-admin-superadmin-finance')
                                        <a href="{{ route('end-user-aset.export', request()->query()) }}"
                                            class="btn btn-success">
                                            <i class="sym sym-file-download-02 me-1"></i> Export Excel
                                        </a>
                                    @endcan

                                    @can('akses-admin-superadmin')
                                        <a href="{{ route('end-user-aset.create') }}" class="btn btn-primary"
                                            aria-label="Tambah Data">
                                            <i class="sym sym-plus me-1"></i> Tambah Data
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('end-user-aset.import-template') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Import Data dari Excel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 text-center">
                                                <div id="drop-area" class="border border-2 border-primary rounded-3 p-4"
                                                    style="border-style: dashed !important; cursor: pointer; background-color: #f8f9fa;"
                                                    onclick="document.getElementById('file-input').click();"
                                                    ondragover="event.preventDefault(); this.classList.add('bg-light');"
                                                    ondragleave="this.classList.remove('bg-light');"
                                                    ondrop="handleDrop(event)">

                                                    <p class="mb-2">Seret file ke sini atau klik untuk memilih</p>
                                                    <p class="small text-muted">Format yang diterima: .xlsx, .xls</p>

                                                    <input type="file" id="file-input" name="file"
                                                        accept=".xlsx, .xls" required hidden
                                                        onchange="updateFileName()" />

                                                    <div id="file-name" class="text-success fw-bold mt-2"></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        @php $showRetirementStatus = in_array('retirement', request('subcategories', [])); @endphp
                                        <th style="min-width: 36px; width: 36px;" rowspan="2">No</th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Nomor Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Merk Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Nama Pemegang<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        @can('akses-superadmin-finance')
                                            <th style="min-width: 100px; width: 10%;" rowspan="2">
                                                <button class="btn p-0 border-0 w-100 h-100 text-start">Company<i
                                                        class="float-end sym sym-switch-vertical"></i></button>
                                            </th>
                                        @endcan
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Klasifikasi Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Status<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        @if ($showRetirementStatus)
                                            <th style="min-width: 160px; width: 10%;" rowspan="2">
                                                <button class="btn p-0 border-0 w-100 h-100 text-start">Status Retirement<i
                                                        class="float-end sym sym-switch-vertical"></i></button>
                                            </th>
                                        @endif
                                        <th class="text-center" rowspan="2">Aksi</th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Tanggal Beli<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 150px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Harga Beli<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 300px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Spesifikasi Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        @php
                                            $totalYears = $yearInit['endYear'] - $yearInit['earlyYear'] + 1;
                                            $colspan = 1 + 1 + $totalYears * 2 + 1;
                                        @endphp
                                        <th colspan="{{ $colspan }}" class="text-center"
                                            style="min-width: 140px; width: 10%;">
                                            <span>Nilai Penyusutan Aset</span>
                                            <button class="btn btn-sm btn-outline-secondary ms-2 toggle-btn"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target=".collapse-depreciation">
                                                <!-- Ikon akan dimasukkan lewat script -->
                                            </button>
                                        </th>
                                    </tr>
                                    <tr class="table-light">
                                        <th class="collapse collapse-depreciation text-center"
                                            style="min-width: 140px; width: 10%;">Harga/Bulan</th>
                                        <th class="collapse collapse-depreciation text-center"
                                            style="min-width: 100px; width: 10%;">Cut Off</th>
                                        <th class="collapse collapse-depreciation text-center"
                                            style="min-width: 100px; width: 10%;">Masa Umur</th>
                                        @for ($year = $yearInit['earlyYear']; $year <= $yearInit['endYear']; $year++)
                                            <th class="collapse collapse-depreciation text-center"
                                                style="min-width: 140px; width: 10%;">{{ $year }}</th>
                                            <th class="collapse collapse-depreciation text-center"
                                                style="min-width: 140px; width: 10%;">Nilai Sisa</th>
                                        @endfor
                                        <th class="collapse collapse-depreciation text-center"
                                            style="min-width: 140px; width: 10%;">Total Penyusutan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($endUserAsets as $aset)
                                        <tr>
                                            <td>{{ ($endUserAsets->currentPage() - 1) * $endUserAsets->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->nomor_aset ?? '-' }}</td>
                                            <td>{{ $aset->merk_aset ?? '-' }}</td>
                                            <td>{{ $aset->name_karyawan ?? '-' }}</td>
                                            @can('akses-superadmin-finance')
                                                <td style="text-align: center;">
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">{{ $aset->company->name ?? '-' }}</span>
                                                </td>
                                            @endcan
                                            <td>{{ $aset->klasifikasi_laptop ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($aset->status_aset == 'stock')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                                @elseif ($aset->status_aset == 'diperbaiki')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Diperbaiki</span>
                                                @elseif ($aset->status_aset == 'terpakai')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                                @elseif ($aset->status_aset == 'dipinjam')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>
                                                @elseif ($aset->status_aset == 'retirement')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                                @elseif ($aset->status_aset == 'dihibahkan')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dihibahkan</span>
                                                @else
                                                    <span>{{ $aset->status_aset }}</span>
                                                @endif
                                            </td>
                                            @if ($showRetirementStatus)
                                                <td style="text-align: center;">
                                                    @php
                                                        $sr = strtolower($aset->status_retirement ?? '');
                                                    @endphp
                                                    @if ($sr === 'active')
                                                        <span
                                                            class="badge text-success bg-success bg-opacity-10 border border-success">Active</span>
                                                    @elseif ($sr === 'destroyed')
                                                        <span
                                                            class="badge text-danger bg-danger bg-opacity-10 border border-danger">Destroyed</span>
                                                    @elseif ($sr === 'reusable')
                                                        <span
                                                            class="badge text-warning bg-warning bg-opacity-10 border border-warning">Reusable</span>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td style="width: 124px;" class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('end-user-aset.show', $aset->id) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Lihat detail" title="Lihat detail">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>

                                                    @can('akses-admin-superadmin')
                                                        <a href="{{ route('end-user-aset.edit', $aset->id) }}">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Edit" title="Edit">
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>
                                                        </a>

                                                        <a href="{{ $aset->bast_aset_id && $aset->bast_aset_user_id ? route('bast-aset.show', $aset->bast_aset_id) : 'javascript:void(0);' }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary {{ !$aset->bast_aset_id || is_null($aset->bast_aset_user_id) ? 'disabled opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                                                            aria-label="Cetak BAST"
                                                            title="{{ !$aset->bast_aset_id || is_null($aset->bast_aset_user_id) ? 'BAST tidak tersedia' : 'Pertinjau Dokumen' }}"
                                                            @if (!$aset->bast_aset_id || is_null($aset->bast_aset_user_id)) onclick="event.preventDefault();" @endif>
                                                            <i class="sym sym-printer-solid"></i>
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Hapus" title="Hapus"
                                                            onclick="confirmDeletion({{ $aset->id }})">
                                                            <i class="sym sym-trash-solid"></i>
                                                        </button>

                                                        <form id="delete-form-{{ $aset->id }}"
                                                            action="{{ route('end-user-aset.destroy', $aset->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}
                                            </td>
                                            <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                                            <td>{{ $aset->spesifikasi_aset ?? '-' }}</td>
                                            <!-- Kolom Nilai Penyusutan -->
                                            <td class="collapse collapse-depreciation">Rp
                                                {{ number_format((float) $aset->harga_per_bulan, 0, ',', '.') }}</td>
                                            <td class="collapse collapse-depreciation">{{ $aset->cut_off }}</td>
                                            <td class="collapse collapse-depreciation">{{ $aset->masa_umur }}</td>

                                            @php
                                                $depreciationValues = collect($aset->depreciation_data)->pad(
                                                    $totalYears * 2,
                                                    '-',
                                                );
                                            @endphp

                                            @foreach ($depreciationValues as $values)
                                                <td class="collapse collapse-depreciation">
                                                    {{ $values !== '-' ? 'Rp ' . number_format((float) $values, 0, ',', '.') : $values }}
                                                </td>
                                            @endforeach

                                            <td class="collapse collapse-depreciation">Rp
                                                {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $endUserAsets->firstItem() }}</span> -
                                <span class="fw-bold">{{ $endUserAsets->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $endUserAsets->total() }}</span> data
                            </p>

                            <!-- Dropdown untuk memilih jumlah item per halaman -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                                <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
                                    onchange="updateItemsPerPage(this.value)">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100
                                    </option>
                                    <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200
                                    </option>
                                    <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500
                                    </option>
                                    <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000
                                    </option>
                                </select>
                            </div>

                            <!-- Navigasi halaman -->
                            @php
                                // Ambil semua query string kecuali 'page'
                                $queryParams = request()->except('page');
                                $queryStr = http_build_query($queryParams);
                                $currentPage = $endUserAsets->currentPage();
                                $lastPage = $endUserAsets->lastPage();
                            @endphp

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $endUserAsets->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $endUserAsets->previousPageUrl() }}{{ $queryStr ? '&' . $queryStr : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    <!-- Nomor halaman -->
                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $endUserAsets->url($page) }}{{ $queryStr ? '&' . $queryStr : '' }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $endUserAsets->url($lastPage) }}{{ $queryStr ? '&' . $queryStr : '' }}">
                                                {{ $lastPage }}
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $endUserAsets->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $endUserAsets->nextPageUrl() }}{{ $queryStr ? '&' . $queryStr : '' }}">
                                            <i class="sym sym-arrow-narrow-right"></i>
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [END] Content -->
    </main>
@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: {!! json_encode(session('error')) !!}, // 👈 Gunakan json_encode agar tetap raw dan aman
        });
    @endif
</script>

<script>
    function confirmDeletion(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3 shadow',
                confirmButton: 'btn btn-primary mx-1',
                cancelButton: 'btn btn-secondary mx-1'
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim form untuk menghapus data
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
<script>
    function updateItemsPerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = url.toString();
    }
</script>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("filterForm");
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                form.submit();
            });
        });
    })
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let toggleBtn = document.querySelector(".toggle-btn");

        // Membuat elemen ikon dan menambahkannya ke tombol
        let icon = document.createElement("i");
        icon.classList.add("sym", "sym-arrow-narrow-right-solid"); // Default ikon right
        toggleBtn.appendChild(icon); // Menambahkan ikon ke dalam tombol

        // Memperbarui status ikon berdasarkan status collapse saat pertama kali dimuat
        let collapseElement = document.querySelector(".collapse-depreciation");
        if (collapseElement && collapseElement.classList.contains("show")) {
            // Jika collapse terbuka, ganti ikon menjadi left
            icon.classList.replace("sym-arrow-narrow-right-solid", "sym-arrow-narrow-left-solid");
        }

        // Memperbarui status ikon setiap kali tombol diklik
        toggleBtn.addEventListener("click", function() {
            if (collapseElement.classList.contains("show")) {
                // Jika collapse terbuka, ubah ikon menjadi kiri
                icon.classList.replace("sym-arrow-narrow-right-solid", "sym-arrow-narrow-left-solid");
            } else {
                // Jika collapse tertutup, ubah ikon menjadi kanan
                icon.classList.replace("sym-arrow-narrow-left-solid", "sym-arrow-narrow-right-solid");
            }
        });
    });
</script>

{{-- Script --}}
<script>
    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('file-input').files = files;
            updateFileName();
        }
    }

    function updateFileName() {
        const input = document.getElementById('file-input');
        const fileNameDiv = document.getElementById('file-name');
        if (input.files.length > 0) {
            fileNameDiv.textContent = input.files[0].name;
        } else {
            fileNameDiv.textContent = '';
        }
    }
</script>
@endsection
