@extends('layouts.admin')

@section('title', 'Detail Aset Pribadi')

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
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Master</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('aset-pribadi.index') }}">Aset Pribadi</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Detail Aset Pribadi -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="m-0">Detail Aset Pribadi</h4>
                                <span class="text-muted">Informasi lengkap aset pribadi karyawan</span>
                            </div>
                            <div>
                                @if ($asetpribadi->status == 'pending')
                                    <span class="badge bg-warning fs-6">Pending</span>
                                @elseif ($asetpribadi->status == 'menunggu_manager')
                                    <span class="badge bg-warning fs-6">Menunggu Manager</span>
                                @elseif($asetpribadi->status == 'menunggu_admin')
                                    <span class="badge bg-info fs-6">Menunggu Admin</span>
                                @elseif($asetpribadi->status == 'disetujui')
                                    <span class="badge bg-success fs-6">Disetujui</span>
                                @elseif($asetpribadi->status == 'dicabut')
                                    <span class="badge bg-danger fs-6">Dicabut</span>
                                @elseif($asetpribadi->status == 'aktif')
                                    <span class="badge bg-primary fs-6">Aktif</span>
                                @elseif($asetpribadi->status == 'ditolak')
                                    <span class="badge bg-secondary fs-6">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary fs-6">{{ $asetpribadi->status }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Informasi Aset</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">Nama Aset:</td>
                                        <td>{{ $asetpribadi->nama_aset }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Merk:</td>
                                        <td>{{ $asetpribadi->merk }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Tipe:</td>
                                        <td>{{ $asetpribadi->tipe }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No. Seri:</td>
                                        <td>{{ $asetpribadi->no_seri }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sistem OS:</td>
                                        <td>{{ $asetpribadi->sistem_os }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">MAC Address:</td>
                                        <td>{{ $asetpribadi->mac_address }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Informasi User</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">Nama User:</td>
                                        <td>{{ $asetpribadi->user->name_karyawan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jabatan User:</td>
                                        <td>{{ $asetpribadi->user->job_role ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Divisi:</td>
                                        <td>{{ $asetpribadi->user->team ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Manager:</td>
                                        <td>{{ $asetpribadi->manager->name_karyawan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jabatan Manager:</td>
                                        <td>{{ $asetpribadi->manager->job_role ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Is Manager:</td>
                                        <td>{{ $asetpribadi->is_manager ? 'Ya' : 'Tidak' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($asetpribadi->nomor_pencabutan_user || $asetpribadi->alasan_pencabutan_user)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Informasi Pencabutan</h5>
                                    <table class="table table-borderless">
                                        @if ($asetpribadi->nomor_pencabutan_user)
                                            <tr>
                                                <td class="fw-bold" width="20%">No. Pencabutan:</td>
                                                <td>{{ $asetpribadi->nomor_pencabutan_user }}</td>
                                            </tr>
                                        @endif
                                        @if ($asetpribadi->alasan_pencabutan_user)
                                            <tr>
                                                <td class="fw-bold">Alasan Pencabutan:</td>
                                                <td>{{ $asetpribadi->alasan_pencabutan_user }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Approval Section for Manager -->

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2">
                            @if ($asetpribadi->status != 'aktif')
                                <a href="{{ route('aset-pribadi.detail', $asetpribadi->id) }}" class="btn btn-primary">
                                    <i class="sym sym-file-text-line"></i> Lihat Formulir PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
