@extends('layouts.admin')

@section('title', 'Page All Lokasi')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Master
                                        Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Lokasi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form action="" id="klasifikasi">
                            <div>
                                <h4 class="m-0">Lokasi</h4>
                        </form>
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

                            <div class="col d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('location.download-template') }}"
                                    class="btn btn-outline-success d-flex align-items-center gap-1"                                     
                                    aria-label="Unduh Template">
                                    <i class="sym sym-download"></i> Unduh Template
                                </a>

                                <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                                    data-bs-toggle="modal" data-bs-target="#importModal"
                                    aria-label="Import">
                                    <i class="sym sym-upload"></i> Import
                                </button>

                                <a href="{{ route('location.create') }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"
                                    aria-label="Tambah Data">
                                    <i class="sym sym-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                        {{-- Modal --}}
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('location.import-template') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Import Data dari Excel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 text-center">
                                                <div id="drop-area" class="border border-2 border-primary rounded-3 p-4"
                                                    style="border-style: dashed !important; cursor: pointer; background-color: #f8f9fa;"
                                                    onclick="document.getElementById('file-input').click();"
                                                    ondragover="event.preventDefault(); this.classList.add('bg-light');"
                                                    ondragleave="this.classList.remove('bg-light');"
                                                    ondrop="handleDrop(event)">

                                                    <p class="mb-2">Seret file ke sini atau klik untuk memilih</p>
                                                    <p class="small text-muted">Format yang diterima: .xlsx, .xls</p>

                                                    <input type="file" id="file-input" name="file"
                                                        accept=".xlsx, .xls" required hidden onchange="updateFileName()" />

                                                    <div id="file-name" class="text-success fw-bold mt-2"></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>

                                        <th style="min-width: 180px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nama Lokasi
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Jumlah Aset Terpasang
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                        <tr>
                                            <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $location->lokasi }}</td>
                                            <td>{{ $location->total_asets }}</td>
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Hapus" title="Hapus"
                                                        onclick="confirmDeletion({{ $location->id }})">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $location->id }}"
                                                        action="{{ route('location.destroy', $location->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="{{ route('location.edit', $location->id) }}">
                                                        <button type="button"
                                                            class="d-none d-md-block btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Edit" title="Edit">
                                                            <i class="sym sym-edit-solid"></i>
                                                        </button>
                                                    </a>
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
                                <span class="fw-bold">{{ $locations->firstItem() }}</span> -
                                <span class="fw-bold">{{ $locations->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $locations->total() }}</span> data
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
                                        $currentPage = $locations->currentPage();
                                        $lastPage = $locations->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $locations->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $locations->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $locations->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $locations->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $locations->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $locations->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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

{{-- script untuk show beberapa page --}}
<script>
    function updateItemsPerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = url.toString();
    }
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
