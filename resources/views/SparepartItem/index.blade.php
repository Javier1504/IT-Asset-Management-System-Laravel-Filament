@extends('layouts.admin')

@section('title', 'Page All Sparepart Item')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Sparepart</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('jenis-sparepart.index') }}">Jenis
                                        Sparepart</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sparepart Item</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4 p-2">
                    <div
                        class="card-header d-flex gap-2 align-items-center justify-content-between flex-wrap bg-white border-light-subtle px-3 py-3 rounded-top-4 border-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="ratio ratio-1x1" style="width: 42px; min-width: 42px;">
                                <span class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                                    <i class="sym sym-shopping-bag-solid"></i>
                                </span>
                            </div>
                            <div class="d-block ms-1">
                                <h5 class="m-0">Informasi Aset</h5>
                                <span class="fs-6 text-secondary">Informasi detail aset</span>
                            </div>
                        </div>
                        <a href="{{ route('jenis-sparepart.edit', $jenisSparepart->id) }}" class="btn btn-light ms-auto">
                            <i class="sym sym-edit-02"></i> Ubah Data
                        </a>
                    </div>

                    <!-- Detail Aset -->
                    <div class="col-12 px-3 py-3"> <!-- Samakan padding dengan header -->
                        <div class="row gy-4 align-items-start">


                            <!-- Informasi Lainnya -->
                            <div class="col-lg-8">
                                <div class="row gy-3">
                                    <div class="col-md-3">
                                        <span class="text-muted">Jenis Sparepart</span>
                                        <div>{{ $jenisSparepart->jenis_sparepart ?? '-' }}</div>
                                    </div>

                                    <!-- Find and display the matching jenis_sparepart data -->
                                    @php
                                        $jenisSparepartData = $jenisSpareparts->firstWhere('id', $jenisSparepart->id);
                                    @endphp

                                    <div class="col-md-3">
                                        <span class="text-muted">Qty Masuk</span>
                                        <div>{{ $jenisSparepartData->qty_masuk ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <span class="text-muted">Qty Keluar</span>
                                        <div>{{ $jenisSparepartData->qty_keluar ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <span class="text-muted">Qty Sisa</span>
                                        <div>{{ $jenisSparepartData->qty_sisa ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form action="" id="categories">
                            <div>
                                <h4 class="m-0">Data Item Sparepart</h4>
                        </form>
                        <hr>
                        <div class="row align-items-center justify-content-between mb-3">

                            <!-- LEFT: FILTER FORM -->
                            <div class="col-md-6 d-flex flex-wrap gap-2">
                                <form method="GET" action="" class="d-flex gap-2 flex-wrap align-items-end w-100">
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Cari nama sparepart.." value="{{ request('search') }}"
                                            autocomplete="off">
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="sym sym-search"></i> Cari
                                    </button>

                                </form>
                            </div>

                            <!-- RIGHT: BUTTON TAMBAH -->
                            <div class="col-md-4 d-flex justify-content-md-end mt-2 mt-md-0 gap-2">
                                <a href="{{ route('sparepart-item.export', ['jenis_sparepart_id' => $jenisSparepart->id], request()->query()) }}"
                                    class="btn btn-success d-block d-lg-inline-block" aria-label="Tambah Data">
                                    <i class="sym sym-file-download-02"></i> Export Excel
                                </a>
                                <a href="{{ route('sparepart-item.create', ['jenis_sparepart_id' => $jenisSparepart->id]) }}"
                                    class="btn btn-primary d-block d-lg-inline-block" aria-label="Tambah Data">
                                    <i class="sym sym-plus"></i> Tambah
                                </a>
                            </div>

                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th rowspan="2" class="text-center align-middle" style="width: 36px;">No
                                        </th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 180px;">
                                            Nama Sparepart atau Aksesoris
                                        </th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">
                                            Qty Masuk
                                        </th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">
                                            Qty Keluar
                                        </th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">
                                            Qty Sisa
                                        </th>
                                        <th rowspan="2" class="text-center align-middle" style="min-width: 120px;">
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($sparepartItems as $index => $item)
                                        <tr data-group-id="{{ $item->id }}">
                                            <td class="text-center">{{ $sparepartItems->firstItem() + $index }}</td>
                                            <td class="editable-cell">
                                                <span class="text-value">{{ $item->nama_sparepart }}</span>
                                                <input type="hidden" name="ids[]" value="{{ $item->id }}">
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-value">{{ $item->checkinCheckoutSpareparts->where('tipe', 'checkin')->sum('qty') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-value">{{ $item->checkinCheckoutSpareparts->where('tipe', 'checkout')->sum('qty') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-value">{{ $item->checkinCheckoutSpareparts->where('tipe', 'checkin')->sum('qty') - $item->checkinCheckoutSpareparts->where('tipe', 'checkout')->sum('qty') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('checkin-checkout-spareparts.index', ['sparepart_id' => $item->id]) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        title="Lihat Detail">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm btn-outline-secondary" title="Edit"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        onclick="loadEditForm({{ $item->id }}, '{{ $item->nama_sparepart }}')">
                                                        <i class="sym sym-edit-solid"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Hapus" title="Hapus"
                                                        onclick="confirmDeletion({{ $item->id }})">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('sparepart-item.destroy', $item->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- EDIT MODAL -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="editForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Sparepart Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="form-label">Nama Sparepart <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="edit_nama" name="nama_sparepart"
                                                    class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $sparepartItems->firstItem() }}</span> -
                                <span class="fw-bold">{{ $sparepartItems->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $sparepartItems->total() }}</span> data
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
                                        $currentPage = $sparepartItems->currentPage();
                                        $lastPage = $sparepartItems->lastPage();
                                    @endphp

                                    @php
                                        $queryParams = http_build_query([
                                            'search' => request('search'),
                                            'status' => request('status'),
                                            'perPage' => request('perPage'),
                                        ]);
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $sparepartItems->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $sparepartItems->previousPageUrl() }}&{{ $queryParams }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $sparepartItems->url($page) }}&{{ $queryParams }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $sparepartItems->url($lastPage) }}&{{ $queryParams }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $sparepartItems->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $sparepartItems->nextPageUrl() }}&{{ $queryParams }}">
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
                html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
            });
        @endif
    </script>
    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'rounded-3 shadow',
                    confirmButton: 'btn btn-danger mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <script>
        function loadEditForm(id, nama) {
            document.getElementById('edit_nama').value = nama;

            document.getElementById('editForm').action =
                '/sparepart-item/' + id;
        }

        function updateItemsPerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1); // Reset ke halaman pertama
            window.location.href = url.toString();
        }
    </script>
@endsection
