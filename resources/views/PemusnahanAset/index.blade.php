@extends('layouts.admin')

@section('title', 'Pemusnahan Aset')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Pemusnahan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Pemusnahan Aset</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Pemusnahan Aset</h4>
                        <span class="text-muted">Daftar pemusnahan aset yang telah dilakukan.</span>
                        <hr>

                        <form action="" id="pemusnahanForm">
                            <div class="row d-flex align-items-center justify-content-between gap-2">
                                <div class="col-md-3">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                @can('akses-admin-superadmin')
                                    <div class="col-md-3 d-flex justify-content-end gap-2">
                                        <a href="{{ route('pemusnahan-aset.export', request()->query()) }}"
                                            class="btn btn-success d-block d-lg-inline-block" aria-label="Export Data">
                                            <i class="sym sym-download"></i> Export
                                        </a>
                                        <a href="{{ route('pemusnahan-aset.create') }}"
                                            class="btn btn-primary d-block d-lg-inline-block" aria-label="Tambah Data">
                                            <i class="sym sym-plus"></i> Tambah
                                        </a>
                                    </div>
                                @endcan

                            </div>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">
                                                Nomor Surat
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">
                                                Tanggal
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">
                                                Tim Pelaksana
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">
                                                Pihak yang Terlibat
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 120px; text-align: center;">
                                            Jumlah Aset
                                        </th>
                                        <th style="min-width: 120px; text-align: center;">
                                            Total Aset yang Dimusnahkan
                                        </th>
                                        <th style="min-width: 120px; text-align: center;">
                                            Status
                                        </th>
                                        <th class="text-center" style="width: 124px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pemusnahans as $pemusnahan)
                                        <tr>
                                            <td>{{ ($pemusnahans->currentPage() - 1) * $pemusnahans->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $pemusnahan->nomor_surat ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @php
                                                    $timPelaksana = $pemusnahan->pemusnahanUsers
                                                        ->where('kategori', 'tim_pelaksana')
                                                        ->pluck('user.name_karyawan')
                                                        ->filter()
                                                        ->values();
                                                @endphp

                                                @if ($timPelaksana->isNotEmpty())
                                                    <ol style="margin: 0; padding-left: 20px;">
                                                        @foreach ($timPelaksana as $index => $nama)
                                                            <li>{{ $nama }}</li>
                                                        @endforeach
                                                    </ol>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $pihakTerlibat = $pemusnahan->pemusnahanUsers
                                                        ->where('kategori', 'pihak_terlibat')
                                                        ->pluck('user.name_karyawan')
                                                        ->filter()
                                                        ->values();
                                                @endphp

                                                @if ($pihakTerlibat->isNotEmpty())
                                                    <ol style="margin: 0; padding-left: 20px;">
                                                        @foreach ($pihakTerlibat as $index => $nama)
                                                            <li>{{ $nama }}</li>
                                                        @endforeach
                                                    </ol>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="text-center">{{ $pemusnahan->pemusnahanAsets->count() }}</td>
                                            <td class="text-center">{{ $pemusnahan->pemusnahanAsets->sum('qty') }}</td>
                                            <td class="text-center">
                                                @if ($pemusnahan->status == 'pending')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                                @elseif ($pemusnahan->status == 'signed')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('pemusnahan-aset.show', $pemusnahan->id) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Lihat Detail" title="Lihat Detail">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>

                                                    @can('akses-admin-superadmin')
                                                        <a href="{{ route('pemusnahan-aset.edit', $pemusnahan->id) }}">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Edit" title="Edit">
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Hapus" title="Hapus"
                                                            onclick="confirmDeletion({{ $pemusnahan->id }})">
                                                            <i class="sym sym-trash-solid"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $pemusnahan->id }}"
                                                            action="{{ route('pemusnahan-aset.destroy', $pemusnahan->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Data belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $pemusnahans->firstItem() }}</span> -
                                <span class="fw-bold">{{ $pemusnahans->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $pemusnahans->total() }}</span> data
                            </p>

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

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end mb-0">
                                    @php
                                        $currentPage = $pemusnahans->currentPage();
                                        $lastPage = $pemusnahans->lastPage();
                                    @endphp

                                    <li class="page-item {{ $pemusnahans->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $pemusnahans->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $pemusnahans->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $pemusnahans->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <li class="page-item {{ $pemusnahans->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $pemusnahans->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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
                html: '{!! session('error') !!}',
            });
        @endif

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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function updateItemsPerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    </script>
@endsection
