@extends('layouts.admin')

@section('title', 'Page All Aset Dihibahkan')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>
                                        Pemeliharaan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Aset Hibah</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Aset Hibah</h4>


                        <hr>

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

                            <div class="col d-flex flex-wrap justify-content-end align-items-center gap-2">
                                {{-- Filter Jenis Aset --}}
                                <div style="min-width: 200px;">
                                    <form method="GET" action="{{ route('aset-hibah.index') }}">
                                        <select class="form-select" id="jenis_aset_id" name="jenis_aset_id"
                                            onchange="this.form.submit()" aria-label="Filter Jenis Aset">
                                            <option value="" {{ request('jenis_aset_id') == '' ? 'selected' : '' }}>
                                                Semua Jenis</option>
                                            @foreach ($jenisAsets as $jenis)
                                                <option value="{{ $jenis->id }}"
                                                    {{ request('jenis_aset_id') == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->name_jenis ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>

                                {{-- Filter Status Aset --}}
                                <div style="min-width: 200px;">
                                    <form method="GET" action="{{ route('aset-hibah.index') }}">
                                        <select class="form-select" id="status_aset" name="status_aset"
                                            onchange="this.form.submit()" aria-label="Filter Status Aset">
                                            <option value="" {{ request('status_aset') == '' ? 'selected' : '' }}>
                                                Semua Status</option>
                                            <option value="retirement"
                                                {{ request('status_aset') == 'retirement' ? 'selected' : '' }}>Retirement
                                            </option>
                                            <option value="dihibahkan"
                                                {{ request('status_aset') == 'dihibahkan' ? 'selected' : '' }}>Dihibahkan
                                            </option>
                                        </select>
                                    </form>
                                </div>

                                @can('akses-admin-superadmin')
                                    {{-- Tombol Tambah --}}
                                    <a href="{{ route('aset-hibah.create') }}"
                                        class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class="sym sym-plus"></i> <span class="d-none d-sm-inline">Tambah</span>
                                    </a>
                                @endcan
                            </div>


                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 140px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Jenis Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Merk Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 300px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Spesifikasi Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 160px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nomor Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Tanggal Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Harga Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Status Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 160px; width: 10%;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Keterangan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        @can('akses-admin-superadmin')
                                            <th class="text-center">Aksi</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asetHibah as $aset)
                                        <tr>
                                            <td>{{ ($asetHibah->currentPage() - 1) * $asetHibah->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->aset->jenisAset->name_jenis ?? '-' }}</td>
                                            <td>{{ $aset->aset->merk_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->aset->spesifikasi_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->aset->nomor_aset ?? '-' }}</td>
                                            <!-- Make sure to access through aset relationship -->
                                            <td>{{ $aset->aset?->tanggal_pembelian ? \Carbon\Carbon::parse($aset->aset->tanggal_pembelian)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>Rp {{ number_format($aset->aset?->harga_pembelian ?? 0, 0, ',', '.') }} </td>
                                            <td style="text-align: center;">
                                                @if ($aset->status_aset == 'retirement')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                                @elseif ($aset->status_aset == 'dihibahkan')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dihibahkan</span>
                                                @else
                                                    <span>{{ $aset->status_aset }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $aset->keterangan ?? '-' }}</td>
                                            @can('akses-admin-superadmin')
                                                <td style="width: 124px;">
                                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                                        <a href="{{ route('aset-hibah.edit', $aset->id) }}">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Edit" title="Edit">
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>
                                                        </a>

                                                        <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Hapus" title="Hapus"
                                                            onclick="confirmDeletion({{ $aset->id }})">
                                                            <i class="sym sym-trash-solid"></i>
                                                        </button>

                                                        <form id="delete-form-{{ $aset->id }}"
                                                            action="{{ route('aset-hibah.destroy', $aset->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $asetHibah->firstItem() }}</span> -
                                <span class="fw-bold">{{ $asetHibah->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $asetHibah->total() }}</span> data
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
                                        $currentPage = $asetHibah->currentPage();
                                        $lastPage = $asetHibah->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $asetHibah->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetHibah->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetHibah->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $asetHibah->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $asetHibah->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $asetHibah->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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
