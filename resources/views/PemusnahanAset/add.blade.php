@extends('layouts.admin')

@section('title', 'Page All Pemusnahan Aset')

@section('content')
    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('pemusnahan-aset.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Tambah Pemusnahan Aset</span>
            </div>
            <div class="d-flex gap-2 align-items-center position-relative">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="pemusnahanForm">
                    Simpan Data
                </button>
            </div>
        </div>
    </header>
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('pemusnahan-aset.store') }}" id="pemusnahanForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        {{-- Tim Pelaksana --}}
                                        <div class="col-md-12">
                                            <h1 class="fs-5 fw-medium mb-0">Tim Pelaksana</h1>
                                            <p class="text-secondary">Pilih petugas IT yang bertanggung jawab.</p>
                                        </div>

                                        <div class="col-md-12" id="timPelaksanaContainer">
                                            <div class="petugas-item row row-cols-1 row-cols-md-3 g-3 mb-3" data-index="0">
                                                <div class="col-md-4">
                                                    <label class="form-label">Pelaksana 1</label>
                                                    <select class="form-select petugas-select" required
                                                        name="tim_pelaksana[0][user_id]" data-target-role="jobRolePel0">
                                                        <option value="">-- Pilih Pelaksana 1 --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                data-role="{{ $user->job_role ?? '' }}">
                                                                {{ $user->name_karyawan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Job Role <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="jobRolePel0" name="tim_pelaksana[0][job_role]"
                                                        class="form-control" placeholder="Job Role" readonly>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Peran Pelaksana 1 <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="tim_pelaksana[0][peran]"
                                                        class="form-control" placeholder="Peran Pelaksana 1" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-outline-primary" id="addPelaksanaBtn">
                                                <i class="sym sym-plus"></i> Tambah Pelaksana
                                            </button>
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />

                                        {{-- Pihak Terlibat --}}
                                        <div class="col-md-12 mt-4">
                                            <h1 class="fs-5 fw-medium mb-0">Pihak yang Terlibat</h1>
                                            <p class="text-secondary">Pilih pihak yang terlibat dalam pemusnahan aset.</p>
                                        </div>

                                        <div class="col-md-12" id="pihakTerlibatContainer">
                                            <!-- Akan diisi dinamis -->
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-outline-primary" id="addPihakBtn">
                                                <i class="sym sym-plus"></i> Tambah Pihak Terlibat
                                            </button>
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pemusnahan Aset<span
                                                        class="text-danger">*</span></h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data pemusnahan aset.
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Tambah Aset --}}

                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#assetModal">
                                                <i class="sym sym-plus"></i> Tambah
                                            </button>

                                            <!-- Tombol Tambah Manual -->
                                            <button type="button" class="btn btn-outline-primary" id="addManualBtn">
                                                <i class="sym sym-edit"></i> Tambah Manual
                                            </button>
                                        </div>


                                        @include('PemusnahanAset.partials.asset-modal')

                                        <div class="col-md-12 mt-3" id="manualAssetForm" style="display:none;">
                                            <div class="card p-3 mb-3">
                                                <h6 class="fw-semibold mb-3">Tambah Aset Manual</h6>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <input type="text" id="manualJenis" class="form-control"
                                                            placeholder="Jenis Aset">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" id="manualMerk" class="form-control"
                                                            placeholder="Merk Aset">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" id="manualNomor" class="form-control"
                                                            placeholder="Nomor Aset">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" id="manualQty" min="1"
                                                            value="1" class="form-control" placeholder="Qty">
                                                    </div>
                                                    <div class="col-md-1 d-flex">
                                                        <button type="button" id="saveManualAsset"
                                                            class="btn btn-success w-100">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2" id="selectedAssetsTable"
                                                style="max-height:500px; overflow-y:auto; display:block;">
                                                <table class="table table-bordered align-middle">
                                                    <thead class="align-middle"
                                                        style="top:0; background:#fff; z-index:10;">
                                                        <tr class="table-light">
                                                            <th style="min-width: 36px; width: 36px;">No</th>
                                                            <th style="min-width: 180px;">Jenis Aset</th>
                                                            <th style="min-width: 120px;">Qty</th>
                                                            <th style="min-width: 180px;">Merk Aset</th>
                                                            <th style="min-width: 180px;">Nomor Aset</th>
                                                            <th class="text-center" style="width: 124px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selectedAssetsBody">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- add keterangan --}}
                                        <div class="col-md-12 mt-3">
                                            <label for="keterangan" class="form-label">Keterangan<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                                placeholder="Masukkan keterangan tambahan jika ada..." required></textarea>
                                        </div>
                                        {{-- Lokasi Pemusnahan --}}
                                        <div class="col-md-6 mt-3">
                                            <label for="lokasi" class="form-label">Lokasi Pemusnahan<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="lokasi" name="lokasi" rows="2" placeholder="Masukkan lokasi ..."
                                                required></textarea>
                                        </div>
                                        {{-- Metode Pemusnahan --}}
                                        <div class="col-md-6 mt-3">
                                            <label for="metode" class="form-label">Metode Pemusnahan<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="metode" name="metode" rows="2"
                                                placeholder="Masukkan metode pemusnahan aset yang digunakan..." required></textarea>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5 class="mb-3">Bukti Sebelum Aset Dimusnahkan</h5>
                                                <div class="mb-3">
                                                    <label for="lampiran_sebelum" class="form-label">Upload
                                                        Lampiran</label>
                                                    <input type="file" class="form-control" id="lampiran_sebelum"
                                                        name="lampiran[]" multiple accept=".jpg,.jpeg,.png">
                                                    <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG
                                                        Maksimal 5MB per file.</div>
                                                </div>
                                                <div class="preview-images mt-2 d-flex flex-wrap gap-2"
                                                    id="preview-sebelum"></div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5 class="mb-3">Bukti Sesudah Aset Dimusnahkan</h5>
                                                <div class="mb-3">
                                                    <label for="lampiran_sesudah" class="form-label">Upload
                                                        Lampiran</label>
                                                    <input type="file" class="form-control" id="lampiran_sesudah"
                                                        name="lampiran[]" multiple accept=".jpg,.jpeg,.png">
                                                    <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG
                                                        Maksimal 5MB per file.</div>
                                                </div>
                                                <div class="preview-images mt-2 d-flex flex-wrap gap-2"
                                                    id="preview-sesudah"></div>
                                            </div>
                                        </div>

                                        <!-- Submit Form Mobile -->
                                        <div class="d-block d-md-none">
                                            <button type="submit" class="btn btn-primary w-100" form="pemusnahanForm">
                                                Simpan Data
                                            </button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const fileGroups = {
            sebelum: [],
            sesudah: []
        };

        function handlePreview(inputId, previewId, key) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            fileGroups[key] = Array.from(input.files);
            preview.innerHTML = "";

            fileGroups[key].forEach((file, i) => {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();
                reader.onload = e => {
                    preview.innerHTML += `
            <div class="position-relative">
                <img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                    style="padding:2px 6px;font-size:12px;" onclick="removeImage('${key}', '${inputId}', '${previewId}', ${i})">
                    <svg width="14" height="14" viewBox="0 0 16 16">
                        <path d="M2 2l12 12M14 2L2 14" stroke="#fff" stroke-width="2"/>
                    </svg>                            
                </button>
            </div>`;
                };
                reader.readAsDataURL(file);
            });
        }

        function removeImage(key, inputId, previewId, index) {
            fileGroups[key].splice(index, 1);

            const dt = new DataTransfer();
            fileGroups[key].forEach(f => dt.items.add(f));

            const input = document.getElementById(inputId);
            input.files = dt.files;

            handlePreview(inputId, previewId, key);
        }

        document.getElementById("lampiran_sebelum")
            .addEventListener("change", () => handlePreview("lampiran_sebelum", "preview-sebelum", "sebelum"));

        document.getElementById("lampiran_sesudah")
            .addEventListener("change", () => handlePreview("lampiran_sesudah", "preview-sesudah", "sesudah"));
    </script>

    <script>
        let pelaksanaIndex = 1;
        let pihakIndex = 0;

        // Tambah Pelaksana
        document.getElementById("addPelaksanaBtn").addEventListener("click", function() {
            const container = document.getElementById("timPelaksanaContainer");
            const newItem = document.createElement("div");
            newItem.className = "petugas-item row row-cols-1 row-cols-md-3 g-3 mb-3 position-relative";
            newItem.dataset.index = pelaksanaIndex;

            newItem.innerHTML = `
        <div class="col-md-4">
            <label class="form-label">Pelaksana ${pelaksanaIndex + 1}</label>
            <select class="form-select petugas-select" required name="tim_pelaksana[${pelaksanaIndex}][user_id]" 
                    data-target-role="jobRolePel${pelaksanaIndex}">
                <option value="">-- Pilih Pelaksana ${pelaksanaIndex + 1} --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" data-role="{{ $user->job_role ?? '' }}">
                        {{ $user->name_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Job Role <span class="text-danger">*</span></label>
            <input type="text" id="jobRolePel${pelaksanaIndex}" name="tim_pelaksana[${pelaksanaIndex}][job_role]" 
                   class="form-control" placeholder="Job Role" readonly>
        </div>

        <div class="col-md-3">
            <label class="form-label">Peran Pelaksana ${pelaksanaIndex + 1} <span class="text-danger">*</span></label>
            <input type="text" name="tim_pelaksana[${pelaksanaIndex}][peran]" class="form-control" 
                   placeholder="Peran Pelaksana ${pelaksanaIndex + 1}" required>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger w-100 removePetugas" title="Hapus">
                <i class="sym sym-trash"></i>
            </button>
        </div>
    `;

            container.appendChild(newItem);
            attachPetugasSelectEvent(newItem);
            pelaksanaIndex++;
        });

        // Tambah Pihak Terlibat
        document.getElementById("addPihakBtn").addEventListener("click", function() {
            const container = document.getElementById("pihakTerlibatContainer");
            const newItem = document.createElement("div");
            newItem.className = "petugas-item row row-cols-1 row-cols-md-3 g-3 mb-3 position-relative";
            newItem.dataset.index = pihakIndex;

            newItem.innerHTML = `
        <div class="col-md-4">
            <label class="form-label">Pihak Terlibat ${pihakIndex + 1}</label>
            <select class="form-select petugas-select" required name="pihak_terlibat[${pihakIndex}][user_id]" 
                    data-target-role="jobRolePihak${pihakIndex}">
                <option value="">-- Pilih Pihak Terlibat ${pihakIndex + 1} --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" data-role="{{ $user->job_role ?? '' }}">
                        {{ $user->name_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Job Role <span class="text-danger">*</span></label>
            <input type="text" id="jobRolePihak${pihakIndex}" name="pihak_terlibat[${pihakIndex}][job_role]" 
                   class="form-control" placeholder="Job Role" readonly>
        </div>

        <div class="col-md-3">
            <label class="form-label">Peran Pihak ${pihakIndex + 1} <span class="text-danger">*</span></label>
            <input type="text" name="pihak_terlibat[${pihakIndex}][peran]" class="form-control" 
                   placeholder="Peran Pihak ${pihakIndex + 1}" required>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger w-100 removePetugas" title="Hapus">
                <i class="sym sym-trash"></i>
            </button>
        </div>
    `;

            container.appendChild(newItem);
            attachPetugasSelectEvent(newItem);
            pihakIndex++;
        });

        // Function untuk attach event
        function attachPetugasSelectEvent(element) {
            const select = element.querySelector('.petugas-select');
            const removeBtn = element.querySelector('.removePetugas');

            if (select) {
                select.addEventListener('change', function() {
                    const role = this.options[this.selectedIndex].dataset.role || "";
                    const target = this.dataset.targetRole;
                    const targetElement = document.getElementById(target);
                    if (targetElement) {
                        targetElement.value = role;
                    }
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Hapus Petugas?',
                        text: "Data petugas ini akan dihapus dari form",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            element.remove();
                        }
                    });
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Event untuk select petugas yang sudah ada
            document.querySelectorAll(".petugas-select").forEach(select => {
                select.addEventListener("change", function() {
                    const role = this.options[this.selectedIndex].dataset.role || "";
                    const target = this.dataset.targetRole;
                    const targetElement = document.getElementById(target);
                    if (targetElement) {
                        targetElement.value = role;
                    }
                });
            });

            renderSelectedAssets();
            attachSelectAssetEvents();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event untuk select petugas
            document.querySelectorAll(".petugas-select").forEach(select => {
                select.addEventListener("change", function() {
                    const role = this.options[this.selectedIndex].dataset.role || "";
                    const target = this.dataset.targetRole;
                    document.getElementById(target).value = role;
                });
            });

            // Render assets dan attach events
            renderSelectedAssets();
            attachSelectAssetEvents();
        });

        window.addEventListener("beforeunload", function() {
            localStorage.removeItem('selectedAssets');
            localStorage.removeItem('pemusnahanFormData');
        });

        function saveAssetToLocalStorage(asset) {
            const selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];

            if (asset.sparepartId && selectedAssets.some(a => a.sparepartId === asset.sparepartId)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aset sudah dipilih!',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            if (!asset.sparepartId && selectedAssets.some(a => a.nomor === asset.nomor)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aset dengan nomor yang sama sudah dipilih!',
                    confirmButtonText: 'OK'
                });
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
                <input type="hidden" name="items[${index}][aset_id]" value="${asset.asetId || ''}">
                <input type="hidden" name="items[${index}][sparepart_id]" value="${asset.sparepartId || ''}">
                ${!asset.asetId && !asset.sparepartId ? `
                                                                                    <input type="hidden" name="items[${index}][manual_jenis]" value="${asset.jenis}">
                                                                                    <input type="hidden" name="items[${index}][manual_merk]" value="${asset.merk}">
                                                                                    <input type="hidden" name="items[${index}][manual_nomor]" value="${asset.nomor}">
                                                                                ` : ''}
            `;
            });

            document.querySelectorAll('.removeAsset').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    removeAssetFromLocalStorage(index);
                });
            });
        }

        function attachSelectAssetEvents() {
            document.querySelectorAll('.pilihAset').forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            document.querySelectorAll('.pilihAset').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const asset = {
                        nomor: this.dataset.nomor || '-',
                        jenis: this.dataset.jenis || '-',
                        merk: this.dataset.merk || '-',
                        qty: 1,
                        asetId: this.dataset.asetId || null,
                        sparepartId: this.dataset.sparepartId && this.dataset.sparepartId !== "null" ?
                            this.dataset.sparepartId : null
                    };

                    if (!saveAssetToLocalStorage(asset)) return;

                    renderSelectedAssets();

                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById(
                        'assetModal'));
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            });
        }

        document.getElementById("addManualBtn").addEventListener("click", function() {
            const form = document.getElementById("manualAssetForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        });

        document.getElementById("saveManualAsset").addEventListener("click", function() {
            const jenis = document.getElementById("manualJenis").value.trim();
            const merk = document.getElementById("manualMerk").value.trim();
            const nomor = document.getElementById("manualNomor").value.trim();
            const qty = parseInt(document.getElementById("manualQty").value);

            if (!jenis || !merk || !nomor || !qty) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Tidak Lengkap',
                    text: 'Jenis, Merk, Nomor, dan Qty harus diisi.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const asset = {
                jenis: jenis,
                merk: merk,
                nomor: nomor,
                qty: qty,
                asetId: null,
            };

            if (!saveAssetToLocalStorage(asset)) return;

            document.getElementById("manualJenis").value = '';
            document.getElementById("manualMerk").value = '';
            document.getElementById("manualNomor").value = '';
            document.getElementById("manualQty").value = 1;

            renderSelectedAssets();
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
    </script>

@endsection
