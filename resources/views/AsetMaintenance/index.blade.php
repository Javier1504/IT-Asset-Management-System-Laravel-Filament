@extends('layouts.admin')

@section('title', 'Page All Aset Maintenance')

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
                                @if (request()->routeIs('aset-maintenance.index'))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>
                                            Pemeliharaan</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.maintenance'))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Form Pemeliharaan Aset</li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Perbaikan Aset</h4>
                        @if (request()->routeIs('daftar-tanda-tangan.maintenance'))
                            <span class="text-muted">Di bawah ini adalah daftar dokumen Formulir Pemeliharaan Aset yang
                                perlu Anda tanda tangani.</span>
                            <hr>
                        @endif

                        @if (request()->routeIs('aset-maintenance.index'))
                            <div class="row mt-4">
                                <form action="{{ route('aset-maintenance.index') }}" method="GET" id="filterForm">
                                    <!-- Hidden inputs untuk preserve filters -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="status_perbaikan" value="{{ request('status_perbaikan') }}">
                                    <input type="hidden" name="from" value="{{ request('from') }}">
                                    <input type="hidden" name="to" value="{{ request('to') }}">
                                    <input type="hidden" name="perPage" value="{{ request('perPage') }}">

                                    <!-- Filter berdasarkan jenis pemeliharaan -->
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between">
                                            @php
                                                $selectedSubcategories = request('subcategories', []);
                                            @endphp

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                    value="perawatan" id="perawatan"
                                                    {{ in_array('perawatan', $selectedSubcategories) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="perawatan">Perawatan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                    value="perbaikan" id="perbaikan"
                                                    {{ in_array('perbaikan', $selectedSubcategories) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="perbaikan">Perbaikan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="subcategories[]"
                                                    value="pergantian_sparepart" id="pergantian_sparepart"
                                                    {{ in_array('pergantian_sparepart', $selectedSubcategories) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="pergantian_sparepart">Pergantian
                                                    Sparepart</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>

                            <!-- Filter Tanggal dan Company -->
                            <div class="row mb-3">
                                <form action="{{ route('aset-maintenance.index') }}" method="GET" id="dateFilterForm">
                                    <!-- Preserve existing filters -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="status_perbaikan"
                                        value="{{ request('status_perbaikan') }}">
                                    <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                                    @foreach (request('subcategories', []) as $sub)
                                        <input type="hidden" name="subcategories[]" value="{{ $sub }}">
                                    @endforeach

                                    <div class="col-md-12">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto">
                                                <label class="col-form-label">Filter Tanggal:</label>
                                            </div>
                                            <div class="col-auto">
                                                <label for="from" class="col-form-label">Dari</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="from" name="from" class="form-control"
                                                    value="{{ request('from') }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="to" class="col-form-label">Sampai</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="to" name="to" class="form-control"
                                                    value="{{ request('to') }}">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                            @if (request('from') || request('to'))
                                                <div class="col-auto">
                                                    <a href="{{ route('aset-maintenance.index', array_filter(request()->except(['from', 'to']))) }}"
                                                        class="btn btn-outline-secondary">Reset Tanggal</a>
                                                </div>
                                            @endif
                                            @can('akses-superadmin-finance')
                                                <div class="col-auto">
                                                    <label for="company" class="col-form-label">Company</label>
                                                </div>
                                                <div class="col-auto">
                                                    <select id="company" class="form-select" name="company"
                                                        onchange="this.form.submit()">
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
                                    </div>
                                </form>
                            </div>
                            <hr>
                        @endif

                        <div class="row d-flex align-items-center justify-content-between gap-2">
                            <div class="col-md-3">
                                <form method="GET" action="{{ route('aset-maintenance.index') }}">
                                    <!-- Preserve all filters -->
                                    <input type="hidden" name="status_perbaikan"
                                        value="{{ request('status_perbaikan') }}">
                                    <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                                    <input type="hidden" name="from" value="{{ request('from') }}">
                                    <input type="hidden" name="to" value="{{ request('to') }}">
                                    @foreach (request('subcategories', []) as $sub)
                                        <input type="hidden" name="subcategories[]" value="{{ $sub }}">
                                    @endforeach

                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search"
                                                placeholder="Cari.." value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if (request()->routeIs('aset-maintenance.index'))
                                <div class="col">
                                    <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
                                        <div class="flex-grow-1 flex-md-grow-0" style="min-width: 180px;">
                                            <form method="GET" action="{{ route('aset-maintenance.index') }}">
                                                <!-- Preserve all filters -->
                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                                <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                                                <input type="hidden" name="from" value="{{ request('from') }}">
                                                <input type="hidden" name="to" value="{{ request('to') }}">
                                                @foreach (request('subcategories', []) as $sub)
                                                    <input type="hidden" name="subcategories[]"
                                                        value="{{ $sub }}">
                                                @endforeach

                                                <select class="form-select" id="status_perbaikan" name="status_perbaikan"
                                                    onchange="this.form.submit()" aria-label="Filter Status">
                                                    <option value=""
                                                        {{ request('status_perbaikan') == '' ? 'selected' : '' }}>Semua
                                                        Status</option>
                                                    <option value="on_progress"
                                                        {{ request('status_perbaikan') == 'on_progress' ? 'selected' : '' }}>
                                                        On Progress</option>
                                                    <option value="pending"
                                                        {{ request('status_perbaikan') == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="selesai"
                                                        {{ request('status_perbaikan') == 'selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                </select>
                                            </form>
                                        </div>

                                        <a href="{{ route('aset-maintenance.download-template') }}"
                                            class="btn btn-outline-success d-flex align-items-center gap-1">
                                            <i class="sym sym-download"></i> <span class="d-none d-sm-inline">Unduh
                                                Template</span>
                                        </a>

                                        <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="sym sym-upload"></i> <span class="d-none d-sm-inline">Import</span>
                                        </button>

                                        <a href="{{ route('aset-maintenance.export', request()->query()) }}"
                                            class="btn btn-success d-flex align-items-center gap-1"
                                            aria-label="Export Excel">
                                            <i class="sym sym-file-download-02"></i> Export Excel
                                        </a>

                                        <a href="{{ route('aset-maintenance.create') }}"
                                            class="btn btn-primary d-flex align-items-center gap-1">
                                            <i class="sym sym-plus"></i> <span class="d-none d-sm-inline">Tambah</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- Modal --}}
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('aset-maintenance.import-template') }}" method="POST"
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
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nomor Formulir
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        @can('super_admin')
                                            <th style="min-width: 170px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-center"aria-label="Photo: active to sort">
                                                    Company
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                        @endcan

                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Petugas
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Pemegang
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>

                                        @if (request()->routeIs('aset-maintenance.index'))
                                            <th style="min-width: 170px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Tangal Mulai
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 170px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Tanggal Selesai
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 200px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Jenis Pemeliharaan
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 140px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Jenis Perangkat
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 200px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Merk Aset
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 140px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Nomor Aset
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 140px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Status Pemeliharaan
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 120px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Prioritas
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 120px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Tipe Pemeliharaan
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 250px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Deskripsi Masalah
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 250px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Solusi
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 250px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Keterangan
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                            <th style="min-width: 140px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Kebutuhan Sparepart
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                        @endif
                                        @if (request()->routeIs('daftar-tanda-tangan.maintenance'))
                                            <th style="min-width: 140px; width: 10%;">
                                                <button
                                                    class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                    Status
                                                    <i class="float-end sym sym-switch-vertical"></i>
                                                </button>
                                            </th>
                                        @endif
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($asetMaintenances as $aset)
                                        <tr>
                                            <td>{{ ($asetMaintenances->currentPage() - 1) * $asetMaintenances->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->nomor_formulir ?? '-' }}</td>
                                            @can('super_admin')
                                                <td style="text-align: center;">
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">{{ $aset->company->name ?? '-' }}</span>
                                                </td>
                                            @endcan
                                            <td>{{ $aset->petugas->name_karyawan ?? '-' }}</td>
                                            <td>{{ $aset->pemegang->name_karyawan ?? '-' }}</td>
                                            @can('akses-admin-superadmin')
                                                <td>{{ $aset->tanggal_mulai ?? '-' }}</td>
                                                <td>{{ $aset->tanggal_selesai ?? '-' }}</td>
                                                <td>
                                                    @if ($aset->jenis_pemeliharaan)
                                                        @if (is_array($aset->jenis_pemeliharaan))
                                                            {{ implode(', ',array_map(function ($item) {return ucwords(str_replace('_', ' ', $item));}, $aset->jenis_pemeliharaan)) }}
                                                        @else
                                                            {{ ucwords(str_replace('_', ' ', $aset->jenis_pemeliharaan)) }}
                                                        @endif
                                                    @else
                                                        Tidak ada jenis pemeliharaan
                                                    @endif

                                                </td>
                                                <td>{{ $aset->jenis_perangkat ?? '-' }}</td>
                                                <td>{{ $aset->aset->merk_aset ?? '-' }}</td>
                                                <td>{{ $aset->aset->nomor_aset ?? '-' }}</td>
                                                <td style="text-align: center;">
                                                    @if ($aset->status_perbaikan == 'on_progress')
                                                        <span
                                                            class="badge text-danger bg-danger bg-opacity-10 border border-danger">On
                                                            Progress</span>
                                                    @elseif ($aset->status_perbaikan == 'pending')
                                                        <span
                                                            class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                                    @elseif ($aset->status_perbaikan == 'selesai')
                                                        <span
                                                            class="badge text-success bg-success bg-opacity-10 border border-success">Selesai</span>
                                                    @else
                                                        <span>{{ $aset->status_perbaikan }}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @php
                                                        $priorityMap = [
                                                            'low' => [
                                                                'label' => 'Rendah',
                                                                'class' => 'text-info bg-info',
                                                            ],
                                                            'medium' => [
                                                                'label' => 'Sedang',
                                                                'class' => 'text-primary bg-primary',
                                                            ],
                                                            'high' => [
                                                                'label' => 'Tinggi',
                                                                'class' => 'text-warning bg-warning',
                                                            ],
                                                            'critical' => [
                                                                'label' => 'Kritis',
                                                                'class' => 'text-danger bg-danger',
                                                            ],
                                                        ];
                                                        $priority = $priorityMap[$aset->priority ?? 'medium'];
                                                    @endphp
                                                    <span
                                                        class="badge {{ $priority['class'] }} bg-opacity-10 border border-{{ explode(' ', $priority['class'])[0] }}">
                                                        {{ $priority['label'] }}
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    @php
                                                        $typeMap = [
                                                            'software' => [
                                                                'label' => 'Software',
                                                                'class' => 'text-info bg-info',
                                                            ],
                                                            'hardware' => [
                                                                'label' => 'Hardware',
                                                                'class' => 'text-secondary bg-secondary',
                                                            ],
                                                            'network' => [
                                                                'label' => 'Network',
                                                                'class' => 'text-success bg-success',
                                                            ],
                                                        ];

                                                        $types = $aset->maintenance_type ?? [];
                                                        if (!is_array($types)) {
                                                            $types = json_decode($types, true) ?? [$types];
                                                        }
                                                    @endphp

                                                    @foreach ($types as $typeKey)
                                                        @php
                                                            $type = $typeMap[$typeKey] ?? [
                                                                'label' => ucfirst($typeKey),
                                                                'class' => 'text-dark bg-light',
                                                            ];
                                                        @endphp

                                                        <span
                                                            class="badge {{ $type['class'] }} bg-opacity-10 border border-{{ explode(' ', $type['class'])[0] }} me-1">
                                                            {{ $type['label'] }}
                                                        </span>
                                                    @endforeach

                                                </td>
                                                <td>{{ $aset->deskripsi_permasalahan ?? '-' }}</td>
                                                <td>{{ $aset->solusi ?? '-' }}</td>
                                                <td>{{ $aset->keterangan ?? '-' }}</td>
                                                <td style="text-align: center;">
                                                    @if ($aset->kebutuhan_sparepart == 'perlu_dibelikan')
                                                        <span
                                                            class="badge text-danger bg-danger bg-opacity-10 border border-danger">Perlu
                                                            Dibelikan</span>
                                                    @elseif ($aset->kebutuhan_sparepart == 'done')
                                                        <span
                                                            class="badge text-success bg-success bg-opacity-10 border border-success">Done</span>
                                                    @else
                                                        {{ $aset->kebutuhan_sparepart }}
                                                    @endif
                                                </td>
                                            @endcan
                                            @if (request()->routeIs('daftar-tanda-tangan.maintenance'))
                                                <td style="text-align: center;">
                                                    @if (is_null($aset->tanda_tangan_pemegang))
                                                        <span
                                                            class="badge text-warning bg-warning bg-opacity-10 border border-warning">Perlu
                                                            Tanda Tangan</span>
                                                    @else
                                                        <span
                                                            class="badge text-success bg-success bg-opacity-10 border border-success">Selesai</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    @if (request()->routeIs('aset-maintenance.index'))
                                                        <!-- Tombol Pending History -->
                                                        @if (!empty($aset->pending_history) && count($aset->pending_history) > 0)
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#pendingHistoryModal{{ $aset->id }}"
                                                                title="Lihat Riwayat Pending">
                                                                <i class="sym sym-clock"></i>
                                                            </button>
                                                        @endif

                                                        <a href="{{ route('aset-maintenance.show', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Pertinjau Dokumen">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @elseif(request()->routeIs('daftar-tanda-tangan.maintenance'))
                                                        <a href="{{ route('daftar-tanda-tangan.detailMaintenance', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Pertinjau Dokumen">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @endif
                                                    @can('akses-admin-superadmin')
                                                        <a href="{{ route('aset-maintenance.edit', $aset->id) }}">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Edit" title="Edit">
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Hapus" title="Hapus"
                                                            onclick="confirmDeletion({{ $aset->id }})">
                                                            <i class="sym sym-trash-solid"></i>
                                                        </button>

                                                        <form id="delete-form-{{ $aset->id }}"
                                                            action="{{ route('aset-maintenance.destroy', $aset->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Data belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>

                        <!-- Pending History Modals -->
                        @foreach ($asetMaintenances as $aset)
                            @if (!empty($aset->pending_history) && count($aset->pending_history) > 0)
                                <div class="modal fade" id="pendingHistoryModal{{ $aset->id }}" tabindex="-1"
                                    aria-labelledby="pendingHistoryModalLabel{{ $aset->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pendingHistoryModalLabel{{ $aset->id }}">
                                                    <i class="sym sym-clock"></i> Riwayat Status Pending -
                                                    {{ $aset->nomor_formulir }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th width="22%">Mulai Pending</th>
                                                                <th width="22%">Selesai Pending</th>
                                                                <th width="18%">Durasi</th>
                                                                <th width="18%">Alasan</th>
                                                                <th width="15%">Catatan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($aset->pending_history as $index => $history)
                                                                <tr>
                                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($history['started_at'])->format('d/m/Y H:i') }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($history['ended_at'])
                                                                            {{ \Carbon\Carbon::parse($history['ended_at'])->format('d/m/Y H:i') }}
                                                                        @else
                                                                            <span class="badge bg-warning">Masih
                                                                                Pending</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($history['ended_at'])
                                                                            @php
                                                                                $start = \Carbon\Carbon::parse(
                                                                                    $history['started_at'],
                                                                                );
                                                                                $end = \Carbon\Carbon::parse(
                                                                                    $history['ended_at'],
                                                                                );
                                                                                $diff = $start->diff($end);
                                                                            @endphp
                                                                            {{ $diff->d > 0 ? $diff->d . ' hari ' : '' }}
                                                                            {{ $diff->h > 0 ? $diff->h . ' jam ' : '' }}
                                                                            {{ $diff->i > 0 ? $diff->i . ' menit' : '' }}
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td><small>{{ is_array($history['reason']) ? implode(',', $history['reason']) : $history['reason'] ?? '-' }}</small>
                                                                    </td>
                                                                    <td><small>{{ $history['note'] ?? '-' }}</small></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <!-- End Pending History Modals -->

                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $asetMaintenances->firstItem() }}</span> -
                                <span class="fw-bold">{{ $asetMaintenances->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $asetMaintenances->total() }}</span> data
                            </p>

                            <!-- Dropdown untuk memilih jumlah item per halaman -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                                <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
                                    onchange="updateItemsPerPage(this.value)">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200</option>
                                    <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
                                    <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000
                                    </option>
                                </select>
                            </div>
                            <!-- Navigasi halaman -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">

                                    @php
                                        $currentPage = $asetMaintenances->currentPage();
                                        $lastPage = $asetMaintenances->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $asetMaintenances->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetMaintenances->appends(request()->except('page'))->previousPageUrl() }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetMaintenances->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetMaintenances->appends(request()->except('page'))->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $asetMaintenances->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetMaintenances->appends(request()->except('page'))->nextPageUrl() }}">
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
