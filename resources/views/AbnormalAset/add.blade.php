@extends('layouts.admin')

@section('title', 'Page Add Abnormal Aset')

@section('content')

<header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">

    <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('abnormal-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
            <span class="m-0 fs-6 fw-medium">Buat Problem Aset Tidak Normal</span>
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
                <form method="POST" action="{{ route('abnormal-aset.store') }}" id="advancedForm" class="qn-form w-100 position-relative" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-3 row-cols-1 gy-4">
                        <div class="card p-0 border-0 rounded-4 shadow-sm">
                            <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-column gap-1 mb-2">
                                            <h1 class="fs-5 fw-medium mb-0">Data Aset Tidak Normal</h1>
                                            <p class="fs-6 fw-medium text-secondary mb-0">
                                                Pilih dan masukkan data aset dengan problem tidak normal.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputAset" class="form-label">
                                            Nomor Aset 
                                            <span class="text-danger">*</span>
                                            <i 
                                                class="sym sym-info-default"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Data Aset yang muncul adalah aset yang memiliki nama pemegang"
                                            ></i>
                                        </label>
                                        <select class="form-select" id="inputAset" name="aset_id" required>
                                            <option value="" disabled selected>Pilih Nomor Aset</option>
                                            @foreach ($asets as $aset)
                                            <option 
                                                value="{{ $aset->id }}" 
                                                data-merk="{{ $aset->merk_aset }}" 
                                                data-pemegang="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->id : '' }}" 
                                                data-pemegang-nama="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->name_karyawan : '-' }}" 
                                                data-pemegang-info="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? ($aset->endUserAsets->first()->user->team ?? '-') . ' - ' . ($aset->endUserAsets->first()->user->job_role ?? '-') : '-' }}"
                                                {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                                {{ $aset->nomor_aset }}
                                            </option>
                                            @endforeach

                                        </select>                                        
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="inputMerkAset" class="form-label">
                                            Merek Aset <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="inputMerkAset" 
                                            placeholder="Merek Aset" 
                                            value="{{ old('merk_aset') }}" 
                                            readonly />
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="inputPemegangAset" class="form-label">
                                            Nama Pemegang <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            name="pemegang_id"
                                            type="text" 
                                            class="form-control" 
                                            id="inputPemegangAset" 
                                            placeholder="Nama Pemegang" 
                                            value="{{ old('nama_pemegang') }}" 
                                            readonly />
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputPemegangInfo" class="form-label">
                                            Tim - Job Role <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="inputPemegangInfo" 
                                            placeholder="Tim - Job Role" 
                                            value="{{ old('pemegang_info') }}" 
                                            readonly />
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputTanggalLaporan" class="form-label">
                                            Tanggal Laporan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="inputTanggalLaporan" name="tanggal_laporan" 
                                               value="{{ old('tanggal_laporan') }}" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputTanggalKejadian" class="form-label">
                                            Tanggal Kejadian
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="inputTanggalKejadian" name="tanggal_kejadian" 
                                               value="{{ old('tanggal_kejadian') }}" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputDeskripsi" class="form-label">
                                            Deskripsi Permasalahan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="inputDeskripsi" name="deskripsi_permasalahan" placeholder="Masukkan deskripsi permasalahan" required>{{ old('deskripsi_permasalahan') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputSolusi" class="form-label">
                                            Solusi Yang Dilakukan
                                        </label>
                                        <textarea class="form-control" id="inputSolusi" name="solusi" placeholder="Masukkan solusi">{{ old('solusi') }}</textarea>
                                    </div>
                                    <!-- Radio Buttons -->
                                    <div class="col-md-12">
                                        <label class="form-label">
                                            Status Perbaikan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @foreach($statuses as $status)
                                                    @if(in_array($status, ['on_progress']))
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status_perbaikan" id="{{ $status }}" value="{{ $status }}" 
                                                                {{ old('status_perbaikan', 'on_progress') == $status ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="{{ $status }}">
                                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        
                                            <div class="col-md-6">
                                                @foreach($statuses as $status)
                                                    @if(in_array($status, ['selesai']))
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status_perbaikan" id="{{ $status }}" value="{{ $status }}" 
                                                                {{ old('status_perbaikan') == $status ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="{{ $status }}">
                                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputTanggalPerbaikan" class="form-label">
                                            Tanggal Perbaikan
                                        </label>
                                        <input type="date" class="form-control" id="inputTanggalPerbaikan" name="tanggal_perbaikan" 
                                               value="{{ old('tanggal_perbaikan') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputBiayaPerbaikan" class="form-label">
                                            Biaya Perbaikan
                                        </label>
                                        <input type="text" class="form-control" id="inputBiayaPerbaikan" name="biaya_perbaikan" placeholder="Masukkan biaya perbaikan" value="{{ old('biaya_perbaikan') }}"/>
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
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
    var merkAset = selectedOption.getAttribute('data-merk') || '';
    var pemegangNama = selectedOption.getAttribute('data-pemegang-nama') || '-';
    var pemegangInfo = selectedOption.getAttribute('data-pemegang-info') || '-';
    var pemegangId = selectedOption.getAttribute('data-pemegang') || '';

    // Mengisi field tampilan
    document.getElementById('inputMerkAset').value = merkAset;
    document.getElementById('inputPemegangAset').value = pemegangNama;
    document.getElementById('inputPemegangInfo').value = pemegangInfo;


    // Menyimpan pemegang_id dalam input hidden untuk dikirim ke backend
    var pemegangIdInput = document.getElementById('inputPemegangId');
    if (!pemegangIdInput) {
        pemegangIdInput = document.createElement('input');
        pemegangIdInput.type = 'hidden';
        pemegangIdInput.name = 'pemegang_id';
        pemegangIdInput.id = 'inputPemegangId';
        document.getElementById('inputPemegangInfo').parentNode.appendChild(pemegangIdInput);
        document.getElementById('inputPemegangAset').parentNode.appendChild(pemegangIdInput);

    }
    pemegangIdInput.value = pemegangId;
});

// Mengisi kembali data saat reload (kalau validasi gagal)
window.onload = function() {
    var selectedOption = document.getElementById('inputAset').options[document.getElementById('inputAset').selectedIndex];
    if (selectedOption.value) {
        document.getElementById('inputMerkAset').value = selectedOption.getAttribute('data-merk');
        document.getElementById('inputPemegangAset').value = selectedOption.getAttribute('data-pemegang-nama');
        document.getElementById('inputPemegangInfo').value = selectedOption.getAttribute('data-pemegang-info');

        var pemegangIdInput = document.getElementById('inputPemegangId');
        if (!pemegangIdInput) {
            pemegangIdInput = document.createElement('input');
            pemegangIdInput.type = 'hidden';
            pemegangIdInput.name = 'pemegang_id';
            pemegangIdInput.id = 'inputPemegangId';
            document.getElementById('inputPemegangInfo').parentNode.appendChild(pemegangIdInput);
            document.getElementById('inputPemegangAset').parentNode.appendChild(pemegangIdInput);
        }
        pemegangIdInput.value = selectedOption.getAttribute('data-pemegang') || '';
    }
};


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

</script>


@endsection



