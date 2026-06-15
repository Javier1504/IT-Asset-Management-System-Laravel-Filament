    @extends('layouts.admin')

    @section('title', 'Ajukan Permintaan Aset')

    @section('content')

        <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
            <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('aset-request.my-requests') }}" class="btn btn-close"
                        aria-label="Kembali ke halaman list"></a>
                    <span class="m-0 fs-6 fw-medium">Form Permintaan Aset</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <button type="submit" class="d-none d-md-block btn btn-primary" form="formPermintaanAset">
                        Ajukan Permintaan
                    </button>
                </div>
            </div>
        </header>

        <main class="qn-main bg-body-tertiary d-flex flex-column">
            <div class="container-fluid">
                <div class="w-100 p-2 bg-white">
                    <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                        <form method="POST" action="{{ route('aset-request.store') }}" id="formPermintaanAset"
                            class="qn-form w-100 position-relative" enctype="multipart/form-data">
                            @csrf
                            <div class="row px-3 row-cols-1 gy-4">
                                <div class="card p-0 border-0 rounded-4 shadow-sm">
                                    <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                        <div class="row row-cols-1 row-cols-md-2 g-3">
                                            <div class="col-md-12">
                                                <h1 class="fs-5 fw-medium mb-0">Tipe Permintaan</h1>
                                                <p class="fs-6 fw-medium text-secondary">Pilih Tipe permintaan.</p>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Tipe Pengajuan <span class="text-danger">*</span>
                                                </label>
                                                <div class="row g-2">
                                                    @foreach ($tipes as $tipe)
                                                        @php
                                                            $isSelected =
                                                                old('tipe_permintaan', 'penambahan') === $tipe;
                                                        @endphp
                                                        <div class="col-12 col-md-6">
                                                            <div class="tipe-card d-flex align-items-center rounded px-4 py-2 {{ $isSelected ? 'border border-primary bg-light' : 'border' }}"
                                                                data-tipe="{{ $tipe }}" role="button">
                                                                <input class="form-check-input me-2 mt-0" type="radio"
                                                                    name="tipe_permintaan" id="tipe_{{ $tipe }}"
                                                                    value="{{ $tipe }}"
                                                                    {{ $isSelected ? 'checked' : '' }}>
                                                                <label for="tipe_{{ $tipe }}"
                                                                    class="mb-0 fw-semibold text-capitalize w-100">
                                                                    {{ $tipe === 'penambahan' ? 'Penambahan Aset Baru' : 'Perubahan Aset' }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr class="border-dark-subtle my-4 col-md-12" />
                                            <div class="col-md-12 mt-0">
                                                <div class="d-flex flex-column gap-1 mb-2">
                                                    <h1 class="fs-5 fw-medium mb-0">Data Personil</h1>
                                                    <p class="fs-6 fw-medium text-secondary mb-0">
                                                        Isikan data personil karyawan yang ingin Anda ajukan.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="user_id" class="form-label">Nama <span
                                                        class="text-danger">*</span></label>

                                                <select id="userSelect" name="target_user_id" class="form-select" required>
                                                    <option value="">-- Pilih Karyawan --</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name_karyawan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <hr class="border-dark-subtle my-4 col-md-12" />
                                            <div class="col-md-12 mt-0">
                                                <div class="d-flex flex-column gap-1 mb-2">
                                                    <h1 class="fs-5 fw-medium mb-0">Detail Permintaan</h1>
                                                    <p class="fs-6 fw-medium text-secondary mb-0">
                                                        Isi detail permintaan untuk kebutuhan karyawan Anda.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="judul_permintaan" class="form-label">Judul Permintaan <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="judul_permintaan"
                                                    name="judul_permintaan" value="{{ old('judul_permintaan') }}"
                                                    placeholder="Masukkan judul permintaan" required>
                                            </div>

                                            {{-- Untuk tipe PENAMBAHAN --}}
                                            <div id="form-penambahan" class="col-md-12">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Jenis Aset <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="jenis_aset"
                                                        placeholder="Contoh: Laptop" value="{{ old('jenis_aset') }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label"> Detail Spesifikasi Aset Diperlukan<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_aset"
                                                        placeholder="Contoh: Lenovo Yoga C640 Intel Core i7"
                                                        value="{{ old('nama_aset') }}">
                                                </div>
                                            </div>

                                            {{-- Untuk tipe PERUBAHAN --}}
                                            <div id="form-perubahan" class="d-none col-md-12">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Jenis Aset <span class="text-danger">*</span>
                                                        <i class="sym sym-info-default" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Jenis aset dan detail aset akan muncul berdasarkan nama karyawan yang dipilih."></i>
                                                    </label>

                                                    <select id="jenisAsetSelect" name="jenis_aset_id" class="form-select">
                                                        <option value="">-- Pilih Jenis Aset --</option>
                                                        {{-- opsi akan diisi otomatis oleh JS --}}
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Detail Spesifikasi Aset Saat Ini<span
                                                            class="text-danger">*</span></label>


                                                    <select id="asetSelect" name="aset_id" class="form-select">
                                                        <option value="">-- Pilih Aset --</option>
                                                        {{-- opsi akan diisi otomatis oleh JS --}}
                                                    </select>
                                                    <div class="col-md-12 mt-3">
                                                        <label class="form-label">Detail Aset Diinginkan <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="aset_diinginkan"
                                                            placeholder="Masukkan detail aset yang diinginkan sebagai pengganti"
                                                            value="{{ old('aset_diinginkan') }}">
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-md-12"> <!-- tambahkan margin-top kecil -->
                                                <label class="form-label">Alasan Pengajuan <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" name="alasan" rows="3" required>{{ old('alasan') }}</textarea>
                                            </div>

                                            <div class="col-md-12 mb-2"> <!-- batasi margin bawah -->
                                                <label for="lampiran" class="form-label">Lampiran</label>
                                                <div id="uploadArea" class="border border-dashed rounded p-3 text-center">
                                                    <i class="bi bi-upload fs-3 text-primary"></i>
                                                    <p class="mb-1">Unggah file pendukung</p>
                                                    <p class="text-muted small mb-1">
                                                        PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, JPEG, PNG (max 5MB)
                                                    </p>
                                                    <input type="file" class="form-control d-none" name="lampiran[]"
                                                        id="lampiran" multiple>
                                                    <button type="button" class="btn btn-outline-primary mt-1"
                                                        onclick="document.getElementById('lampiran').click()">Pilih
                                                        File</button>
                                                </div>
                                                <div id="filePreviewList" class="mt-2"></div>
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
                <button type="submit" class="btn w-100 btn-primary" form="formPermintaanAset">
                    Ajukan Permintaan
                </button>
            </div>
        </div>

        {{-- SweetAlert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: `{!! session('error') !!}`
                });
            @endif
        </script>

        <script>
            let lastSelectedTipe = document.querySelector('input[name="tipe_permintaan"]:checked')?.value;

            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.tipe-card');
                const radios = document.querySelectorAll('input[name="tipe_permintaan"]');

                function updateSelectedCard() {
                    cards.forEach(card => {
                        card.classList.remove('border-primary', 'border-1', 'bg-light');
                        card.classList.add('border');
                    });

                    const checked = document.querySelector('input[name="tipe_permintaan"]:checked');
                    if (checked) {
                        const selectedCard = checked.closest('.tipe-card');
                        if (selectedCard) {
                            selectedCard.classList.add('border-primary', 'border-1', 'bg-light');
                        }
                    }
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', updateSelectedCard);
                });

                cards.forEach(card => {
                    card.addEventListener('click', () => {
                        const tipe = card.dataset.tipe;
                        const input = document.querySelector(`#tipe_${tipe}`);
                        if (input) {
                            input.checked = true;
                            input.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                        }
                    });
                });

                updateSelectedCard();

                function resetFormFields() {
                    // Reset semua input dan select, kecuali radio untuk tipe
                    const form = document.getElementById('formPermintaanAset');
                    const inputs = form.querySelectorAll('input:not([type=radio]), textarea, select');

                    inputs.forEach(input => {
                        if (input.type === 'file') {
                            input.value = '';
                        } else {
                            input.value = '';
                        }
                    });

                    // Kosongkan file preview & reset selectedFiles array
                    selectedFiles = [];
                    updateFilePreview();
                    updateFileInput();

                    // Tampilkan form penambahan sebagai default
                    document.getElementById('form-penambahan').classList.remove('d-none');
                    document.getElementById('form-perubahan').classList.add('d-none');
                }

                radios.forEach(radio => {
    radio.addEventListener('change', function () {
        const selectedValue = this.value;

        // ⛔ Jangan lakukan apa-apa jika tipe yang sama diklik ulang
        if (selectedValue === lastSelectedTipe) {
            return;
        }

        lastSelectedTipe = selectedValue; // update tipe terakhir

        updateSelectedCard();

        // Reset hanya jika pindah ke tipe lain
        resetFormFields();

        if (selectedValue === 'penambahan') {
            document.getElementById('form-penambahan').classList.remove('d-none');
            document.getElementById('form-perubahan').classList.add('d-none');
        } else {
            document.getElementById('form-penambahan').classList.add('d-none');
            document.getElementById('form-perubahan').classList.remove('d-none');
        }
    });
});

            });
        </script>

        <script>
            const fileInput = document.getElementById('lampiran');
            const filePreviewList = document.getElementById('filePreviewList');
            let selectedFiles = [];

            fileInput.addEventListener('change', function(e) {
                // Tambahkan file ke array sementara
                for (const file of e.target.files) {
                    selectedFiles.push(file);
                }
                updateFilePreview();
                updateFileInput();
            });

            function updateFilePreview() {
                filePreviewList.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className =
                        'd-flex align-items-center justify-content-between bg-light rounded px-3 py-2 mb-2';

                    fileItem.innerHTML = `
                    <span><i class="bi bi-paperclip me-2"></i> ${file.name}</span>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFile(${index})">
                        <i class="sym sym-trash-solid"></i>
                    </button>
                `;
                    filePreviewList.appendChild(fileItem);
                });
            }

            function removeFile(index) {
                selectedFiles.splice(index, 1);
                updateFilePreview();
                updateFileInput();
            }

            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
            }
        </script>
        <script>
            const asetByUser = {!! $asetByUserJson !!};

            const userSelect = document.getElementById('userSelect');
            const jenisAsetSelect = document.getElementById('jenisAsetSelect');
            const asetSelect = document.getElementById('asetSelect');

            // Bersihkan dan buat opsi dropdown baru
            function clearOptions(selectElement) {
                selectElement.innerHTML = '<option value="">-- Pilih --</option>';
            }

            function populateJenisAset(asetList) {
                clearOptions(jenisAsetSelect);

                const uniqueJenis = {};
                asetList.forEach(item => {
                    uniqueJenis[item.jenis_aset_id] = item.nama_jenis;
                });

                for (const [id, name] of Object.entries(uniqueJenis)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = name;
                    jenisAsetSelect.appendChild(option);
                }

                // Reset dropdown aset juga
                clearOptions(asetSelect);
            }

            /// Isi dropdown aset berdasarkan jenis aset yang dipilih 
            function populateAsetByJenis(jenisId, asetList) {
                clearOptions(asetSelect);

                const filtered = asetList.filter(item => item.jenis_aset_id == jenisId);

                filtered.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.aset_id;
                    option.textContent = `${item.nomor_aset} | ${item.merk_aset}`;
                    asetSelect.appendChild(option);
                });
            }

            userSelect.addEventListener('change', () => {
                const userId = userSelect.value;

                if (userId && asetByUser[userId]) {
                    populateJenisAset(asetByUser[userId]);
                } else {
                    clearOptions(jenisAsetSelect);
                    clearOptions(asetSelect);
                }
            });

            jenisAsetSelect.addEventListener('change', () => {
                const jenisId = jenisAsetSelect.value;
                const userId = userSelect.value;

                if (userId && jenisId && asetByUser[userId]) {
                    populateAsetByJenis(jenisId, asetByUser[userId]);
                } else {
                    clearOptions(asetSelect);
                }
            });
        </script>
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
@endsection
