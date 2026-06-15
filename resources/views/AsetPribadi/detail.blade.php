@extends('layouts.admin')

<title>{{ $incrementNumber ?? '' }}. Formulir Aset Pribadi_SEVIMA</title>

@section('content')
    @use(Illuminate\Support\Facades\Auth)
    <!-- Main Content -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <!-- [START] Breadcrumbs -->
                <div class="d-flex align-items-center gap-1 px-0 mb-3">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            @if (request()->routeIs('aset-pribadi.detail', $asetpribadi->id))
                                <li class="breadcrumb-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="sym sym-home-line me-1"></i>Master
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('aset-pribadi.index') }}" class="text-decoration-none">
                                        Aset Pribadi
                                    </a>
                                </li>
                            @elseif(request()->routeIs('daftar-tanda-tangan.detailPencabutanAsetpribadi', $asetpribadi->id))
                                <li class="breadcrumb-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="sym sym-home-line me-1"></i>Tanda Tangan
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('daftar-tanda-tangan.PencabutanAsetpribadi') }}"
                                        class="text-decoration-none">
                                        Aset Pribadi
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active fw-medium" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div
                    class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 px-0 mb-4">
                    <h4 class="m-0 text-dark fw-bold">Formulir Aset Pribadi</h4>

                    <!-- Actions Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end align-items-center">
                        <!-- Tombol Tanda Tangan Pemohon -->
                        @if ($asetpribadi->status == 'pending' && Auth::user()->id === $asetpribadi->id_user && !$asetpribadi->tanda_tangan_user)
                            <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
                                <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                                    id="signButtonPemohon" data-bs-toggle="modal" data-bs-target="#modalSignPemohon"
                                    title="Tanda Tangani sebagai Pemohon"
                                    style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="sym sym-signature"></i>
                                    <span>Tanda Tangani</span>
                                </button>
                            </div>
                        @endif

                        <!-- Tombol Tanda Tangan Manager -->
                        @if (
                            $asetpribadi->status == 'menunggu_manager' &&
                                $asetpribadi->id_manager == Auth::user()->id &&
                                !$asetpribadi->tanda_tangan_manager)
                            <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
                                <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                                    id="signButtonManager" data-bs-toggle="modal" data-bs-target="#modalSignManager"
                                    title="Tanda Tangani sebagai Manager"
                                    style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="sym sym-signature"></i>
                                    <span>Tanda Tangani</span>
                                </button>
                            </div>
                        @endif

                        <!-- Tombol Persetujuan Admin -->
                        @can('akses-admin-superadmin')
                            @if ($asetpribadi->status == 'menunggu_admin' && !$asetpribadi->tanda_tangan_admin)
                                <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
                                    <button type="button" class="btn btn-success d-flex align-items-center gap-2 shadow-lg"
                                        id="signButtonAdmin" data-bs-toggle="modal" data-bs-target="#modalSignAdmin"
                                        title="Setujui sebagai Admin"
                                        style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(25, 135, 84, 0.45) !important; transition: transform 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="sym sym-check-circle"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Tombol Aksi untuk Status Aktif -->
                            @if ($asetpribadi->status == 'aktif')
                                <a href="{{ route('aset-pribadi.edit', $asetpribadi->id) }}"
                                    class="btn btn-warning d-flex align-items-center gap-2 px-3 py-2" title="Edit Data Aset">
                                    <i class="sym sym-edit"></i>
                                    <span>Edit</span>
                                </a>
                            @endif

                            <!-- Tombol Aksi untuk Status Pending/Menunggu Admin -->
                            @if (in_array($asetpribadi->status, ['pending', 'menunggu_admin']))
                                <form action="{{ route('aset-pribadi.batalkan', $asetpribadi->id) }}" method="POST"
                                    class="d-none" id="formBatalkan">
                                    @csrf
                                </form>

                                {{-- Jika menunggu_admin: Batalkan naik ke atas tombol Setujui --}}
                                {{-- Jika pending saja: Batalkan di posisi bawah normal --}}
                                <div
                                    style="position: fixed; bottom: {{ $asetpribadi->status == 'menunggu_admin' ? '5.5rem' : '2rem' }}; right: 2rem; z-index: 1050;">
                                    <button type="button" class="btn btn-danger d-flex align-items-center gap-2 shadow-lg"
                                        onclick="confirmBatalkan()" title="Batalkan Pengajuan"
                                        style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(220, 53, 69, 0.45) !important; transition: transform 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="sym sym-x"></i>
                                        <span>Batalkan Pencabutan</span>
                                    </button>
                                </div>
                            @endif
                        @endcan
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

                <!-- [START] Card for Tanda Tangani Section -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 text-primary">
                            <i class="sym sym-signature me-2"></i>Status Tanda Tangan
                        </h5>

                        <div class="row g-3">
                            <!-- Pemohon -->
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <h6 class="fw-bold text-dark mb-2">Pemohon</h6>
                                    <p class="mb-1 fw-medium">{{ $asetpribadi->user->name_karyawan ?? '-' }}</p>
                                    @if ($asetpribadi->tanda_tangan_user)
                                        <div class="d-flex align-items-center text-success">
                                            <i class="sym sym-check-circle me-1"></i>
                                            <small>Ditandatangani</small>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_user_at)->format('d/m/Y H:i') }}
                                        </small>
                                    @else
                                        <div class="d-flex align-items-center text-warning">
                                            <i class="sym sym-clock me-1"></i>
                                            <small>Belum ditandatangani</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Manager -->
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <h6 class="fw-bold text-dark mb-2">Manager / PJ Data</h6>
                                    <p class="mb-1 fw-medium">{{ $asetpribadi->manager->name_karyawan ?? '-' }}</p>
                                    @if ($asetpribadi->tanda_tangan_manager)
                                        <div class="d-flex align-items-center text-success">
                                            <i class="sym sym-check-circle me-1"></i>
                                            <small>Ditandatangani</small>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_manager_at)->format('d/m/Y H:i') }}
                                        </small>
                                    @else
                                        <div class="d-flex align-items-center text-warning">
                                            <i class="sym sym-clock me-1"></i>
                                            <small>Belum ditandatangani</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Admin -->
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <h6 class="fw-bold text-dark mb-2">Admin</h6>
                                    <p class="mb-1 fw-medium">
                                        {{ $asetpribadi->admin->name_karyawan ?? 'Belum ditentukan' }}</p>
                                    @if ($asetpribadi->tanda_tangan_admin)
                                        <div class="d-flex align-items-center text-success">
                                            <i class="sym sym-check-circle me-1"></i>
                                            <small>Ditandatangani</small>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_admin_at)->format('d/m/Y H:i') }}
                                        </small>
                                    @else
                                        <div class="d-flex align-items-center text-warning">
                                            <i class="sym sym-clock me-1"></i>
                                            <small>Belum ditandatangani</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->

                <!-- [START] Card for Status Information -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 text-primary">
                            <i class="sym sym-info-circle me-2"></i>Informasi Aset
                        </h5>

                        <!-- Status Badge -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Status Pencabutan:</h6>
                            @if ($asetpribadi->status == 'pending')
                                <span class="badge bg-warning fs-6 px-3 py-2">
                                    <i class="sym sym-clock me-1"></i>Pending
                                </span>
                            @elseif ($asetpribadi->status == 'menunggu_manager')
                                <span class="badge bg-warning fs-6 px-3 py-2">
                                    <i class="sym sym-hourglass me-1"></i>Menunggu Manager / PJ Data
                                </span>
                            @elseif($asetpribadi->status == 'menunggu_admin')
                                <span class="badge bg-info fs-6 px-3 py-2">
                                    <i class="sym sym-hourglass me-1"></i>Menunggu Admin
                                </span>
                            @elseif($asetpribadi->status == 'disetujui')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="sym sym-check-circle me-1"></i>Disetujui
                                </span>
                            @elseif($asetpribadi->status == 'ditolak')
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="sym sym-x-circle me-1"></i>Ditolak
                                </span>
                            @elseif($asetpribadi->status == 'dicabut')
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    <i class="sym sym-trash me-1"></i>Dicabut
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6 px-3 py-2">{{ $asetpribadi->status }}</span>
                            @endif
                        </div>
                        <!-- Status Keputusan -->
                        @if ($asetpribadi->keputusan_manager || $asetpribadi->keputusan_admin)
                            <hr class="my-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="sym sym-check-square me-2"></i>Status Persetujuan
                            </h6>
                            <div class="row g-3">
                                @if ($asetpribadi->keputusan_manager)
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-warning bg-opacity-25 border-0">
                                                <h6 class="mb-0 fw-bold">
                                                    <i class="sym sym-user-check me-2"></i>Keputusan Manager / PJ Data
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <strong class="text-muted">Keputusan:</strong>
                                                    <span
                                                        class="badge {{ $asetpribadi->keputusan_manager == 'disetujui' ? 'bg-success' : 'bg-danger' }} ms-2">
                                                        <i
                                                            class="sym sym-{{ $asetpribadi->keputusan_manager == 'disetujui' ? 'check' : 'x' }} me-1"></i>
                                                        {{ ucfirst($asetpribadi->keputusan_manager) }}
                                                    </span>
                                                </div>

                                                @if ($asetpribadi->status_backup)
                                                    <div class="mb-3">
                                                        <strong class="text-muted">Status Backup:</strong>
                                                        <span class="badge bg-secondary ms-2">
                                                            {{ ucfirst(str_replace('_', ' ', $asetpribadi->status_backup)) }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($asetpribadi->acc_manager)
                                                    <div class="mb-3">
                                                        <i class="sym sym-calendar me-1"></i>
                                                        <small>{{ \Carbon\Carbon::parse($asetpribadi->acc_manager_at)->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                @endif

                                                @if ($asetpribadi->catatan_manager)
                                                    <div class="mb-3">
                                                        <strong class="text-muted">Catatan:</strong>
                                                        <p class="mb-0 mt-1 text-dark">{{ $asetpribadi->catatan_manager }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($asetpribadi->keputusan_admin)
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-info bg-opacity-25 border-0">
                                                <h6 class="mb-0 fw-bold">
                                                    <i class="sym sym-user-gear me-2"></i>Keputusan Admin
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <strong class="text-muted">Keputusan:</strong>
                                                    <span
                                                        class="badge {{ $asetpribadi->keputusan_admin == 'disetujui' ? 'bg-success' : 'bg-danger' }} ms-2">
                                                        <i
                                                            class="sym sym-{{ $asetpribadi->keputusan_admin == 'disetujui' ? 'check' : 'x' }} me-1"></i>
                                                        {{ ucfirst($asetpribadi->keputusan_admin) }}
                                                    </span>
                                                </div>

                                                @if ($asetpribadi->status_reset_os)
                                                    <div class="mb-3">
                                                        <strong class="text-muted">Status Reset OS:</strong>
                                                        <span class="badge bg-secondary ms-2">
                                                            {{ ucfirst(str_replace('_', ' ', $asetpribadi->status_reset_os)) }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($asetpribadi->tanda_tangan_admin_at)
                                                    <div class="mb-3">
                                                        <i class="sym sym-calendar me-1"></i>
                                                        <small>{{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_admin_at)->format('d/m/Y H:i') ?? '' }}</small>
                                                    </div>
                                                @endif

                                                @if ($asetpribadi->catatan_admin)
                                                    <div class="mb-3">
                                                        <strong class="text-muted">Catatan:</strong>
                                                        <p class="mb-0 mt-1 text-dark">{{ $asetpribadi->catatan_admin }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <!-- [END] Card for Status Information -->

                <!-- [START] Card for Withdrawal Signatures -->
                @if (
                    $asetpribadi->nomor_pencabutan_user &&
                        ($asetpribadi->tanda_tangan_pencabutan_user ||
                            $asetpribadi->tanda_tangan_pencabutan_manager ||
                            $asetpribadi->tanda_tangan_pencabutan_admin))
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 text-danger">
                                <i class="sym sym-signature me-2"></i>Tanda Tangan Proses Pencabutan
                            </h5>

                            <div class="row g-3">
                                <!-- Pemegang Aset -->
                                <div class="col-md-4">
                                    <div
                                        class="border rounded-3 p-3 h-100 {{ $asetpribadi->tanda_tangan_pencabutan_user ? 'bg-light border-success' : 'bg-light' }}">
                                        <h6 class="fw-bold text-dark mb-2">Pemegang Aset</h6>
                                        <p class="mb-1 fw-medium">{{ $asetpribadi->user->name_karyawan ?? '-' }}</p>
                                        @if ($asetpribadi->tanda_tangan_pencabutan_user)
                                            <div class="d-flex align-items-center text-success mb-2">
                                                <i class="sym sym-check-circle me-1"></i>
                                                <small>Sudah Ditandatangani</small>
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_pencabutan_user_at)->format('d/m/Y H:i') }}
                                            </small>
                                        @else
                                            <div class="d-flex align-items-center text-warning">
                                                <i class="sym sym-clock me-1"></i>
                                                <small>Menunggu Tanda Tangan</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Manager -->
                                <div class="col-md-4">
                                    <div
                                        class="border rounded-3 p-3 h-100 {{ $asetpribadi->tanda_tangan_pencabutan_manager ? 'bg-light border-success' : 'bg-light' }}">
                                        <h6 class="fw-bold text-dark mb-2">Manager / PJ Data</h6>
                                        <p class="mb-1 fw-medium">{{ $asetpribadi->manager->name_karyawan ?? '-' }}</p>
                                        @if ($asetpribadi->tanda_tangan_pencabutan_manager)
                                            <div class="d-flex align-items-center text-success mb-2">
                                                <i class="sym sym-check-circle me-1"></i>
                                                <small>Sudah Diverifikasi</small>
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_pencabutan_manager_at)->format('d/m/Y H:i') }}
                                            </small>
                                            @if ($asetpribadi->status_backup)
                                                <div class="mt-1">
                                                    <small
                                                        class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $asetpribadi->status_backup)) }}</small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center text-warning">
                                                <i class="sym sym-clock me-1"></i>
                                                <small>Menunggu Verifikasi</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Admin -->
                                <div class="col-md-4">
                                    <div
                                        class="border rounded-3 p-3 h-100 {{ $asetpribadi->tanda_tangan_pencabutan_admin ? 'bg-light border-success' : 'bg-light' }}">
                                        <h6 class="fw-bold text-dark mb-2">Admin</h6>
                                        <p class="mb-1 fw-medium">
                                            {{ $asetpribadi->admin->name_karyawan ?? 'Belum ditentukan' }}</p>
                                        @if ($asetpribadi->tanda_tangan_pencabutan_admin)
                                            <div class="d-flex align-items-center text-success mb-2">
                                                <i class="sym sym-check-circle me-1"></i>
                                                <small>Sudah Difinalisasi</small>
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($asetpribadi->tanda_tangan_pencabutan_admin_at)->format('d/m/Y H:i') }}
                                            </small>
                                            @if ($asetpribadi->status_reset_os)
                                                <div class="mt-1">
                                                    <small
                                                        class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $asetpribadi->status_reset_os)) }}</small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center text-warning">
                                                <i class="sym sym-clock me-1"></i>
                                                <small>Menunggu Finalisasi</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- [END] Card for Withdrawal Signatures -->

                <!-- [START] Card for Document Preview -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe id="printFrame" src="{{ route('aset-pribadi.download', $asetpribadi->id) }}"
                                class="w-100 h-100 border-0" allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                <!-- [END] Card for Document Preview -->

            </div>
        </div>
    </main>

    <!-- Modal Sign Pemohon -->
    <div class="modal fade" id="modalSignPemohon" tabindex="-1" aria-labelledby="modalSignPemohonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSignPemohonLabel">
                        <i class="sym sym-signature me-2"></i>Konfirmasi Tanda Tangan Pemohon
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftar-tanda-tangan.signPencabutanAsetpribadi', $asetpribadi->id) }}"
                    method="POST" id="formSignPemohon">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="sym sym-info-circle me-2"></i>
                            <strong>Perhatian:</strong> Dengan menandatangani dokumen ini, Anda menyatakan bahwa data yang
                            diinput sudah benar dan sesuai dengan kondisi aset yang sebenarnya.
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="checkDataAccuracy" required>
                            <label class="form-check-label" for="checkDataAccuracy">
                                Saya selaku <strong>PIHAK KEDUA</strong> menyatakan bahwa seluruh data perusahaan yang
                                tersimpan pada perangkat pribadi saya telah dilakukan backup/penyerahan oleh penanggung
                                jawab/manager terkait sesuai dengan ketentuan.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitPemohon" disabled>
                            <i class="sym sym-signature me-1"></i>Tanda Tangani
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sign Manager -->
    <div class="modal fade" id="modalSignManager" tabindex="-1" aria-labelledby="modalSignManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSignManagerLabel">
                        <i class="sym sym-signature me-2"></i>Konfirmasi Persetujuan Manager / PJ Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftar-tanda-tangan.signPencabutanAsetpribadi', $asetpribadi->id) }}"
                    method="POST" id="formSignManager">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="sym sym-warning me-2"></i>
                            <strong>Peran Manager / PJ Data :</strong> Anda bertanggung jawab untuk memverifikasi dan
                            menyetujui pengajuan aset pribadi ini.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="keputusanManager" class="form-label">Keputusan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="keputusanManager" name="keputusan_manager" required>
                                    <option value="">Pilih Keputusan</option>
                                    <option value="disetujui">Setuju</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="statusBackup" class="form-label">Status Backup Data</label>
                                <select class="form-select" id="statusBackup" name="status_backup">
                                    <option value="">Pilih Status</option>
                                    <option value="sudah_backup">Sudah dilakukan backup penuh</option>
                                    <option value="tidak_perlu">Tidak ada data perusahaan pada perangkat</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="catatanManager" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatanManager" name="catatan_manager" rows="3"
                                placeholder="Tambahkan catatan atau alasan keputusan..."></textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="checkVerification" required>
                            <label class="form-check-label" for="checkVerification">
                                Saya selaku Manager/Penanggung
                                Jawab Data menyatakan bahwa
                                data dari perangkat pribadi milik
                                PIHAK KEDUA:
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning" id="submitManager" disabled>
                            <i class="sym sym-signature me-1"></i>Setujui sebagai Manager / PJ Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sign Admin -->
    <div class="modal fade" id="modalSignAdmin" tabindex="-1" aria-labelledby="modalSignAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSignAdminLabel">
                        <i class="sym sym-signature me-2"></i>Konfirmasi Persetujuan Admin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('daftar-tanda-tangan.signPencabutanAsetpribadi', $asetpribadi->id) }}"
                    method="POST" id="formSignAdmin">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <i class="sym sym-shield-check me-2"></i>
                            <strong>Peran Admin:</strong> Anda adalah pihak yang memberikan persetujuan final untuk
                            pengajuan aset pribadi ini.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="keputusanAdmin" class="form-label">Keputusan Final <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="keputusanAdmin" name="keputusan_admin" required>
                                    <option value="">Pilih Keputusan</option>
                                    <option value="disetujui">Disetujui</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="statusResetOS" class="form-label">Status Reset OS</label>
                                <select class="form-select" id="statusResetOS" name="status_reset_os">
                                    <option value="">Pilih Status</option>
                                    <option value="sudah_reset">Sudah dilakukan reset sistem operasi</option>
                                    <option value="belum_reset">Reset tidak bisa dilakukan, sehingga dilakukan install
                                        ulang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="catatanAdmin" class="form-label">Catatan Admin</label>
                            <textarea class="form-control" id="catatanAdmin" name="catatan_admin" rows="3"
                                placeholder="Tambahkan catatan atau instruksi khusus..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="submitAdmin">
                            <i class="sym sym-signature me-1"></i>Setujui sebagai Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menampilkan notifikasi jika ada session success atau error
    @if (session('success'))
        Swal.fire({
            title: 'Sukses!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Tutup',
            customClass: {
                confirmButton: 'btn btn-success'
            }
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Tutup',
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
    @endif


    // Fungsi untuk mencetak konten iframe
    document.getElementById('printButton')?.addEventListener('click', function() {
        var iframe = document.getElementById('printFrame');

        // Cek apakah iframe sudah dimuat
        iframe.onload = function() {
            // Log untuk memastikan iframe sudah dimuat
            console.log('Iframe sudah dimuat, memanggil fungsi print...');

            // Memberikan sedikit jeda sebelum memanggil print()
            setTimeout(function() {
                // Memanggil fungsi print di dalam iframe
                iframe.contentWindow.print();
            }, 500); // Delay 500ms untuk memastikan iframe siap
        };

        // Pastikan iframe sudah dimuat sebelum menunggu
        if (iframe.contentWindow.document.readyState === 'complete') {
            console.log('Iframe sudah dimuat sebelumnya, langsung memanggil print...');
            iframe.contentWindow.print();
        }
    });

    // Role-based Modal Sign Functionality

    // Pemohon Modal Validation
    const checkDataAccuracy = document.getElementById('checkDataAccuracy');
    const submitPemohon = document.getElementById('submitPemohon');

    function validatePemohonForm() {
        if (checkDataAccuracy && submitPemohon) {
            submitPemohon.disabled = !(checkDataAccuracy.checked);
        }
    }

    checkDataAccuracy?.addEventListener('change', validatePemohonForm);

    // Manager Modal Validation
    const checkVerification = document.getElementById('checkVerification');
    const submitManager = document.getElementById('submitManager');

    function validateManagerForm() {
        if (checkVerification && submitManager) {
            submitManager.disabled = !(checkVerification.checked);
        }
    }

    checkVerification?.addEventListener('change', validateManagerForm);


    // Form Submission with SweetAlert Confirmation
    document.getElementById('formSignPemohon')?.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Tanda Tangan',
            text: 'Apakah Anda yakin ingin menandatangani dokumen ini sebagai pemohon?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tanda Tangani',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memproses tanda tangan',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                this.submit();
            }
        });
    });

    document.getElementById('formSignManager')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const keputusan = document.getElementById('keputusanManager').value;

        Swal.fire({
            title: 'Konfirmasi Persetujuan Manager',
            text: `Apakah Anda yakin ingin ${keputusan} pengajuan ini sebagai Manager/PJ Data?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memproses persetujuan manager',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                this.submit();
            }
        });
    });

    document.getElementById('formSignAdmin')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const keputusan = document.getElementById('keputusanAdmin').value;

        Swal.fire({
            title: 'Konfirmasi Persetujuan Admin',
            text: `Apakah Anda yakin ingin ${keputusan} pengajuan ini sebagai Admin? Ini adalah keputusan final.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memproses persetujuan admin',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                this.submit();
            }
        });
    });
