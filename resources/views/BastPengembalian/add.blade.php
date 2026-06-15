@extends('layouts.admin')

@section('title', 'Page Add End User Aset')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('bast-pengembalian.index') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Buat Surat BAST Pengembalian Aset</span>
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
                    <form method="POST" action="{{ route('bast-pengembalian.store') }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
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
                                            <select class="form-select" id="inputUser1" name="petugas_id">
                                                <option value="" selected>Pilih Petugas IT</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('petugas_id') == $user->id ? 'selected' : '' }}>
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
                                                placeholder="Job Role" value="{{ old('job_role') }}" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat1" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat1" name="alamat"
                                                placeholder="Alamat" value="{{ old('alamat') }}" readonly />
                                        </div>


                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Kedua</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data pengembali.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputUser2" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser2" name="pengembali_id">
                                                <option value="" selected>Pilih Pengembali</option>
                                                @foreach ($pengembali as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('pengembali_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">
                                                <i class="sym sym-info-circle">
                                                    Pilih karyawan yang mengembalikan aset.
                                                </i>
                                            </small>

                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputJobRole2" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole2" name="job_role2"
                                                placeholder="Job Role" value="{{ old('job_role2') }}" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat2" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat2" name="alamat2"
                                                placeholder="Alamat" value="{{ old('alamat2') }}" readonly />
                                        </div>
                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan aset yang akan dikembalikan.
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
                                                                <h5 class="m-0">Data Aset Dikembalikan</h5>
                                                                <span class="fs-6 text-secondary">
                                                                    Pilih aset yang akan dikembalikan.
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
                                                            <div class="tab-pane fade show active" id="endUserAset" role="tabpanel" aria-labelledby="endUserAset-tab">
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
                                                                                <th style="min-width: 200px;">
                                                                                    <button
                                                                                        class="btn p-0 border-0 w-100 text-start">
                                                                                        Nama Pemegang
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
                                                                        <tbody id="asetTableBody">
                                                                            @isset($endUserAsets)
                                                                                @foreach ($endUserAsets as $aset)
                                                                                    <tr>
                                                                                        <td class="text-center">
                                                                                            <button
                                                                                                class="btn btn-primary btn-sm pilihAset"
                                                                                                data-nomor="{{ $aset->aset->nomor_aset ?? '-' }}"
                                                                                                data-jenis="{{ $aset->aset->jenisAset->name_jenis ?? '-' }}"
                                                                                                data-merk="{{ $aset->aset->merk_aset ?? '-' }}"
                                                                                                data-end-user-id="{{ $aset->id }}"
                                                                                                data-sparepart-id="">
                                                                                                Pilih
                                                                                            </button>
                                                                                        </td>
                                                                                        <td>{{ $aset->aset->nomor_aset ?? '-' }}
                                                                                        </td>
                                                                                        <td>{{ $aset->user->name_karyawan ?? '-' }}
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
                                                                <div class="table-responsive mt-4" id="sparepartTable"
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

                                        <!-- Tabel untuk Menampilkan Aset yang Telah Dipilih -->
                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2"
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
                                                        <!-- This section will dynamically update with selected assets -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Radio Buttons Kondisi Aset -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Kondisi Aset <span class="text-danger">*</span>
                                            </label>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    @foreach (['baik', 'rusak_berat'] as $kondisi)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="kondisi_aset" id="kondisi_{{ $kondisi }}"
                                                                value="{{ $kondisi }}"
                                                                {{ old('kondisi_aset', 'baik') == $kondisi ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="kondisi_{{ $kondisi }}">
                                                                {{ ucfirst(str_replace('_', ' ', $kondisi)) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach (['rusak_ringan', 'tidak_lengkap'] as $kondisi)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="kondisi_aset" id="kondisi_{{ $kondisi }}"
                                                                value="{{ $kondisi }}"
                                                                {{ old('kondisi_aset') == $kondisi ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="kondisi_{{ $kondisi }}">
                                                                {{ ucfirst(str_replace('_', ' ', $kondisi)) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Kondisi "Lainnya" -->
                                                <div class="col-md-12 mt-2 d-flex align-items-center">
                                                    <div class="form-check me-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="kondisi_aset" id="kondisi_lainnya" value="lainnya"
                                                            {{ old('kondisi_aset') == 'lainnya' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi_lainnya">
                                                            Lainnya:
                                                        </label>
                                                    </div>

                                                    <input type="text" class="form-control w-25"
                                                        name="kondisi_lainnya" id="kondisi_lainnya_field"
                                                        placeholder="Masukkan kondisi lainnya"
                                                        value="{{ old('kondisi_lainnya') }}">
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



    <!-- Script untuk toggle input kondisi lainnya -->
    <script>
        function toggleKondisiLainnya(index) {
            var inputField = document.getElementById('kondisi_lainnya_field_' + index);
            var radioButton = document.getElementById('kondisi_' + index + '_lainnya');
            inputField.style.display = radioButton.checked ? 'block' : 'none';
        }
    </script>

    <script>
        // Format tanggal dan angka
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

        // AJAX Search dan render hasil pencarian aset
        $(document).ready(function() {
            $('#btnSearch').on('click', function(e) {
                e.preventDefault();
                var search = $('#searchInput').val().trim();

                $.ajax({
                    url: '/bast-aset-pengembalian/search-aset',
                    method: 'GET',
                    data: {
                        search: search,
                        ajax: 1
                    },
                    dataType: 'json',
                    success: function(response) {
                        var tbody = '';

                        if (response.data && response.data.length > 0) {
                            $.each(response.data, function(index, aset) {
                                var statusBadge = '';
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

                                tbody += `
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm pilihAset"
                                            data-nomor="${aset.aset?.nomor_aset ?? '-'}"
                                            data-jenis="${aset.aset?.jenis_aset?.name_jenis ?? '-'}"
                                            data-merk="${aset.aset?.merk_aset ?? '-'}"
                                            data-end-user-id="${aset.id}">
                                            Pilih
                                        </button>
                                    </td>
                                    <td>${aset.aset?.nomor_aset ?? '-'}</td>
                                    <td>${aset.user?.name_karyawan ?? '-'}</td>
                                    <td>${aset.aset?.jenis_aset?.name_jenis ?? '-'}</td>
                                    <td>${aset.aset?.merk_aset ?? '-'}</td>
                                    <td>${aset.aset?.spesifikasi_aset ?? '-'}</td>
                                    <td>${aset.klasifikasi_laptop?.klasifikasi_laptop ?? '-'}</td>
                                    <td>${formatDate(aset.aset?.tanggal_pembelian ?? '-')}</td>
                                    <td>Rp ${formatNumber(aset.aset?.harga_pembelian ?? '-')}</td>
                                    <td style="text-align: center;">${statusBadge}</td>
                                </tr>
                            `;
                            });
                        } else {
                            tbody =
                                '<tr><td colspan="10" class="text-center">Tidak ada data aset yang tersedia untuk user ini</td></tr>';
                        }

                        $('#asetTableBody').html(tbody);
                        attachSelectAssetEvents();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error ajax:', error);
                        $('#asetTableBody').html(
                            '<tr><td colspan="10" class="text-center text-danger">Gagal mencari data aset: ' +
                            error + '</td></tr>'
                        );
                    }
                });
            });

            $('#searchInput').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btnSearch').click();
                }
            });
        });

        // ==== Pengelolaan LocalStorage Aset ====

        document.addEventListener("DOMContentLoaded", function() {
            renderSelectedAssets();
            attachSelectAssetEvents();

            selectedPihakKeduaId = document.getElementById('inputUser2').value || null;
            prevPihakKeduaId = selectedPihakKeduaId;

            if (selectedPihakKeduaId) {
                loadAllAsets();
            }
        });

        document.getElementById('inputUser2').addEventListener('change', function() {
            const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
            const newVal = this.value;

            if (selectedAssets.length > 0) {
                Swal.fire({
                    title: 'Ubah Pihak Kedua?',
                    text: 'Semua aset yang dipilih akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then(res => {
                    if (res.isConfirmed) {
                        localStorage.removeItem('selectedAssets');
                        renderSelectedAssets();
                        selectedPihakKeduaId = newVal || null;
                        prevPihakKeduaId = selectedPihakKeduaId;
                        // Load data baru sesuai user_id yang baru dipilih
                        if (selectedPihakKeduaId) {
                            loadAllAsets();
                        }
                    } else {
                        // Revert selection visually and restore dependent fields
                        this.value = prevPihakKeduaId || '';
                        const prevOpt = Array.from(this.options).find(o => o.value == (prevPihakKeduaId ||
                            ''));
                        const jobRole = prevOpt?.getAttribute('data-job-role') || '';
                        const alamat = prevOpt?.getAttribute('data-alamat') || '';
                        const jobRoleEl = document.getElementById('inputJobRole2');
                        const alamatEl = document.getElementById('inputAlamat2');
                        if (jobRoleEl) jobRoleEl.value = jobRole;
                        if (alamatEl) alamatEl.value = alamat;
                    }
                });
            } else {
                selectedPihakKeduaId = newVal || null;
                prevPihakKeduaId = selectedPihakKeduaId;
                // Load data baru sesuai user_id yang baru dipilih
                if (selectedPihakKeduaId) {
                    loadAllAsets();
                }
            }
        });

        function saveAssetToLocalStorage(asset) {
            const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];

            // Cek duplikat sesuai sparepartId / nomor
            if (asset.sparepartId && selectedAssets.some(a => a.sparepartId === asset.sparepartId)) {
                alert(
                    "Sparepart sudah dipilih. Jika ingin menambahkan sparepart yang sama, silakan tambahkan jumlahnya melalui kolom Qty pada tabel yang sudah ada!"
                );
                return false;
            }
            if (!asset.sparepartId && selectedAssets.some(a => a.nomor === asset.nomor)) {
                alert("Aset sudah dipilih!");
                return false;
            }


            selectedAssets.push(asset);
            localStorage.setItem('selectedAssets', JSON.stringify(selectedAssets));
            return true;
        }

        function removeAssetFromLocalStorage(index) {
            let selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
            selectedAssets.splice(index, 1);
            localStorage.setItem('selectedAssets', JSON.stringify(selectedAssets));
            renderSelectedAssets();
        }

        function renderSelectedAssets() {
            const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
            const tableBody = document.getElementById('selectedAssetsBody');
            tableBody.innerHTML = '';

            if (selectedAssets.length === 0) {
                tableBody.innerHTML = `
                <tr id="noAssetsRow">
                    <td colspan="6" class="text-center text-muted">Belum ada aset yang terpilih</td>
                </tr>
            `;
                return;
            }

            selectedAssets.forEach((asset, index) => {
                const newRow = tableBody.insertRow();
                newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${asset.jenis}</td>
                <td><input type="number" name="items[${index}][qty]" class="form-control" min="1" value="${asset.qty}" required></td>
                <td>${asset.merk}</td>
                <td>${asset.nomor}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-icon btn-sm btn-outline-secondary removeAsset" data-index="${index}">
                        <i class="sym sym-trash-solid"></i>
                    </button>
                </td>
                <input type="hidden" name="items[${index}][end_user_aset_id]" value="${asset.endUserAsetId || ''}">
                <input type="hidden" name="items[${index}][sparepart_id]" value="${asset.sparepartId || ''}">
            `;
            });

            // Pasang event remove sekali saat render selesai
            document.querySelectorAll('.removeAsset').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    removeAssetFromLocalStorage(index);
                });
            });
        }

        function attachSelectAssetEvents() {
            // Hapus event listener lama sebelum pasang yang baru
            document.querySelectorAll('.pilihAset').forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            document.querySelectorAll('.pilihAset').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const nomorAset = this.dataset.nomor || '-';
                    const jenisAset = this.dataset.jenis || '-';
                    const merkAset = this.dataset.merk || '-';
                    const endUserAsetId = this.dataset.endUserId && this.dataset.endUserId !== "null" ? this
                        .dataset.endUserId : null;
                    const sparepartId = this.dataset.sparepartId && this.dataset.sparepartId !== "null" ?
                        this.dataset.sparepartId : null;

                    const asset = {
                        nomor: nomorAset,
                        jenis: jenisAset,
                        merk: merkAset,
                        qty: 1,
                        endUserAsetId,
                        sparepartId
                    };

                    if (!saveAssetToLocalStorage(asset)) return;

                    renderSelectedAssets();

                    // Jangan set keepModalOpen karena modal kita hide manual di sini
                    // sessionStorage.setItem('keepModalOpen', 'true');

                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById(
                        'assetModal'));
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            });
        }

        function loadAllAsets() {
            // Tampilkan loading indicator
            $('#asetTableBody').html(`
                <tr>
                    <td colspan="10" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Memuat data aset...</div>
                    </td>
                </tr>
            `);

            $.ajax({
                url: '/bast-aset-pengembalian/search-aset',
                method: 'GET',
                data: {
                    search: '',
                    ajax: 1,
                    user_id: selectedPihakKeduaId || ''
                },
                dataType: 'json',
                success: function(response) {
                    var tbody = '';

                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function(index, aset) {
                            var statusBadge = '';
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
                                    statusBadge = `<span>${aset.status_aset}</span>`;
                            }

                            tbody += `
                        <tr>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm pilihAset"
                                    data-nomor="${aset.aset?.nomor_aset ?? '-'}"
                                    data-jenis="${aset.aset?.jenis_aset?.name_jenis ?? '-'}"
                                    data-merk="${aset.aset?.merk_aset ?? '-'}"
                                    data-end-user-id="${aset.id}">
                                    Pilih
                                </button>
                            </td>
                            <td>${aset.aset?.nomor_aset ?? '-'}</td>
                            <td>${aset.user?.name_karyawan ?? '-'}</td>

                            <td>${aset.aset?.jenis_aset?.name_jenis ?? '-'}</td>
                            <td>${aset.aset?.merk_aset ?? '-'}</td>
                            <td>${aset.aset?.spesifikasi_aset ?? '-'}</td>
                            <td>${aset.klasifikasi_laptop?.klasifikasi_laptop ?? '-'}</td>
                            <td>${formatDate(aset.aset?.tanggal_pembelian ?? '-')}</td>
                            <td>Rp ${formatNumber(aset.aset?.harga_pembelian ?? '-')}</td>
                            <td style="text-align: center;">${statusBadge}</td>
                        </tr>
                    `;
                        });
                    } else {
                        tbody =
                            '<tr><td colspan="10" class="text-center">Tidak ada data aset yang tersedia untuk user ini</td></tr>';
                    }

                    $('#asetTableBody').html(tbody);
                    attachSelectAssetEvents();
                },
                error: function(xhr, status, error) {
                    console.error('Error load all assets:', error);
                    $('#asetTableBody').html(
                        '<tr><td colspan="10" class="text-center text-danger">Gagal memuat data aset: ' +
                        error + '</td></tr>'
                    );
                }
            });
        }


        // Sembunyikan baris aset yang sudah dipilih ketika modal ditampilkan
        document.getElementById('assetModal').addEventListener('shown.bs.modal', function() {
            const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
            document.querySelectorAll('#assetModal .table tbody tr').forEach(row => {
                const nomorAset = row.querySelector('.pilihAset')?.dataset.nomor;
                if (nomorAset) {
                    row.style.display = selectedAssets.some(asset => asset.nomor === nomorAset) ? 'none' :
                        '';
                }
            });
        });

        document.getElementById('assetModal').addEventListener('hidden.bs.modal', function() {
            // Reset input search
            document.getElementById('searchInput').value = '';

            // Tampilkan ulang semua data aset yang belum dipilih
            loadAllAsets();
        });


        // Saat form submit, bersihkan localStorage selectedAssets dan sessionStorage agar bersih
        document.getElementById('advancedForm').addEventListener('submit', function() {
            sessionStorage.setItem('formSubmitted', 'true');
        });

        window.addEventListener('load', function() {
            // Hapus selectedAssets di localStorage jika form baru saja berhasil submit
            if (sessionStorage.getItem('formSubmitted')) {
                localStorage.removeItem('selectedAssets');
                sessionStorage.removeItem('formSubmitted');
                renderSelectedAssets();
            }
        });
        window.addEventListener('load', function() {
            // Bersihkan jika bukan dari history back (bukan reload dari cache)
            if (performance.navigation.type !== performance.navigation.TYPE_BACK_FORWARD) {
                localStorage.removeItem('selectedAssets');
            }

            // Jika form baru saja berhasil submit
            if (sessionStorage.getItem('formSubmitted')) {
                localStorage.removeItem('selectedAssets');
                sessionStorage.removeItem('formSubmitted');
            }

            renderSelectedAssets();
        });
    </script>


    <script>
        document.getElementById('inputUser1').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var jobRole = selectedOption.getAttribute('data-job-role');
            var alamat = selectedOption.getAttribute('data-alamat');

            // Set the Job Role and Alamat fields for Pihak Pertama
            document.getElementById('inputJobRole1').value = jobRole;
            document.getElementById('inputAlamat1').value = alamat;

            // Disable the fields to make them read-only
            document.getElementById('inputJobRole1').disabled = true;
            document.getElementById('inputAlamat1').disabled = true;
        });

        // Populate Job Role and Alamat based on the selected user (Pihak Kedua)
        document.getElementById('inputUser2').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var jobRole = selectedOption.getAttribute('data-job-role');
            var alamat = selectedOption.getAttribute('data-alamat');

            // Set the Job Role and Alamat fields for Pihak Kedua
            document.getElementById('inputJobRole2').value = jobRole;
            document.getElementById('inputAlamat2').value = alamat;

            // Disable the fields to make them read-only
            document.getElementById('inputJobRole2').disabled = true;
            document.getElementById('inputAlamat2').disabled = true;
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
