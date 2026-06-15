@extends('layouts.admin')

@section('title', 'Edit Physical Host Aset')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('physical-host-aset.index') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Aset</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="d-none d-md-block btn btn-primary" form="advancedForm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('physical-host-aset.update', $aset->id) }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-4">
                                            <label for="inputNamaPerangkat" class="form-label">Nama Perangkat<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNamaPerangkat"
                                                name="nama_perangkat" value="{{ $aset->nama_perangkat }}" required />
                                        </div>
                                        @can('super_admin')
                                            <div class="col-md-4">
                                                <label for="editCompany" class="form-label">
                                                    Company <span class="text-danger">*</span>
                                                </label>

                                                <select class="form-select" id="editCompany" name="company_id" required>
                                                    <option value="">Pilih Company</option>

                                                    @foreach ($companies as $id => $name)
                                                        <option value="{{ $id }}"
                                                            {{ old('company_id', $aset->company_id) == $id ? 'selected' : '' }}>
                                                            {{ ucfirst($name) }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        @endcan

                                        <div class="col-md-4">
                                            <label for="inputLokasi" class="form-label">Lokasi</label>
                                            <select class="form-select" id="inputLokasi" name="lokasi_id">
                                                <option value="">Pilih Lokasi Pemasangan</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                        {{ $aset->lokasi_id == $location->id ? 'selected' : '' }}>
                                                        {{ $location->lokasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jenisAset" class="form-label">Jenis Aset <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="jenisAset" name="jenis_aset_id" required>
                                                @foreach ($jenisAsets as $jenisAset)
                                                    <option value="{{ $jenisAset->id }}"
                                                        {{ $aset->jenis_aset_id == $jenisAset->id ? 'selected' : '' }}>
                                                        {{ $jenisAset->name_jenis }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="heirarchi_perangkat" class="form-label">
                                                Heirarki Perangkat
                                                <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Hanya tersedia untuk aset dengan jenis Network Switch & Router, Network Access Point."></i>
                                            </label>
                                            <select class="form-select" id="heirarchi_perangkat" name="heirarchi_perangkat">
                                                <option value="" disabled>Pilih Heirarki Perangkat</option>
                                                <option value="core"
                                                    {{ $aset->heirarchi_perangkat == 'core' ? 'selected' : '' }}>Core
                                                </option>
                                                <option value="distribution"
                                                    {{ $aset->heirarchi_perangkat == 'distribution' ? 'selected' : '' }}>
                                                    Distribution</option>
                                                <option value="management"
                                                    {{ $aset->heirarchi_perangkat == 'management' ? 'selected' : '' }}>
                                                    Management</option>
                                                <option value="access"
                                                    {{ $aset->heirarchi_perangkat == 'access' ? 'selected' : '' }}>Access
                                                </option>
                                                <option value="endpoint"
                                                    {{ $aset->heirarchi_perangkat == 'endpoint' ? 'selected' : '' }}>
                                                    Endpoint</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputTipeAset" class="form-label">Merk Aset<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputTipeAset" name="merk_aset"
                                                value="{{ $aset->aset->merk_aset }}" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputSpesifikasiAset" class="form-label">Spesifikasi Aset<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="inputSpesifikasiAset" name="spesifikasi_aset">{{ $aset->aset->spesifikasi_aset }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputTanggalPembelian" class="form-label">Tanggal Pembelian<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="inputTanggalPembelian"
                                                name="tanggal_pembelian" value="{{ $aset->aset->tanggal_pembelian }}"
                                                required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputHargaPembelian" class="form-label">Harga Pembelian<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="inputHargaPembelian"
                                                name="harga_pembelian" value="{{ $aset->aset->harga_pembelian }}"
                                                required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputNomorAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex align-items-center">
                                                <!-- Bagian untuk angka increment awal -->
                                                <span class="me-1" id="assetCount">
                                                    {{ sprintf('%03d', isset($aset->aset->nomor_aset) ? intval(explode('/', $aset->aset->nomor_aset)[0]) : 0) }}/
                                                </span>

                                                <!-- Input hanya untuk bagian tengah nomor aset -->
                                                <input type="text" class="form-control text-start"
                                                    id="inputNomorAsetTengah" name="nomor_aset_tengah"
                                                    placeholder="Masukkan kode aset"
                                                    value="{{ old('nomor_aset_tengah', isset($aset->aset->nomor_aset) ? explode('/', $aset->aset->nomor_aset)[1] : '') }}"
                                                    required />

                                                <!-- Bagian untuk tanggal pembelian -->
                                                <span class="ms-1" id="purchaseDateSuffix">
                                                    /{{ session('active_company_code') }}/{{ isset($aset->aset->tanggal_pembelian) ? \Carbon\Carbon::parse($aset->aset->tanggal_pembelian)->format('n/Y') : \Carbon\Carbon::now()->format('n/Y') }}
                                                </span>

                                                <!-- Hidden input untuk mengirim nomor aset lengkap -->
                                                <input type="hidden" id="hiddenNomorAset" name="nomor_aset"
                                                    value="{{ $aset->aset->nomor_aset ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputGambar" class="form-label">Gambar Aset</label>
                                            <input type="file" class="form-control" id="inputGambar"
                                                name="gambar_aset" accept="image/*" />
                                            @if ($aset->aset && $aset->aset->gambar_aset)
                                                <img src="{{ asset('storage/' . $aset->aset->gambar_aset) }}"
                                                    alt="Gambar Aset" class="mt-2 img-thumbnail" width="200">
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <!-- Kolom pertama untuk status utama -->
                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['stock', 'disewakan', 'terpakai']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_aset" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ $aset->status_aset == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucfirst($status) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <!-- Kolom kedua untuk status lainnya -->
                                                <div class="col-md-6">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['retirement', 'dihibahkan']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_aset" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ $aset->status_aset == $status ? 'checked' : '' }}
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
                                            <label for="inputKeterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control" id="inputKeterangan" name="keterangan">{{ $aset->aset->keterangan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    // Fungsi untuk menggabungkan nomor aset
    function updateNomorAset() {
        var nomorAwal = document.getElementById('assetCount').textContent.trim();
        var nomorTengah = document.getElementById('inputNomorAsetTengah').value;
        var tanggalSuffix = document.getElementById('purchaseDateSuffix').textContent.trim();

        // Gabungkan nomor aset
        var nomorAsetLengkap = nomorAwal + nomorTengah + tanggalSuffix;

        // Set nilai hidden input
        document.getElementById('hiddenNomorAset').value = nomorAsetLengkap;
    }

    // Event listener untuk input nomor aset tengah
    document.getElementById('inputNomorAsetTengah').addEventListener('input', function() {
        updateNomorAset();
    });

    // Event listener untuk perubahan tanggal pembelian
    document.getElementById('inputTanggalPembelian').addEventListener('change', function() {
        var purchaseDate = new Date(this.value);
        var month = purchaseDate.getMonth() + 1;
        var year = purchaseDate.getFullYear();

        // Update suffix tanggal pembelian
        document.getElementById('purchaseDateSuffix').textContent = '/{{ session('active_company_code') }}/' +
            month + '/' + year;
        // Perbarui nomor aset setelah tanggal berubah
        updateNomorAset();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const jenisAsetSelect = document.getElementById("jenisAset");
        const heirarchiSelect = document.getElementById("heirarchi_perangkat");

        function toggleHeirarchiPerangkat() {
            const selectedOption = jenisAsetSelect.options[jenisAsetSelect.selectedIndex];
            const selectedText = selectedOption.text.toLowerCase();

            const isAccessPoint = selectedText.includes("network access point");

            const isNetworkRelated = (
                selectedText.includes("network") ||
                selectedText.includes("switch") ||
                selectedText.includes("router")
            );

            if (isAccessPoint) {
                heirarchiSelect.value = "access";
                heirarchiSelect.readOnly = true;
                heirarchiSelect.style.pointerEvents = "none";
                heirarchiSelect.style.backgroundColor = "#e9ecef";
            } else if (isNetworkRelated) {
                heirarchiSelect.readOnly = false;
                heirarchiSelect.style.pointerEvents = "auto";
                heirarchiSelect.style.backgroundColor = "";
            } else {
                heirarchiSelect.value = "";
                heirarchiSelect.readOnly = true;
                heirarchiSelect.style.pointerEvents = "none";
                heirarchiSelect.style.backgroundColor = "#e9ecef";
            }
        }

        toggleHeirarchiPerangkat();
        jenisAsetSelect.addEventListener("change", toggleHeirarchiPerangkat);
    });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>


@endsection
