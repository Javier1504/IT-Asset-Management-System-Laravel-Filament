@extends('layouts.admin')

@section('title', 'Page All Request Aset')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">

                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Permintaan</a>
                                </li>

                                @can('akses-admin-superadmin-manager')
                                    @if (request()->routeIs('aset-request.my-requests'))
                                        <li class="breadcrumb-item active" aria-current="page">Ajukan Permintaan</li>
                                    @elseif(request()->routeIs('aset-request.index'))
                                        <li class="breadcrumb-item active" aria-current="page">Daftar Permintaan</li>
                                    @endif
                                @endcan

                                @can('akses-karyawan-finance')
                                    @if (request()->routeIs('aset-request.my-requests'))
                                        <li class="breadcrumb-item active" aria-current="page">Permintaan Aset</li>
                                    @elseif(request()->routeIs('aset-request.index'))
                                        <li class="breadcrumb-item active" aria-current="page">Daftar Permintaan</li>
                                    @endif
                                @endcan

                                {{-- Fallback jika user tidak memiliki kedua akses di atas --}}
                                @if (!auth()->user()->can('akses-admin-superadmin-manager') && !auth()->user()->can('akses-karyawan-finance'))
                                    @if (request()->routeIs('aset-request.my-requests'))
                                        <li class="breadcrumb-item active" aria-current="page">Ajukan Permintaan</li>
                                    @elseif(request()->routeIs('aset-request.index'))
                                        <li class="breadcrumb-item active" aria-current="page">Daftar Permintaan</li>
                                    @endif
                                @endif


                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        @if (request()->routeIs('aset-request.my-requests'))
                            <!-- Sesuaikan dengan nama route -->
                            <h4 class="m-0">Permintaan Anda</h4>
                            <span class="text-muted">Di bawah ini adalah daftar permintaan aset Anda.</span>
                        @elseif(request()->routeIs('aset-request.index'))
                            <h4 class="m-0">Daftar Permintaan</h4>
                            <span class="text-muted">Di bawah ini adalah daftar permintaan user yang sedang menunggu
                                persetujuan Anda.</span>
                        @endif
                        <div class="row g-3 mb-4 mt-3">
                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #F9F4DD;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Pending</h5>
                                        <h1 class="fw-bold mt-2">{{ $pendingCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #DFECFF;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Permintaan Diproses</h5>
                                        <h1 class="fw-bold mt-2">{{ $onProgressCount}}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #d1ffde;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Permintaan Diterima</h5>
                                        <h1 class="fw-bold mt-2">{{ $diterimaCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #F8C9C9;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Permintaan Ditolak</h5>
                                        <h1 class="fw-bold mt-2">{{ $ditolakCount }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr>

                        <div class="row d-flex align-items-center justify-content-between gap-2">
                            <div class="col-md-3">
                                <form method="GET"
                                    action="{{ request()->routeIs('aset-request.my-requests') ? route('aset-request.my-requests') : route('aset-request.index') }}">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                            <input type="hidden" name="tipe_permintaan"
                                                value="{{ request('tipe_permintaan') }}">
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                            <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col d-flex justify-content-end align-items-center gap-2">
                                <div class="col-md-3">
                                    <form method="GET"
                                        action="{{ request()->routeIs('aset-request.my-requests') ? route('aset-request.my-requests') : route('aset-request.index') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <select class="form-select" id="tipe_permintaan" name="tipe_permintaan"
                                            onchange="this.form.submit()" aria-label="Default select example">
                                            <option value=""
                                                {{ request('tipe_permintaan') == '' ? 'selected' : '' }}>
                                                Semua Tipe Permintaan
                                            </option>
                                            <option value="penambahan"
                                                {{ request('tipe_permintaan') == 'penambahan' ? 'selected' : '' }}>
                                                Penambahan
                                            </option>
                                            <option value="perubahan"
                                                {{ request('tipe_permintaan') == 'perubahan' ? 'selected' : '' }}>Perubahan
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form method="GET"
                                        action="{{ request()->routeIs('aset-request.my-requests') ? route('aset-request.my-requests') : route('aset-request.index') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="tipe_permintaan"
                                            value="{{ request('tipe_permintaan') }}">
                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <select class="form-select" id="status" name="status"
                                            onchange="this.form.submit()" aria-label="Default select example">
                                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>
                                                Semua Status
                                            </option>
                                            <option value="pending"
                                                {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="on_progress"
                                                {{ request('status') == 'on_progress' ? 'selected' : '' }}>
                                                Diproses
                                            </option>
                                            <option value="diterima"
                                                {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima
                                            </option>
                                            <option value="ditolak"
                                                {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                                Ditolak
                                            </option>
                                        </select>
                                    </form>
                                </div>

                                @if (request()->routeIs('aset-request.my-requests'))
                                    @can('akses-admin-superadmin-manager')
                                        {{-- Tombol tambah data --}}
                                        <div class="d-flex align-items-center">

                                            <a href="{{ route('aset-request.create') }}"
                                                class="btn btn-primary d-flex align-items-center justify-content-center"
                                                aria-label="Tambah Data">
                                                <i class="sym sym-plus"></i> Tambah
                                            </a>
                                        </div>
                                    @endcan
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nama Pemohon
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nama Personil Diajukan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Status
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Tanggal Diajukan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Judul Permintaan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Tipe Permintaan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 170px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Jenis Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asetRequests as $aset)
                                        <tr>
                                            <td>{{ ($asetRequests->currentPage() - 1) * $asetRequests->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->requestedBy->name_karyawan ?? '-' }}</td>
                                            <td>{{ $aset->targetUser->name_karyawan ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($aset->status == 'pending')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                                @elseif ($aset->status == 'on_progress')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Diproses</span>
                                                @elseif ($aset->status == 'diterima')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Diterima</span>
                                                @elseif ($aset->status == 'ditolak')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Ditolak</span>
                                                @else
                                                    <span>{{ $aset->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $aset->tanggal_diajukan->format('d-m-Y H:i:s') ?? '-' }}</td>
                                            <td>{{ $aset->judul_permintaan ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($aset->tipe_permintaan == 'penambahan')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Penambahan
                                                        Aset</span>
                                                @elseif ($aset->tipe_permintaan == 'perubahan')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Perubahan
                                                        Aset</span>
                                                @else
                                                    <span>{{ $aset->tipe_permintaan }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($aset->tipe_permintaan === 'penambahan')
                                                    {{ $aset->jenis_aset ?? '-' }}
                                                @elseif ($aset->tipe_permintaan === 'perubahan')
                                                    {{ $aset->aset->jenisAset->name_jenis ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($aset->tipe_permintaan === 'penambahan')
                                                    {{ $aset->nama_aset ?? '-' }}
                                                @elseif ($aset->tipe_permintaan === 'perubahan')
                                                    {{ $aset->aset->merk_aset ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    @if (request()->routeIs('aset-request.my-requests'))
                                                        <a href="{{ route('aset-request.showUser', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Lihat Detail">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @elseif(request()->routeIs('aset-request.index'))
                                                        <a href="{{ route('aset-request.showAdmin', $aset->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat Surat" title="Lihat Detail">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @endif
                                                    @can('akses-admin-superadmin-manager')
                                                        <a
                                                            href="{{ $aset->status === 'pending' ? route('aset-request.edit', $aset->id) : '#' }}">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Edit" title="Edit"
                                                                {{ $aset->status !== 'pending' ? 'disabled' : '' }}>
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $asetRequests->firstItem() }}</span> -
                                <span class="fw-bold">{{ $asetRequests->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $asetRequests->total() }}</span> data
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
                                        $currentPage = $asetRequests->currentPage();
                                        $lastPage = $asetRequests->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $asetRequests->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetRequests->appends(request()->except('page'))->previousPageUrl() }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetRequests->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetRequests->appends(request()->except('page'))->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $asetRequests->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetRequests->appends(request()->except('page'))->nextPageUrl() }}">
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

@endsection
