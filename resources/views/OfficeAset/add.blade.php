@extends('layouts.admin')

@section('title', 'Page Add Office Aset')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">

        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('office-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Tambahkan Aset</span>
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
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('office-aset.store') }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Office Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Pilih dan masukkan data aset Office.
                                                </p>
                                            </div>
                                        </div>
                                        @can('super_admin')
                                            <div class="col-md-4">
                                                <label for="inputCompany" class="form-label">
                                                    Company <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="company" name="company" required>
                                                    <option value="" selected>Pilih Company</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company }}"
                                                            {{ old('company') == $company ? 'selected' : '' }}>
                                                            {{ ucfirst($company) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endcan
                                        <div class="col-md-6">
                                            <label for="inputLokasi" class="form-label">
                                                Lokasi
                                            </label>
                                            <select class="form-select" id="inputLokasi" name="lokasi_id">
                                                <option value="" selected>Pilih Lokasi Pemasangan</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                        {{ old('lokasi_id') == $location->id ? 'selected' : '' }}>
                                                        {{ $location->lokasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputCategory" class="form-label">
                                                Jenis Aset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="jenisAset" name="jenis_aset_id" required>
                                                <option value="" selected>Pilih Jenis Aset</option>
                                                @foreach ($jenisAsets as $jenisAset)
                                                    <option value="{{ $jenisAset->id }}">{{ $jenisAset->name_jenis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputTipeAset" class="form-label">
                                                Merk Aset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputTipeAset" name="merk_aset"
                                                placeholder="Masukkan merk aset" value="{{ old('merk_aset') }}" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputSpesifikasiAset" class="form-label">
                                                Spesifikasi Aset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="inputSpesifikasiAset" name="spesifikasi_aset" placeholder="Masukkan spesifikasi aset"
                                                required>{{ old('spesifikasi_aset') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputTanggalPembelian" class="form-label">
                                                Tanggal Pembelian
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control" id="inputTanggalPembelian"
                                                name="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputHargaPembelian" class="form-label">
                                                Harga Pembelian
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" id="inputHargaPembelian"
                                                name="harga_pembelian" placeholder="Masukkan harga pembelian"
                                                value="{{ old('harga_pembelian') }}" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputNomorAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex align-items-center">
                                                <span class="me-1"
                                                    id="assetCount">{{ sprintf('%03d', count($asets) + 1) }}/</span>
                                                <input type="text" class="form-control text-start" id="inputNomorAset"
                                                    name="nomor_aset" placeholder="Masukkan nomor aset"
                                                    value="{{ old('nomor_aset') }}" required />
                                                <span class="ms-1"
                                                    id="purchaseDateSuffix">/{{ session('active_company_code') }}/{{ \Carbon\Carbon::now()->format('n/Y') }}</span>
                                            </div>
                                        </div>

                                        <!-- Gambar -->
                                        <div class="col-md-6">
                                            <label for="inputGambar" class="form-label">
                                                Gambar Aset
                                            </label>
                                            <input type="file" class="form-control" id="inputGambar"
                                                name="gambar_aset" accept="image/*" />
                                        </div>

                                        <!-- Radio Buttons -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['stock', 'terpakai', 'dipinjam']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_aset" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('status_aset') == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucfirst($status) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['retirement', 'dihibahkan']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_aset" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('status_aset') == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucfirst($status) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputKeterangan" class="form-label">
                                                Keterangan
                                            </label>
                                            <textarea class="form-control" id="inputKeterangan" name="keterangan" placeholder="Masukkan keterangan">{{ old('keterangan') }}</textarea>
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
</script>

{{-- untuk nomor aset --}}
<script>
    // Event listener untuk jenis aset
    document.getElementById('jenisAset').addEventListener('change', function() {
        var jenisAsetId = this.value;

        if (jenisAsetId) {
            // Cari aset terakhir berdasarkan jenis aset yang dipilih
            var assetCount = 1; // Default jika tidak ada aset yang cocok

            // Loop untuk mencari aset terakhir berdasarkan jenis aset yang dipilih
            @foreach ($asets as $aset)
                if ("{{ $aset->jenis_aset_id }}" === jenisAsetId) {
                    // Cek apakah ini aset terakhir (nomor terbesar)
                    var lastAssetNumber = "{{ $aset->nomor_aset }}";
                    var lastAssetNumberPrefix = lastAssetNumber.match(/^(\d{3})\//);
                    var currentAssetCount = lastAssetNumberPrefix ? parseInt(lastAssetNumberPrefix[1]) : 0;

                    if (currentAssetCount >= assetCount) {
                        assetCount = currentAssetCount + 1; // Update nomor aset jika lebih besar
                    }
                }
            @endforeach

            // Update nomor aset yang ditampilkan
            document.getElementById('assetCount').textContent = sprintf(assetCount) + '/';
        }
    });

    // Fungsi untuk format string dengan leading zeros
    function sprintf(num) {
        return num.toString().padStart(3, '0');
    }

    // Update suffix tanggal pembelian
    document.getElementById('inputTanggalPembelian').addEventListener('change', function() {
        var purchaseDate = new Date(this.value);
        var month = purchaseDate.getMonth() + 1; // JavaScript months are 0-based
        var year = purchaseDate.getFullYear();

        // Update the suffix based on the selected purchase date
        document.getElementById('purchaseDateSuffix').textContent = '/{{ session('active_company_code') }}/' +
            month + '/' + year;
    });
</script>


@endsection