</script>

<!-- Withdrawal Modal Scripts -->
<script>
    // User Withdrawal Modal
    document.addEventListener('DOMContentLoaded', function() {
        const checkBackupUser = document.getElementById('checkBackupUser');
        const checkConfirmWithdrawalUser = document.getElementById('checkConfirmWithdrawalUser');
        const submitWithdrawalUser = document.getElementById('submitWithdrawalUser');

        if (checkBackupUser && checkConfirmWithdrawalUser && submitWithdrawalUser) {
            function toggleUserSubmitButton() {
                submitWithdrawalUser.disabled = !(checkBackupUser.checked && checkConfirmWithdrawalUser
                    .checked);
            }

            checkBackupUser.addEventListener('change', toggleUserSubmitButton);
            checkConfirmWithdrawalUser.addEventListener('change', toggleUserSubmitButton);
        }

        // Manager Withdrawal Modal
        const checkVerificationManager = document.getElementById('checkVerificationManager');
        const checkAuthorityManager = document.getElementById('checkAuthorityManager');
        const submitWithdrawalManager = document.getElementById('submitWithdrawalManager');
        const backupRadios = document.querySelectorAll('input[name="status_backup"]');

        if (checkVerificationManager && checkAuthorityManager && submitWithdrawalManager && backupRadios
            .length > 0) {
            function toggleManagerSubmitButton() {
                const backupSelected = Array.from(backupRadios).some(radio => radio.checked);
                submitWithdrawalManager.disabled = !(checkVerificationManager.checked && checkAuthorityManager
                    .checked && backupSelected);
            }

            checkVerificationManager.addEventListener('change', toggleManagerSubmitButton);
            checkAuthorityManager.addEventListener('change', toggleManagerSubmitButton);
            backupRadios.forEach(radio => {
                radio.addEventListener('change', toggleManagerSubmitButton);
            });
        }

        // Admin Withdrawal Modal
        const checkFinalVerification = document.getElementById('checkFinalVerification');
        const checkFinalAuthority = document.getElementById('checkFinalAuthority');
        const submitWithdrawalAdmin = document.getElementById('submitWithdrawalAdmin');
        const resetRadios = document.querySelectorAll('input[name="status_reset_os"]');

        if (checkFinalVerification && checkFinalAuthority && submitWithdrawalAdmin && resetRadios.length > 0) {
            function toggleAdminSubmitButton() {
                const resetSelected = Array.from(resetRadios).some(radio => radio.checked);
                submitWithdrawalAdmin.disabled = !(checkFinalVerification.checked && checkFinalAuthority
                    .checked && resetSelected);
            }

            checkFinalVerification.addEventListener('change', toggleAdminSubmitButton);
            checkFinalAuthority.addEventListener('change', toggleAdminSubmitButton);
            resetRadios.forEach(radio => {
                radio.addEventListener('change', toggleAdminSubmitButton);
            });
        }
    });
</script>

<script>
    // Konfirmasi pembatalan pengajuan
    function confirmBatalkan() {
        Swal.fire({
            title: 'Pembatalan Pencabutan Aset Pribadi',
            text: 'Apakah Anda yakin ingin membatalkan proses pencabutan aset pribadi personel tersebut ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang membatalkan pengajuan',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                document.getElementById('formBatalkan').submit();
            }
        });
    }
</script>
@endsection
