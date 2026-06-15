@extends('layouts.admin')

@section('title', 'Formulir Pemeliharaan Aset Operasional')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-maintenance-operasional.index') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Formulir Pemeliharaan Aset IT Operasional</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="advancedForm">
                    Update Data
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST"
                        action="{{ route('aset-maintenance-operasional.update', $asetMaintenanceOperasional->id) }}"
                        id="advancedForm" class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rouned-4 shadown-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pemeliharaan Aset IT Operasional</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Data Aset IT Operasional yang diperbaiki.
                                                </p>
                                            </div>
                                        </div>
                                        {{-- Jenis Pemeliharaan --}}
                                        <div class="col-md-12">
                                            <label class="form-label">Jenis Pemeliharaan<span
                                                    class="text-danger">*</span></label>
                                            <div class="row g-2 px-3">
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('jenis_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="jenis_pemeliharaan" id="jenisPerbaikan"
                                                        value="perbaikan"
                                                        {{ old('jenis_pemeliharaan', $asetMaintenanceOperasional->jenis_pemeliharaan) == 'perbaikan' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenisPerbaikan">
                                                        Perbaikan
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('jenis_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="jenis_pemeliharaan" id="jenisPerawatan"
                                                        value="perawatan"
                                                        {{ old('jenis_pemeliharaan', $asetMaintenanceOperasional->jenis_pemeliharaan) == 'perawatan' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenisPerawatan">
                                                        Perawatan
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('jenis_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="jenis_pemeliharaan" id="jenisPergantian"
                                                        value="pergantian"
                                                        {{ old('jenis_pemeliharaan', $asetMaintenanceOperasional->jenis_pemeliharaan) == 'pergantian' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenisPergantian">
                                                        Pergantian Sparepart
                                                    </label>
                                                </div>
                                            </div>
                                            @error('jenis_pemeliharaan')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- Checkbox Input Manual --}}
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inputManualCheckbox">
                                                <label class="form-check-label" for="inputManualCheckbox">
                                                    Aset tidak tersedia / Input manual
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Data Aset --}}
                                        <div class="col-md-6" id="selectAsetSection">
                                            <label for="inputAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                                <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Data Aset yang muncul adalah aset yang memiliki nama pemegang"></i>
                                            </label>
                                            <select class="form-select" id="inputAset" name="aset_id">
                                                <option value="" disabled selected>Pilih Nomor Aset</option>
                                                @foreach ($asets as $aset)
                                                    <option value="{{ $aset->id }}" data-merk="{{ $aset->merk_aset }}"
                                                        data-jenis-perangkat="{{ $aset->jenisAset->name_jenis ?? '' }}"
                                                        data-pemegang="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->id : '' }}"
                                                        data-pemegang-nama="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->name_karyawan : '-' }}"
                                                        {{ old('aset_id', $asetMaintenanceOperasional->aset_id) == $aset->id ? 'selected' : '' }}>
                                                        {{ $aset->nomor_aset }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="merkAsetSection">
                                            <label for="inputMerkAset" class="form-label">
                                                Merek Aset <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputMerkAset"
                                                placeholder="Merek Aset" value="{{ old('merk_aset') }}" readonly disabled
                                                style="background-color: #e9ecef;" />
                                        </div>
                                        <div class="col-md-3" id="jenisAsetSection">
                                            <label for="inputJenisAset" class="form-label">
                                                Jenis Aset <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJenisAset"
                                                placeholder="Jenis Aset"
                                                value="{{ old('inputJenisAset', isset($asets->name_jenis)) }}" readonly
                                                disabled style="background-color: #e9ecef;" />
                                        </div>

                                        {{-- Manual Input Section --}}
                                        <div class="col-md-12" id="manualInputSection" style="display: none;">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0">Detail Aset Operasional (Manual)</h6>
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            id="addDetailBtn">
                                                            <i class="bi bi-plus"></i> Tambah Aset
                                                        </button>
                                                    </div>
                                                    <div id="detailAsetContainer">
                                                        <!-- Dynamic detail inputs will be added here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="tanggal_pemeliharaan" class="form-label">Tanggal
                                                Pemeliharaan</label>
                                            <input type="date" name="tanggal_pemeliharaan" id="tanggal_pemeliharaan"
                                                class="form-control @error('tanggal_pemeliharaan') is-invalid @enderror"
                                                value="{{ old('tanggal_pemeliharaan', $asetMaintenanceOperasional->tanggal) }}">
                                            @error('tanggal_pemeliharaan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- Petugas IT --}}

                                        <div class="col-md-4">
                                            <label for="petugas_id" class="form-label">Petugas Instalasi<span
                                                    class="text-danger">*</span></label>
                                            <select name="petugas_id" id="petugas_id"
                                                class="form-select @error('user_id') is-invalid @enderror">
                                                <option value="">Pilih User</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('petugas_id', $asetMaintenanceOperasional->petugas->user_id ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="verifikator_id" class="form-label">Verifikator<span
                                                    class="text-danger">*</span></label>
                                            <select name="verifikator_id" id="verifikator_id"
                                                class="form-select @error('user_id') is-invalid @enderror">
                                                <option value="">Pilih User</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('verifikator_id', $asetMaintenanceOperasional->verifikator->user_id ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- status --}}
                                        <div class="col-md-12">
                                            <label class="form-label">Status Pemeliharaan<span
                                                    class="text-danger">*</span></label>
                                            <div class="row g-2 px-3">
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('status_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="status_pemeliharaan" id="statusOnProgress"
                                                        value="on_progress"
                                                        {{ old('status_pemeliharaan', $asetMaintenanceOperasional->status) == 'on_progress' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="statusOnProgress">
                                                        On Progress
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('status_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="status_pemeliharaan" id="statusPending"
                                                        value="pending"
                                                        {{ old('status_pemeliharaan', $asetMaintenanceOperasional->status) == 'pending' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="statusPending">
                                                        Pending
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-4">
                                                    <input
                                                        class="form-check-input @error('status_pemeliharaan') is-invalid @enderror"
                                                        type="radio" name="status_pemeliharaan" id="statusSelesai"
                                                        value="selesai"
                                                        {{ old('status_pemeliharaan', $asetMaintenanceOperasional->status) == 'selesai' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="statusSelesai">
                                                        Seleseai
                                                    </label>
                                                </div>
                                            </div>
                                            @error('status_pemeliharaan')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="deskripsi_permasalahan" class="form-label">Deskripsi
                                                Permasalahan</label>
                                            <textarea name="deskripsi_permasalahan" id="deskripsi_permasalahan" rows="3"
                                                class="form-control @error('deskripsi_permasalahan') is-invalid @enderror"
                                                placeholder="Masukkan Deskripsi Permasalahan">{{ old('deskripsi_permasalahan', $asetMaintenanceOperasional->deskripsi_permasalahan) }}</textarea>
                                            @error('deskripsi_permasalahan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="solusi" class="form-label">Solusi yang Dilakukan</label>
                                            <textarea name="solusi" id="solusi" rows="3" class="form-control @error('solusi') is-invalid @enderror"
                                                placeholder="Solusi yang Dilakukan">{{ old('solusi', $asetMaintenanceOperasional->solusi) }}</textarea>
                                            @error('solusi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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

    <div class="d-block d-md-none rounded-top-4 shadow-lg bg-white"
        style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030;">
        <div class="w-100 d-flex gap-2 p-3">
            <button type="submit" class="btn w-100 btn-primary" form="advancedForm">
                Simpan
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('inputAset').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var merkAset = selectedOption.getAttribute('data-merk') || '';
            var jenisAset = selectedOption.getAttribute('data-jenis-perangkat') || '';

            document.getElementById('inputMerkAset').value = merkAset;
            document.getElementById('inputJenisAset').value = jenisAset;
        });

        // Toggle between select aset and manual input
        document.getElementById('inputManualCheckbox').addEventListener('change', function() {
            const isManual = this.checked;
            const selectAsetSection = document.getElementById('selectAsetSection');
            const merkAsetSection = document.getElementById('merkAsetSection');
            const jenisAsetSection = document.getElementById('jenisAsetSection');
            const manualInputSection = document.getElementById('manualInputSection');
            const inputAset = document.getElementById('inputAset');

            if (isManual) {
                // Hide select sections
                selectAsetSection.style.display = 'none';
                merkAsetSection.style.display = 'none';
                jenisAsetSection.style.display = 'none';

                // Show manual input section
                manualInputSection.style.display = 'block';

                // Remove required from select
                inputAset.removeAttribute('required');
                inputAset.value = '';

                // Add initial detail row if none exists
                if (document.querySelectorAll('.detail-row').length === 0) {
                    addDetailRow();
                }
            } else {
                // Show select sections
                selectAsetSection.style.display = 'block';
                merkAsetSection.style.display = 'block';
                jenisAsetSection.style.display = 'block';

                // Hide manual input section
                manualInputSection.style.display = 'none';

                // Add required to select
                inputAset.setAttribute('required', 'required');

                // Clear manual inputs
                document.getElementById('detailAsetContainer').innerHTML = '';
            }
        });

        // Counter for unique input names
        let detailCounter = 0;

        // Add detail row function
        function addDetailRow() {
            const container = document.getElementById('detailAsetContainer');
            const rowId = 'detail-row-' + detailCounter;

            const rowHtml = `
                <div class="card border mb-3 detail-row" id="${rowId}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Aset #${detailCounter + 1}</h6>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeDetailRow('${rowId}')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Jenis Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis_aset[]" placeholder="Contoh: Access Point, Router, dll" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Detail Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="detail_aset[]" placeholder="Contoh: AP Ruang Meeting" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nomor Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_aset[]" placeholder="Contoh: 003/TIS.VIM/2026" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', rowHtml);
            detailCounter++;
        }

        // Remove detail row function
        function removeDetailRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
            }
        }

        // Add detail button event listener
        document.getElementById('addDetailBtn').addEventListener('click', function() {
            addDetailRow();
        });

        // Load existing data on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger change event to populate merk and jenis aset if aset is selected
            const inputAset = document.getElementById('inputAset');
            if (inputAset.value) {
                inputAset.dispatchEvent(new Event('change'));
            }

            // Load manual detail aset if exists
            @if (
                $asetMaintenanceOperasional->detail_aset_operasional &&
                    is_array($asetMaintenanceOperasional->detail_aset_operasional))
                const detailAsetOperasional = @json($asetMaintenanceOperasional->detail_aset_operasional);
                if (detailAsetOperasional && detailAsetOperasional.length > 0) {
                    // Check manual input checkbox
                    document.getElementById('inputManualCheckbox').checked = true;
                    document.getElementById('inputManualCheckbox').dispatchEvent(new Event('change'));

                    // Add detail rows with existing data
                    detailAsetOperasional.forEach((detail, index) => {
                        addDetailRowWithData(detail['Jenis Aset'], detail['Detail Aset'], detail[
                            'Nomor Aset']);
                    });
                }
            @endif
        });

        // Add detail row with data function
        function addDetailRowWithData(jenisAset = '', detailAset = '', nomorAset = '') {
            const container = document.getElementById('detailAsetContainer');
            const rowId = 'detail-row-' + detailCounter;

            const rowHtml = `
                <div class="card border mb-3 detail-row" id="${rowId}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Aset #${detailCounter + 1}</h6>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeDetailRow('${rowId}')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Jenis Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis_aset[]" placeholder="Contoh: Access Point, Router, dll" value="${jenisAset}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Detail Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="detail_aset[]" placeholder="Contoh: AP Ruang Meeting" value="${detailAset}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nomor Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_aset[]" placeholder="Contoh: 003/TIS.VIM/2026" value="${nomorAset}" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', rowHtml);
            detailCounter++;
        }
    </script>

    <script>
        let isSubmitting = false;

        document.addEventListener('DOMContentLoaded', function() {
            $('#advancedForm').on('submit', function(e) {
                if (isSubmitting) {
                    return true; // Allow form to submit
                }

                e.preventDefault(); // Prevent default submit

                const form = this;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah disimpan tidak bisa diubah lagi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        isSubmitting = true;
                        form.submit(); // Submit form if user confirms
                    }
                });
            });
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
                html: '{!! session('error') !!}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: '<ul style="text-align: left;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        @endif
    </script>
@endsection
