@extends('layouts.admin')

@section('title', 'Page Edit Bast Pengembalian')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-maintenance.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Pemeliharaan Aset</span>
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
                    <form method="POST" action="{{ route('aset-maintenance.update', $asetMaintenance->id) }}"
                        id="advancedForm" class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Edit Data Pemeliharaan Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Perbarui data pemeliharaan aset.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputUser" class="form-label">Nama Petugas IT<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="inputUser" name="petugas_id" required>
                                                <option value="" disabled
                                                    {{ empty($asetMaintenance->petugas_id) ? 'selected' : '' }}>Pilih
                                                    Pengguna (Admin)</option>
                                                @foreach ($users as $user)
                                                    @if (strtolower($user->role ?? '') === 'admin')
                                                        <option value="{{ $user->id }}"
                                                            {{ (int) $asetMaintenance->petugas_id === (int) $user->id ? 'selected' : '' }}>
                                                            {{ $user->name_karyawan }} | {{ $user->job_role }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputTanggalSurat" class="form-label">Tanggal Formulir<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="inputTanggalSurat"
                                                name="tanggal_surat" value="{{ $asetMaintenance->tanggal_surat }}"
                                                required />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Jenis Pemeliharaan<span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                @foreach ($jenisPemeliharaanOptions as $index => $jenis)
                                                    <div class="form-check col-md-4">
                                                        <input class="form-check-input" type="radio"
                                                            name="jenis_pemeliharaan" id="{{ $jenis }}"
                                                            value="{{ $jenis }}"
                                                            {{ (is_array($asetMaintenance->jenis_pemeliharaan) && in_array($jenis, $asetMaintenance->jenis_pemeliharaan)) || $asetMaintenance->jenis_pemeliharaan == $jenis ? 'checked' : '' }}
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
                                                                {{ in_array($type, $asetMaintenance->maintenance_type ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $type }}">
                                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @if (($index + 1) % 3 == 0)
                                                        <div class="w-100"></div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="inputJenisPerangkat" class="form-label">
                                                Jenis Perangkat <span class="text-danger">*</span>
                                            </label>

                                            <select class="form-select select2-cat" id="inputJenisPerangkat"
                                                name="jenis_perangkat[]" multiple="multiple" required>

                                                @php
                                                    // Gunakan data yang sudah diproses dari controller
                                                    $selectedJenisPerangkat = old(
                                                        'jenis_perangkat',
                                                        $jenisPerangkatDatabase ?? [],
                                                    );
                                                    $otherValues = old(
                                                        'other_jenis_perangkat',
                                                        $otherJenisPerangkat ?? [],
                                                    );
                                                @endphp

                                                @foreach ($jenisPerangkat as $jenis)
                                                    <option value="{{ $jenis->jenis_sparepart }}"
                                                        {{ in_array($jenis->jenis_sparepart, $selectedJenisPerangkat) ? 'selected' : '' }}>
                                                        {{ $jenis->jenis_sparepart }}
                                                    </option>
                                                @endforeach

                                                <option value="other"
                                                    {{ in_array('other', $selectedJenisPerangkat) ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('jenis_perangkat')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Other Jenis Perangkat Input Fields -->
                                        <div class="col-md-12" id="otherJenisPerangkatContainer"
                                            style="display: {{ in_array('other', $selectedJenisPerangkat) ? 'block' : 'none' }};">
                                            <label class="form-label">
                                                Jenis Perangkat Lainnya <span class="text-danger">*</span>
                                            </label>
                                            <div id="otherJenisPerangkatFields">
                                                @if (!empty($otherValues))
                                                    @foreach ($otherValues as $index => $otherValue)
                                                        <div class="d-flex gap-2 mb-2 other-field-group">
                                                            <input type="text" class="form-control"
                                                                name="other_jenis_perangkat[]" value="{{ $otherValue }}"
                                                                placeholder="Masukkan jenis perangkat lainnya"
                                                                {{ in_array('other', $selectedJenisPerangkat) ? 'required' : 'disabled' }}>
                                                            @if ($index > 0 || count($otherValues) > 1)
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm remove-other-field">
                                                                    <i class="sym sym-minus"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="d-flex gap-2 mb-2 other-field-group">
                                                        <input type="text" class="form-control"
                                                            name="other_jenis_perangkat[]" value=""
                                                            placeholder="Masukkan jenis perangkat lainnya"
                                                            {{ in_array('other', $selectedJenisPerangkat) ? 'required' : 'disabled' }}>
                                                    </div>
                                                @endif
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
                                                <option value="" disabled>Pilih Nomor Aset</option>
                                                @foreach ($asets as $aset)
                                                    <option value="{{ $aset->id }}"
                                                        data-merk="{{ $aset->merk_aset }}"
                                                        data-jenis-perangkat="{{ $aset->jenisAset->name_jenis ?? '' }}"
                                                        data-pemegang="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->id : '' }}"
                                                        data-pemegang-nama="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->name_karyawan : '-' }}"
                                                        {{ old('aset_id', $selectedAsetId ?? '') == $aset->id ? 'selected' : '' }}>
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
                                                placeholder="Merek Aset"
                                                value="{{ old('merk_aset', $selectedMerk ?? '') }}" readonly />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputPemegangAset" class="form-label">
                                                Nama Pemegang <span class="text-danger">*</span>
                                            </label>
                                            <input name="pemegang_id" type="text" class="form-control"
                                                id="inputPemegangAset" placeholder="Nama Pemegang"
                                                value="{{ old('nama_pemegang', $selectedPemegangNama ?? '') }}"
                                                readonly />
                                            <input type="hidden" name="pemegang_id" id="inputPemegangId"
                                                value="{{ old('pemegang_id', $selectedPemegangId ?? '') }}" />
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
                                                                {{ ($asetMaintenance->priority ?? 'medium') == $priority ? 'checked' : '' }}
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
                                                            {{ old('missing_data', (int) ($asetMaintenance->missing_data ?? 0)) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="missing_data_yes">Ya, ada
                                                            potensi kehilangan data</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="missing_data" id="missing_data_no" value="0"
                                                            {{ old('missing_data', (int) ($asetMaintenance->missing_data ?? 0)) == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="missing_data_no">Tidak, tidak
                                                            ada potensi kehilangan data</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('missing_data')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12" id="backupDataContainer"
                                            style="display: {{ old('missing_data', (int) ($asetMaintenance->missing_data ?? 0)) == 1 ? 'block' : 'none' }};">
                                            <label for="inputBackupData" class="form-label">Keterangan Backup Data <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="inputBackupData" name="backup_data"
                                                placeholder="Tuliskan detail backup yang dilakukan"
                                                {{ old('missing_data', (int) ($asetMaintenance->missing_data ?? 0)) == 1 ? 'required' : '' }}>{{ old('backup_data', $asetMaintenance->backup_data ?? '') }}</textarea>
                                            @error('backup_data')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Status Perbaikan<span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['on_progress']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" value="{{ $status }}"
                                                                    {{ $asetMaintenance->status_perbaikan == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label
                                                                    class="form-check-label">{{ ucwords(str_replace('_', ' ', $status)) }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['pending']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" value="{{ $status }}"
                                                                    {{ $asetMaintenance->status_perbaikan == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label">Pending</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-md-4">
                                                    @foreach ($statuses as $status)
                                                        @if (in_array($status, ['selesai']))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status_perbaikan" value="{{ $status }}"
                                                                    {{ $asetMaintenance->status_perbaikan == $status ? 'checked' : '' }}
                                                                    required>
                                                                <label
                                                                    class="form-check-label">{{ ucwords(str_replace('_', ' ', $status)) }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pending Reason Field -->
                                        <div class="col-md-12" id="pendingReasonContainer"
                                            style="display: {{ $asetMaintenance->status_perbaikan == 'pending' ? 'block' : 'none' }};">
                                            <label for="inputPendingReason" class="form-label">
                                                Alasan Pending <span class="text-danger">*</span>
                                            </label>

                                            <select class="form-select select2-pending" id="inputPendingReason"
                                                name="pending_reason[]" multiple="multiple"
                                                {{ $asetMaintenance->status_perbaikan == 'pending' ? 'required' : '' }}>

                                                @php
                                                    // Ambil old values jika ada, atau gunakan data dari controller
                                                    $currentPendingReasons = old('pending_reason', $selectedPendingReasons ?? []);
                                                    $currentOtherReasons = old('other_pending_reason', $otherPendingReasons ?? []);
                                                @endphp

                                                @foreach ($alasanPending as $alasan)
                                                    <option value="{{ $alasan }}"
                                                        {{ in_array($alasan, $currentPendingReasons) ? 'selected' : '' }}>
                                                        {{ $alasan }}
                                                    </option>
                                                @endforeach

                                                <option value="other"
                                                    {{ in_array('other', $currentPendingReasons) ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('pending_reason')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Other Pending Reason Input Fields -->
                                        <div class="col-md-12" id="otherPendingReasonContainer"
                                            style="display: {{ in_array('other', $currentPendingReasons ?? []) ? 'block' : 'none' }};">
                                            <label class="form-label">
                                                Alasan Pending Lainnya <span class="text-danger">*</span>
                                            </label>
                                            <div id="otherPendingReasonFields">
                                                @if (!empty($currentOtherReasons))
                                                    @foreach ($currentOtherReasons as $index => $otherReason)
                                                        <div class="d-flex gap-2 mb-2 other-pending-field-group">
                                                            <input type="text" class="form-control"
                                                                name="other_pending_reason[]" value="{{ $otherReason }}"
                                                                placeholder="Masukkan alasan pending lainnya"
                                                                {{ in_array('other', $currentPendingReasons ?? []) ? 'required' : 'disabled' }}>
                                                            @if ($index > 0 || count($currentOtherReasons) > 1)
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm remove-other-pending-field">
                                                                    <i class="sym sym-minus"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="d-flex gap-2 mb-2 other-pending-field-group">
                                                        <input type="text" class="form-control"
                                                            name="other_pending_reason[]" value=""
                                                            placeholder="Masukkan alasan pending lainnya"
                                                            {{ in_array('other', $currentPendingReasons ?? []) ? 'required' : 'disabled' }}>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                id="addOtherPendingReason">
                                                <i class="sym sym-plus"></i> Tambah Alasan Lainnya
                                            </button>
                                            @error('other_pending_reason.*')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputDeskripsi" class="form-label">Deskripsi Permasalahan<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="inputDeskripsi" name="deskripsi_permasalahan" required>{{ $asetMaintenance->deskripsi_permasalahan }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputSolusi" class="form-label">Solusi Yang Dilakukan</label>
                                            <textarea class="form-control" id="inputSolusi" name="solusi">{{ $asetMaintenance->solusi }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputKeterangan" class="form-label">Keterangan Tambahan</label>
                                            <textarea class="form-control" id="inputKeterangan" name="keterangan">{{ $asetMaintenance->keterangan }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputCatatan" class="form-label">Catatan</label>
                                            <textarea class="form-control" id="inputCatatan" name="catatan">{{ $asetMaintenance->catatan }}</textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Kebutuhan Sparepart</label>
                                            <div class="row">
                                                @foreach ($kebutuhan as $status)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="kebutuhan_sparepart" id="{{ $status }}"
                                                                value="{{ $status }}"
                                                                {{ $asetMaintenance->kebutuhan_sparepart == $status ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $status }}">
                                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Sparepart</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan atau ubah data sparepart.
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
                                                        @if (isset($selectedSpareparts) && $selectedSpareparts->count())
                                                            @foreach ($selectedSpareparts as $index => $sel)
                                                                <tr>
                                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                                    <td>{{ $sel->sparepart->jenisSparepart->jenis_sparepart ?? '-' }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" name="sparepart_qty[]"
                                                                            class="form-control"
                                                                            value="{{ $sel->qty }}" min="1"
                                                                            required />
                                                                        <input type="hidden" name="sparepart_id[]"
                                                                            value="{{ $sel->sparepart_id }}" />
                                                                    </td>
                                                                    <td>{{ $sel->sparepart->nama_sparepart ?? '-' }}</td>
                                                                    <td class="text-center">
                                                                        <button type="button"
                                                                            class="btn btn-outline-danger btn-sm removeSparepart"
                                                                            data-index="{{ $index }}"> <i
                                                                                class="sym sym-trash-solid"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
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
        $(document).ready(function() {
            $('.select2-cat').select2({
                placeholder: "Pilih Jenis Perangkat",
                allowClear: true,
                width: '100%'
            });

            $('.select2-pending').select2({
                placeholder: "Pilih Alasan Pending",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bersihkan localStorage saat halaman edit dimuat
            localStorage.removeItem('selectedSpareparts');

            // Inisialisasi listener untuk tombol hapus yang sudah ada
            attachRemoveSparepartListeners();
            attachSelectSparepartListeners();
        });

        // Fungsi untuk menyimpan sparepart baru ke localStorage (hanya untuk yang baru ditambah)
        function saveSparepartToLocalStorage(sparepart) {
            const selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];
            selectedSpareparts.push(sparepart);
            localStorage.setItem('selectedSpareparts', JSON.stringify(selectedSpareparts));
            return true;
        }

        // Fungsi untuk menghapus sparepart dari localStorage berdasarkan index
        function removeSparepartFromLocalStorage(index) {
            let selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];
            selectedSpareparts.splice(index, 1);
            localStorage.setItem('selectedSpareparts', JSON.stringify(selectedSpareparts));
            return true;
        }

        // Fungsi untuk menambahkan row sparepart baru
        function appendSparepartRow(sparepart, source = 'local') {
            const tbody = document.getElementById('selectedSparepartBody');
            const currentRowCount = tbody.children.length;
            const rowNumber = currentRowCount + 1;

            const tr = document.createElement('tr');

            // Hanya beri data-index untuk row yang berasal dari localStorage
            let dataIndexAttr = '';
            if (source === 'local') {
                const selectedSpareparts = JSON.parse(localStorage.getItem('selectedSpareparts')) || [];
                const localIndex = selectedSpareparts.length - 1;
                dataIndexAttr = `data-index="${localIndex}" data-source="local"`;
            } else {
                dataIndexAttr = `data-source="server"`;
            }

            tr.innerHTML = `
        <td class="text-center">${rowNumber}</td>
        <td>${sparepart.jenis}</td>
        <td>
            <input type="number" name="sparepart_qty[]" class="form-control" value="${sparepart.qty}" min="1" required />
            <input type="hidden" name="sparepart_id[]" value="${sparepart.id}" />
        </td>
        <td>${sparepart.merk}</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger removeSparepart" ${dataIndexAttr}>
                <i class="sym sym-trash-solid"></i>
            </button>
        </td>
    `;
            tbody.appendChild(tr);

            // Update nomor urut semua baris
            updateRowNumbers();
        }

        // Fungsi untuk update nomor urut
        function updateRowNumbers() {
            const tbody = document.getElementById('selectedSparepartBody');
            Array.from(tbody.children).forEach((tr, idx) => {
                const cell = tr.querySelector('td:first-child');
                if (cell) cell.textContent = idx + 1;
            });
        }

        // Listener untuk tombol "Pilih" di modal
        function attachSelectSparepartListeners() {
            document.querySelectorAll('.pilihAset').forEach(button => {
                button.addEventListener('click', function() {
                    const sparepartId = this.getAttribute('data-sparepart-id');
                    const tbody = document.getElementById('selectedSparepartBody');

                    // Cek apakah sparepart sudah ada di tabel (baik dari server maupun localStorage)
                    const existingRows = Array.from(tbody.querySelectorAll('input[name="sparepart_id[]"]'));
                    const isAlreadySelected = existingRows.some(input => input.value === sparepartId);

                    if (isAlreadySelected) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Sparepart ini sudah dipilih!',
                            timer: 2000
                        });
                        return;
                    }

                    // Buat object sparepart baru
                    const sparepart = {
                        id: sparepartId,
                        jenis: this.getAttribute('data-jenis'),
                        merk: this.getAttribute('data-merk'),
                        qty: 1
                    };

                    // Simpan ke localStorage
                    saveSparepartToLocalStorage(sparepart);

                    // Tambahkan row baru
                    appendSparepartRow(sparepart, 'local');

                    // Attach listener untuk tombol hapus
                    attachRemoveSparepartListeners();

                    // Tutup modal
                    const assetModal = bootstrap.Modal.getInstance(document.getElementById('assetModal'));
                    if (assetModal) {
                        assetModal.hide();
                    }
                });
            });
        }

        // Listener untuk tombol hapus
        function attachRemoveSparepartListeners() {
            document.querySelectorAll('.removeSparepart').forEach(button => {
                // Hapus listener lama jika ada
                button.replaceWith(button.cloneNode(true));
            });

            // Attach listener baru
            document.querySelectorAll('.removeSparepart').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const source = this.getAttribute('data-source');
                    const index = this.getAttribute('data-index');

                    // Konfirmasi sebelum hapus
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus sparepart ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika dari localStorage, hapus dari localStorage
                            if (source === 'local' && index !== null && index !== '') {
                                removeSparepartFromLocalStorage(parseInt(index, 10));

                                // Update data-index untuk row lain yang berasal dari localStorage
                                const localRows = document.querySelectorAll(
                                    '.removeSparepart[data-source="local"]');
                                localRows.forEach((btn, idx) => {
                                    if (btn !== button) {
                                        const currentIndex = parseInt(btn.getAttribute(
                                            'data-index'));
                                        if (currentIndex > parseInt(index)) {
                                            btn.setAttribute('data-index', currentIndex -
                                                1);
                                        }
                                    }
                                });
                            }

                            // Hapus row dari tampilan
                            if (row) {
                                row.remove();
                            }

                            // Update nomor urut
                            updateRowNumbers();

                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: 'Sparepart berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                });
            });
        }

        // Fungsi untuk membuka modal
        function openAssetModal() {
            const assetModal = new bootstrap.Modal(document.getElementById('assetModal'));
            assetModal.show();
        }

        // Update fields untuk Aset, Merk, dan Pemegang
        document.addEventListener('DOMContentLoaded', function() {
            function updateFields() {
                var inputAset = document.getElementById('inputAset');
                var selectedOption = inputAset.options[inputAset.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    document.getElementById('inputMerkAset').value = selectedOption.getAttribute('data-merk') || '';
                    document.getElementById('inputPemegangAset').value = selectedOption.getAttribute(
                        'data-pemegang-nama') || '-';

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
            }

            document.getElementById('inputAset').addEventListener('change', updateFields);
            updateFields();
        });

        // Tampilkan/sembunyikan field backup_data
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

        // Tampilkan/sembunyikan field pending reason
        function updatePendingReasonVisibility() {
            var selected = document.querySelector('input[name="status_perbaikan"]:checked');
            var container = document.getElementById('pendingReasonContainer');
            var select = document.getElementById('inputPendingReason');
            if (!container || !select) return;

            if (selected && selected.value === 'pending') {
                container.style.display = 'block';
                select.setAttribute('required', 'required');
            } else {
                container.style.display = 'none';
                select.removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateBackupFieldVisibility();
            document.querySelectorAll('input[name="missing_data"]').forEach(function(el) {
                el.addEventListener('change', updateBackupFieldVisibility);
            });

            updatePendingReasonVisibility();
            document.querySelectorAll('input[name="status_perbaikan"]').forEach(function(el) {
                el.addEventListener('change', updatePendingReasonVisibility);
            });

            initializeOtherJenisPerangkat();
            initializeOtherPendingReason();
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

        // Other Pending Reason Functions
        function initializeOtherPendingReason() {
            const select = document.getElementById('inputPendingReason');
            const container = document.getElementById('otherPendingReasonContainer');

            // Initialize state on page load
            const initialSelectedValues = $(select).val() || [];
            if (initialSelectedValues.includes('other')) {
                container.style.display = 'block';
                updateOtherPendingFieldsRequired(true);
            } else {
                container.style.display = 'none';
                updateOtherPendingFieldsRequired(false);
            }

            // Handle select change
            $(select).on('change', function() {
                const selectedValues = $(this).val() || [];
                if (selectedValues.includes('other')) {
                    container.style.display = 'block';
                    updateOtherPendingFieldsRequired(true);
                } else {
                    container.style.display = 'none';
                    updateOtherPendingFieldsRequired(false);
                }
            });

            // Add new other field
            document.getElementById('addOtherPendingReason').addEventListener('click', function() {
                addOtherPendingReasonField();
            });

            // Remove other field
            attachRemoveOtherPendingFieldListeners();
        }

        function addOtherPendingReasonField() {
            const fieldsContainer = document.getElementById('otherPendingReasonFields');
            const fieldGroup = document.createElement('div');
            fieldGroup.className = 'd-flex gap-2 mb-2 other-pending-field-group';

            // Check if container is visible to determine if field should be required
            const container = document.getElementById('otherPendingReasonContainer');
            const isVisible = container.style.display !== 'none';

            fieldGroup.innerHTML = `
                <input type="text" class="form-control" name="other_pending_reason[]"
                    value="" placeholder="Masukkan alasan pending lainnya" ${isVisible ? 'required' : 'disabled'}>
                <button type="button" class="btn btn-outline-danger btn-sm remove-other-pending-field">
                    <i class="sym sym-trash"></i>
                </button>
            `;

            fieldsContainer.appendChild(fieldGroup);
            attachRemoveOtherPendingFieldListeners();
        }

        function attachRemoveOtherPendingFieldListeners() {
            document.querySelectorAll('.remove-other-pending-field').forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            document.querySelectorAll('.remove-other-pending-field').forEach(button => {
                button.addEventListener('click', function() {
                    const fieldsContainer = document.getElementById('otherPendingReasonFields');
                    const fieldGroups = fieldsContainer.querySelectorAll('.other-pending-field-group');

                    if (fieldGroups.length > 1) {
                        this.closest('.other-pending-field-group').remove();
                    }
                });
            });
        }

        function updateOtherPendingFieldsRequired(required) {
            const otherFields = document.querySelectorAll('input[name="other_pending_reason[]"]');
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

@endsection
