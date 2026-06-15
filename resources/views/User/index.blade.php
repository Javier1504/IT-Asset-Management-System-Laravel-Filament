@extends('layouts.admin')

@section('title', 'Page All Karyawan')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <!-- Spinner -->
        <div id="spinner"
            class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
            style="background-color: rgba(0, 0, 0, 0.5); z-index: 9999;">
            <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"></div>
            <span class="text-light ms-3" style="font-size: 1.5rem;">Loading...</span>
        </div>

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Pegawai</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"> Data Pegawai</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-block ms-1">
                            <h4 class="m-0">Data Pegawai</h4>
                            <span class="fs-6 text-secondary">Data Pegawai sinkronisasi dari tabel spreadsheet data
                                HC</span>
                        </div>
                        <hr>
                        <div class="row d-flex align-items-center justify-content-between gap-2">

                            <div class="col-md-3">
                                <form method="GET" action="{{ route('users.index') }}">
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



                            <div class="col d-flex justify-content-end align-items-center gap-2">

                            </div>
                            <div class="col-md-3 d-flex justify-content-end gap-2">
                                <button id="btn-refresh" class="btn btn-primary d-block d-lg-inline-block"
                                    aria-label="Refresh Data">
                                    <i class="sym sym-refresh-ccw"></i> Refresh
                                </button>

                            </div>
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
                                        <th style="min-width: 200px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Job Role
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Job Family
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Team
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 120px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Company
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 120px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Status
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Tanggal Masuk
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 250px;">
                                            <button
                                                class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                                                Alamat
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
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user['No'] ?? '-' }}</td>
                                            <td>{{ $user['Nama Karyawan'] ?? '-' }}</td>
                                            <td>{{ $user['Job Role'] ?? '-' }}</td>
                                            <td>{{ $user['Job Family'] ?? '-' }}</td>
                                            <td>{{ $user['Tim'] ?? '-' }}</td>
                                            <td>{{ $user['Company'] ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($user['Status'] == 'Kontrak')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Kontrak</span>
                                                @elseif ($user['Status'] == 'Tetap')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Tetap</span>
                                                @elseif ($user['Status'] == 'Onboard')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Onboard</span>
                                                @elseif ($user['Status'] == 'Magang')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Magang</span>
                                                @elseif ($user['Status'] == 'Dosen Kontrak')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Dosen
                                                        Kontrak</span>
                                                @elseif ($user['Status'] == 'Dosen Magang')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dosen
                                                        Magang</span>
                                                @else
                                                    <span>{{ $user['Status'] ?? '-' }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $user['Tgl Masuk'] ?? '-' }}</td>
                                            <td>{{ $user['Alamat'] ?? '-' }}</td>
                                            <td>{{ $user['Email'] ?? '-' }}</td>
                                            <td>{{ $user['Corporate Email'] ?? '-' }}</td>
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    @if (!empty($user['id']))
                                                        <a href="{{ route('users.show', $user['id']) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Lihat detail" title="Lihat detail">
                                                            <i class="sym sym-eye-solid"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">ID tidak ditemukan</span>
                                                    @endif
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
                                <span class="fw-bold">{{ $users->firstItem() }}</span> -
                                <span class="fw-bold">{{ $users->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $users->total() }}</span> data
                            </p>

                            <form method="GET" id="perPageForm">
                                @if (request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="d-flex align-items-center gap-2">
                                    <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                                    <select id="itemsPerPage" name="perPage" class="form-select form-select-sm"
                                        style="width: auto;" onchange="this.form.submit()">
                                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100
                                        </option>
                                        <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200
                                        </option>
                                        <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500
                                        </option>
                                        <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000
                                        </option>
                                    </select>
                                </div>
                            </form>


                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-0">

                                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                            aria-label="Sebelumnya">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @if ($startPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $users->url(1) }}">1</a>
                                        </li>
                                        @if ($startPage > 2)
                                            <li class="page-item disabled"><span class="page-link">…</span></li>
                                        @endif
                                    @endif

                                    @for ($i = $startPage; $i <= $endPage; $i++)
                                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($endPage < $lastPage)
                                        @if ($endPage < $lastPage - 1)
                                            <li class="page-item disabled"><span class="page-link">…</span></li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $users->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <li class="page-item {{ $users->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}"
                                            aria-label="Selanjutnya">
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

<script>
    // Fungsi untuk tampilkan spinner
    function showSpinner() {
        document.getElementById('spinner').classList.remove('d-none');
    }

    // Tampilkan spinner saat form filter disubmit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            showSpinner();
        });
    });

    // Tampilkan spinner saat select onchange
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            showSpinner();
        });
    });

    // Tampilkan spinner saat link pagination diklik
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function() {
            showSpinner();
        });
    });

    // Tampilkan spinner saat button refresh diklik
    const btnRefresh = document.getElementById('btn-refresh');
    if (btnRefresh) {
        btnRefresh.addEventListener('click', function() {
            showSpinner();
            btnRefresh.disabled = true;
            fetch("{{ route('users.refresh') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    location.reload();
                })
                .catch(error => {
                    alert('Gagal menyinkron data!');
                    console.error('Error:', error);
                });
        });
    }

    // Tampilkan spinner saat klik tombol "Lihat detail"
    document.querySelectorAll('a.btn-outline-secondary').forEach(link => {
        link.addEventListener('click', function() {
            showSpinner();
        });
    });

    // Tambahkan fallback spinner untuk submit perPage (yang tidak pakai form GET langsung)
    const perPageForm = document.getElementById('perPageForm');
    if (perPageForm) {
        perPageForm.addEventListener('submit', function() {
            showSpinner();
        });
    }
</script>


@endsection
