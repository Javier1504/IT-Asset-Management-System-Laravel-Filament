@extends('layouts.admin')

@section('title', 'Page Pencabutan Aset Pribadi')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        @use(Illuminate\Support\Facades\Auth)
        @php
            $user = Auth::user();
        @endphp
        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                @if (request()->routeIs('PencabutanAsetpribadi'))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>Aset
                                            Pribadi</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.PencabutanAsetpribadi'))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Form Pencabutan Aset Pribadi</li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Pencabutan Aset Pribadi</h4>
                        @if (request()->routeIs('daftar-tanda-tangan.pencabutan-asetpribadi'))
                            <span class="text-muted">Di bawah ini adalah daftar dokumen Pencabutan Aset Pribadi yang
                                perlu Anda tanda tangani.</span>
                            <hr>
                        @endif

                        @if (request()->routeIs('PencabutanAsetpribadi'))
                            <div class="row mt-4">
                                <form action="{{ route('PencabutanAsetpribadi') }}" method="GET" id="filterForm">
                                    <!-- Filter berdasarkan status -->
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between">
                                            @php
                                                $selectedStatuses = request('statuses', []);
                                            @endphp

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="statuses[]"
                                                    value="pending" id="pending"
                                                    {{ in_array('pending', $selectedStatuses) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="pending">Pending</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="statuses[]"
                                                    value="approved" id="approved"
                                                    {{ in_array('approved', $selectedStatuses) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="approved">Disetujui</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="statuses[]"
                                                    value="rejected" id="rejected"
                                                    {{ in_array('rejected', $selectedStatuses) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="rejected">Ditolak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="statuses[]"
                                                    value="completed" id="completed"
                                                    {{ in_array('completed', $selectedStatuses) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit();">
                                                <label class="form-check-label" for="completed">Selesai</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                        @endif

                        <div class="row d-flex align-items-center justify-content-between gap-2">
                            <div class="col-md-3">
                                <form>
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if (request()->routeIs('PencabutanAsetpribadi'))
                                <div class="col">
                                    <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
                                        <div class="flex-grow-1 flex-md-grow-0" style="min-width: 180px;">
                                            <form method="GET" action="{{ route('PencabutanAsetpribadi') }}">
                                                <select class="form-select" id="status" name="status"
                                                    onchange="this.form.submit()" aria-label="Filter Status">
                                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>
                                                        Semua
                                                        Status</option>
                                                    <option value="pending"
                                                        {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="approved"
                                                        {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                        Disetujui</option>
                                                    <option value="rejected"
                                                        {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                                        Ditolak</option>
                                                    <option value="completed"
                                                        {{ request('status') == 'completed' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                </select>
                                            </form>
                                        </div>

                                        <a href="{{ route('pencabutan-asetpribadi.download-template') }}"
                                            class="btn btn-outline-success d-flex align-items-center gap-1">
                                            <i class="sym sym-download"></i> <span class="d-none d-sm-inline">Unduh
                                                Template</span>
                                        </a>

                                        <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="sym sym-upload"></i> <span class="d-none d-sm-inline">Import</span>
                                        </button>

                                        <a href="{{ route('pencabutan-asetpribadi.create') }}"
                                            class="btn btn-primary d-flex align-items-center gap-1">
                                            <i class="sym sym-plus"></i> <span class="d-none d-sm-inline">Tambah</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 150px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Photo: active to sort">
                                                Nomor Pencabutan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Photo: active to sort">
                                                Nama Personel
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="width: 150px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Photo: active to sort">
                                                Jabatan User
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="width: 120px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Photo: active to sort">
                                                Sebagai :
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="width: 100px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Photo: active to sort">
                                                Status
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="width: 50px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($asetPribadis as $aset)
                                        <tr>
                                            <td>{{ ($asetPribadis->currentPage() - 1) * $asetPribadis->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->nomor_pencabutan_user ?? '-' }}</td>
                                            <td>{{ $aset->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $aset->user->job_role ?? '-' }}</td>
                                            <td>
                                                @if ($aset->id_user == $user->id)
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Pihak
                                                        Kedua</span>
                                                @elseif($aset->id_manager == $user->id)
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">PJ
                                                        Data</span>
                                                @else
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Pihak
                                                        Pertama</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($aset->status == 'completed')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Selesai</span>
                                                @elseif ($aset->status == 'menunggu_manager')
                                                    <span
                                                        class="badge text-info bg-warning bg-opacity-10 border border-info">Menunggu
                                                        Manager</span>
                                                @elseif ($aset->status == 'menunggu_admin')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Menunggu
                                                        Admin</span>
                                                @elseif ($aset->status == 'dicabut')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Dicabut</span>
                                                @elseif ($aset->status == 'pending')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                                @else
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">{{ $aset->status ?? 'Belum Diproses' }}</span>
                                                @endif
                                            </td>
                                            @if (request()->routeIs('daftar-tanda-tangan.pencabutan-asetpribadi'))
                                                <td style="text-align: center;">
                                                    @if ($aset->tanda_tangan_user && $aset->tanda_tangan_manager && $aset->tanda_tangan_admin)
                                                        <span
                                                            class="badge text-success bg-success bg-opacity-10 border border-success">Lengkap</span>
                                                    @elseif ($aset->tanda_tangan_user && $aset->tanda_tangan_manager)
                                                        <span
                                                            class="badge text-info bg-info bg-opacity-10 border border-info">Menunggu
                                                            Admin</span>
                                                    @elseif ($aset->tanda_tangan_user)
                                                        <span
                                                            class="badge text-warning bg-warning bg-opacity-10 border border-warning">Menunggu
                                                            Manager</span>
                                                    @else
                                                        <span
                                                            class="badge text-danger bg-danger bg-opacity-10 border border-danger">Belum
                                                            Ditandatangani</span>
                                                    @endif
                                                </td>
                                            @endif

                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    @if (request()->routeIs('daftar-tanda-tangan.PencabutanAsetpribadi'))
                                                        <a href="{{ route('daftar-tanda-tangan.detailPencabutanAsetpribadi', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Pertinjau Dokumen">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('aset-pribadi.detail', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Pertinjau Dokumen">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="17" class="text-center text-muted">Data belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $asetPribadis->firstItem() }}</span> -
                                <span class="fw-bold">{{ $asetPribadis->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $asetPribadis->total() }}</span> data
                            </p>

                            <!-- Dropdown untuk memilih jumlah item per halaman -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                                <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
                                    onchange="updateItemsPerPage(this.value)">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200</option>
                                    <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
                                    <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000
                                    </option>
                                </select>
                            </div>
                            <!-- Navigasi halaman -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">

                                    @php
                                        $currentPage = $asetPribadis->currentPage();
                                        $lastPage = $asetPribadis->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $asetPribadis->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetPribadis->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetPribadis->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetPribadis->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $asetPribadis->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetPribadis->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-right"></i>
                                        </a>
                                    </li>


                                </ul>
                            </nav>

                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- [END] Content -->
    </main>
    @section('footer')
        <p></p>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: {!! json_encode(session('error')) !!}, // 👈 Gunakan json_encode agar tetap raw dan aman
            });
        @endif
    </script>
    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3 shadow',
                    confirmButton: 'btn btn-primary mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    <script>
        function updateItemsPerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1); // Reset ke halaman pertama
            window.location.href = url.toString();
        }
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById("filterForm");
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", () => {
                    form.submit();
                });
            });
        })
    </script>

    <script>
        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('file-input').files = files;
                updateFileName();
            }
        }

        function updateFileName() {
            const input = document.getElementById('file-input');
            const fileNameDiv = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileNameDiv.textContent = input.files[0].name;
            } else {
                fileNameDiv.textContent = '';
            }
        }
    </script>

@endsection
