@extends('layouts.admin')

@section('title', 'Page Detail Aset')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Aset</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('end-user-aset.index') }}">Data End-User
                                        Aset</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 p-2"> <!-- Gunakan p-4 agar padding seragam -->

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
                        <a href="{{ route('end-user-aset.edit', $endUserAset->id) }}" class="btn btn-light ms-auto">
                            <i class="sym sym-edit-02"></i> Ubah Data
                        </a>
                    </div>

                    <!-- Detail Aset -->
                    <div class="col-12 px-3 py-3"> <!-- Samakan padding dengan header -->
                        <div class="row gy-4 align-items-start">
                            <!-- Gambar Aset -->
                            <div class="col-lg-4 d-flex justify-content-start">
                                <div class="text-center w-100">
                                    <span class="text-muted mb-2 d-block">Gambar Aset</span>
                                    @if ($endUserAset->aset->gambar_aset)
                                        <img src="{{ asset('storage/' . $endUserAset->aset->gambar_aset) }}"
                                            alt="Gambar Aset" class="img-thumbnail rounded-4"
                                            style="max-width: 300px; height: auto; object-fit: cover;" />
                                    @else
                                        <div class="text-muted">Tidak ada gambar</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Informasi Lainnya -->
                            <div class="col-lg-8">
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <span class="text-muted">Nomor Aset</span>
                                        <div>{{ $endUserAset->aset->nomor_aset }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted">Jenis Aset</span>
                                            <div>{{ $endUserAset->aset->jenisAset->name_jenis }}</div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            @if ($endUserAset->status_aset == 'stock')
                                                <span
                                                    class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                            @elseif ($endUserAset->status_aset == 'diperbaiki')
                                                <span
                                                    class="badge text-warning bg-warning bg-opacity-10 border border-warning">Diperbaiki</span>
                                            @elseif ($endUserAset->status_aset == 'terpakai')
                                                <span
                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                            @elseif ($endUserAset->status_aset == 'dipinjam')
                                                <span
                                                    class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>
                                            @elseif ($endUserAset->status_aset == 'retirement')
                                                <span
                                                    class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                            @elseif ($endUserAset->status_aset == 'dihibahkan')
                                                <span
                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Dihibahkan</span>
                                            @else
                                                <span>{{ $endUserAset->status_aset }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="text-muted">Klasifikasi Laptop</span>
                                        <div>{{ $endUserAset->klasifikasiLaptop->klasifikasi_laptop ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Merk Aset</span>
                                        <div>{{ $endUserAset->aset->merk_aset ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Spesifikasi Aset</span>
                                        <div>{{ $endUserAset->aset->spesifikasi_aset }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Harga Pembelian</span>
                                        <div>Rp {{ number_format($endUserAset->aset->harga_pembelian, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Tanggal Pembelian</span>
                                        <div>{{ \Carbon\Carbon::parse($endUserAset->aset->tanggal_pembelian)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Nama Pemegang</span>
                                        <div>{{ optional($endUserAset->user)->name_karyawan ?? '-' }}
                                            @if (optional($endUserAset->user)->job_role)
                                                | {{ optional($endUserAset->user)->job_role }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Serial Number</span>
                                        <div>{{ $endUserAset->serial_number ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Keterangan</span>
                                        <div>{{ $endUserAset->aset->keterangan ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request('tab') == 'historyPemegang' || request('tab') == '' ? 'active' : '' }}"
                            id="historyPemegang-tab" data-bs-toggle="tab" href="#historyPemegang" role="tab"
                            aria-controls="historyPemegang" aria-selected="true" onclick="setTab('historyPemegang')">Riwayat
                            Pemegang Aset</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request('tab') == 'historyMaintenance' ? 'active' : '' }}"
                            id="historyMaintenance-tab" data-bs-toggle="tab" href="#historyMaintenance" role="tab"
                            aria-controls="historyMaintenance" aria-selected="false"
                            onclick="setTab('historyMaintenance')">Riwayat Perbaikan Aset</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="myTabContent">
                    <!-- Riwayat Pemegang Aset Tab -->
                    <div class="tab-pane fade show {{ request('tab') == 'historyPemegang' || request('tab') == '' ? 'active' : '' }}"
                        id="historyPemegang" role="tabpanel" aria-labelledby="historyPemegang-tab">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <h4 class="m-0">Riwayat Pemegang Aset</h4>

                                {{-- Search Form --}}
                                <form method="GET" class="mt-4">
                                    <input type="hidden" name="tab" value="historyPemegang">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-3">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari.." value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>

                                {{-- Tabel Riwayat --}}
                                <div class="table-responsive mt-4" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light text-nowrap">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Pemegang</th>
                                                <th>Job Role</th>
                                                <th>Tim</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historyPemegangAset as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $history->tanggal ?? '-' }}</td>
                                                    <td>{{ $history->user->name_karyawan ?? '-' }}</td>
                                                    <td>{{ $history->user->job_role ?? '-' }}</td>
                                                    <td>{{ $history->user->team ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data riwayat pemegang
                                                        aset.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Riwayat Perbaikan Aset Tab -->
                    <div class="tab-pane fade show {{ request('tab') == 'historyMaintenance' ? 'active' : '' }}"
                        id="historyMaintenance" role="tabpanel" aria-labelledby="historyMaintenance-tab">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <h4 class="m-0">Riwayat Perbaikan Aset</h4>
                                <form method="GET"
                                    class="row mt-4 d-flex align-items-center justify-content-between gap-2">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-3">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search.." value="{{ request('search') }}"
                                                autocomplete="off" />
                                            <input type="hidden" name="tab" placeholder="Cari.."
                                                value="historyMaintenance" />
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mt-4" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-bordered align-middle">
                                        <thead class="align-middle">
                                            <tr class="table-light">
                                                <th>No</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Petugas</th>
                                                <th>Nama Pemegang</th>
                                                <th>Deskripsi Masalah</th>
                                                <th>Solusi</th>
                                                <th>Status Asal</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($histories as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <!-- Tanggal Selesai atau Tanggal Laporan -->
                                                    <td>
                                                        @if ($history instanceof \App\Models\AsetMaintenance && $history->tanggal_selesai)
                                                            {{ \Carbon\Carbon::parse($history->tanggal_selesai)->format('d/m/Y') }}
                                                        @elseif ($history instanceof \App\Models\AbnormalAset && $history->tanggal_perbaikan)
                                                            {{ \Carbon\Carbon::parse($history->tanggal_perbaikan)->format('d/m/Y') }}
                                                        @else
                                                            <em style="color: red">Masih Dalam Perbaikan</em>
                                                        @endif
                                                    </td>

                                                    <!-- Nama Petugas atau Pelapor -->
                                                    <td>
                                                        @if ($history instanceof \App\Models\AsetMaintenance)
                                                            {{ $history->petugas->name_karyawan ?? '-' }}
                                                        @elseif ($history instanceof \App\Models\AbnormalAset)
                                                            {{ $history->dilaporkan_oleh ?? '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <!-- Nama Pemegang Aset -->
                                                    <td>
                                                        {{ optional($history->pemegang)->name_karyawan ?? '-' }}
                                                    </td>

                                                    <!-- Deskripsi Permasalahan -->
                                                    <td>{{ $history->deskripsi_permasalahan ?? '-' }}</td>

                                                    <!-- Solusi (khusus Maintenance) -->
                                                    <td>{{ $history->solusi ?? '-' }}</td>

                                                    <!-- Status atau Jenis Riwayat -->
                                                    <td style="text-align: center;">
                                                        @if ($history instanceof \App\Models\AsetMaintenance)
                                                            <span
                                                                class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pemeliharaan</span>
                                                        @elseif ($history instanceof \App\Models\AbnormalAset)
                                                            <span
                                                                class="badge text-danger bg-danger bg-opacity-10 border border-danger">Problem
                                                                Tidak Normal</span>
                                                        @else
                                                            <span
                                                                class="badge text-info bg-info bg-opacity-10 border border-info">Tidak
                                                                Diketahui</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" style="text-align: center; color: red;">Tidak ada
                                                        data riwayat pemeliharaan atau masalah abnormal.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>



                                    </table>
                                </div>
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
@endsection
