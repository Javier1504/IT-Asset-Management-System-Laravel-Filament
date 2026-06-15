@extends('layouts.admin')

@section('title', 'Buat Laporan Insiden')

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
                                <li class="breadcrumb-item active" aria-current="page">Buat Laporan</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Buat Laporan Insiden Baru</h4>
                        <span class="text-muted">Isi formulir untuk melaporkan insiden</span>

                        <form action="{{ route('incident-report.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf

                            <div class="row g-3">
                                <!-- Title -->
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Judul Insiden <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="network" {{ old('category') == 'network' ? 'selected' : '' }}>Network</option>
                                        <option value="listrik" {{ old('category') == 'listrik' ? 'selected' : '' }}>Listrik</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Priority -->
                                <div class="col-md-6">
                                    <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Evidence -->
                                <div class="col-md-12">
                                    <label for="evidence" class="form-label">Bukti (Foto/Dokumen)</label>
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
                                    <i class="sym sym-save"></i> Simpan Laporan
                                </button>
                                <a href="{{ route('incident-report.index') }}" class="btn btn-secondary">
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
