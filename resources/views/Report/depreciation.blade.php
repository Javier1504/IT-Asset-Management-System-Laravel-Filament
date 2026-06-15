@extends('layouts.admin')

@section('title', 'Laporan Penyusutan Aset')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <!-- Breadcrumb -->
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Laporan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan Penyusutan Aset</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0 mb-4">Laporan Penyusutan Aset</h4>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('report.depreciation') }}">
                            <div class="row g-3 align-items-end mb-2">
                                <div class="col-md-3">
                                    <label for="month" class="form-label">Bulan Pembelian</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="">-- Semua Bulan --</option>
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ $m }}"
                                                {{ request('month') == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="year" class="form-label">Tahun Pembelian</label>
                                    <select name="year" id="year" class="form-select">
                                        <option value="">-- Semua Tahun --</option>
                                        @foreach (range(now()->year, now()->year - 10) as $y)
                                            <option value="{{ $y }}"
                                                {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="jenis_aset_id" class="form-label">Jenis Aset</label>
                                    <select name="jenis_aset_id" id="jenis_aset_id" class="form-select">
                                        <option value="">-- Semua Jenis Aset --</option>
                                        @foreach ($jenisAsetOptions as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ request('jenis_aset_id') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->name_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                                    <a href="{{ route('report.depreciation') }}"
                                        class="btn btn-outline-primary w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Form Search -->
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

                            <!-- Export Button -->
                            <a href="{{ route('report.depreciation.export', request()->query()) }}"
                                class="btn btn-success">
                                <i class="sym sym-file-download-02-solid"></i> Export Excel
                            </a>
                        </div>



                        <!-- Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;" rowspan="2">No</th>
                                        <th style="min-width: 120px; width: 10%;" rowspan="2">Jenis Aset</th>
                                        <th style="min-width: 150px; width: 10%;" rowspan="2">Nomor Aset</th>
                                        <th style="min-width: 150px; width: 10%;" rowspan="2">Merk Aset</th>
                                        <th style="min-width: 280px; width: 10%;" rowspan="2">Spesifikasi</th>
                                        <th style="min-width: 100px; width: 10%;" rowspan="2">Tanggal Beli</th>
                                        <th style="min-width: 140px; width: 10%;" rowspan="2">Harga Beli</th>

                                        @php
                                            $totalYears = $yearInit['endYear'] - $yearInit['earlyYear'] + 1;
                                            $colspan = 6 + 2 + $totalYears * 2 + 1;
                                        @endphp
                                        <th colspan="{{ $colspan }}" class="text-center">
                                            Nilai Penyusutan Aset
                                        </th>
                                    </tr>
                                    <tr class="table-light">
                                        <th style="min-width: 140px; width: 10%;" class="text-center">Harga/Bulan</th>
                                        <th style="min-width: 100px; width: 10%;" class="text-center">Cut Off</th>
                                        <th style="min-width: 100px; width: 10%;" class="text-center">Masa Umur</th>
                                        @for ($year = $yearInit['earlyYear']; $year <= $yearInit['endYear']; $year++)
                                            <th style="min-width: 140px; width: 10%;" class="text-center">
                                                {{ $year }}</th>
                                            <th style="min-width: 140px; width: 10%;" class="text-center">Nilai Sisa</th>
                                        @endfor
                                        <th style="min-width: 140px; width: 10%;" class="text-center">Total Penyusutan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($results->isEmpty())
                                        <tr>
                                            <td colspan="{{ 6 + $colspan }}" class="text-center">
                                                @if (request()->has('filter') && request('filter') !== null)
                                                    Data tidak ditemukan.
                                                @else
                                                    Harap filter dulu untuk menampilkan data.
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($results as $aset)
                                            <tr>
                                                <td>{{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}
                                                </td>
                                                <td>{{ $aset->jenis_aset ?? '-' }}</td>
                                                <td>{{ $aset->nomor_aset ?? '-' }}</td>
                                                <td>{{ $aset->merk_aset ?? '-' }}</td>
                                                <td>{{ $aset->spesifikasi_aset ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}
                                                </td>
                                                <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>

                                                <td>Rp {{ number_format($aset->harga_per_bulan, 0, ',', '.') }}</td>
                                                <td>{{ $aset->cut_off }}</td>
                                                <td>{{ $aset->masa_umur }}</td>

                                                @php
                                                    $depreciationValues = collect($aset->depreciation_data)->pad(
                                                        $totalYears * 2,
                                                        '-',
                                                    );
                                                @endphp

                                                @foreach ($depreciationValues as $value)
                                                    <td>
                                                        {{ $value !== '-' ? 'Rp ' . number_format($value, 0, ',', '.') : $value }}
                                                    </td>
                                                @endforeach

                                                <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $results->firstItem() }}</span> -
                                <span class="fw-bold">{{ $results->lastItem() }}</span>
                                dari Total <span class="fw-bold">{{ $results->total() }}</span> data
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
                                        $currentPage = $results->currentPage();
                                        $lastPage = $results->lastPage();
                                    @endphp

                                    <!-- Tombol Sebelumnya -->
                                    <li class="page-item {{ $results->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $results->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                            <i class="sym sym-arrow-narrow-left"></i>
                                        </a>
                                    </li>

                                    @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $results->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    @if ($lastPage > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($lastPage > 3)
                                        <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $results->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <!-- Tombol Selanjutnya -->
                                    <li class="page-item {{ $results->onLastPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $results->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
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
<script>
    function updateItemsPerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = url.toString();
    }
</script>
@endsection
