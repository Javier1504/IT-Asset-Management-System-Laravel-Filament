@extends('layouts.admin')

@section('title', 'Page Add Aset Maintenance')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">

        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-maintenance.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Buat Pemeliharaan Aset</span>
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
                    <form method="POST" action="{{ route('aset-maintenance.store') }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pemeliharaan Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data pemeliharaan aset.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputUser" class="form-label">
                                                Nama Petugas IT
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="inputUser" name="petugas_id">
                                                <option value="" selected>Pilih Petugas IT (Admin)</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('petugas_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }} | {{ $user->job_role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Formulir <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="tanggal_surat"
                                                placeholder="Masukkan tanggal formulir" value="{{ old('tanggal_surat') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Jenis Pemeliharaan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                @foreach ($jenisPemeliharaanOptions as $index => $jenis)
                                                    <!-- Menggunakan col-md-4 untuk membagi menjadi 3 kolom -->
                                                    <div class="form-check col-md-4">
                                                        <input class="form-check-input" type="radio"
                                                            name="jenis_pemeliharaan" id="{{ $jenis }}"
                                                            value="{{ $jenis }}"
                                                            {{ old('jenis_pemeliharaan') == $jenis ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="{{ $jenis }}">
                                                            {{ ucfirst(str_replace('_', ' ', $jenis)) }}
                                                        </label>
                                                    </div>
                                                    @if (($index + 1) % 3 == 0)
                                                        <div class="w-100"></div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Maintenance Type Field -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Tipe Pemeliharaan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                @foreach ($maintenanceTypes as $index => $type)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="maintenance_type[]" id="{{ $type }}"
                                                                value="{{ $type }}"
                                                                {{ in_array($type, old('maintenance_type', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $type }}">
                                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputJenisPerangkat" class="form-label">
                                                Jenis Perangkat <span class="text-danger">*</span>
                                            </label>

                                            <select class="form-select select2-cat" id="inputJenisPerangkat"
                                                name="jenis_perangkat[]" multiple="multiple" required>

                                                @foreach ($jenisPerangkat as $jenis)
                                                    <option value="{{ $jenis->jenis_sparepart }}"
                                                        {{ is_array(old('jenis_perangkat')) && in_array($jenis->jenis_sparepart, old('jenis_perangkat')) ? 'selected' : '' }}>
                                                        {{ $jenis->jenis_sparepart }}
                                                    </option>
                                                @endforeach

                                                <option value="other"
                                                    {{ is_array(old('jenis_perangkat')) && in_array('other', old('jenis_perangkat')) ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('jenis_perangkat')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Other Jenis Perangkat Input Fields -->
                                        <div class="col-md-12" id="otherJenisPerangkatContainer"
                                            style="display: {{ is_array(old('jenis_perangkat')) && in_array('other', old('jenis_perangkat')) ? 'block' : 'none' }};">
                                            <label class="form-label">
                                                Jenis Perangkat Lainnya <span class="text-danger">*</span>
                                            </label>
                                            <div id="otherJenisPerangkatFields">
                                                @php
                                                    $otherValues = old('other_jenis_perangkat', ['']);
                                                @endphp
                                                @foreach ($otherValues as $index => $otherValue)
                                                    <div class="d-flex gap-2 mb-2 other-field-group">
                                                        <input type="text" class="form-control"
                                                            name="other_jenis_perangkat[]" value="{{ $otherValue }}"
                                                            placeholder="Masukkan jenis perangkat lainnya"
                                                            {{ is_array(old('jenis_perangkat')) && in_array('other', old('jenis_perangkat')) ? 'required' : 'disabled' }}>
                                                        @if ($index > 0)
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm remove-other-field">
                                                                <i class="sym sym-minus"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                id="addOtherJenisPerangkat">
                                                <i class="sym sym-plus"></i> Tambah Jenis Perangkat Lainnya
                                            </button>
                                            @error('other_jenis_perangkat.*')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                                <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Data Aset yang muncul adalah aset yang memiliki nama pemegang"></i>
                                            </label>
                                            <select class="form-select" id="inputAset" name="aset_id" required>
                                                <option value="" disabled selected>Pilih Nomor Aset</option>
                                                @foreach ($asets as $aset)
                                                    <option value="{{ $aset->id }}"
                                                        data-merk="{{ $aset->merk_aset }}"
                                                        data-jenis-perangkat="{{ $aset->jenisAset->name_jenis ?? '' }}"
                                                        data-pemegang="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->id : '' }}"
                                                        data-pemegang-nama="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->name_karyawan : '-' }}"
                                                        {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                                        {{ $aset->nomor_aset }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputMerkAset" class="form-label">
                                                Merek Aset <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputMerkAset"
                                                placeholder="Merek Aset" value="{{ old('merk_aset') }}" readonly />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputPemegangAset" class="form-label">
                                                Nama Pemegang <span class="text-danger">*</span>
                                            </label>
                                            <input name="pemegang_id" type="text" class="form-control"
                                                id="inputPemegangAset" placeholder="Nama Pemegang"
                                                value="{{ old('nama_pemegang') }}" readonly />
                                        </div>

                                        <!-- Priority Field -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Prioritas Perbaikan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                @foreach ($priorities as $priority)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="priority" id="priority_{{ $priority }}"
                                                                value="{{ $priority }}"
                                                                {{ old('priority', 'medium') == $priority ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="priority_{{ $priority }}">
                                                                @if ($priority == 'low')
                                                                    Rendah
                                                                @elseif($priority == 'medium')
                                                                    Sedang
                                                                @elseif($priority == 'high')
                                                                    Tinggi
                                                                @elseif($priority == 'critical')
                                                                    Kritis
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Potensi Kehilangan Data<span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="missing_data" id="missing_data_yes" value="1"
                                                            {{ old('missing_data') == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="missing_data_yes">
                                                            Ya, ada potensi kehilangan data
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="missing_data" id="missing_data_no" value="0"
                                                            {{ old('missing_data') === '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="missing_data_no">
                                                            Tidak, tidak ada potensi kehilangan data
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('missing_data')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Backup Data (tampil jika missing_data = ya) -->
                                        <div class="col-md-12" id="backupDataContainer"
                                            style="display: {{ old('missing_data') == '1' ? 'block' : 'none' }};">
                                            <label for="inputBackupData" class="form-label">
                                                Keterangan Backup Data <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="inputBackupData" name="backup_data"
                                                placeholder="Tuliskan detail backup yang dilakukan" {{ old('missing_data') == '1' ? 'required' : '' }}>{{ old('backup_data') }}</textarea>
                                            @error('backup_data')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Radio Buttons -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Status Perbaikan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['on_progress']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('status_perbaikan', 'on_progress') == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['pending']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('status_perbaikan') == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    Pending
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['selesai']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('status_perbaikan') == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Pending Reason Field -->
                                        <div class="col-md-12" id="pendingReasonContainer" style="display: none;">
                                            <label for="inputPendingReason" class="form-label">
                                                Alasan Pending <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="inputPendingReason" name="pending_reason" placeholder="Masukkan alasan pending"
                                                rows="3">{{ old('pending_reason') }}</textarea>
                                            @error('pending_reason')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputDeskripsi" class="form-label">
                                                Deskripsi Permasalahan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="inputDeskripsi" name="deskripsi_permasalahan"
                                                placeholder="Masukkan deskripsi permasalahan" required>{{ old('deskripsi_permasalahan') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputSolusi" class="form-label">
                                                Solusi Yang Dilakukan
                                            </label>
                                            <textarea class="form-control" id="inputSolusi" name="solusi" placeholder="Masukkan solusi">{{ old('solusi') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputKeterangan" class="form-label">
                                                Keterangan Tambahan
                                            </label>
                                            <textarea class="form-control" id="inputKeterangan" name="keterangan" placeholder="Masukkan keterangan">{{ old('keterangan') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputCatatan" class="form-label">
                                                Catatan
                                            </label>
                                            <textarea class="form-control" id="inputCatatan" name="catatan" placeholder="Masukkan catatan">{{ old('catatan') }}</textarea>
                                        </div>
                                        <!-- Radio Buttons -->
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                Kebutuhan Sparepart
                                            </label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @foreach ($kebutuhan as $status)
                                                        @if (in_array($status, ['perlu_dibelikan']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="kebutuhan_sparepart" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('kebutuhan_sparepart') == $status ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach ($kebutuhan as $status)
                                                        @if (in_array($status, ['done']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="kebutuhan_sparepart" id="{{ $status }}"
                                                                    value="{{ $status }}"
                                                                    {{ old('kebutuhan_sparepart') == $status ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="{{ $status }}">
                                                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Sparepart</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data sparepart.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Button "Tambah Sparepart Item" -->
                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#assetModal">
                                                <i class="sym sym-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2" id="selectedSparepartTable"
                                                style="max-height:500px; overflow-y:auto; display:block;">
                                                <table class="table table-bordered align-middle">
                                                    <thead class="align-middle">
                                                        <tr class="table-light">
                                                            <th style="min-width: 36px; width: 36px;">No</th>
                                                            <th style="min-width: 180px;">Sparepart Item</th>
                                                            <th style="min-width: 180px;">Qty</th>
                                                            <th style="min-width: 180px;">Merk Sparepart</th>
                                                            <th class="text-center" style="width: 124px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selectedSparepartBody">
                                                        <!-- This section will dynamically update with selected assets -->
                                                    </tbody>
                                                </table>
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
        @include('AsetMaintenance.partials.modal-sparepart')
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
        $(document).ready(function() {
            $('.select2-cat').select2({
                placeholder: "Pilih Jenis Perangkat",
                allowClear: true,
                width: '100%' // Ubah dari '100' menjadi '100%'
            });
        });
    </script>


    <script>
        document.getElementById('inputAset').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var merkAset = selectedOption.getAttribute('data-merk') || '';
            var pemegangNama = selectedOption.getAttribute('data-pemegang-nama') || '-';
            var pemegangId = selectedOption.getAttribute('data-pemegang') || '';

            // Mengisi field tampilan nama pemegang
            document.getElementById('inputMerkAset').value = merkAset;
            document.getElementById('inputPemegangAset').value = pemegangNama;

            // Menyimpan pemegang_id dalam input hidden agar dikirim ke backend
            var pemegangIdInput = document.getElementById('inputPemegangId');
            if (!pemegangIdInput) {
                pemegangIdInput = document.createElement('input');
                pemegangIdInput.type = 'hidden';
                pemegangIdInput.name = 'pemegang_id';
                pemegangIdInput.id = 'inputPemegangId';
                document.getElementById('inputPemegangAset').parentNode.appendChild(pemegangIdInput);
            }
            pemegangIdInput.value = pemegangId;
        });

        // Mengisi kembali data saat halaman reload karena validasi gagal
        window.onload = function() {
            var selectedOption = document.getElementById('inputAset').options[document.getElementById('inputAset')
                .selectedIndex];
            if (selectedOption.value) {
                document.getElementById('inputMerkAset').value = selectedOption.getAttribute('data-merk');
                document.getElementById('inputPemegangAset').value = selectedOption.getAttribute('data-pemegang-nama');

                var pemegangIdInput = document.getElementById('inputPemegangId');
                if (!pemegangIdInput) {
                    pemegangIdInput = document.createElement('input');
                    pemegangIdInput.type = 'hidden';
                    pemegangIdInput.name = 'pemegang_id';
                    pemegangIdInput.id = 'inputPemegangId';
                    document.getElementById('inputPemegangAset').parentNode.appendChild(pemegangIdInput);
                }
                pemegangIdInput.value = selectedOption.getAttribute('data-pemegang') || '';
            }
        };
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        }) // Konfirmasi sebelum mengirim form
    </script>

    <script>
        // Tampilkan/sembunyikan field backup_data berdasarkan pilihan missing_data
        function updateBackupFieldVisibility() {
            var selected = document.querySelector('input[name="missing_data"]:checked');
            var container = document.getElementById('backupDataContainer');
            var textarea = document.getElementById('inputBackupData');
            if (!container || !textarea) return;

            if (selected && selected.value === '1') {
                container.style.display = 'block';
                textarea.setAttribute('required', 'required');
            } else {
                container.style.display = 'none';
                textarea.removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateBackupFieldVisibility();
            document.querySelectorAll('input[name="missing_data"]').forEach(function(el) {
                el.addEventListener('change', updateBackupFieldVisibility);
            });

            initializeOtherJenisPerangkat();
        });

        // Other Jenis Perangkat Functions
        function initializeOtherJenisPerangkat() {
            const select = document.getElementById('inputJenisPerangkat');
            const container = document.getElementById('otherJenisPerangkatContainer');

            // Initialize state on page load
            const initialSelectedValues = $(select).val() || [];
            if (initialSelectedValues.includes('other')) {
                container.style.display = 'block';
                updateOtherFieldsRequired(true);
            } else {
                container.style.display = 'none';
                updateOtherFieldsRequired(false);
            }

            // Handle select change
            $(select).on('change', function() {
                const selectedValues = $(this).val() || [];
                if (selectedValues.includes('other')) {
                    container.style.display = 'block';
                    updateOtherFieldsRequired(true);
                } else {
                    container.style.display = 'none';
                    updateOtherFieldsRequired(false);
                }
            });

            // Add new other field
            document.getElementById('addOtherJenisPerangkat').addEventListener('click', function() {
                addOtherJenisPerangkatField();
            });

            // Remove other field
            attachRemoveOtherFieldListeners();
        }

        function addOtherJenisPerangkatField() {
            const fieldsContainer = document.getElementById('otherJenisPerangkatFields');
            const fieldGroup = document.createElement('div');
            fieldGroup.className = 'd-flex gap-2 mb-2 other-field-group';

            // Check if container is visible to determine if field should be required
            const container = document.getElementById('otherJenisPerangkatContainer');
            const isVisible = container.style.display !== 'none';

            fieldGroup.innerHTML = `
                <input type="text" class="form-control" name="other_jenis_perangkat[]"
                    value="" placeholder="Masukkan jenis perangkat lainnya" ${isVisible ? 'required' : 'disabled'}>
                <button type="button" class="btn btn-outline-danger btn-sm remove-other-field">
                    <i class="sym sym-trash"></i>
                </button>
            `;

            fieldsContainer.appendChild(fieldGroup);
            attachRemoveOtherFieldListeners();
        }

        function attachRemoveOtherFieldListeners() {
            document.querySelectorAll('.remove-other-field').forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            document.querySelectorAll('.remove-other-field').forEach(button => {
                button.addEventListener('click', function() {
                    const fieldsContainer = document.getElementById('otherJenisPerangkatFields');
                    const fieldGroups = fieldsContainer.querySelectorAll('.other-field-group');

                    if (fieldGroups.length > 1) {
                        this.closest('.other-field-group').remove();
                    }
                });
            });
        }

        function updateOtherFieldsRequired(required) {
            const otherFields = document.querySelectorAll('input[name="other_jenis_perangkat[]"]');
            otherFields.forEach(field => {
                if (required) {
                    field.setAttribute('required', 'required');
                    field.disabled = false;
                } else {
                    field.removeAttribute('required');
                    field.disabled = true;
                    field.value = '';
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('selectedSpareparts')) {
                localStorage.removeItem('selectedSpareparts');
            }

            renderSelectedSpareparts();
            attachSelectSparepartListeners();
        });


        function saveSparepartToLocalStorage(sparepart) {
            const selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];

            selectedSpareparts.push(sparepart);
            localStorage.setItem('selectedSpareparts', JSON.stringify(selectedSpareparts));
            return true;
        }

        function removeSparepartFromLocalStorage(index) {
            let selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];
            selectedSpareparts.splice(index, 1);
            localStorage.setItem('selectedSpareparts', JSON.stringify(selectedSpareparts));
            return true;
        }

        function renderSelectedSpareparts() {
            const selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];
            const tbody = document.getElementById('selectedSparepartBody');
            tbody.innerHTML = '';

            selectedSpareparts.forEach((sparepart, index) => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td>${sparepart.jenis}</td>
                <td>
                    <input type="number" name="sparepart_qty[]" class="form-control" value="${sparepart.qty}" min="1" required />
                    <input type="hidden" name="sparepart_id[]" value="${sparepart.id}" />
                </td>
                <td>${sparepart.merk}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm removeSparepart" data-index="${index}">
                        <i class="sym sym-trash-solid"></i>
                    </button>
                </td>
            `;

                tbody.appendChild(tr);
            });

            attachRemoveSparepartListeners();
        }

        function attachSelectSparepartListeners() {
            document.querySelectorAll('.pilihAset').forEach(button => {
                button.addEventListener('click', function() {
                    const sparepart = {
                        id: this.getAttribute('data-sparepart-id'),
                        jenis: this.getAttribute('data-jenis'),
                        merk: this.getAttribute('data-merk'),
                        qty: 1 // Default qty
                    };

                    if (saveSparepartToLocalStorage(sparepart)) {
                        renderSelectedSpareparts();
                        // Tutup modal setelah memilih
                        const assetModal = bootstrap.Modal.getInstance(document.getElementById(
                            'assetModal'));
                        assetModal.hide();
                    }
                });
            });
        }

        function attachRemoveSparepartListeners() {
            document.querySelectorAll('.removeSparepart').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    if (removeSparepartFromLocalStorage(index)) {
                        renderSelectedSpareparts();
                    }
                });
            });
        }

        function openAssetModal() {
            const assetModal = new bootstrap.Modal(document.getElementById('assetModal'));
            assetModal.show();
        }
    </script>
@endsection
