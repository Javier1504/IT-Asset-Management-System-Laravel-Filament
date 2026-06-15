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
                                <li class="breadcrumb-item"><a href="{{ route('office-aset.index') }}">Data Office Aset</a>
                                </li>
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
                        <a href="{{ route('office-aset.edit', $aset->id) }}" class="btn btn-light ms-auto">
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
                                    @if ($aset->aset->gambar_aset)
                                        <img src="{{ asset('storage/' . $aset->aset->gambar_aset) }}" alt="Gambar Aset"
                                            class="img-thumbnail rounded-4"
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
                                        <div>{{ $aset->aset->nomor_aset }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted">Jenis Aset</span>
                                            <div>{{ $aset->aset->jenisAset->name_jenis }}</div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            @if ($aset->status_aset == 'stock')
                                                <span
                                                    class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                                            @elseif ($aset->status_aset == 'terpakai')
                                                <span
                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                                            @elseif ($aset->status_aset == 'diperbaiki')
                                                <span
                                                    class="badge text-warning bg-warning bg-opacity-10 border border-warning">Dihibahkan</span>
                                            @elseif ($aset->status_aset == 'dihibahkan')
                                                <span
                                                    class="badge text-info bg-info bg-opacity-10 border border-info">Dipinjam</span>
                                            @elseif ($aset->status_aset == 'retirement')
                                                <span
                                                    class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                                            @else
                                                <span>{{ $aset->status_aset }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Lokasi Pemasangan</span>
                                        <div>{{ $aset->lokasi->lokasi ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Merk Aset</span>
                                        <div>{{ $aset->aset->merk_aset ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="text-muted">Harga Pembelian</span>
                                        <div>Rp {{ number_format($aset->aset->harga_pembelian, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Tanggal Pembelian</span>
                                        <div>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Keterangan</span>
                                        <div>{{ $aset->aset->keterangan ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Spesifikasi Aset</span>
                                        <div>{{ $aset->aset->spesifikasi_aset }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Riwayat Lokasi Pemasangan</h4>
                        <form method="GET" class="mt-4">
                            <input type="hidden">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari.."
                                        value="{{ request('search') }}" autocomplete="off">
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
                                        <th>Tanggal</th>
                                        <th>Lokasi Pemasangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historyLokasiAsets as $history)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $history->tanggal ?? '-' }}</td>
                                            <td>{{ $history->lokasi->lokasi ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
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
