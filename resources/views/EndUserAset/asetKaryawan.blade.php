@extends('layouts.admin')

@section('title', 'Page All Category')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Aset Saya</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Data Aset</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Aset Saya Saat Ini</h4>

                        <hr>
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-2">
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
                            <div class="col d-flex justify-content-end align-items-center gap-2">
                                <div class="col-md-3">
                                    <form method="GET" action="{{ route('aset-karyawan') }}">
                                        <select class="form-select" id="jenis_aset_id" name="jenis_aset_id"
                                            onchange="this.form.submit()" aria-label="Default select example">
                                            <option value="" {{ request('jenis_aset_id') == '' ? 'selected' : '' }}>
                                                Semua Jenis</option>
                                            @foreach ($jenisAsets as $jenis)
                                                <option value="{{ $jenis->id }}"
                                                    {{ request('jenis_aset_id') == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->name_jenis }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form method="GET" action="{{ route('aset-karyawan') }}">
                                        <select class="form-select" id="klasifikasi_laptop_id" name="klasifikasi_laptop_id"
                                            onchange="this.form.submit()" aria-label="Default select example">
                                            <option selected value="">Semua Klasifikasi Laptop</option>
                                            @foreach ($klasifikasiLaptops as $klasifikasi)
                                                <option value="{{ $klasifikasi->id }}"
                                                    {{ request('klasifikasi_laptop_id') == $klasifikasi->id ? 'selected' : '' }}>
                                                    {{ $klasifikasi->klasifikasi_laptop }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>

                            </div>

                        </div>


                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;" rowspan="2">No</th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Nomor Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Jenis Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 200px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Merk Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 300px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Spesifikasi Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Klasifikasi Aset<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Tanggal Beli<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 150px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Harga Beli<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start">Status<i
                                                    class="float-end sym sym-switch-vertical"></i></button>
                                        </th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @forelse ($endUserAsets as $aset)
                                        <tr>
                                            <td>{{ ($endUserAsets->currentPage() - 1) * $endUserAsets->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $aset->nomor_aset ?? '-' }}</td>
                                            <td>{{ $aset->jenis_aset ?? '-' }}</td>
                                            <td>{{ $aset->merk_aset ?? '-' }}</td>
                                            <td>{{ $aset->spesifikasi_aset ?? '-' }}</td>
                                            <td>{{ $aset->klasifikasi_laptop ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}</td>
                                            <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                                            <td style="text-align: center;">
                                                @if ($aset->status_aset == 'stock')
                                                    <span
                                                        class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                                @elseif ($aset->status_aset == 'diperbaiki')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Diperbaiki</span>
                                                @elseif ($aset->status_aset == 'terpakai')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                                @elseif ($aset->status_aset == 'dipinjam')
                                                    <span
                                                        class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>
                                                @elseif ($aset->status_aset == 'retirement')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                                @elseif ($aset->status_aset == 'dihibahkan')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dihibahkan</span>
                                                @else
                                                    <span>{{ $aset->status_aset }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">Data aset tidak tersedia.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>

                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $endUserAsets->firstItem() }}</span> -
                                <span class="fw-bold">{{ $endUserAsets->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $endUserAsets->total() }}</span> data
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
                                        $currentPage = $endUserAsets->currentPage();
                                        $lastPage = $endUserAsets->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $endUserAsets->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $endUserAsets->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $endUserAsets->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $endUserAsets->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $endUserAsets->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $endUserAsets->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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


    {{-- Script --}}
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
