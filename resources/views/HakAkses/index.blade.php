@extends('layouts.admin')

@section('title', 'Page All Akses')

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
                                <li class="breadcrumb-item active" aria-current="page"> Hak Akses</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form action="" id="categories">
                            <div>
                                <h4 class="m-0">Hak Akses</h4>
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

                            <div class="col-md-3">
                                <form method="GET"
                                    action="{{ route('permissions.index') }}">
                                    <select class="form-select" id="role_permintaan" name="role_permintaan"
                                        onchange="this.form.submit()" aria-label="Default select example">
                                        <option value="" {{ request('role_permintaan') == '' ? 'selected' : '' }}>
                                            Filter Hak Akses
                                        </option>
                                        <option value="admin"
                                            {{ request('role_permintaan') == 'admin' ? 'selected' : '' }}>Admin IT
                                        </option>
                                        <option value="finance"
                                            {{ request('role_permintaan') == 'finance' ? 'selected' : '' }}>Finance                                        </option>
                                        <option value="manager"
                                            {{ request('role_permintaan') == 'manager' ? 'selected' : '' }}>Manager
                                        </option>
                                    </select>
                                </form>
                            </div>


                            @can('super_admin')
                            <div class="col d-flex justify-content-end align-items-center gap-2">
                                {{-- Tombol tambah data --}}
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('permissions.create') }}" class="btn btn-primary d-block"
                                        aria-label="Tambah Data">
                                        <i class="sym sym-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                            @endcan
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 200px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Nama
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 120px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Hak Akses
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>


                                        <th style="min-width: 200px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Email
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Corporate Email
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>

                                        @can('super_admin')
                                        <th class="text-center">Aksi</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $user->name_karyawan ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($user->role == 'admin')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Admin
                                                        IT</span>
                                                @elseif ($user->role == 'finance')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Finance</span>
                                                @elseif ($user->role == 'manager')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Manager</span>

                                                @else
                                                    <span>{{ $user->role }}</span>
                                                @endif
                                            </td>

                                            <td>{{ $user->email ?? '-' }}</td>
                                            <td>{{ $user->corporate_email ?? '-' }}</td>
                                            @can('super_admin')
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">

                                                    <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Hapus" title="Hapus"
                                                        onclick="confirmDeletion({{ $user->id }})">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('permissions.destroy', $user->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <a href="{{ route('permissions.edit', $user->id) }}" class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Edit" title="Edit">
                                                         <i class="sym sym-settings-02-solid"></i>
                                                    </a>

                                                </div>
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
                                <span class="fw-bold">{{ $users->firstItem() }}</span> -
                                <span class="fw-bold">{{ $users->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $users->total() }}</span> data
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
                                        $currentPage = $users->currentPage();
                                        $lastPage = $users->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $users->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $users->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $users->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $users->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $users->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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
@endsection
