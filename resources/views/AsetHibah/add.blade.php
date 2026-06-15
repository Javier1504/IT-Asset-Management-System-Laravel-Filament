@extends('layouts.admin')

@section('title', 'Page Add Aset Hibah')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">

        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-hibah.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Tambahkan Aset Hibah</span>
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
                    <form method="POST" action="{{ route('aset-hibah.store') }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset Hibah</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Pilih data aset yang ingin dihibahkan.
                                                </p>
                                            </div>
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
                                            <label for="inputAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                                <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Data Nomor Aset yang muncul sesuai dengan jenis aset yang dipilih"></i>
                                            </label>
                                            <select class="form-select" id="inputAset" name="aset_id" required>
                                                <option value="" disabled selected>Pilih Nomor Aset</option>
                                                <!-- Nomor Aset akan diisi oleh JavaScript -->
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputMerkAset" class="form-label">
                                                Merek Aset <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputMerkAset"
                                                placeholder="Merek Aset" value="{{ old('merk_aset') }}" readonly />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputSpesifikasiAset" class="form-label">
                                                Spesifikasi Aset
                                            </label>
                                            <input type="text" class="form-control" id="inputSpesifikasiAset"
                                                placeholder="Spesifikasi Aset" value="{{ old('spesifikasi_aset') }}"
                                                readonly />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputTanggalBeli" class="form-label">
                                                Tanggal Beli
                                            </label>
                                            <input type="text" class="form-control" id="inputTanggalBeli"
                                                placeholder="Tanggal Beli" value="{{ old('tanggal_pembelian') }}"
                                                readonly />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputHargaBeli" class="form-label">
                                                Harga Beli
                                            </label>
                                            <input type="text" class="form-control" id="inputHargaBeli"
                                                placeholder="Harga Beli" value="{{ old('harga_pembelian') }}" readonly />
                                        </div>


                                        <!-- Radio Buttons -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <!-- Radio buttons in 4 column width -->
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status_aset"
                                                            id="retirement" value="retirement"
                                                            {{ old('status_aset') == 'retirement' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="retirement">
                                                            Retirement
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status_aset"
                                                            id="dihibahkan" value="dihibahkan"
                                                            {{ old('status_aset') == 'dihibahkan' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="dihibahkan">
                                                            Dihibahkan
                                                        </label>
                                                    </div>
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

<script>
    document.getElementById('inputAset').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

        // Ambil data aset yang dipilih
        var merkAset = selectedOption.getAttribute('data-merk') || '';
        var spesifikasiAset = selectedOption.getAttribute('data-spesifikasi') || '';
        var tanggalBeli = selectedOption.getAttribute('data-tanggal-beli') || '';
        var hargaBeli = selectedOption.getAttribute('data-harga-beli') || '';

        // Mengisi field tampilan
        document.getElementById('inputMerkAset').value = merkAset;
        document.getElementById('inputSpesifikasiAset').value = spesifikasiAset;
        document.getElementById('inputTanggalBeli').value = tanggalBeli;
        document.getElementById('inputHargaBeli').value = hargaBeli;

        // Menyimpan aset_id dalam input hidden untuk dikirim ke backend
        var asetIdInput = document.getElementById('inputAsetId');
        if (!asetIdInput) {
            asetIdInput = document.createElement('input');
            asetIdInput.type = 'hidden';
            asetIdInput.name = 'aset_id';
            asetIdInput.id = 'inputAsetId';
            document.getElementById('inputAset').parentNode.appendChild(asetIdInput);
        }
        asetIdInput.value = selectedOption.value;
    });

    // Mengisi kembali data saat reload (kalau validasi gagal)
    window.onload = function() {
        var selectedOption = document.getElementById('inputAset').options[document.getElementById('inputAset')
            .selectedIndex];
        if (selectedOption.value) {
            document.getElementById('inputMerkAset').value = selectedOption.getAttribute('data-merk');
            document.getElementById('inputSpesifikasiAset').value = selectedOption.getAttribute('data-spesifikasi');
            document.getElementById('inputTanggalBeli').value = selectedOption.getAttribute('data-tanggal-beli');
            document.getElementById('inputHargaBeli').value = selectedOption.getAttribute('data-harga-beli');
        }
    };
</script>

<script>
    // Ambil semua aset yang sudah ada di view
    var allAssets = @json($asets);

    document.getElementById('jenisAset').addEventListener('change', function() {
        var jenisAsetId = this.value;

        // Ambil dropdown Nomor Aset
        var asetDropdown = document.getElementById('inputAset');

        // Hapus semua option sebelumnya
        asetDropdown.innerHTML = '<option value="" disabled selected>Pilih Nomor Aset</option>';

        // Jika jenis aset dipilih
        if (jenisAsetId) {
            // Filter aset berdasarkan jenis aset yang dipilih
            var filteredAssets = allAssets.filter(function(aset) {
                return aset.jenis_aset_id == jenisAsetId;
            });

            // Jika ada aset yang sesuai
            if (filteredAssets.length > 0) {
                filteredAssets.forEach(function(aset) {
                    var option = document.createElement("option");
                    option.value = aset.id;
                    option.text = aset.nomor_aset;
                    option.setAttribute('data-merk', aset.merk_aset);
                    option.setAttribute('data-spesifikasi', aset.spesifikasi_aset);
                    option.setAttribute('data-tanggal-beli', aset.tanggal_pembelian);
                    option.setAttribute('data-harga-beli', aset.harga_pembelian);
                    asetDropdown.appendChild(option);
                });
            } else {
                // Jika tidak ada aset yang sesuai
                var option = document.createElement("option");
                option.value = "";
                option.text = "Tidak ada aset untuk jenis ini";
                asetDropdown.appendChild(option);
            }
        } else {
            // Jika tidak ada jenis aset yang dipilih
            var option = document.createElement("option");
            option.value = "";
            option.text = "Pilih jenis aset terlebih dahulu"; // Mengubah teks yang muncul
            asetDropdown.appendChild(option);
        }
    });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>


@endsection
