@extends('layouts.admin')

@use(Illuminate\Support\Facades\Storage)

@section('title', 'Detail Laporan Insiden')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <!-- Breadcrumb -->
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('incident-report.index') }}">Laporan Insiden</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Detail Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="m-0">Detail Laporan Insiden</h4>
                                <span class="text-muted">{{ $incidentReport->nomor_formulir }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('incident-report.edit', $incidentReport) }}" class="btn btn-warning">
                                    <i class="sym sym-edit"></i> Edit
                                </a>
                                <form action="{{ route('incident-report.destroy', $incidentReport) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="sym sym-delete"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="mb-4">
                                    <h5 class="text-muted mb-2">Judul Insiden</h5>
                                    <h3>{{ $incidentReport->title }}</h3>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <h5 class="text-muted mb-2">Deskripsi</h5>
                                    <p class="text-justify">{{ $incidentReport->description }}</p>
                                </div>

                                <!-- Evidence -->
                                @if ($incidentReport->evidence && count($incidentReport->evidence) > 0)
                                    <div class="mb-4">
                                        <h5 class="text-muted mb-3">Bukti</h5>
                                        <div class="row g-3">
                                            @foreach ($incidentReport->evidence as $file)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body p-2">
                                                            @if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                <a href="{{ Storage::url($file) }}" target="_blank">
                                                                    <img src="{{ Storage::url($file) }}" class="img-fluid rounded" alt="Evidence">
                                                                </a>
                                                            @else
                                                                <a href="{{ Storage::url($file) }}" target="_blank" class="text-decoration-none">
                                                                    <div class="text-center p-3 bg-light rounded">
                                                                        <i class="sym sym-document fs-1 text-primary"></i>
                                                                        <p class="mb-0 small mt-2">{{ basename($file) }}</p>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Status Card -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi Status</h6>
                                        <hr>

                                        <div class="mb-3">
                                            <small class="text-muted">Status</small>
                                            <div class="mt-1">
                                                <span class="badge bg-{{ $incidentReport->status == 'open' ? 'warning' : ($incidentReport->status == 'in_progress' ? 'info' : ($incidentReport->status == 'resolved' ? 'success' : 'secondary')) }} fs-6">
                                                    {{ str_replace('_', ' ', ucfirst($incidentReport->status)) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">Kategori</small>
                                            <div class="mt-1">
                                                <span class="badge bg-{{ $incidentReport->category == 'network' ? 'info' : 'warning' }} fs-6">
                                                    {{ ucfirst($incidentReport->category) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">Prioritas</small>
                                            <div class="mt-1">
                                                <span class="badge bg-{{ $incidentReport->priority == 'high' ? 'danger' : ($incidentReport->priority == 'medium' ? 'warning' : 'secondary') }} fs-6">
                                                    {{ ucfirst($incidentReport->priority) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- People Card -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi Pelapor</h6>
                                        <hr>

                                        <div class="mb-3">
                                            <small class="text-muted">Dilaporkan Oleh</small>
                                            <p class="mb-0 fw-bold">{{ $incidentReport->reporter->name_karyawan ?? '-' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">Ditugaskan Ke</small>
                                            <p class="mb-0 fw-bold">{{ $incidentReport->assignee->name_karyawan ?? 'Belum ditugaskan' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeline Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Timeline</h6>
                                        <hr>

                                        <div class="mb-3">
                                            <small class="text-muted">Tanggal Laporan</small>
                                            <p class="mb-0">{{ $incidentReport->created_at->format('d M Y, H:i') }}</p>
                                        </div>

                                        @if ($incidentReport->resolved_at)
                                            <div class="mb-3">
                                                <small class="text-muted">Tanggal Selesai</small>
                                                <p class="mb-0">{{ $incidentReport->resolved_at->format('d M Y, H:i') }}</p>
                                            </div>

                                            <div class="mb-0">
                                                <small class="text-muted">Durasi Penyelesaian</small>
                                                <p class="mb-0">{{ $incidentReport->created_at->diffForHumans($incidentReport->resolved_at, true) }}</p>
                                            </div>
                                        @endif

                                        <div class="mb-0">
                                            <small class="text-muted">Terakhir Diperbarui</small>
                                            <p class="mb-0">{{ $incidentReport->updated_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-4">
                            <a href="{{ route('incident-report.index') }}" class="btn btn-secondary">
                                <i class="sym sym-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
