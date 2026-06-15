@extends('layouts.admin')

@section('title', 'Edit BAST Persetujuan Aset Pribadi')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('bast-persetujuan-asetpribadi.index') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Edit BAST Persetujuan Aset Pribadi</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <!-- Submit Form Desktop -->
                <button type="submit" class="d-none d-md-block btn btn-primary" form="bastForm">
                    Update Data
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid p-0">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('bast-persetujuan-asetpribadi.update', $bast->id) }}"
                        id="bastForm" class="qn-form w-100 position-relative" enctype="multipart/form-data">
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
                                        <div class="col-md-4">
                                            <label for="inputUser1" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser1" name="user_pihak_pertama_id"
                                                required>
                                                <option value="">Pilih Petugas IT</option>
                                                @foreach ($users->where('role', 'admin') as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('user_pihak_pertama_id', $bast->user_pihak_pertama_id) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputJobRole1" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole1" name="job_role"
                                                placeholder="Job Role"
                                                value="{{ old('job_role', $bast->pihakPertama->job_role ?? '') }}"
                                                readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat1" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat1" name="alamat"
                                                placeholder="Alamat"
                                                value="{{ old('alamat', $bast->pihakPertama->alamat ?? '') }}" readonly />
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Pihak Kedua</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Masukkan data penerima.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputUser2" class="form-label">
                                                Nama
                                            </label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select" id="inputUser2" name="user_pihak_kedua_id" required>
                                                <option value="">Pilih Penerima</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-job-role="{{ $user->job_role }}"
                                                        data-alamat="{{ $user->alamat }}"
                                                        {{ old('user_pihak_kedua_id', $bast->user_pihak_kedua_id) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputJobRole2" class="form-label">
                                                Job Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputJobRole2" name="job_role2"
                                                placeholder="Job Role"
                                                value="{{ old('job_role2', $bast->pihakKedua->job_role ?? '') }}"
                                                readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAlamat2" class="form-label">
                                                Alamat
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="inputAlamat2" name="alamat2"
                                                placeholder="Alamat"
                                                value="{{ old('alamat2', $bast->pihakKedua->alamat ?? '') }}" readonly />
                                        </div>

                                        <hr class="border-dark-subtle my-4 col-md-12" />
                                        <div class="col-md-12 mt-0">
                                            <div class="d-flex flex-column gap-1 mb-2">
                                                <h1 class="fs-5 fw-medium mb-0">Data Aset Pribadi Request</h1>
                                                <p class="fs-6 fw-medium text-secondary mb-0">
                                                    Kelola request aset pribadi yang terkait.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Button "Tambah Aset Pribadi Request" -->
                                        <div class="col-md-12 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#asetpribadiModal">
                                                <i class="sym sym-plus"></i> Tambah Request
                                            </button>
                                        </div>

                                        <!-- Modal Card - Same as in add.blade.php -->
                                        <div class="modal fade" id="asetpribadiModal" tabindex="-1"
                                            aria-labelledby="asetpribadiModalLabel" aria-hidden="true"
                                            data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="ratio ratio-1x1"
                                                                style="width: 42px; min-width: 42px;">
                                                                <span
                                                                    class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                                                                    <i class="sym sym-laptop-solid"></i>
                                                                </span>
                                                            </div>
                                                            <div class="d-block ms-1">
                                                                <h5 class="m-0">Pilih Request Aset Pribadi</h5>
                                                                <span class="fs-6 text-secondary">
                                                                    Pilih request aset pribadi yang sudah disetujui.
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="row d-flex align-items-center justify-content-between gap-2">
                                                            <div
                                                                class="col d-flex justify-content-end align-items-center gap-2">
                                                                <div class="col-md-3">
                                                                    <div id="searchForm">
                                                                        <div class="row g-2">
                                                                            <div class="col">
                                                                                <input type="text" class="form-control"
                                                                                    name="search" id="searchInput"
                                                                                    placeholder="Cari request..."
                                                                                    autocomplete="off">
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    id="searchButton">Cari</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive mt-4"
                                                            style="max-height:500px; overflow-y:auto;">
                                                            <table class="table table-bordered align-middle">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Aksi</th>
                                                                        <th>Nama User</th>
                                                                        <th>Jabatan</th>
                                                                        <th>Divisi</th>
                                                                        <th>Tanggal Request</th>
                                                                        <th>Aset Pribadi</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="asetpribadiRequestTable">
                                                                    @forelse ($availableAsetpribadiRequests as $request)
                                                                        <tr>
                                                                            <td>
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-primary btn-sm pilihRequest"
                                                                                    data-request-id="{{ $request->id }}"
                                                                                    data-user-name="{{ $request->user->name_karyawan ?? '-' }}"
                                                                                    data-jabatan="{{ $request->jabatan_user ?? '-' }}"
                                                                                    data-divisi="{{ $request->divisi ?? '-' }}"
                                                                                    data-tanggal="{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}"
                                                                                    data-aset-pribadi="{{ json_encode($request->aset_pribadi ?? []) }}">
                                                                                    Pilih
                                                                                </button>
                                                                            </td>
                                                                            <td>{{ $request->user->name_karyawan ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $request->jabatan_user ?? '-' }}</td>
                                                                            <td>{{ $request->divisi ?? '-' }}</td>
                                                                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}
                                                                            </td>
                                                                            <td>
                                                                                @if (is_array($request->aset_pribadi) && count($request->aset_pribadi) > 0)
                                                                                    @foreach ($request->aset_pribadi as $index => $aset)
                                                                                        <div class="mb-1">
                                                                                            <strong>{{ $aset['nama'] ?? '-' }}</strong><br>
                                                                                            <small>S/N:
                                                                                                {{ $aset['no_seri'] ?? '-' }}</small><br>
                                                                                            <small>MAC:
                                                                                                {{ $aset['mac_address'] ?? '-' }}</small>
                                                                                        </div>
                                                                                        @if ($index < count($request->aset_pribadi) - 1)
                                                                                            <hr class="my-1">
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="badge text-success bg-success bg-opacity-10 border border-success">
                                                                                    Disetujui
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="7" class="text-center">
                                                                                Tidak ada request aset pribadi yang tersedia
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tabel untuk Menampilkan Request yang Telah Dipilih -->
                                        <div class="col-md-12 mt-3">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered align-middle"
                                                    id="selectedRequestsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Aksi</th>
                                                            <th>Nama User</th>
                                                            <th>Jabatan</th>
                                                            <th>Divisi</th>
                                                            <th>Tanggal Request</th>
                                                            <th>Aset Pribadi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selectedRequestsBody">
                                                        @foreach ($bast->asetpribadiRequests as $request)
                                                            <tr>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeRequest({{ $loop->index }})">
                                                                        <i class="sym sym-trash-solid"></i>
                                                                    </button>
                                                                    <input type="hidden" name="asetpribadi_requests[]"
                                                                        value="{{ $request->id }}">
                                                                </td>
                                                                <td>{{ $request->user->name_karyawan ?? '-' }}</td>
                                                                <td>{{ $request->jabatan_user ?? '-' }}</td>
                                                                <td>{{ $request->divisi ?? '-' }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}
                                                                </td>
                                                                <td>
                                                                    @if (is_array($request->aset_pribadi) && count($request->aset_pribadi) > 0)
                                                                        @foreach ($request->aset_pribadi as $index => $aset)
                                                                            <div class="mb-1">
                                                                                <strong>{{ $aset['nama'] ?? '-' }}</strong><br>
                                                                                <small>S/N:
                                                                                    {{ $aset['no_seri'] ?? '-' }}</small><br>
                                                                                <small>MAC:
                                                                                    {{ $aset['mac_address'] ?? '-' }}</small>
                                                                            </div>
                                                                            @if ($index < count($request->aset_pribadi) - 1)
                                                                                <hr class="my-1">
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Form Mobile -->
                            <div class="d-block d-md-none">
                                <button type="submit" class="btn btn-primary w-100" form="bastForm">
                                    Update Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ session('success') }}');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ session('error') }}');
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function populateUserData(selectId, jobRoleId, alamatId) {
                const select = document.getElementById(selectId);
                const jobRoleInput = document.getElementById(jobRoleId);
                const alamatInput = document.getElementById(alamatId);

                select.addEventListener('change', function() {
                    const opt = select.options[select.selectedIndex];
                    jobRoleInput.value = opt?.dataset.jobRole || '';
                    alamatInput.value = opt?.dataset.alamat || '';
                });
            }

            populateUserData('inputUser1', 'inputJobRole1', 'inputAlamat1');
            populateUserData('inputUser2', 'inputJobRole2', 'inputAlamat2');

            let selectedRequests = [];
            let selectedPihakKeduaId = document.getElementById('inputUser2').value;

            @foreach ($bast->asetpribadiRequests as $request)
                selectedRequests.push({
                    id: '{{ $request->id }}',
                    user: '{{ $request->user->name_karyawan ?? '-' }}',
                    jabatan: '{{ $request->jabatan_user ?? '-' }}',
                    divisi: '{{ $request->divisi ?? '-' }}',
                    tanggal: '{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}',
                    aset: {!! json_encode($request->aset_pribadi ?? []) !!}
                });
            @endforeach

            renderSelectedTable();

            document.querySelector('[data-bs-target="#asetpribadiModal"]')
                .addEventListener('click', function(e) {

                    if (!selectedPihakKeduaId) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Pihak Kedua',
                            text: 'Pilih Pihak Kedua terlebih dahulu sebelum memilih request.'
                        });
                        return;
                    }

                    loadRequests();
                });

            document.getElementById('inputUser2').addEventListener('change', function() {

                const newUserId = this.value;

                if (selectedRequests.length > 0) {
                    Swal.fire({
                        title: 'Ubah Pihak Kedua?',
                        text: 'Request yang sudah dipilih akan dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then(res => {
                        if (res.isConfirmed) {
                            selectedRequests = [];
                            renderSelectedTable();
                            selectedPihakKeduaId = newUserId;
                        } else {
                            this.value = selectedPihakKeduaId;
                        }
                    });
                } else {
                    selectedPihakKeduaId = newUserId;
                }
            });

            function loadRequests(search = '') {
                const url = '{{ route('bast-persetujuan-asetpribadi.searchAsetpribadiRequest') }}';
                const tbody = document.getElementById('asetpribadiRequestTable');

                // Show loading icon
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <span class="spinner-border text-primary" role="status" aria-hidden="true"></span>
                            <span class="ms-2">Memuat data...</span>
                        </td>
                    </tr>
                `;

                fetch(`${url}?user_id=${selectedPihakKeduaId}&search=${encodeURIComponent(search)}`)
                    .then(res => res.json())
                    .then(res => {
                        tbody.innerHTML = '';

                        if (!res.data || res.data.length === 0) {
                            tbody.innerHTML =
                            `<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>`;
                            return;
                        }

                        res.data.forEach(req => {
                            tbody.innerHTML += `
                        <tr>
                            <td>
                                <button class="btn btn-primary btn-sm pilihRequest"
                                    type="button"
                                    data-id="${req.id}"
                                    data-user="${req.user?.name_karyawan || '-'}"
                                    data-jabatan="${req.jabatan_user || '-'}"
                                    data-divisi="${req.divisi || '-'}"
                                    data-tanggal="${new Date(req.created_at).toLocaleDateString('id-ID')}"
                                    data-aset='${JSON.stringify(req.aset_pribadi || [])}'>
                                    Pilih
                                </button>
                            </td>
                            <td>${req.user?.name_karyawan || '-'}</td>
                            <td>${req.jabatan_user || '-'}</td>
                            <td>${req.divisi || '-'}</td>
                            <td>${new Date(req.created_at).toLocaleDateString('id-ID')}</td>
                            <td>${renderAset(req.aset_pribadi)}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Disetujui</span></td>
                        </tr>`;
                        });
                    });
            }

            document.addEventListener('click', function(e) {
                if (!e.target.classList.contains('pilihRequest')) return;

                const btn = e.target;
                const id = btn.dataset.id;

                if (selectedRequests.some(r => r.id == id)) {
                    Swal.fire('Request sudah dipilih', '', 'warning');
                    return;
                }

                selectedRequests.push({
                    id,
                    user: btn.dataset.user,
                    jabatan: btn.dataset.jabatan,
                    divisi: btn.dataset.divisi,
                    tanggal: btn.dataset.tanggal,
                    aset: JSON.parse(btn.dataset.aset || '[]')
                });

                renderSelectedTable();
                bootstrap.Modal.getInstance(document.getElementById('asetpribadiModal')).hide();
            });

            function renderSelectedTable() {
                const tbody = document.getElementById('selectedRequestsBody');
                tbody.innerHTML = '';

                selectedRequests.forEach((r, i) => {
                    tbody.innerHTML += `
                <tr>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="removeRequest(${i})" type="button">
                            <i class="sym sym-trash-solid"></i>
                        </button>
                        <input type="hidden" name="asetpribadi_requests[]" value="${r.id}">
                    </td>
                    <td>${r.user}</td>
                    <td>${r.jabatan}</td>
                    <td>${r.divisi}</td>
                    <td>${r.tanggal}</td>
                    <td>${renderAset(r.aset)}</td>
                </tr>`;
                });
            }

            function renderAset(aset) {
                if (!Array.isArray(aset)) return '-';
                return aset.map(a => `
            <div>
                <strong>${a.nama || '-'}</strong><br>
                <small>S/N: ${a.no_seri || '-'}</small><br>
                <small>MAC: ${a.mac_address || '-'}</small>
            </div>
            <hr class="my-1">
        `).join('');
            }

            window.removeRequest = function(i) {
                Swal.fire({
                    title: 'Hapus request?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (r.isConfirmed) {
                        selectedRequests.splice(i, 1);
                        renderSelectedTable();
                    }
                });
            };

            document.getElementById('searchButton').addEventListener('click', () => {
                loadRequests(document.getElementById('searchInput').value);
            });

        });
    </script>
@endsection
