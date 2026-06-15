@extends('layouts.admin')

@section('title', 'Catatan Internal Tim')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Catatan Internal Tim</h4>
            <p class="text-muted mb-0">
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('internal-notes.index') }}" class="row g-2">
                <div class="col-md-3">
                    <input type="text"
                           name="stock_opname_search"
                           value="{{ request('stock_opname_search') }}"
                           class="form-control"
                           placeholder="Cari judul/kode Stock Opname...">
                </div>

                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari isi catatan...">
                </div>

                <div class="col-md-2">
                    <select name="request_type" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach($requestTypeOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('request_type') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="priority" class="form-select">
                        <option value="">Semua Prioritas</option>
                        @foreach($priorityOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <select name="status" class="form-select">
                        <option value="">Status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-dark">Filter</button>
                </div>

                @if(request()->hasAny(['stock_opname_search', 'search', 'request_type', 'priority', 'status']))
                    <div class="col-md-12 mt-2">
                        <a href="{{ route('internal-notes.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Stock Opname</th>
                            <th>Tim</th>
                            <th>Periode</th>
                            <th>Total Catatan</th>
                            <th>Open</th>
                            <th>Progress</th>
                            <th>Done</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockOpnames as $index => $stockOpname)
                            @php
                                $stockOpnameLabel = trim(
                                    ($stockOpname->code ?? '') . ' - ' . ($stockOpname->title ?? ''),
                                    ' -'
                                ) ?: 'Stock Opname ID ' . $stockOpname->id;

                                $period = collect([
                                    optional($stockOpname->start_date)->format('d/m/Y'),
                                    optional($stockOpname->end_date)->format('d/m/Y'),
                                ])->filter()->implode(' - ');
                            @endphp

                            <tr>
                                <td>{{ $stockOpnames->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $stockOpnameLabel }}</div>
                                    <small class="text-muted">
                                        Status Stock Opname: {{ $stockOpname->status_label ?? ucfirst((string) $stockOpname->status) }}
                                    </small>
                                </td>
                                <td>{{ $stockOpname->team_summary ?? ($stockOpname->team ?: '-') }}</td>
                                <td>{{ $period ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-dark">{{ (int) $stockOpname->internal_notes_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ (int) $stockOpname->open_notes_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ (int) $stockOpname->in_progress_notes_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ (int) $stockOpname->done_notes_count }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('internal-notes.stock-opname', $stockOpname->id) }}" class="btn btn-sm btn-primary">
                                            Lihat Catatan
                                        </a>

                                        @if(\Illuminate\Support\Facades\Route::has('stock-opnames.show'))
                                            <a href="{{ route('stock-opnames.show', $stockOpname->id) }}" class="btn btn-sm btn-outline-secondary">
                                                Stock Opname
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada Stock Opname yang memiliki catatan internal sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($stockOpnames->hasPages())
            <div class="card-footer bg-white">
                {{ $stockOpnames->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
