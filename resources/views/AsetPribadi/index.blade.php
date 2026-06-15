@extends('layouts.admin')

@section('title', 'Aset Pribadi')

@section('content')

    @use(Illuminate\Support\Facades\Auth)
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                @if (request()->is('daftar-tanda-tangan/pencabutan-asetpribadi'))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Form Pencabutan Aset Pribadi</li>
                                @else
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>
                                            Master</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Aset Pribadi</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                    @if (!request()->is('daftar-tanda-tangan/pencabutan-asetpribadi'))
                        <a href="{{ route('aset-pribadi-create-request') }}" class="btn btn-primary">
                            <i class="sym sym-plus"></i> Ajukan Penggunaan Aset Pribadi
                        </a>
                    @endif
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        @if (request()->is('daftar-tanda-tangan/pencabutan-asetpribadi'))
                            <h4 class="m-0">Form Pencabutan Aset Pribadi</h4>
                            <span class="text-muted">Di bawah ini adalah daftar aset pribadi yang perlu Anda tanda tangani
                                untuk proses pencabutan.</span>
                        @else
                            <h4 class="m-0">Daftar Aset Pribadi</h4>
                            <span class="text-muted">Di bawah ini adalah daftar aset pribadi karyawan.</span>
                        @endif

                        <div class="row g-3 mb-4 mt-3">

                            <div class="col-12 col-md-4">
                                <div class="card shadow-sm rounded-3" style="background-color: #D4EDDA;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Aset Pribadi Aktif</h5>
                                        <h1 class="fw-bold mt-2">{{ $activeCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card shadow-sm rounded-3" style="background-color: #D1ECF1;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Menunggu Pencabutan</h5>
                                        <h1 class="fw-bold mt-2">{{ $menungguAdminCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card shadow-sm rounded-3" style="background-color: #F8D7DA;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Aset Telah Dicabut</h5>
                                        <h1 class="fw-bold mt-2">{{ $revokedCount }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <form method="GET" action="{{ route('aset-pribadi.index') }}"
                                    class="d-flex gap-3 flex-wrap">
                                    <div class="flex-grow-1">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control" placeholder="Cari nama aset, merk, tipe, user...">
                                    </div>
                                    <div>
                                        <select name="status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="menunggu_admin"
                                                {{ request('status') == 'menunggu_admin' ? 'selected' : '' }}>
                                                Menunggu Admin</option>
                                            <option value="dicabut" {{ request('status') == 'dicabut' ? 'selected' : '' }}>
                                                Dicabut</option>
                                        </select>
                                    </div>
                                    <div>
                                        <select name="perPage" class="form-select">
                                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request('perPage') == '25' ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('perPage') == '50' ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('perPage') == '100' ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="sym sym-search"></i> Cari
                                    </button>
                                    <a href="{{ route('aset-pribadi.index') }}" class="btn btn-outline-secondary">
                                        <i class="sym sym-refresh"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Nama Aset</th>
                                        <th>MAC Address</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($asetpribadis as $index => $asetpribadi)
                                        <tr>
                                            <td>{{ ($asetpribadis->currentPage() - 1) * $asetpribadis->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $asetpribadi->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $asetpribadi->nama_aset }}</td>
                                            <td>{{ $asetpribadi->mac_address }}</td>
                                            <td>
                                                @if ($asetpribadi->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($asetpribadi->status == 'menunggu_manager')
                                                    <span class="badge bg-warning">Menunggu Manager</span>
                                                @elseif($asetpribadi->status == 'menunggu_admin')
                                                    <span class="badge bg-info">Menunggu Admin</span>
                                                @elseif($asetpribadi->status == 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($asetpribadi->status == 'dicabut')
                                                    <span class="badge bg-danger">Dicabut</span>
                                                @elseif($asetpribadi->status == 'aktif')
                                                    <span class="badge bg-primary">Aktif</span>
                                                @elseif($asetpribadi->status == 'ditolak')
                                                    <span class="badge bg-secondary">Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $asetpribadi->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('aset-pribadi.show', $asetpribadi->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="sym sym-eye"></i> Detail
                                                    </a>
                                                    @if ($asetpribadi->status != 'aktif')
                                                        <a href="{{ route('aset-pribadi.detail', $asetpribadi->id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="sym sym-file-03"></i> Form
                                                        </a>
                                                    @endif
                                                    @can('akses-admin-superadmin')
                                                        @if ($asetpribadi->status == 'aktif')
                                                            <a href="{{ route('aset-pribadi.cabut', $asetpribadi->id) }}"
                                                                class="btn btn-sm btn-outline-danger">
                                                                <i class="sym sym-trash"></i> Cabut
                                                            </a>
                                                        @endif
                                                        @if ($asetpribadi->status == 'aktif' || $asetpribadi->status == 'pending')
                                                            <a href="{{ route('aset-pribadi.edit', $asetpribadi->id) }}"
                                                                class="btn btn-sm btn-outline-warning">
                                                                <i class="sym sym-edit"></i> Edit
                                                            </a>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada data aset pribadi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $asetpribadis->firstItem() ?? 0 }} - {{ $asetpribadis->lastItem() ?? 0 }}
                                dari {{ $asetpribadis->total() }} data
                            </div>
                            <div>
                                {{ $asetpribadis->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
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
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endsection
