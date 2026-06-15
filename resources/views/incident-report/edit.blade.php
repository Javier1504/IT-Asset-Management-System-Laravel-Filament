@extends('layouts.admin')

@use(Illuminate\Support\Facades\Storage)

@section('title', 'Edit Laporan Insiden')

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
                                <li class="breadcrumb-item active" aria-current="page">Edit Laporan</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Edit Laporan Insiden</h4>
                        <span class="text-muted">Perbarui informasi laporan insiden</span>

                        <form action="{{ route('incident-report.update', $incidentReport) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Nomor Formulir (Read-only) -->
                                <div class="col-md-6">
                                    <label for="nomor_formulir" class="form-label">Nomor Formulir</label>
                                    <input type="text" class="form-control" id="nomor_formulir"
                                           value="{{ $incidentReport->nomor_formulir }}" readonly>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="open" {{ old('status', $incidentReport->status) == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ old('status', $incidentReport->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ old('status', $incidentReport->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ old('status', $incidentReport->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Title -->
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Judul Insiden <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $incidentReport->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-4">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror"
                                            id="category" name="category" required>
                                        <option value="network" {{ old('category', $incidentReport->category) == 'network' ? 'selected' : '' }}>Network</option>
                                        <option value="listrik" {{ old('category', $incidentReport->category) == 'listrik' ? 'selected' : '' }}>Listrik</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Priority -->
                                <div class="col-md-4">
                                    <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror"
                                            id="priority" name="priority" required>
                                        <option value="low" {{ old('priority', $incidentReport->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $incidentReport->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $incidentReport->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Assigned To -->
                                <div class="col-md-4">
                                    <label for="assigned_to" class="form-label">Ditugaskan Ke</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror"
                                            id="assigned_to" name="assigned_to">
                                        <option value="">Belum ditugaskan</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('assigned_to', $incidentReport->assigned_to) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="5" required>{{ old('description', $incidentReport->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Existing Evidence -->
                                @if ($incidentReport->evidence && count($incidentReport->evidence) > 0)
                                    <div class="col-md-12">
                                        <label class="form-label">Bukti yang Ada</label>
                                        <div class="row g-2">
                                            @foreach ($incidentReport->evidence as $index => $file)
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-body p-2">
                                                            @if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                <img src="{{ Storage::url($file) }}" class="img-fluid mb-2" alt="Evidence">
                                                            @else
                                                                <div class="text-center p-3 bg-light">
                                                                    <i class="sym sym-document fs-1"></i>
                                                                    <p class="mb-0 small">{{ basename($file) }}</p>
                                                                </div>
                                                            @endif
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="remove_evidence[]" value="{{ $file }}"
                                                                       id="remove_{{ $index }}">
                                                                <label class="form-check-label small" for="remove_{{ $index }}">
                                                                    Hapus
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- New Evidence -->
                                <div class="col-md-12">
                                    <label for="evidence" class="form-label">Tambah Bukti Baru</label>
                                    <input type="file" class="form-control @error('evidence.*') is-invalid @enderror"
                                           id="evidence" name="evidence[]" multiple
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX. Max: 5MB per file</small>
                                    @error('evidence.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="sym sym-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('incident-report.show', $incidentReport) }}" class="btn btn-secondary">
                                    <i class="sym sym-close"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
