@extends('layouts.admin')

@section('title', 'Page All Security Peripheral')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Aset</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Security Peripheral</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Security Peripheral</h4>
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-2 mt-3">
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
                            @can('akses-admin-superadmin')
                                <div class="col d-flex justify-content-end gap-2 flex-wrap">
                                    <button class="btn btn-primary d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#addDeviceModal">
                                        <i class="sym sym-plus"></i> Tambah
                                    </button>
                                </div>
                            @endcan
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width: 36px; width: 36px;"></th>
                                        <th style="min-width: 36px; width: 36px;">No</th>

                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Nama Aset: active to sort">
                                                Nama Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Lokasi Pemasangan: active to sort">
                                                Lokasi Pemasangan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Harga: active to sort">
                                                Harga
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 180px;">
                                            <button class="btn p-0 border-0 w-100 h-100 text-start"
                                                aria-label="Tanggal Pemasangan: active to sort">
                                                Tanggal Pemasangan
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        @can('akses-admin-superadmin')
                                            <th class="text-center" style="min-width: 124px;">Aksi</th>
                                        @endcan
                                    </tr>
                                </thead>

                                <tbody id="device-body">
                                    @if ($paginator && $paginator->count() > 0)
                                        @foreach ($paginator as $lot)
                                            <tr data-index="{{ $loop->index }}">
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary toggle-detail"
                                                        data-toggle-state="closed">▼</button>
                                                </td>
                                                <td class="text-center">
                                                    {{ ($paginator->currentPage() - 1) * $paginator->perPage() + $loop->iteration }}
                                                </td>
                                                <td>{{ $lot->jenisAsets->name_jenis ?? '-' }}</td>
                                                <td>{{ $lot->lokasi->lokasi ?? '-' }}</td>
                                                <td class="harga">Rp
                                                    {{ number_format($lot->harga, 0, ',', '.') }}
                                                </td>
                                                <td class="installation_date">
                                                    {{ $lot->installation_date ? date('d-m-Y', strtotime($lot->installation_date)) : '-' }}
                                                </td>
                                                @can('akses-admin-superadmin')
                                                    <td style="width: 124px;">
                                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                                            <!-- Tombol Edit -->
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary btn-edit"
                                                                aria-label="Edit" title="Edit" data-bs-toggle="modal"
                                                                data-bs-target="#editDeviceModal{{ $lot->id }}">
                                                                <i class="sym sym-edit-solid"></i>
                                                            </button>


                                                            <!-- Tombol Hapus -->
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-outline-secondary"
                                                                aria-label="Hapus" title="Hapus"
                                                                onclick="confirmDeletion({{ $lot->id }})">
                                                                <i class="sym sym-trash-solid"></i>
                                                            </button>

                                                            <!-- Form tersembunyi -->
                                                            <form id="delete-form-{{ $lot->id }}"
                                                                action="{{ route('security-peripheral.destroy', $lot->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                        </div>
                                                    </td>
                                                @endcan
                                            </tr>

                                            <!-- Baris detail yang tersembunyi -->
                                            <tr class="detail-row d-none" data-detail-index="{{ $loop->index }}">
                                                <td colspan="7">
                                                    <div class="table-responsive mt-2"
                                                        style="max-height: 350px; overflow: auto;">
                                                        <table class="table table-bordered align-middle">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th style="min-width: 36px; width: 36px;">No</th>
                                                                    <th style="min-width: 180px;">
                                                                        <button
                                                                            class="btn p-0 border-0 w-100 h-100 text-start"
                                                                            aria-label="Nama Aset: active to sort">
                                                                            Detail Aset
                                                                            <i
                                                                                class="float-end sym sym-switch-vertical"></i>
                                                                        </button>
                                                                    </th>
                                                                    <th style="min-width: 180px;">
                                                                        <button
                                                                            class="btn p-0 border-0 w-100 h-100 text-start"
                                                                            aria-label="Qty: active to sort">
                                                                            Qty
                                                                            <i
                                                                                class="float-end sym sym-switch-vertical"></i>
                                                                        </button>
                                                                    </th>
                                                                    <th style="min-width: 180px;">
                                                                        <button
                                                                            class="btn p-0 border-0 w-100 h-100 text-start"
                                                                            aria-label="Spesifikasi: active to sort">
                                                                            Spesifikasi
                                                                            <i
                                                                                class="float-end sym sym-switch-vertical"></i>
                                                                        </button>
                                                                    </th>

                                                                    @can('akses-admin-superadmin')
                                                                        <th class="text-center" style="min-width: 150px;">Aksi
                                                                        </th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody class="komponen-table"
                                                                data-lot-id="{{ $lot->id }}">
                                                                @forelse($lot->details as $detail)
                                                                    {{-- Row tampil data --}}
                                                                    <tr class="detail-data-row"
                                                                        data-detail-index="{{ $loop->index }}">
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td class="detail_device">
                                                                            {{ $detail->detail_device }}</td>
                                                                        <td class="quantity">{{ $detail->quantity }}</td>
                                                                        <td class="spesifikasi">
                                                                            {{ $detail->spesifikasi ?? '-' }}</td>
                                                                        {{-- <td class="harga">Rp
                                                                            {{ number_format($detail->harga, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="installation_date">
                                                                            {{ $detail->installation_date ? date('d-m-Y', strtotime($detail->installation_date)) : '-' }}
                                                                        </td> --}}
                                                                        @can('akses-admin-superadmin')
                                                                            <td style="width: 124px;">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-center gap-1">

                                                                                    <button type="button"
                                                                                        class="btn btn-icon btn-sm btn-outline-primary btn-edit"
                                                                                        aria-label="Edit" title="Edit"
                                                                                        data-index="{{ $loop->index }}">
                                                                                        <i class="sym sym-edit-solid"></i>
                                                                                    </button>

                                                                                    <button type="button"
                                                                                        class="btn btn-icon btn-sm btn-outline-danger btn-delete"
                                                                                        aria-label="Hapus" title="Hapus"
                                                                                        onclick="confirmDeletion({{ $detail->id }})">
                                                                                        <i class="sym sym-trash-solid"></i>
                                                                                    </button>

                                                                                    {{-- Form delete hidden --}}
                                                                                    <form id="delete-form-{{ $detail->id }}"
                                                                                        action="{{ route('security-peripheral.destroyDetails', $detail->id) }}"
                                                                                        method="POST" style="display: none;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                    </form>
                                                                                </div>
                                                                            </td>
                                                                        @endcan
                                                                    </tr>

                                                                    {{-- Row edit data (hidden by default) --}}
                                                                    <tr class="edit-row d-none"
                                                                        data-detail-index="{{ $loop->index }}">
                                                                        <form
                                                                            action="{{ route('security-peripheral.updateDetails', $detail->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <td></td>
                                                                            <td>
                                                                                <input type="text" name="detail_device"
                                                                                    class="form-control edit-detail_device"
                                                                                    value="{{ $detail->detail_device }}"
                                                                                    required />
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="quantity"
                                                                                    class="form-control edit-quantity"
                                                                                    value="{{ $detail->quantity }}"
                                                                                    required />
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="spesifikasi"
                                                                                    class="form-control edit-spesifikasi"
                                                                                    value="{{ $detail->spesifikasi }}"
                                                                                    required />
                                                                            </td>

                                                                            <td class="text-center">
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-success btn-update">Update</button>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-outline-success btn-cancel">Cancel</button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @empty
                                                                    <tr class="text-muted text-center no-komponen-row">
                                                                        <td colspan="6">Belum ada detail aset</td>
                                                                    </tr>
                                                                @endforelse

                                                                {{-- Row input tambah baru (template, hidden) --}}
                                                                <tr class="input-row-template d-none">
                                                                    <td></td>
                                                                    <td>
                                                                        <input type="text" name="detail_device"
                                                                            class="form-control"
                                                                            placeholder="Nama Komponen" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" name="quantity"
                                                                            class="form-control" placeholder="Qty"
                                                                            required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="spesifikasi"
                                                                            class="form-control" placeholder="Spesifikasi"
                                                                            required>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <!-- form akan disisipkan via JS -->
                                                                    </td>
                                                                </tr>




                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-primary w-100 btn-tambah-komponen">
                                                            <i class="sym sym-plus"></i> Tambah Detail Aset
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @push('modals')
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editDeviceModal{{ $lot->id }}"
                                                    tabindex="-1" aria-labelledby="editDeviceModalLabel{{ $lot->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <form action="{{ route('security-peripheral.update', $lot->id) }}"
                                                            method="POST" class="modal-content">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editDeviceModalLabel{{ $lot->id }}">
                                                                    Edit Security Peripheral
                                                                    {{ $lot->jenisAsets->name_jenis ?? '-' }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jenis Aset <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="jenis_aset_id" class="form-select" required>
                                                                        @foreach ($jenisAsets as $jenis)
                                                                            <option value="{{ $jenis->id }}"
                                                                                {{ $jenis->id == $lot->jenis_aset_id ? 'selected' : '' }}>
                                                                                {{ $jenis->name_jenis }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lokasi
                                                                        Pemasangan <span class="text-danger">*</span></label>
                                                                    <select name="lokasi_id" class="form-select" required>
                                                                        @foreach ($locations as $lokasi)
                                                                            <option value="{{ $lokasi->id }}"
                                                                                {{ $lokasi->id == $lot->lokasi_id ? 'selected' : '' }}>
                                                                                {{ $lokasi->lokasi }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Harga <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" name="harga" class="form-control"
                                                                        value="{{ $lot->harga }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Pemasangan <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="date" name="installation_date"
                                                                        class="form-control"
                                                                        value="{{ $lot->installation_date ? date('Y-m-d', strtotime($lot->installation_date)) : '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endpush
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endif
                                </tbody>


                            </table>


                        </div>

                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $paginator->firstItem() }}</span> -
                                <span class="fw-bold">{{ $paginator->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $paginator->total() }}</span> data
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
                                        $currentPage = $paginator->currentPage();
                                        $lastPage = $paginator->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $paginator->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $paginator->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $paginator->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $paginator->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $paginator->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-right"></i>
                                        </a>
                                    </li>


                                </ul>
                            </nav>


                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Tambah Device Lot -->
            <div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('security-peripheral.store') }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Security Peripheral Aset</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Jenis Aset <span class="text-danger">*</span></label>
                                <select name="jenis_aset_id" class="form-select" required>
                                    <option value="" disabled selected>Pilih Jenis Aset</option>
                                    @foreach ($jenisAsets as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->name_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lokasi Pemasangan <span class="text-danger">*</span></label>
                                <select name="lokasi_id" class="form-select" required>
                                    <option value="" disabled selected>Pilih Lokasi Pemasangan</option>
                                    @foreach ($locations as $lokasi)
                                        <option value="{{ $lokasi->id }}">{{ $lokasi->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pemasangan <span class="text-danger">*</span></label>
                                <input type="date" name="installation_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

    </main>
    @section('footer')
        <p></p>
    @endsection
    @stack('modals')



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        $(document).ready(function() {
            const $deviceBody = $(
                '#device-body'); // Pastikan ini element pembungkus tabel utama, ganti sesuai selector kamu

            // --- Inisialisasi awal ---
            $('.edit-row').addClass('d-none'); // Sembunyikan semua baris edit
            $('.detail-row').addClass('d-none'); // Sembunyikan semua baris detail (anak)

            // --- Ambil status baris terbuka dari localStorage ---
            const openRows = JSON.parse(localStorage.getItem('openRows')) || [];

            openRows.forEach(index => {
                const $detailRow = $(`.detail-row[data-detail-index="${index}"]`);
                const $toggleButton = $(`[data-index="${index}"] .toggle-detail`);

                $detailRow.removeClass('d-none'); // Tampilkan baris detail yang disimpan terbuka
                $toggleButton.text('▲'); // Ubah ikon panah sesuai status terbuka
            });

            // --- Toggle tombol untuk buka/tutup baris detail ---
            $deviceBody.on('click', '.toggle-detail', function() {
                const $button = $(this);
                const $row = $button.closest('tr');
                const index = $row.data('index');
                const $detailRow = $(`.detail-row[data-detail-index="${index}"]`);

                const isHidden = $detailRow.hasClass('d-none');
                $detailRow.toggleClass('d-none');
                $button.text(isHidden ? '▲' : '▼');

                // Simpan atau hapus dari localStorage
                let openRows = JSON.parse(localStorage.getItem('openRows')) || [];
                const idx = openRows.indexOf(index);

                if (!isHidden && idx > -1) {
                    openRows.splice(idx, 1); // Tutup detail
                } else if (isHidden && idx === -1) {
                    openRows.push(index); // Buka detail
                }

                localStorage.setItem('openRows', JSON.stringify(openRows));
            });

            // --- Tombol edit: sembunyikan detail-data, tampilkan baris edit ---
            $deviceBody.on('click', '.btn-edit', function() {
                const index = $(this).data('index');

                $(`.detail-data-row[data-detail-index="${index}"]`).addClass('d-none');
                $(`.edit-row[data-detail-index="${index}"]`).removeClass('d-none');
            });

            // --- Tombol cancel edit: sembunyikan form edit, tampilkan kembali data ---
            $deviceBody.on('click', '.btn-cancel', function() {
                const index = $(this).closest('tr').data('detail-index');

                $(`.edit-row[data-detail-index="${index}"]`).addClass('d-none');
                $(`.detail-data-row[data-detail-index="${index}"]`).removeClass('d-none');
            });

            // --- Tombol tambah komponen: clone baris input template dan tampilkan ---
            $deviceBody.on('click', '.btn-tambah-komponen', function(e) {
                e.preventDefault();

                const $tbody = $(this).closest('td').find('tbody.komponen-table');
                if ($tbody.length === 0) {
                    console.warn('tbody tidak ditemukan');
                    return;
                }

                const $template = $tbody.find('tr.input-row-template').first();
                if ($template.length === 0) {
                    console.warn('Template tidak ditemukan');
                    return;
                }

                const $newRow = $template.clone();
                $newRow.removeClass('d-none input-row-template').addClass('input-row');
                $newRow.find('input').val(''); // Kosongkan input

                // Buat form unik untuk setiap baris
                const uniqueId = 'form-' + Date.now();

                // Update semua input agar punya atribut `form="form-xxxx"`
                $newRow.find('input').each(function() {
                    $(this).attr('form', uniqueId);
                });

                // Buat form HTML-nya
                const csrf = $('meta[name="csrf-token"]').attr('content');
                const actionUrl = "{{ route('security-peripheral.details-store', $lot->id) }}";

                const formHtml = `
        <form method="POST" action="${actionUrl}" id="${uniqueId}" class="d-inline">
            <input type="hidden" name="_token" value="${csrf}">
            <button type="submit" class="btn btn-sm btn-success">Simpan</button>
        </form>
        <button type="button" class="btn btn-sm btn-outline-danger btn-cancel-input">Hapus</button>
    `;

                $newRow.find('td:last').html(formHtml);
                $tbody.append($newRow);
            });


            // --- Tombol cancel input baru: hapus baris input baru ---
            $deviceBody.on('click', '.btn-cancel-input', function() {
                const $inputRow = $(this).closest('tr');
                const $tbody = $inputRow.closest('tbody');

                $inputRow.remove();

                // Cek apakah ada baris data dan baris input aktif
                const hasData = $tbody.find('tr.detail-data-row').length > 0;
                const hasInputRow = $tbody.find('tr.input-row').length > 0;

                // Jika tidak ada data dan input row, tampilkan row no-komponen
                if (!hasData && !hasInputRow) {
                    $tbody.find('tr.no-komponen-row').show();
                }
            });
        });
    </script>


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
@endsection
