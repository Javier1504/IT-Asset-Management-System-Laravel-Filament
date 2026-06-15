@extends('layouts.admin')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('title', 'Permintaan Aset Pribadi')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Permintaan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Aset Pribadi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Daftar Permintaan Aset Pribadi</h4>
                        <span class="text-muted">Di bawah ini adalah daftar permintaan aset pribadi karyawan.</span>

                        <div class="row g-3 mb-4 mt-3">
                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #FFF3C7;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Menunggu Manager</h5>
                                        <h1 class="fw-bold mt-2">{{ $pendingCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #D1ECF1;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Menunggu Admin</h5>
                                        <h1 class="fw-bold mt-2">{{ $menungguAdminCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #D4EDDA;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Disetujui</h5>
                                        <h1 class="fw-bold mt-2">{{ $approvedCount }}</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="card shadow-sm rounded-3" style="background-color: #F8C9C9;">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <h5 class="mb-1">Ditolak</h5>
                                        <h1 class="fw-bold mt-2">{{ $rejectedCount }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            <button type="submit" class="btn btn-primary">
                                                <i class="sym sym-search-default-solid"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <form method="GET" action="{{ route('aset-pribadi-request') }}">
                                            <select class="form-select" name="status" onchange="this.form.submit()">
                                                <option value="">Semua Status</option>
                                                <option value="pending"
                                                    {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Manager
                                                </option>
                                                <option value="menunggu_admin"
                                                    {{ request('status') == 'menunggu_admin' ? 'selected' : '' }}>Menunggu
                                                    Admin</option>
                                                <option value="disetujui"
                                                    {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                                                </option>
                                                <option value="ditolak"
                                                    {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('aset-pribadi-create-request') }}" class="btn btn-primary">
                                    <i class="sym sym-plus-line"></i> Tambah Permintaan
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>Jumlah Aset</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($asetpribadiRequests as $index => $request)
                                        <tr>
                                            <td>{{ $asetpribadiRequests->firstItem() + $index }}</td>
                                            <td>{{ $request->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $request->jabatan_user }}</td>
                                            <td>{{ $request->divisi }}</td>
                                            <td>{{ is_array($request->aset_pribadi) ? count($request->aset_pribadi) : 0 }}
                                                aset</td>
                                            <td>
                                                @if ($request->tanda_tangan_user_at == null && Auth::user()->id == $request->id_user)
                                                    <span class="badge bg-secondary">Perlu Ditandatangani</span>
                                                @elseif ($request->tanda_tangan_user_at == null && Auth::user()->role == 'manager')
                                                    <span class="badge bg-warning text-dark">Menunggu Tanda Tangan Pemohon</span>
                                                @else
                                                    @if ($request->status == 'pending')
                                                        <span class="badge bg-warning">Menunggu Manager</span>
                                                    @elseif($request->status == 'menunggu_admin')
                                                        <span class="badge bg-info">Menunggu Admin</span>
                                                    @elseif($request->status == 'disetujui')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($request->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('aset-pribadi-request-show', $request->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="sym sym-eye-line"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Tidak ada data permintaan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $asetpribadiRequests->firstItem() ?? 0 }} -
                                {{ $asetpribadiRequests->lastItem() ?? 0 }}
                                dari {{ $asetpribadiRequests->total() }} data
                            </div>
                            <div>
                                {{ $asetpribadiRequests->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
