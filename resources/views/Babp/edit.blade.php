@extends('layouts.admin')

@section('title', 'Page Edit Surat BABP')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('babp.index') }}" class="btn btn-close" aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit Surat BABP Aset</span>
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
                <div class="w-100 p-2 py-md-3 py-xl-4 rounded-4 bg-body-tertiary">
                    <form method="POST" action="{{ route('babp.update', $babp->id) }}" id="advancedForm"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row px-3 row-cols-1 gy-4">
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 row-cols-md-2 g-3">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Pertama</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data Petugas IT.
                                                </p>
                                            </div>
                                        </div>
                                        {{-- petugas --}}
                                        <div class="col-md-6">
                                            <label for="inputUser1" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser1" name="petugas_id">
                                                <option value="" selected>Pilih Petugas IT (Admin)</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        {{ old('petugas_id', $babp->petugas_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputJobRole1" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole1" name="job_role"
                                                placeholder="Job Role"
                                                value="{{ old('job_role', $existingData->job_role ?? '') }}" readonly />
                                        </div>
                                        {{-- validator --}}
                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Kedua</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data validator.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputUser2" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser2" name="penerima_id">
                                                <option value="" selected>Pilih Validator</option>
                                                @foreach ($validator as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        {{ old('penerima_id', $babp->penerima_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputJobRole2" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole2" name="job_role2"
                                                placeholder="Job Role"
                                                value="{{ old('job_role2', $existingData->job_role2 ?? '') }}" readonly />
                                        </div>
                                        {{-- verifikator --}}
                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Verifikator</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data verifikator.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputUser3" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser3" name="verifier_id">
                                                <option value="" selected>Pilih Verifikator</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        {{ old('verifier_id', $babp->verifier_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputJobRole3" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole3" name="job_role3"
                                                placeholder="Job Role"
                                                value="{{ old('job_role3', $existingData->job_role3 ?? '') }}" readonly />
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />

                                        {{-- Evidence Files --}}
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Dokumen Bukti Pendukung</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Upload dokumen pendukung (faktur, nota, dll). Format: PDF, JPG, PNG.
                                                    Maksimal 5MB per file.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="evidenceFiles" class="form-label">
                                                File Evidence
                                            </label>
                                            @if ($babp->evidence && count(json_decode($babp->evidence, true) ?? []) > 0)
                                                <div class="mb-2 p-3 bg-light rounded">
                                                    <small class="text-muted d-block mb-2">File evidence saat ini:</small>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach (json_decode($babp->evidence, true) as $index => $evidencePath)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <a href="{{ asset('storage/' . $evidencePath) }}"
                                                                    target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="sym sym-file-line"></i> File {{ $index + 1 }}
                                                                </a>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="evidence_delete[]"
                                                                        value="{{ $evidencePath }}"
                                                                        id="evidenceDelete{{ $index }}">
                                                                    <label class="form-check-label"
                                                                        for="evidenceDelete{{ $index }}">
                                                                        Hapus
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <small class="text-warning d-block mt-2">Centang file yang ingin
                                                        dihapus. Upload file baru akan menambah file evidence.</small>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="evidenceFiles"
                                                name="evidence[]" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                            <small class="text-muted">Anda dapat memilih multiple file sekaligus</small>
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />

                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-1">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan aset yang akan diserahkan.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Tombol Tambah Item Aset -->
                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-primary" id="addAssetRow">
                                                <i class="sym sym-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <!-- Tabel untuk Menampilkan Aset -->
                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered align-middle">
                                                    <thead class="align-middle">
                                                        <tr class="table-light text-center">
                                                            <th style="min-width: 50px;">No</th>
                                                            <th style="min-width: 200px;">Nama Barang</th>
                                                            <th style="min-width: 150px;">Kuantitas Dipesan</th>
                                                            <th style="min-width: 150px;">Kuantitas Diterima</th>
                                                            <th style="min-width: 150px;">Kategori</th>
                                                            <th style="min-width: 150px;">Tanggal Beli</th>
                                                            <th style="min-width: 150px;">Tanggal Diterima</th>
                                                            <th style="min-width: 300px;">Gambar Barang</th>
                                                            <th style="min-width: 300px;">Invoice</th>
                                                            <th class="text-center" style="min-width: 100px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="assetTableBody">
                                                        @forelse($babp->details as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td><input type="text"
                                                                        name="items[{{ $index }}][nama_barang]"
                                                                        class="form-control"
                                                                        value="{{ $item->nama_barang }}"></td>
                                                                <td><input type="number"
                                                                        name="items[{{ $index }}][kuantitas_dipesan]"
                                                                        class="form-control"
                                                                        value="{{ $item->kuantitas_dipesan }}"></td>
                                                                <td><input type="number"
                                                                        name="items[{{ $index }}][kuantitas_diterima]"
                                                                        class="form-control"
                                                                        value="{{ $item->kuantitas_diterima }}"></td>
                                                                <td>
                                                                    <select name="items[{{ $index }}][kategori]"
                                                                        class="form-select" required>
                                                                        <option value="">Pilih Kategori</option>
                                                                        <option value="sparepart"
                                                                            {{ $item->kategori == 'sparepart' ? 'selected' : '' }}>
                                                                            Sparepart</option>
                                                                        <option value="aksesoris"
                                                                            {{ $item->kategori == 'aksesoris' ? 'selected' : '' }}>
                                                                            Aksesoris</option>
                                                                        <option value="aset"
                                                                            {{ $item->kategori == 'aset' ? 'selected' : '' }}>
                                                                            Aset</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="date"
                                                                        name="items[{{ $index }}][tanggal_beli]"
                                                                        class="form-control"
                                                                        value="{{ $item->tanggal_beli }}"></td>
                                                                <td><input type="date"
                                                                        name="items[{{ $index }}][tanggal_terima]"
                                                                        class="form-control"
                                                                        value="{{ $item->tanggal_terima }}"></td>
                                                                <td>
                                                                    @if ($item->image)
                                                                        <div class="mb-2">
                                                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                                                alt="Current Image" class="img-thumbnail"
                                                                                style="max-width: 100px;">
                                                                            <small class="d-block text-muted">Gambar saat
                                                                                ini</small>
                                                                        </div>
                                                                    @endif
                                                                    <input type="file"
                                                                        name="items[{{ $index }}][image]"
                                                                        class="form-control"
                                                                        accept="image/jpeg,image/png,image/jpg">
                                                                </td>
                                                                <td>
                                                                    @if ($item->invoice)
                                                                        <div class="mb-2">
                                                                            <a href="{{ asset('storage/' . $item->invoice) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-outline-primary">
                                                                                <i class="sym sym-file-line"></i> Lihat
                                                                                Invoice
                                                                            </a>
                                                                            <small class="d-block text-muted">Invoice saat
                                                                                ini</small>
                                                                        </div>
                                                                    @endif
                                                                    <input type="file"
                                                                        name="items[{{ $index }}][invoice]"
                                                                        class="form-control"
                                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                                </td>
                                                                <td class="text-center"><button type="button"
                                                                        class="btn btn-icon btn-sm btn-outline-secondary removeAssetRow">
                                                                        <i class="sym sym-trash-solid"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr id="noAssetsRow">
                                                                <td colspan="9" class="text-center">Belum ada aset
                                                                    ditambahkan</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
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
    <div class="d-block d-md-none rounded-top-4 shadow-lg sticky-bottom">
        <div class="w-100 d-flex bg-white gap-2 p-3">
            <button type="submit" class="btn w-100 btn-primary" form="advancedForm">
                Simpan
            </button>
        </div>
    </div>
    <!-- [END] Submit Button Mobile -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addButton = document.getElementById("addAssetRow");
            const tableBody = document.getElementById("assetTableBody");

            // Tambahkan event listener untuk tombol tambah
            addButton.addEventListener("click", function() {
                addAssetRow();
            });

            // Fungsi untuk menambahkan baris baru
            function addAssetRow() {
                const noAssetsRow = document.getElementById("noAssetsRow");

                // Hapus baris default jika ada (Belum ada aset yang ditambahkan)
                if (noAssetsRow) {
                    noAssetsRow.remove();
                }

                const rowCount = tableBody.rows.length;
                const newRow = tableBody.insertRow();

                newRow.innerHTML = `
            <td>${rowCount + 1}</td>
            <td><input type="text" name="items[${rowCount}][nama_barang]" class="form-control" required></td>
            <td><input type="number" name="items[${rowCount}][kuantitas_dipesan]" class="form-control" min="1" required></td>
            <td><input type="number" name="items[${rowCount}][kuantitas_diterima]" class="form-control" min="0" required></td>
             <td>
                <select name="items[${rowCount}][kategori]" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="sparepart">Sparepart</option>
                    <option value="aksesoris">Aksesoris</option>
                    <option value="aset">Aset</option>
                </select>
            </td>
            <td><input type="date" name="items[${rowCount}][tanggal_beli]" class="form-control"></td>
            <td><input type="date" name="items[${rowCount}][tanggal_terima]" class="form-control"></td>
            <td><input type="file" name="items[${rowCount}][image]" class="form-control" accept="image/jpeg,image/png,image/jpg"></td>
            <td><input type="file" name="items[${rowCount}][invoice]" class="form-control" accept=".pdf,.jpg,.jpeg,.png"></td>
            <td class="text-center">
                <button type="button" class="btn btn-icon btn-sm btn-outline-secondary removeAssetRow">
                    <i class="sym sym-trash-solid"></i>
                </button>
            </td>
        `;

                // Tambahkan event listener untuk tombol hapus di baris baru
                newRow.querySelector('.removeAssetRow').addEventListener("click", function() {
                    newRow.remove();
                    renumberRows();
                });
            }

            // Fungsi untuk mengatur ulang nomor urut dan handle baris kosong
            function renumberRows() {
                const rows = tableBody.querySelectorAll("tr");

                if (rows.length === 0) {
                    tableBody.innerHTML = `
                <tr id="noAssetsRow">
                    <td colspan="9" class="text-center text-muted">Belum ada aset yang ditambahkan</td>
                </tr>
            `;
                } else {
                    rows.forEach((row, index) => {
                        row.cells[0].innerText = index + 1;
                        updateRowNameAttributes(row, index);
                    });
                }
            }

            // Fungsi untuk update 'name' attribute input sesuai index baru
            function updateRowNameAttributes(row, index) {
                row.querySelectorAll("input").forEach(input => {
                    const nameParts = input.name.match(/items\[\d+\]\[(.+)\]/);
                    if (nameParts && nameParts[1]) {
                        input.name = `items[${index}][${nameParts[1]}]`;
                    }
                });
            }
        });
    </script>


    <script>
        // Function to set job role and address
        function setUserDetails(userSelectId, jobRoleInputId) {
            var selectElement = document.getElementById(userSelectId);
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var jobRole = selectedOption.getAttribute('data-job-role');

            document.getElementById(jobRoleInputId).value = jobRole || '';
            document.getElementById(jobRoleInputId).disabled = true;
        }

        // Populate fields on change
        document.getElementById('inputUser1').addEventListener('change', function() {
            setUserDetails('inputUser1', 'inputJobRole1');
        });

        document.getElementById('inputUser2').addEventListener('change', function() {
            setUserDetails('inputUser2', 'inputJobRole2');
        });

        document.getElementById('inputUser3').addEventListener('change', function() {
            setUserDetails('inputUser3', 'inputJobRole3');
        });

        // Initialize fields on page load
        window.addEventListener('DOMContentLoaded', function() {
            setUserDetails('inputUser1', 'inputJobRole1');
            setUserDetails('inputUser2', 'inputJobRole2');
            setUserDetails('inputUser3', 'inputJobRole3');
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
                html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
            });
        @endif
    </script>

@endsection
