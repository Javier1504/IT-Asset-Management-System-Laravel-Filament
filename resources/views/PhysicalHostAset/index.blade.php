@extends('layouts.admin')

@section('title', 'Page All Physical Host Aset')

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
                                <li class="breadcrumb-item active" aria-current="page">Data Physical Host Aset</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Physical Host Aset</h4>

                        <form method="GET" action="{{ route('physical-host-aset.index') }}" id="filterForm">
                            <!-- Hidden field untuk perPage -->
                            <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">

                            <div class="row mt-4">
                                <!-- Filter berdasarkan status aset -->
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="subcategories[]" value="stock" id="stock"
                                                @if (in_array('stock', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="stock">Stock</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="subcategories[]" value="terpakai" id="terpakai"
                                                @if (in_array('terpakai', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="terpakai">Terpakai</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="subcategories[]" value="disewakan" id="disewakan"
                                                @if (in_array('disewakan', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="disewakan">Disewakan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="subcategories[]" value="retirement" id="retirement"
                                                @if (in_array('retirement', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="retirement">Retirement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="subcategories[]" value="dihibahkan" id="dihibahkan"
                                                @if (in_array('dihibahkan', request('subcategories', []))) checked @endif>
                                            <label class="form-check-label" for="dihibahkan">Dihibahkan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row d-flex align-items-center justify-content-between gap-2 mb-2">

                                {{-- Kolom Search --}}
                                <div class="col-md-3">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Dropdown Filter --}}
                                <div class="col d-flex justify-content-end align-items-center gap-2">

                                    {{-- Filter Heirarki Perangkat --}}
                                    <div class="col-md-3">
                                        <select class="form-select" id="heirarchi_perangkat" name="heirarchi_perangkat"
                                            onchange="this.form.submit()" aria-label="Filter Heirarki">
                                            <option value="">Semua Heirarki</option>
                                            <option value="core"
                                                {{ request('heirarchi_perangkat') == 'core' ? 'selected' : '' }}>Core
                                            </option>
                                            <option value="distribution"
                                                {{ request('heirarchi_perangkat') == 'distribution' ? 'selected' : '' }}>
                                                Distribution</option>
                                            <option value="management"
                                                {{ request('heirarchi_perangkat') == 'management' ? 'selected' : '' }}>
                                                Management</option>
                                            <option value="access"
                                                {{ request('heirarchi_perangkat') == 'access' ? 'selected' : '' }}>Access
                                            </option>
                                            <option value="endpoint"
                                                {{ request('heirarchi_perangkat') == 'endpoint' ? 'selected' : '' }}>
                                                Endpoint</option>
                                        </select>
                                    </div>

                                    {{-- Filter Jenis Aset --}}
                                    <div class="col-md-3">
                                        <select class="form-select" id="jenis_aset_id" name="jenis_aset_id"
                                            onchange="this.form.submit()" aria-label="Filter Jenis Aset">
                                            <option value="">Semua Jenis</option>
                                            @foreach ($jenisAsets as $jenis)
                                                <option value="{{ $jenis->id }}"
                                                    {{ request('jenis_aset_id') == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->name_jenis }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @can('super_admin')
                                        <div class="col-md-3">
                                            <select class="form-select" name="company" onchange="this.form.submit()"
                                                aria-label="Filter Company">
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

                        @can('akses-admin-superadmin')
                            {{-- Baris 2: Tombol Aksi --}}
                            <div class="row mb-3">
                                <div class="col d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('physical-host-aset.download-template') }}"
                                        class="btn btn-outline-success d-flex align-items-center gap-1"
                                        aria-label="Unduh Template">
                                        <i class="sym sym-download"></i> Unduh Template
                                    </a>

                                    <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#importModal" aria-label="Import">
                                        <i class="sym sym-upload"></i> Import
                                    </button>

                                    <a href="{{ route('physical-host-aset.export') }}"
                                        class="btn btn-success d-block d-lg-inline-block" aria-label="Ekspor Data">
                                        <i class="sym sym-download"></i> Ekspor Data
                                    </a>

                                    <a href="{{ route('physical-host-aset.create') }}"
                                        class="btn btn-primary d-flex align-items-center gap-1" aria-label="Tambah Data">
                                        <i class="sym sym-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                        @endcan

                        {{-- Modal --}}
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('physical-host-aset.import-template') }}" method="POST"
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
                                        <th style="min-width: 36px; width: 36px;" rowspan="2">No</th>
                                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nomor Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nama Perangkat
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        @can('super_admin')
                                            <th style="min-width: 100px; width: 10%;" rowspan="2">
                                                <button class="btn p-0 border-0 w-100 h-100 text-start">Company<i
                                                        class="float-end sym sym-switch-vertical"></i></button>
                                            </th>
                                        @endcan
                                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Lokasi
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Jenis Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>

                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Heirarchi Perangkat
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Merk Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 300px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Spesifikasi Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Tanggal Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Harga Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Status
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th class="text-center" rowspan="2">Aksi</th>
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
                                    @foreach ($physicalHostAsets as $aset)
                                        <tr>
                                            <td>{{ ($physicalHostAsets->currentPage() - 1) * $physicalHostAsets->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->nomor_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->nama_perangkat ?? '-' }}</td>
                                            @can('super_admin')
                                                <td style="text-align: center;">
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">{{ $aset->company->name ?? '-' }}</span>
                                                </td>
                                            @endcan
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->lokasi ?? '-' }}</td>
                                            <td>{{ $aset->jenis_aset ?? '-' }}</td>

                                            <td style="text-align: center;">
                                                @if ($aset->heirarchi_perangkat == 'core')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Core</span>
                                                @elseif ($aset->heirarchi_perangkat == 'distribution')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Distribution</span>
                                                @elseif ($aset->heirarchi_perangkat == 'management')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Management</span>
                                                @elseif ($aset->heirarchi_perangkat == 'access')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Access</span>
                                                @elseif ($aset->heirarchi_perangkat == 'endpoint')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Endpoint</span>
                                                @elseif (is_null($aset->heirarchi_perangkat))
                                                    <span>-</span>
                                                @else
                                                    <span>{{ $aset->heirarchi_perangkat }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $aset->merk_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->spesifikasi_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}</td>
                                            <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }} </td>
                                            <td style="text-align: center;">
                                                @if ($aset->status_aset == 'stock')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                                @elseif ($aset->status_aset == 'terpakai')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                                @elseif ($aset->status_aset == 'disewakan')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Disewakan</span>
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

                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-end gap-1">
                                                    <a href="{{ route('physical-host-aset.show', $aset->id) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Lihat detail" title="Lihat detail">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>
                                                    @can('akses-admin-superadmin')
                                                        <a href="{{ route('physical-host-aset.edit', $aset->id) }}">
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
                                                            action="{{ route('physical-host-aset.destroy', $aset->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                            </td>
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
                                <span class="fw-bold">{{ $physicalHostAsets->firstItem() }}</span> -
                                <span class="fw-bold">{{ $physicalHostAsets->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $physicalHostAsets->total() }}</span> data
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
                            @php
                                $currentPage = $physicalHostAsets->currentPage();
                                $lastPage = $physicalHostAsets->lastPage();
                            @endphp

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $physicalHostAsets->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $physicalHostAsets->appends(request()->except('page'))->previousPageUrl() }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    <!-- Nomor halaman -->
                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $physicalHostAsets->appends(request()->except('page'))->url($page) }}">
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
                                                href="{{ $physicalHostAsets->appends(request()->except('page'))->url($lastPage) }}">
                                                {{ $lastPage }}
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $physicalHostAsets->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $physicalHostAsets->appends(request()->except('page'))->nextPageUrl() }}">
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
        const form = document.getElementById('filterForm');
        const perPageInput = form.querySelector('input[name="perPage"]');
        if (perPageInput) {
            perPageInput.value = perPage;
        }
        form.submit();
    }
</script>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("filterForm");
        const checkboxes = document.querySelectorAll('.filter-checkbox');
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
