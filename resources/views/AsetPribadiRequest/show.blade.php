@extends('layouts.admin')

@section('title', 'Detail Permintaan Aset Pribadi')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Facades\Auth;
    @endphp

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row gy-3 p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Permintaan</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('aset-pribadi-request') }}">Aset Pribadi</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div
                        class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="m-0">Detail Permintaan Aset Pribadi</h5>
                            <span class="fs-6 text-secondary">Informasi lengkap permintaan aset pribadi</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            @if ($asetpribadiRequest->tanda_tangan_user_at == null && Auth::user()->id == $asetpribadiRequest->id_user)
                                <span
                                    class="badge fs-6 text-secondary bg-secondary bg-opacity-10 border border-secondary">Perlu
                                    ditandatangani</span>
                            @elseif ($asetpribadiRequest->tanda_tangan_user_at == null)
                                <span
                                    class="badge fs-6 text-secondary bg-secondary bg-opacity-10 border border-secondary">Belum
                                    Ditandatangani Pemohon</span>
                            @else
                                @if ($asetpribadiRequest->status == 'pending')
                                    <span
                                        class="badge fs-6 text-warning bg-warning bg-opacity-10 border border-warning">Menunggu
                                        Manager</span>
                                @elseif ($asetpribadiRequest->status == 'menunggu_admin')
                                    <span class="badge fs-6 text-info bg-info bg-opacity-10 border border-info">Menunggu
                                        Admin</span>
                                @elseif ($asetpribadiRequest->status == 'disetujui')
                                    <span
                                        class="badge fs-6 text-success bg-success bg-opacity-10 border border-success">Disetujui</span>
                                @elseif ($asetpribadiRequest->status == 'ditolak')
                                    <span
                                        class="badge fs-6 text-danger bg-danger bg-opacity-10 border border-danger">Ditolak</span>
                                @endif
                            @endif

                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Informasi Umum -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Informasi Umum</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Nama Karyawan</div>
                                    <div class="col-8">{{ $asetpribadiRequest->user->name_karyawan ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Jabatan</div>
                                    <div class="col-8">{{ $asetpribadiRequest->jabatan_user }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Divisi</div>
                                    <div class="col-8">{{ $asetpribadiRequest->divisi }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Manager</div>
                                    <div class="col-8">{{ $asetpribadiRequest->manager->name_karyawan ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Jabatan Manager</div>
                                    <div class="col-8">{{ $asetpribadiRequest->jabatan_manager }}</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Daftar Aset Pribadi -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Daftar Aset Pribadi</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Aset</th>
                                                <th>Merk</th>
                                                <th>Tipe</th>
                                                <th>No. Seri</th>
                                                <th>Sistem Os</th>
                                                <th>Mac Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (is_array($asetpribadiRequest->aset_pribadi))
                                                @foreach ($asetpribadiRequest->aset_pribadi as $index => $aset)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $aset['nama'] ?? '-' }}</td>
                                                        <td>{{ $aset['merk'] ?? '-' }}</td>
                                                        <td>{{ $aset['tipe'] ?? '-' }}</td>
                                                        <td>{{ $aset['no_seri'] ?? '-' }}</td>
                                                        <td>{{ $aset['sistem_os'] ?? '-' }}</td>
                                                        <td>{{ $aset['mac_address'] ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">Tidak ada data aset
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Alasan -->

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Alur Persetujuan</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <!-- Step 1: User Submit -->
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="sym sym-check-line text-white"></i>
                                                </div>
                                                <div>
                                                    <small class="fw-semibold">User Mengajukan</small>
                                                    <br><small
                                                        class="text-muted">{{ $asetpribadiRequest->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                            </div>

                                            <div class="border-top flex-grow-1"></div>

                                            <!-- Step 2: Manager Approval -->
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($asetpribadiRequest->tanda_tangan_user_at == null)
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="sym sym-more-line text-white"></i>
                                                    </div>
                                                @else
                                                    @if ($asetpribadiRequest->is_manager)
                                                        <!-- Jika pemohon adalah manager, langsung disetujui -->
                                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="sym sym-check-line text-white"></i>
                                                        </div>
                                                    @elseif ($asetpribadiRequest->keputusan_manager == 'disetujui')
                                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="sym sym-check-line text-white"></i>
                                                        </div>
                                                    @elseif($asetpribadiRequest->keputusan_manager == 'ditolak')
                                                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="sym sym-close-line text-white"></i>
                                                        </div>
                                                    @elseif($asetpribadiRequest->status == 'pending')
                                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="sym sym-time-line text-white"></i>
                                                        </div>
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="sym sym-more-line text-white"></i>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div>
                                                    <small class="fw-semibold">Manager Review</small>
                                                    <br><small class="text-muted">
                                                        @if ($asetpribadiRequest->acc_manager)
                                                            {{ \Carbon\Carbon::parse($asetpribadiRequest->acc_manager)->format('d/m/Y H:i') }}
                                                        @elseif ($asetpribadiRequest->is_manager)
                                                            Pengaju adalah manager
                                                        @else
                                                            Menunggu
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="border-top flex-grow-1"></div>

                                            <!-- Step 3: Admin Final Approval -->
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($asetpribadiRequest->keputusan_admin == 'disetujui')
                                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="sym sym-check-line text-white"></i>
                                                    </div>
                                                @elseif($asetpribadiRequest->keputusan_admin == 'ditolak' || $asetpribadiRequest->keputusan_manager == 'ditolak')
                                                    <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="sym sym-close-line text-white"></i>
                                                    </div>
                                                @elseif($asetpribadiRequest->status == 'menunggu_admin')
                                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="sym sym-time-line text-white"></i>
                                                    </div>
                                                @else
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px;">
                                                        <i class="sym sym-more-line text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <small class="fw-semibold">Admin Final</small>
                                                    <br><small class="text-muted">
                                                        @if ($asetpribadiRequest->eva_admin)
                                                            {{ \Carbon\Carbon::parse($asetpribadiRequest->eva_admin)->format('d/m/Y H:i') }}
                                                        @elseif ($asetpribadiRequest->keputusan_manager == 'ditolak')
                                                            Proses ditolak oleh manager
                                                        @else
                                                            Menunggu
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($asetpribadiRequest->tanda_tangan_user_at == null && Auth::user()->id == $asetpribadiRequest->id_user)
                                            <div class="alert alert-secondary">
                                                <i class="sym sym-info-line"></i> Silakan tandatangani formulir permintaan
                                                aset pribadi
                                            </div>
                                        @elseif ($asetpribadiRequest->tanda_tangan_user_at == null)
                                            <div class="alert alert-secondary">
                                                <i class="sym sym-info-line"></i> Pemohon belum menandatangani formulir
                                                permintaan
                                            </div>
                                        @else
                                            @if ($asetpribadiRequest->status == 'pending')
                                                <div class="alert alert-warning">
                                                    <i class="sym sym-info-line"></i> Menunggu persetujuan dari manager
                                                </div>
                                            @elseif($asetpribadiRequest->status == 'menunggu_admin')
                                                <div class="alert alert-info">
                                                    <i class="sym sym-info-line"></i>
                                                    @if ($asetpribadiRequest->is_manager)
                                                        Menunggu persetujuan dari admin (Pengaju adalah manager)
                                                    @else
                                                        Telah disetujui manager, menunggu persetujuan final dari admin
                                                    @endif
                                                </div>
                                            @elseif($asetpribadiRequest->status == 'disetujui')
                                                <div class="alert alert-success">
                                                    <i class="sym sym-check-double-line"></i> Permintaan telah disetujui
                                                    sepenuhnya
                                                </div>
                                            @elseif($asetpribadiRequest->status == 'ditolak')
                                                <div class="alert alert-danger">
                                                    <i class="sym sym-close-line"></i> Permintaan telah ditolak
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Alasan -->

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Alasan user melakukan pengajuan</h6>
                                <div class="row">
                                    <div class="col mb-3">

                                        <p>{{ $asetpribadiRequest->catatan_user }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Lampiran -->
                        @if (
                            $asetpribadiRequest->lampiran &&
                                is_array($asetpribadiRequest->lampiran) &&
                                count($asetpribadiRequest->lampiran) > 0)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Lampiran Gambar</h6>
                                    <div class="row">
                                        @foreach ($asetpribadiRequest->lampiran as $index => $lampiran)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="position-relative">
                                                            <img src="{{ Storage::url($lampiran) }}"
                                                                alt="Lampiran {{ $index + 1 }}"
                                                                class="img-fluid rounded w-100"
                                                                style="height: 200px; object-fit: cover; cursor: pointer;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#imageModal{{ $index }}">
                                                            <div class="position-absolute top-0 end-0 m-2">
                                                                <span
                                                                    class="badge bg-dark bg-opacity-75">{{ $index + 1 }}</span>
                                                            </div>
                                                        </div>
                                                        <p class="card-text small text-center mt-2 mb-0">
                                                            {{ basename($lampiran) }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal untuk preview gambar penuh -->
                                            <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ basename($lampiran) }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-0">
                                                            <img src="{{ Storage::url($lampiran) }}"
                                                                alt="Lampiran {{ $index + 1 }}"
                                                                class="img-fluid w-100">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ Storage::url($lampiran) }}" target="_blank"
                                                                class="btn btn-primary">
                                                                <i class="sym sym-external-link-line"></i> Buka di Tab Baru
                                                            </a>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Status dan Tanggal -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Status</div>
                                    <div class="col-8">
                                        @if ($asetpribadiRequest->tanda_tangan_user_at == null && Auth::user()->id == $asetpribadiRequest->id_user)
                                            <span class="badge bg-secondary">Perlu Ditandatangani</span>
                                        @elseif ($asetpribadiRequest->tanda_tangan_user_at == null)
                                            <span class="badge bg-secondary">Belum Ditandatangani Pemohon</span>
                                        @else
                                            @if ($asetpribadiRequest->status == 'pending')
                                                <span class="badge bg-warning">Menunggu Manager</span>
                                            @elseif($asetpribadiRequest->status == 'menunggu_admin')
                                                <span class="badge bg-info">Menunggu Admin</span>
                                            @elseif($asetpribadiRequest->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($asetpribadiRequest->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 text-muted">Tanggal Dibuat</div>
                                    <div class="col-8">{{ $asetpribadiRequest->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($asetpribadiRequest->keputusan_manager)
                                    <div class="row mb-2">
                                        <div class="col-4 text-muted">Keputusan Manager</div>
                                        <div class="col-8">{{ $asetpribadiRequest->keputusan_manager }}</div>
                                    </div>
                                @endif
                                @if ($asetpribadiRequest->keputusan_admin)
                                    <div class="row mb-2">
                                        <div class="col-4 text-muted">Keputusan Admin</div>
                                        <div class="col-8">{{ $asetpribadiRequest->keputusan_admin }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if ($asetpribadiRequest->catatan_manager || $asetpribadiRequest->catatan_admin)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Catatan</h6>
                                </div>
                                @if ($asetpribadiRequest->catatan_manager)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Catatan Manager</strong>
                                            </div>
                                            <div class="card-body">
                                                {{ $asetpribadiRequest->catatan_manager }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($asetpribadiRequest->catatan_admin)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Catatan Admin</strong>
                                            </div>
                                            <div class="card-body">
                                                {{ $asetpribadiRequest->catatan_admin }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div
                        class="card-footer bg-white border-top rounded-bottom-4 px-3 py-3 d-flex justify-content-end gap-2">
                        @php
                            $user = Auth::user();
                        @endphp
                        <div class="d-flex flex-wrap gap-2 gap-md-4 flex-column flex-sm-row">
                            {{-- User Signature Button --}}
                            @if ($asetpribadiRequest->tanda_tangan_user_at == null && $user->id == $asetpribadiRequest->id_user)
                                <form action="{{ route('daftar-tanda-tangan.signAsetpribadi', $asetpribadiRequest->id) }}"
                                    method="POST" class="d-none" id="signForm">
                                    @csrf
                                </form>

                                <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
                                    <button type="button" id="signButtonSticky"
                                        class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                                        style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease, box-shadow 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 28px rgba(13,110,253,0.55) !important'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 20px rgba(13,110,253,0.45) !important'">
                                        <i class="sym sym-pen-to-square"></i>
                                        Tanda Tangani
                                    </button>
                                </div>
                            @endif
                            {{-- Manager Approval Buttons --}}
                            @if (
                                $asetpribadiRequest->status == 'pending' &&
                                    $user->role == 'manager' &&
                                    $asetpribadiRequest->id_manager == $user->id &&
                                    $asetpribadiRequest->tanda_tangan_user_at != null &&
                                    !$asetpribadiRequest->is_manager)
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalTolakManager">
                                    <i class="sym sym-close-line"></i> Tolak
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSetujuiManager">
                                    <i class="sym sym-check-line"></i> Setujui
                                </button>
                            @endif

                            {{-- Admin Approval Buttons --}}
                            @if ($asetpribadiRequest->status == 'menunggu_admin' && in_array($user->role, ['admin', 'super_admin']))
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalTolakAdmin">
                                    <i class="sym sym-close-line"></i> Tolak (Final)
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSetujuiAdmin">
                                    <i class="sym sym-check-line"></i> Setujui (Final)
                                </button>
                            @endif

                            {{-- Status Information --}}
                            @if (in_array($asetpribadiRequest->status, ['disetujui', 'ditolak']))
                                <div class="text-muted">
                                    @if ($asetpribadiRequest->status == 'disetujui')
                                        <i class="sym sym-check-double-line text-success"></i> Permintaan telah disetujui
                                        sepenuhnya
                                    @else
                                        <i class="sym sym-close-line text-danger"></i> Permintaan telah ditolak
                                    @endif
                                </div>
                            @endif

                            {{-- Action Buttons --}}
                            <a href="{{ route('daftar-tanda-tangan.detailAsetpribadi', $asetpribadiRequest->id) }}"
                                class="btn btn-primary me-2 mb-2">
                                <i class="sym sym-file-text-line"></i> Lihat Formulir PDF
                            </a>
                            <a href="{{ route('aset-pribadi-request') }}" class="btn btn-outline-secondary mb-2">
                                <i class="sym sym-arrow-left-line"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Image hover effects for better UX */
        .img-fluid[data-bs-toggle="modal"] {
            transition: all 0.3s ease;
        }

        .img-fluid[data-bs-toggle="modal"]:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Loading state for images */
        .img-fluid {
            background: linear-gradient(90deg, #f0f0f0 25%, transparent 37%, #f0f0f0 63%);
            background-size: 400% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }

        .img-fluid[src]:not([src=""]) {
            background: none;
            animation: none;
        }

        /* Modal image styling */
        .modal-body img {
            max-height: 70vh;
            object-fit: contain;
        }
    </style>

    <!-- Modal untuk Persetujuan Manager -->
    <div class="modal fade" id="modalSetujuiManager" tabindex="-1" aria-labelledby="modalSetujuiManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSetujuiManagerLabel">Setujui Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('aset-pribadi-approve-manager', $asetpribadiRequest->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="keputusan_manager" value="disetujui">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui permintaan aset pribadi ini?</p>
                        <p class="text-muted small">Setelah disetujui, permintaan akan diteruskan ke admin untuk
                            persetujuan final.</p>

                        <div class="mb-3">
                            <label for="catatan_manager_setuju" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan_manager_setuju" name="catatan_manager" rows="3"
                                placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirm_responsibility_setuju"
                                    required>
                                <label class="form-check-label text-primary fw-semibold"
                                    for="confirm_responsibility_setuju">
                                    Dengan ini saya <strong
                                        class="text-dark">{{ $asetpribadiRequest->manager->name_karyawan ?? 'Manager' }}</strong>
                                    selaku manager untuk personil <strong
                                        class="text-dark">{{ $asetpribadiRequest->user->name_karyawan ?? 'Manager' }}</strong>
                                    bertanggung jawab pada aset pribadi yang diajukan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn_setujui_manager" disabled>Ya,
                            Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Penolakan Manager -->
    <div class="modal fade" id="modalTolakManager" tabindex="-1" aria-labelledby="modalTolakManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakManagerLabel">Tolak Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('aset-pribadi-approve-manager', $asetpribadiRequest->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="keputusan_manager" value="ditolak">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak permintaan aset pribadi ini?</p>
                        <p class="text-danger small">Setelah ditolak, permintaan akan langsung berstatus ditolak dan tidak
                            dapat diproses lebih lanjut.</p>

                        <div class="mb-3">
                            <label for="catatan_manager_tolak" class="form-label">Alasan Penolakan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="catatan_manager_tolak" name="catatan_manager" rows="3"
                                placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirm_responsibility_tolak"
                                    required>
                                <label class="form-check-label text-danger fw-semibold"
                                    for="confirm_responsibility_tolak">
                                    Dengan ini saya {{ $asetpribadiRequest->manager->name_karyawan ?? 'Manager' }}
                                    bertanggung jawab pada keputusan penolakan aset pribadi yang diajukan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="btn_tolak_manager" disabled>Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Persetujuan Final Admin -->
    <div class="modal fade" id="modalSetujuiAdmin" tabindex="-1" aria-labelledby="modalSetujuiAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSetujuiAdminLabel">Setujui Final Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('aset-pribadi-approve-admin', $asetpribadiRequest->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="keputusan_admin" value="disetujui">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui permintaan aset pribadi ini secara final?</p>
                        <p class="text-success small">Setelah disetujui, permintaan akan berstatus disetujui dan selesai
                            diproses.</p>

                        <div class="mb-3">
                            <label for="catatan_admin_setuju" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan_admin_setuju" name="catatan_admin" rows="3"
                                placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Setujui Final</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Penolakan Final Admin -->
    <div class="modal fade" id="modalTolakAdmin" tabindex="-1" aria-labelledby="modalTolakAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakAdminLabel">Tolak Final Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('aset-pribadi-approve-admin', $asetpribadiRequest->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="keputusan_admin" value="ditolak">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak permintaan aset pribadi ini secara final?</p>
                        <p class="text-danger small">Setelah ditolak, permintaan akan langsung berstatus ditolak final dan
                            tidak dapat diproses lebih lanjut.</p>

                        <div class="mb-3">
                            <label for="catatan_admin_tolak" class="form-label">Alasan Penolakan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="catatan_admin_tolak" name="catatan_admin" rows="3"
                                placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak Final</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle checkbox for manager approval (setuju)
            const checkboxSetuju = document.getElementById('confirm_responsibility_setuju');
            const btnSetujuManager = document.getElementById('btn_setujui_manager');

            if (checkboxSetuju && btnSetujuManager) {
                checkboxSetuju.addEventListener('change', function() {
                    btnSetujuManager.disabled = !this.checked;
                });
            }

            // Handle checkbox for manager rejection (tolak)
            const checkboxTolak = document.getElementById('confirm_responsibility_tolak');
            const btnTolakManager = document.getElementById('btn_tolak_manager');

            if (checkboxTolak && btnTolakManager) {
                checkboxTolak.addEventListener('change', function() {
                    btnTolakManager.disabled = !this.checked;
                });
            }

            // Reset checkboxes and buttons when modals are closed
            document.querySelectorAll('.modal').forEach(function(modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    // Reset checkboxes
                    const checkboxes = modal.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });

                    // Reset buttons to disabled state
                    const submitButtons = modal.querySelectorAll('button[type="submit"]');
                    submitButtons.forEach(function(button) {
                        if (button.id === 'btn_setujui_manager' || button.id ===
                            'btn_tolak_manager') {
                            button.disabled = true;
                        }
                    });
                });
            });
        });
    </script>
    <script>
        function showSignConfirmation() {
            Swal.fire({
                title: 'Apakah Semua Data Sudah Benar?',
                text: 'Pastikan semua informasi sudah benar sebelum melakukan tanda tangan.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Tandatangani!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('signForm').submit();
                }
            });
        }

        // Tombol sticky di pojok kanan bawah
        const signButtonSticky = document.getElementById('signButtonSticky');
        if (signButtonSticky) {
            signButtonSticky.addEventListener('click', function(event) {
                event.preventDefault();
                showSignConfirmation();
            });
        }
    </script>
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
