@extends('layouts.admin')

@section('title', 'Page Edit End User Aset')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('bast-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Surat BAST Aset</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="advancedForm">
                    Simpan Data
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('bast-aset.update', $bastAset->id) }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Pertama</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data Petugas IT.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputUser1" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser1" name="user_pihak_pertama_id">
                                                <option value="" selected>Pilih Petugas IT</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('user_pihak_pertama_id', $bastAset->user_pihak_pertama_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputJobRole1" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole1" name="job_role"
                                                placeholder="Job Role"
                                                value="{{ old('job_role', $existingData->job_role ?? '') }}" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat1" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat1" name="alamat"
                                                placeholder="Alamat"
                                                value="{{ old('alamat', $existingData->alamat ?? '') }}" readonly />
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Kedua</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data penerima.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputUser2" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser2" name="user_pihak_kedua_id">
                                                <option value="" selected>Pilih Penerima</option>
                                                @foreach ($penerima as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('user_pihak_kedua_id', $bastAset->user_pihak_kedua_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputJobRole2" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole2" name="job_role2"
                                                placeholder="Job Role"
                                                value="{{ old('job_role2', $existingData->job_role2 ?? '') }}" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat2" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat2" name="alamat2"
                                                placeholder="Alamat"
                                                value="{{ old('alamat2', $existingData->alamat2 ?? '') }}" readonly />
                                        </div>
                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-1">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan aset yang akan diserahkan.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Button "Tambah Item Aset" -->
                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#assetModal">
                                                <i class="sym sym-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <!-- Modal Card -->
                                        <div class="modal fade" id="assetModal" tabindex="-1"
                                            aria-labelledby="assetModalLabel" aria-hidden="true"
                                            data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <!-- Tambahkan role document -->
                                                <div class="modal-content"> <!-- Tambahkan modal-content -->
                                                    <div class="modal-header">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="ratio ratio-1x1"
                                                                style="width: 42px; min-width: 42px;">
                                                                <span
                                                                    class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                                                                    <i class="sym sym-shopping-bag-solid"></i>
                                                                    <!-- Ikon Pencarian -->
                                                                </span>
                                                            </div>
                                                            <div class="d-block ms-1">
                                                                <h5 class="m-0">Pilih Jenis Aset Yang Sedang Available
                                                                </h5>
                                                                <span class="fs-6 text-secondary">
                                                                    Pilih jenis aset yang akan diserahkan.
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Tabel untuk memilih jenis aset -->
                                                        <ul class="nav nav-tabs" id="assetTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="endUserAset-tab"
                                                                    data-bs-toggle="tab" href="#endUserAset"
                                                                    role="tab" aria-controls="endUserAset"
                                                                    aria-selected="true">End-User Aset</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="sparepart-tab"
                                                                    data-bs-toggle="tab" href="#sparepart" role="tab"
                                                                    aria-controls="sparepart"
                                                                    aria-selected="false">Sparepart</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content mt-3" id="assetTabContent">
                                                            <!-- Tab End-User Aset -->
                                                            <div class="tab-pane fade show active" id="endUserAset"
                                                                role="tabpanel">
                                                                <div
                                                                    class="row d-flex align-items-center justify-content-between gap-2">

                                                                    <div
                                                                        class="col d-flex justify-content-end align-items-center gap-2">
                                                                        <div class="col-md-3">
                                                                            <div id="searchForm">
                                                                                <div class="row g-2">
                                                                                    <div class="col">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="search"
                                                                                            id="searchInput"
                                                                                            placeholder="Cari.."
                                                                                            autocomplete="off">
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <button type="button"
                                                                                            id="btnSearch"
                                                                                            class="btn btn-primary">Cari</button>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mt-4" id="endUserAsetTable"
                                                                    style="max-height:500px; overflow-y:auto; display:block;">
                                                                    <table class="table table-bordered align-middle">
                                                                        <thead class="align-middle">
                                                                            <tr class="table-light">
                                                                                <th class="text-center">Aksi</th>
                                                                                <th style="min-width: 140px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Nomor Aset
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 140px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Jenis Aset
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 200px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Merk Aset
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 300px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Spesifikasi Aset
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 140px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Klasifikasi Aset
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 140px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Tanggal Beli
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 150px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Harga Beli
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                                <th style="min-width: 100px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Status
                                                                                        <i
                                                                                            class="float-end sym sym-switch-vertical"></i>
                                                                                    </button>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="resultAsetContainer">
                                                                            @isset($endUserAsets)
                                                                                @foreach ($endUserAsets as $aset)
                                                                                    <tr>
                                                                                        <td class="text-center">
                                                                                            <button
                                                                                                class="btn btn-primary btn-sm pilihAset"
                                                                                                data-nomor="{{ $aset->aset->nomor_aset ?? '-' }}"
                                                                                                data-jenis="{{ $aset->aset->jenisAset->name_jenis ?? '-' }}"
                                                                                                data-merk="{{ $aset->aset->merk_aset ?? '-' }}"
                                                                                                data-end-user-id="{{ $aset->id }}">
                                                                                                Pilih

                                                                                            </button>
                                                                                        </td>
                                                                                        <td>{{ $aset->aset->nomor_aset ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $aset->aset->jenisAset->name_jenis ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $aset->aset->merk_aset ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $aset->aset->spesifikasi_aset ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $aset->klasifikasiLaptop->klasifikasi_laptop ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}
                                                                                        </td>
                                                                                        <td>Rp
                                                                                            {{ number_format($aset->aset->harga_pembelian, 0, ',', '.') }}
                                                                                        </td>
                                                                                        <td style="text-align: center;">
                                                                                            @if ($aset->status_aset == 'stock')
                                                                                                <span
                                                                                                    class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                                                                            @elseif($aset->status_aset == 'diperbaiki')
                                                                                                <span
                                                                                                    class="badge text-warning bg-warning bg-opacity-10 border border-warning">Diperbaiki</span>
                                                                                            @elseif($aset->status_aset == 'terpakai')
                                                                                                <span
                                                                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                                                                            @elseif($aset->status_aset == 'dipinjam')
                                                                                                <span
                                                                                                    class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>
                                                                                            @elseif($aset->status_aset == 'retirement')
                                                                                                <span
                                                                                                    class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                                                                            @elseif($aset->status_aset == 'dihibahkan')
                                                                                                <span
                                                                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Dihibahkan</span>
                                                                                            @else
                                                                                                <span>{{ $aset->status_aset }}</span>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                                <p>Variabel endUserAsets tidak tersedia</p>
                                                                            @endisset
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Sparepart -->
                                                            <div class="tab-pane fade" id="sparepart" role="tabpanel"
                                                                aria-labelledby="sparepart-tab">
                                                                <div class="table-responsive mt-4" id="endUserAsetTable"
                                                                    style="max-height:500px; overflow-y:auto; display:block;">
                                                                    <table class="table table-bordered align-middle">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Aksi</th>
                                                                                <th>Jenis Sparepart</th>
                                                                                <th>Nama Sparepart</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($sparepartItems as $sparepart)
                                                                                <tr>
                                                                                    <td>
                                                                                        <button
                                                                                            class="btn btn-primary btn-sm pilihAset"
                                                                                            data-jenis="{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}"
                                                                                            data-merk="{{ $sparepart->nama_sparepart ?? '-' }}"
                                                                                            data-sparepart-id="{{ $sparepart->id }}">
                                                                                            {{-- data-end-user-id="">  --}}
                                                                                            Pilih
                                                                                        </button>
                                                                                    </td>
                                                                                    <td>{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}
                                                                                    </td>
                                                                                    <td>{{ $sparepart->nama_sparepart ?? '-' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2" id="endUserAsetTable"
                                                style="max-height:500px; overflow-y:auto; display:block;">
                                                <table class="table table-bordered align-middle">
                                                    <thead class="align-middle">
                                                        <tr class="table-light">
                                                            <th style="min-width: 36px; width: 36px;">No</th>
                                                            <th style="min-width: 180px;">Jenis Aset</th>
                                                            <th style="min-width: 180px;">Qty</th>
                                                            <th style="min-width: 180px;">Merk Aset</th>
                                                            <th style="min-width: 180px;">Nomor Aset</th>
                                                            <th class="text-center" style="width: 124px;">Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="selectedAssetsBody">
                                                        <!-- Data dari database akan dimuat di sini oleh server-side rendering -->
                                                        @foreach ($bastItems as $index => $item)
                                                            <tr data-source="database" data-id="{{ $item->id }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    @if ($item->endUserAset)
                                                                        {{ $item->endUserAset->aset->jenisAset->name_jenis ?? '-' }}
                                                                    @elseif ($item->sparepart)
                                                                        {{ $item->sparepart->jenisSparepart->jenis_sparepart ?? '-' }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td><input type="number"
                                                                        name="items[{{ $index }}][qty]"
                                                                        class="form-control" min="1"
                                                                        value="{{ $item->qty }}" required></td>
                                                                <td>
                                                                    @if ($item->endUserAset)
                                                                        {{ $item->endUserAset->aset->merk_aset ?? '-' }}
                                                                    @else
                                                                        {{ $item->sparepart->nama_sparepart ?? '-' }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->endUserAset)
                                                                        {{ $item->endUserAset->aset->nomor_aset ?? '-' }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm btn-outline-secondary removeAsset"
                                                                        aria-label="Hapus" title="Hapus"
                                                                        data-index="{{ $index }}"
                                                                        data-source="database">
                                                                        <i class="sym sym-trash-solid"></i>
                                                                    </button>
                                                                </td>
                                                                <input type="hidden"
                                                                    name="items[{{ $index }}][end_user_aset_id]"
                                                                    value="{{ $item->end_user_aset_id }}">
                                                                <input type="hidden"
                                                                    name="items[{{ $index }}][sparepart_id]"
                                                                    value="{{ $item->sparepart_id }}">
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Status<span class="text-danger"> *</span></label>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['terpakai']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="{{ $status }}"
                                                                    {{ $bastAset->status == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label
                                                                    class="form-check-label">{{ ucwords(str_replace('_', ' ', $status)) }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['dipinjam']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="{{ $status }}"
                                                                    {{ $bastAset->status == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label
                                                                    class="form-check-label">{{ ucwords(str_replace('_', ' ', $status)) }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
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
    <div class="d-block d-md-none rounded-top-4 shadow-lg bg-white"
        style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030;">
        <div class="w-100 d-flex gap-2 p-3">
            <button type="submit" class="btn w-100 btn-primary" form="advancedForm">
                Simpan
            </button>
        </div>
    </div>
    <!-- [END] Submit Button Mobile -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            localStorage.removeItem('selectedAssets');

            let databaseAssets = {!! json_encode($bastItems) !!} || [];

            // Format fungsi tambahan (optional jika digunakan)
            function formatDate(dateString) {
                if (!dateString) return '-';
                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            function formatNumber(num) {
                if (!num) return '0';
                return Number(num).toLocaleString('id-ID');
            }

            renderSelectedAssets();

            // Search handler AJAX
            $('#btnSearch').on('click', function(e) {
                e.preventDefault();
                const search = $('#searchInput').val().trim();

                $.ajax({
                    url: '/bast-aset/search-aset',
                    method: 'GET',
                    data: {
                        search: search,
                        ajax: 1
                    },
                    dataType: 'json',
                    success: function(response) {
                        const container = $('#resultAsetContainer');
                        container.html('');

                        if (response.data && response.data.length > 0) {
                            response.data.forEach((aset) => {
                                let statusBadge = '';
                                switch (aset.status_aset) {
                                    case 'stock':
                                        statusBadge =
                                            `<span class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>`;
                                        break;
                                    case 'diperbaiki':
                                        statusBadge =
                                            `<span class="badge text-warning bg-warning bg-opacity-10 border border-warning">Diperbaiki</span>`;
                                        break;
                                    case 'terpakai':
                                        statusBadge =
                                            `<span class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>`;
                                        break;
                                    case 'dipinjam':
                                        statusBadge =
                                            `<span class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>`;
                                        break;
                                    case 'retirement':
                                        statusBadge =
                                            `<span class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>`;
                                        break;
                                    case 'dihibahkan':
                                        statusBadge =
                                            `<span class="badge text-success bg-success bg-opacity-10 border border-success">Dihibahkan</span>`;
                                        break;
                                    default:
                                        statusBadge =
                                            `<span>${aset.status_aset}</span>`;
                                }

                                const row = `
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm pilihAset"
                                        data-nomor="${aset.aset?.nomor_aset ?? '-'}"
                                        data-jenis="${aset.aset?.jenis_aset?.name_jenis ?? (aset.jenis_sparepart?.jenis_sparepart ?? '-')}"
                                        data-merk="${aset.aset?.merk_aset ?? (aset.nama_sparepart ?? '-')}"
                                        data-end-user-id="${aset.id ?? ''}"
                                        data-sparepart-id="${aset.sparepart_id ?? ''}">
                                        Pilih
                                        </button>

                                    </td>
                                    <td>${aset.aset?.nomor_aset ?? '-'}</td>
                                    <td>${aset.aset?.jenis_aset?.name_jenis ?? '-'}</td>
                                    <td>${aset.aset?.merk_aset ?? '-'}</td>
                                    <td>${aset.aset?.spesifikasi_aset ?? '-'}</td>
                                    <td>${aset.klasifikasi_laptop?.klasifikasi_laptop ?? '-'}</td>
                                    <td>${formatDate(aset.aset?.tanggal_pembelian)}</td>
                                    <td>Rp ${formatNumber(aset.aset?.harga_pembelian)}</td>
                                    <td class="text-center">${statusBadge}</td>
                                </tr>
                            `;
                                container.append(row);
                            });

                            bindSelectButtons(); // re-bind event setelah DOM dimodifikasi
                        } else {
                            container.html(
                                '<tr><td colspan="9" class="text-center">Tidak ditemukan</td></tr>'
                            );
                        }

                    }

                });

            });



            // Render ulang tombol pilih
            function bindSelectButtons() {
                document.querySelectorAll('.pilihAset').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const nomorAset = this.dataset.nomor || '-';
                        const jenisAset = this.dataset.jenis || '-';
                        const merkAset = this.dataset.merk || '-';
                        const endUserAsetId = this.dataset.endUserId && this.dataset.endUserId !==
                            "null" ? this
                            .dataset.endUserId : null;
                        const sparepartId = this.dataset.sparepartId && this.dataset.sparepartId !==
                            "null" ?
                            this.dataset.sparepartId : null;
                        const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) ||
                            [];
                        const allAssets = [];

                        databaseAssets.forEach(item => {
                            if (item.end_user_aset && item.end_user_aset.aset) {
                                allAssets.push({
                                    sparepart_id: null,
                                    nomor: item.end_user_aset.aset.nomor_aset
                                });
                            } else if (item.sparepart_id) {
                                allAssets.push({
                                    sparepart_id: item.sparepart_id,
                                    nomor: null
                                });
                            }
                        });

                        selectedAssets.forEach(asset => {
                            allAssets.push({
                                sparepart_id: asset.sparepartId || null,
                                nomor: asset.nomor || null
                            });
                        });

                        const isDuplicate = allAssets.some(asset => {
                            if (sparepartId && asset.sparepart_id) {
                                return String(asset.sparepart_id) === String(sparepartId);
                            }
                            if (nomorAset && asset.nomor) {
                                return asset.nomor === nomorAset;
                            }
                            return false;
                        });


                        if (isDuplicate) {
                            if (sparepartId) {
                                alert(
                                    "Sparepart sudah dipilih. Jika ingin menambahkan sparepart yang sama, silakan tambahkan jumlahnya melalui kolom Qty pada tabel yang sudah ada!"
                                );
                            } else {
                                alert("Aset sudah dipilih!");
                            }
                            return;
                        }


                        selectedAssets.push({
                            nomor: nomorAset,
                            jenis: jenisAset,
                            merk: merkAset,
                            qty: 1,
                            endUserAsetId,
                            sparepartId
                        });

                        localStorage.setItem('selectedAssets', JSON.stringify(selectedAssets));
                        renderSelectedAssets();

                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'assetModal'));
                        modal.hide();
                    });
                });
            }

            // Render gabungan table dari database + localStorage
            function renderSelectedAssets() {
                const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
                const tableBody = document.getElementById('selectedAssetsBody');
                tableBody.innerHTML = '';
                let nomor = 1;

                databaseAssets.forEach((item, index) => {
                    let jenis = '-',
                        merk = '-',
                        nomorAset = '-';
                    if (item.end_user_aset?.aset) {
                        jenis = item.end_user_aset.aset.jenis_aset?.name_jenis || '-';
                        merk = item.end_user_aset.aset.merk_aset || '-';
                        nomorAset = item.end_user_aset.aset.nomor_aset || '-';
                    } else if (item.sparepart) {
                        jenis = item.sparepart.jenis_sparepart?.jenis_sparepart || '-';
                        merk = item.sparepart.nama_sparepart || '-';
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${nomor++}</td>
                    <td>${jenis}</td>
                    <td><input type="number" name="items[${index}][qty]" class="form-control" min="1" value="${item.qty}" required></td>
                    <td>${merk}</td>
                    <td>${nomorAset}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger removeDbAsset" data-index="${index}">
                            <i class="sym sym-trash-solid"></i>
                        </button>
                    </td>
                    <input type="hidden" name="items[${index}][end_user_aset_id]" value="${item.end_user_aset_id || ''}">
                    <input type="hidden" name="items[${index}][sparepart_id]" value="${item.sparepart_id || ''}">
                `;
                    tableBody.appendChild(row);
                });

                selectedAssets.forEach((asset, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${nomor++}</td>
                    <td>${asset.jenis}</td>
                    <td><input type="number" name="items[new-${index}][qty]" class="form-control" min="1" value="${asset.qty}" required></td>
                    <td>${asset.merk}</td>
                    <td>${asset.nomor}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger removeAsset" data-index="${index}">
                            <i class="sym sym-trash-solid"></i>
                        </button>
                    </td>
                    <input type="hidden" name="items[new-${index}][end_user_aset_id]" value="${asset.endUserAsetId || ''}">
                    <input type="hidden" name="items[new-${index}][sparepart_id]" value="${asset.sparepartId || ''}">
                `;
                    tableBody.appendChild(row);
                });

                // Re-bind delete buttons
                document.querySelectorAll('.removeDbAsset').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        databaseAssets.splice(index, 1);
                        renderSelectedAssets();
                    });
                });

                document.querySelectorAll('.removeAsset').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        let selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) ||
                        [];
                        selectedAssets.splice(index, 1);
                        localStorage.setItem('selectedAssets', JSON.stringify(selectedAssets));
                        renderSelectedAssets();
                    });
                });
            }


            // Submit form logic
            const form = document.getElementById('advancedForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
                    document.querySelectorAll(".dynamic-input").forEach(input => input.remove());

                    selectedAssets.forEach((asset, index) => {
                        addHiddenInput(form, `items[new-${index}][qty]`, asset.qty);
                        addHiddenInput(form, `items[new-${index}][end_user_aset_id]`, asset
                            .endUserAsetId || '');
                        addHiddenInput(form, `items[new-${index}][sparepart_id]`, asset
                            .sparepartId || '');
                    });

                    localStorage.removeItem('selectedAssets');
                });
            }

            // Reset localStorage on unload
            window.addEventListener("beforeunload", function() {
                localStorage.removeItem('selectedAssets');
            });

            function addHiddenInput(form, name, value) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = name;
                input.value = value;
                input.classList.add("dynamic-input");
                form.appendChild(input);
            }

            // First bind for modal pilih aset
            bindSelectButtons();
        });
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnSearch').click();
            }
        });
    </script>



    <script>
        // Function to set job role and address
        function setUserDetails(userSelectId, jobRoleInputId, addressInputId) {
            var selectElement = document.getElementById(userSelectId);
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var jobRole = selectedOption.getAttribute('data-job-role');
            var alamat = selectedOption.getAttribute('data-alamat');

            document.getElementById(jobRoleInputId).value = jobRole || '';
            document.getElementById(addressInputId).value = alamat || '';
            document.getElementById(jobRoleInputId).disabled = true;
            document.getElementById(addressInputId).disabled = true;
        }

        // Populate fields on change
        document.getElementById('inputUser1').addEventListener('change', function() {
            setUserDetails('inputUser1', 'inputJobRole1', 'inputAlamat1');
        });

        document.getElementById('inputUser2').addEventListener('change', function() {
            setUserDetails('inputUser2', 'inputJobRole2', 'inputAlamat2');
        });

        // Initialize fields on page load
        window.addEventListener('DOMContentLoaded', function() {
            setUserDetails('inputUser1', 'inputJobRole1', 'inputAlamat1');
            setUserDetails('inputUser2', 'inputJobRole2', 'inputAlamat2');
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

@endsection
