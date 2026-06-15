@extends('layouts.admin')

@section('title', 'Instalasi Aset IT')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Instalasi Aset
                                        IT</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Formulir Instalsi Aset IT</li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Formulir Instalasi Aset IT</h4>

                        <hr>

                        <form action="" id="categories" method="GET">
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
                                <div class="col-md-3 d-flex justify-content-end gap-2">
                                    <a href="{{ route('instalasi-aset.create') }}"
                                        class="btn btn-primary d-block d-lg-inline-block" aria-label="Tambah Data">
                                        <i class="sym sym-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 250px; width: 10%;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Nomor Surat">
                                                Nomor Surat
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px; width: 10%;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Tanggal">
                                                Tanggal Instalasi
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Penerima">
                                                Penerima
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Penerima">
                                                Petugas
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Verifikator">
                                                Verifikator
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th class="text-center" style="min-width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($instalasiAsets as $instalasiAset)
                                        <tr>
                                            <td>{{ $loop->iteration + ($instalasiAsets->currentPage() - 1) * $instalasiAsets->perPage() }}
                                            </td>
                                            <td>{{ $instalasiAset->nomor_surat }}</td>
                                            <td>{{ \Carbon\Carbon::parse($instalasiAset->tanggal_surat)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $instalasiAset->penerima->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $instalasiAset->petugas->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $instalasiAset->verifikator->user->name_karyawan ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('instalasi-aset.show', $instalasiAset->id) }}"
                                                    class="btn btn-icon btn-sm btn-outline-secondary"
                                                    aria-label="Lihat Detail">
                                                    <i class="sym sym-eye-solid"></i>
                                                </a>
                                                <a href="{{ route('instalasi-aset.edit', $instalasiAset->id) }}"
                                                    class="btn btn-icon btn-sm btn-outline-secondary"
                                                    aria-label="Edit Data">
                                                    <i class="sym sym-edit-solid"></i>
                                                </a>
                                                <form id="delete-form-{{ $instalasiAset->id }}"
                                                    action="{{ route('instalasi-aset.destroy', $instalasiAset->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                        onclick="confirmDeletion({{ $instalasiAset->id }})"
                                                        aria-label="Hapus Data">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>
                                                </form>
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
                                <span class="fw-bold">{{ $instalasiAsets->firstItem() }}</span> -
                                <span class="fw-bold">{{ $instalasiAsets->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $instalasiAsets->total() }}</span> data
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
                                        $currentPage = $instalasiAsets->currentPage();
                                        $lastPage = $instalasiAsets->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $instalasiAsets->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $instalasiAsets->appends(request()->query())->previousPageUrl() }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $instalasiAsets->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $instalasiAsets->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $instalasiAsets->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $instalasiAsets->appends(request()->query())->nextPageUrl() }}">
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

    @section('footer')
        <p></p>
    @endsection

@endsection
