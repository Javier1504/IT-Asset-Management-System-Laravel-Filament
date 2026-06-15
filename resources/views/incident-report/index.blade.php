@extends('layouts.admin')

@section('title', 'Laporan Insiden')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <!-- Breadcrumb -->
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan Insiden</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Laporan Insiden</h4>
                        <span class="text-muted">Kelola laporan insiden jaringan dan listrik</span>

                        <div class="row g-3 mb-4 mt-3">
                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #F9F4DD;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Open</h5>
                                        <h1 class="fw-bold mt-2">{{ $openCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #DFECFF;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">In Progress</h5>
                                        <h1 class="fw-bold mt-2">{{ $inProgressCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #d1ffde;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Resolved</h5>
                                        <h1 class="fw-bold mt-2">{{ $resolvedCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #E8E8E8;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Closed</h5>
                                        <h1 class="fw-bold mt-2">{{ $closedCount }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Filters -->
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-3">
                            <div class="col-md-3">
                                <form method="GET" action="{{ route('incident-report.index') }}">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari..."
                                                value="{{ request('search') }}" autocomplete="off">
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                            <input type="hidden" name="priority" value="{{ request('priority') }}">
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
                                <!-- Category Filter -->
                                <div class="col-md-2">
                                    <form method="GET" action="{{ route('incident-report.index') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="priority" value="{{ request('priority') }}">
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <select class="form-select" name="category" onchange="this.form.submit()">
                                            <option value="">Semua Kategori</option>
                                            <option value="network"
                                                {{ request('category') == 'network' ? 'selected' : '' }}>
                                                Network
                                            </option>
                                            <option value="listrik"
                                                {{ request('category') == 'listrik' ? 'selected' : '' }}>
                                                Listrik
                                            </option>
                                        </select>
                                    </form>
                                </div>

                                <!-- Priority Filter -->
                                <div class="col-md-2">
                                    <form method="GET" action="{{ route('incident-report.index') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <select class="form-select" name="priority" onchange="this.form.submit()">
                                            <option value="">Semua Prioritas</option>
                                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>
                                                Low</option>
                                            <option value="medium"
                                                {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>
                                                High</option>
                                        </select>
                                    </form>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <form method="GET" action="{{ route('incident-report.index') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="priority" value="{{ request('priority') }}">
                                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                        <select class="form-select" name="status" onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>
                                                Open</option>
                                            <option value="in_progress"
                                                {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="resolved"
                                                {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                                Closed</option>
                                        </select>
                                    </form>
                                </div>

                                <a href="{{ route('incident-report.create') }}" class="btn btn-primary">
                                    <i class="sym sym-add"></i> Laporan Baru
                                </a>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 200px; width: 10%;">
                                            No. Formulir</th>
                                        <th style="min-width: 200px; width: 10%;">Judul</th>
                                        <th style="min-width: 100px; width: 10%;">Kategori</th>
                                        <th style="min-width: 100px; width: 10%;">Prioritas</th>
                                        <th style="min-width: 100px; width: 10%;">Status</th>
                                        <th style="min-width: 100px; width: 10%;">Dilaporkan Oleh</th>
                                        <th style="min-width: 100px; width: 10%;">Ditugaskan Ke</th>
                                        <th style="min-width: 100px; width: 10%;">Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($incidents as $incident)
                                        <tr>
                                            <td>{{ $incident->nomor_formulir }}</td>
                                            <td>{{ $incident->title }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $incident->category == 'network' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($incident->category) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $incident->priority == 'high' ? 'danger' : ($incident->priority == 'medium' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($incident->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $incident->status == 'open' ? 'warning' : ($incident->status == 'in_progress' ? 'info' : ($incident->status == 'resolved' ? 'success' : 'secondary')) }}">
                                                    {{ str_replace('_', ' ', ucfirst($incident->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $incident->reporter->name_karyawan ?? '-' }}</td>
                                            <td>{{ $incident->assignee->name_karyawan ?? 'Belum ditugaskan' }}</td>
                                            <td>{{ $incident->created_at->format('d M Y') }}</td>
                                            <td style="width: 124px">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('incident-report.show', $incident) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Lihat Detail" title="Detail">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>
                                                    <a href="{{ route('incident-report.edit', $incident) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary" title="Edit"
                                                        aria-label="Edit">
                                                        <i class="sym sym-edit-solid"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Hapus" title="Hapus"
                                                        onclick="confirmDeletion({{ $incident->id }})">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $incident->id }}"
                                                        action="{{ route('instalasi-aset.destroy', $incident->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $incidents->firstItem() }}</span> -
                                <span class="fw-bold">{{ $incidents->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $incidents->total() }}</span> data
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
                                        $currentPage = $incidents->currentPage();
                                        $lastPage = $incidents->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $incidents->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $incidents->appends(request()->query())->previousPageUrl() }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $incidents->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $incidents->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $incidents->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $incidents->appends(request()->query())->nextPageUrl() }}">
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

@endsection


@push('scripts')
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
@endpush
