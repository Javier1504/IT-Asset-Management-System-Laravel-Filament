@extends('layouts.admin')

@section('title', 'Formulir Instalasi Aset')

@section('content')
    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('instalasi-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Formulir Instalasi Aset</span>
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
        <!-- [START] Content -->
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('instalasi-aset.update', $instalasiAset->id) }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rouned-4 shadown-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset & Penerimaan</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Data Aset yang akan diinstall ulang dan penerima aset setelah proses
                                                    instalasi selesai.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ba_pengembalian_id" class="form-label">BA Pengembalian</label>
                                            <select name="ba_pengembalian_id" id="ba_pengembalian_id"
                                                class="form-select @error('ba_pengembalian_id') is-invalid @enderror">
                                                <option value="">Pilih BA Pengembalian</option>
                                                @foreach ($baPengembalian as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-aset-ids="{{ $item->bastPengembalianDetails->pluck('endUserAset.aset_id')->filter()->toJson() }}"
                                                        {{ old('ba_pengembalian_id', $instalasiAset->ba_pengembalian_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nomor_surat }} - {{ $item->pengembali->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ba_pengembalian_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_instalasi" class="form-label">Tanggal Instalasi</label>
                                            <input type="date" name="tanggal_instalasi" id="tanggal_instalasi"
                                                class="form-control @error('tanggal_instalasi') is-invalid @enderror"
                                                value="{{ old('tanggal_instalasi', $instalasiAset->tanggal_surat) }}">
                                            @error('tanggal_instalasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAset" class="form-label">
                                                Nomor Aset
                                                <span class="text-danger">*</span>
                                                <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Data Aset yang muncul adalah aset yang memiliki nama pemegang"></i>
                                            </label>
                                            <input type="hidden" name="aset_id" id="hiddenAsetId" value="{{ old('aset_id', $instalasiAset->aset_id) }}">
                                            <select class="form-select" id="inputAset" disabled style="background-color: #e9ecef;">
                                                <option value="" disabled selected>Pilih Nomor Aset</option>
                                                @foreach ($asets as $aset)
                                                    <option value="{{ $aset->id }}" data-merk="{{ $aset->merk_aset }}"
                                                        data-jenis-perangkat="{{ $aset->jenisAset->name_jenis ?? '' }}"
                                                        data-pemegang="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->id : '' }}"
                                                        data-pemegang-nama="{{ $aset->endUserAsets->first() && $aset->endUserAsets->first()->user ? $aset->endUserAsets->first()->user->name_karyawan : '-' }}"
                                                        {{ old('aset_id', $instalasiAset->aset_id) == $aset->id ? 'selected' : '' }}>
                                                        {{ $aset->nomor_aset }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="inputMerkAset" class="form-label">
                                                Merek Aset <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputMerkAset"
                                                placeholder="Merek Aset"
                                                value="{{ old('merk_aset', $instalasiAset->aset->merk_aset ?? '') }}"
                                                readonly disabled style="background-color: #e9ecef;" />
                                        </div>

                                        <div class="col-md-3">
                                            <label for="os_sebelumnya" class="form-label">
                                                Sistem Operasi Sebelumnya <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="os_sebelumnya"
                                                name="os_sebelumnya" placeholder="Sistem Operasi Sebelumnya"
                                                value="{{ old('os_sebelumnya', $instalasiAset->os_sebelumnya) }}"
                                                required />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="petugas_id" class="form-label">Petugas Instalasi<span
                                                    class="text-danger">*</span></label>
                                            <select name="petugas_id" id="petugas_id"
                                                class="form-select @error('user_id') is-invalid @enderror">
                                                <option value="">Pilih User</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('petugas_id', $instalasiAset->petugas->user_id ?? '') == $item->id ? 'selected' : '' }}>
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
                                        <div class="col-md-6">
                                            <label for="verifikator_id" class="form-label">Verifikator<span
                                                    class="text-danger">*</span></label>
                                            <select name="verifikator_id" id="verifikator_id"
                                                class="form-select @error('user_id') is-invalid @enderror">
                                                <option value="">Pilih User</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('verifikator_id', $instalasiAset->verifikator->user_id ?? '') == $item->id ? 'selected' : '' }}>
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
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0"> Verifikasi Penghapusan Data & Aplikasi
                                                </h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Verifikasi terkait penghapusan data dan aplikasi pada aset sebelum
                                                    instalasi ulang dilakukan.
                                                </p>
                                            </div>
                                        </div>

                                        @php
                                            $booleanFields = [
                                                'is_asset_data_cleared' =>
                                                    'Data pada aset telah dihapus oleh pemegang sebelumnya',
                                                'is_sensitive_data_checked' =>
                                                    'Petugas telah memastikan tidak ada data pribadi/sensitif yang tersisa',
                                                'has_unauthorized_apps' =>
                                                    'Terdapat aplikasi ilegal/tidak sah dalam perangkat',
                                            ];
                                        @endphp

                                        @foreach ($booleanFields as $name => $label)
                                            <div class="col-md-4">
                                                <label class="form-label">{{ $label }}</label>

                                                <div class="d-flex gap-3">
                                                    @foreach ([1 => 'Ya', 0 => 'Tidak'] as $value => $text)
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error($name) is-invalid @enderror"
                                                                type="radio" name="{{ $name }}"
                                                                id="{{ $name }}_{{ $value }}"
                                                                value="{{ $value }}"
                                                                {{ old($name, $instalasiAset->{$name}) == (string) $value ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="{{ $name }}_{{ $value }}">
                                                                {{ $text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @error($name)
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endforeach

                                        {{-- has authorization app --}}

                                        <div class="col-md-12">
                                            <label for="daftar_aplikasi_ilegal_text" class="form-label">Daftar aplikasi
                                                ilegal
                                                (jika ada)</label>
                                            <input type="text" class="form-control" id="daftar_aplikasi_ilegal_text"
                                                name="daftar_aplikasi_ilegal_text"
                                                value="{{ old('daftar_aplikasi_ilegal_text', $instalasiAset->daftar_aplikasi_ilegal) }}">
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0"> Checklist Instalasi Ulang
                                                </h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Checklist yang harus dilakukan selama proses instalasi ulang aset
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Instalasi/Reset Sistem Operasi --}}
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 my-2">
                                                <h2 class="fs-6 fw-medium mb-0">Instalasi / Reset Sistem Operasi</h2>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Pilih sistem operasi yang diinstalasi pada aset
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="reset_sistem_operasi_windows" value="1"
                                                            id="os_windows"
                                                            {{ old('reset_sistem_operasi_windows', isset($instalasiAset->reset_sistem_operasi['Windows']) ? '1' : '0') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="os_windows">
                                                            Windows
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="reset_sistem_operasi_linux" value="1"
                                                            id="os_linux"
                                                            {{ old('reset_sistem_operasi_linux', isset($instalasiAset->reset_sistem_operasi['Linux']) ? '1' : '0') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="os_linux">
                                                            Linux
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="reset_sistem_operasi_macos" value="1"
                                                            id="os_macos"
                                                            {{ old('reset_sistem_operasi_macos', isset($instalasiAset->reset_sistem_operasi['Mac OS']) ? '1' : '0') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="os_macos">
                                                            Mac OS
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="os_windows_version" class="form-label">Versi/Seri
                                                        Windows</label>
                                                    <input type="text" class="form-control" id="os_windows_version"
                                                        name="os_windows_version" placeholder="Contoh: Windows 11 Pro"
                                                        value="{{ old('os_windows_version', $instalasiAset->reset_sistem_operasi['Windows'] ?? '') }}">
                                                    <small class="text-muted">Isi jika memilih Windows</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="os_linux_version" class="form-label">Versi/Seri
                                                        Linux</label>
                                                    <input type="text" class="form-control" id="os_linux_version"
                                                        name="os_linux_version" placeholder="Contoh: Ubuntu 22.04 LTS"
                                                        value="{{ old('os_linux_version', $instalasiAset->reset_sistem_operasi['Linux'] ?? '') }}">
                                                    <small class="text-muted">Isi jika memilih Linux</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="os_macos_version" class="form-label">Versi/Seri Mac
                                                        OS</label>
                                                    <input type="text" class="form-control" id="os_macos_version"
                                                        name="os_macos_version" placeholder="Contoh: Ventura 13.0"
                                                        value="{{ old('os_macos_version', $instalasiAset->reset_sistem_operasi['Mac OS'] ?? '') }}">
                                                    <small class="text-muted">Isi jika memilih Mac OS</small>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Instalasi Anti Malware --}}
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 my-2">
                                                <h2 class="fs-6 fw-medium mb-0">Instalasi Anti Malware</h2>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Pilih anti malware yang diinstalasi pada aset
                                                </p>
                                            </div>
                                        </div>

                                        @php
                                            $existingAntimalware = old(
                                                'instalasi_antimalware',
                                                $instalasiAset->instalasi_antimalware ?? [],
                                            );
                                            $hasLainnya = false;
                                            $lainnyaText = '';
                                            foreach ($existingAntimalware as $item) {
                                                if (str_starts_with($item, 'Lainnya: ')) {
                                                    $hasLainnya = true;
                                                    $lainnyaText = substr($item, 9);
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div class="col-md-12">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="instalasi_antimalware[]" value="Windows Security"
                                                            id="am_windows_security"
                                                            {{ is_array($existingAntimalware) && in_array('Windows Security', $existingAntimalware) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="am_windows_security">
                                                            Windows Security
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="instalasi_antimalware[]" value="Windows Firewall"
                                                            id="am_windows_firewall"
                                                            {{ is_array($existingAntimalware) && in_array('Windows Firewall', $existingAntimalware) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="am_windows_firewall">
                                                            Windows Firewall
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="instalasi_antimalware[]" value="Clamav" id="am_clamav"
                                                            {{ is_array($existingAntimalware) && in_array('Clamav', $existingAntimalware) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="am_clamav">
                                                            Clamav
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="instalasi_antimalware_lainnya" value="1"
                                                            id="am_lainnya"
                                                            {{ old('instalasi_antimalware_lainnya', $hasLainnya ? '1' : '0') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="am_lainnya">
                                                            Lainnya
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="instalasi_antimalware_lainnya_text"
                                                        class="form-label">Sebutkan Anti Malware Lainnya</label>
                                                    <input type="text" class="form-control"
                                                        id="instalasi_antimalware_lainnya_text"
                                                        name="instalasi_antimalware_lainnya_text"
                                                        placeholder="Contoh: Avast, McAfee, dll"
                                                        value="{{ old('instalasi_antimalware_lainnya_text', $lainnyaText) }}">
                                                    <small class="text-muted">Isi jika memilih Lainnya</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="aplikasi_terpasang_text" class="form-label">Aplikasi
                                                        Terpasang</label>
                                                    <input type="text" class="form-control"
                                                        id="aplikasi_terpasang_text" name="aplikasi_terpasang_text"
                                                        value="{{ old('aplikasi_terpasang_text', $instalasiAset->aplikasi_terpasang) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="aplikasi_tambahan_text" class="form-label">Aplikasi
                                                        Tambahan
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        id="aplikasi_tambahan_text" name="aplikasi_tambahan_text"
                                                        value="{{ old('aplikasi_tambahan_text', $instalasiAset->aplikasi_tambahan) }}">
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
        document.getElementById('ba_pengembalian_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var asetIds = JSON.parse(selectedOption.getAttribute('data-aset-ids') || '[]');
            var asetSelect = document.getElementById('inputAset');

            if (asetIds.length > 0) {
                var firstAsetId = asetIds[0];
                for (var i = 0; i < asetSelect.options.length; i++) {
                    if (asetSelect.options[i].value == firstAsetId) {
                        asetSelect.selectedIndex = i;
                        document.getElementById('hiddenAsetId').value = firstAsetId;
                        asetSelect.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            } else {
                asetSelect.selectedIndex = 0;
                document.getElementById('hiddenAsetId').value = '';
                asetSelect.dispatchEvent(new Event('change'));
            }
        });

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
