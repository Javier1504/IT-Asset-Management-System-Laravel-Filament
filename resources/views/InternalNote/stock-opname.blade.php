@extends('layouts.admin')

@section('title', 'Catatan Internal Stock Opname')

@section('content')
<div class="container-fluid py-4">
    @php
        $stockOpnameLabel = trim(
            ($stockOpname->code ?? '') . ' - ' . ($stockOpname->title ?? ''),
            ' -'
        ) ?: 'Stock Opname ID ' . $stockOpname->id;

        $period = collect([
            optional($stockOpname->start_date)->format('d/m/Y'),
            optional($stockOpname->end_date)->format('d/m/Y'),
        ])->filter()->implode(' - ');

        $currentUserRole = auth()->check()
            ? strtolower(str_replace(['-', ' '], '_', trim((string) auth()->user()->role)))
            : null;

        $canDeleteInternalNote = in_array($currentUserRole, [
            'super_admin',
            'superadmin',
            'admin',
        ], true);
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Catatan Internal - {{ $stockOpnameLabel }}</h4>
            <p class="text-muted mb-0">
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('internal-notes.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>

            @if(\Illuminate\Support\Facades\Route::has('stock-opnames.show'))
                <a href="{{ route('stock-opnames.show', $stockOpname->id) }}" class="btn btn-outline-primary">
                    Detail Stock Opname
                </a>
            @endif

            <a href="{{ route('internal-notes.create', ['stock_opname_id' => $stockOpname->id]) }}" class="btn btn-primary">
                + Tambah Catatan
            </a>
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

    <div class="row mb-3">
        <div class="col-md-3 mb-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Catatan</small>
                    <h4 class="mb-0">{{ (int) ($noteSummary->total_notes ?? 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Open</small>
                    <h4 class="mb-0">{{ (int) ($noteSummary->open_notes ?? 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">In Progress</small>
                    <h4 class="mb-0">{{ (int) ($noteSummary->in_progress_notes ?? 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Done</small>
                    <h4 class="mb-0">{{ (int) ($noteSummary->done_notes ?? 0) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-2 mb-2">
                <div class="col-md-3">
                    <small class="text-muted">Parent Stock Opname</small>
                    <div class="fw-semibold">{{ $stockOpnameLabel }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Tim</small>
                    <div class="fw-semibold">{{ $stockOpname->team_summary ?? ($stockOpname->team ?: '-') }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Periode</small>
                    <div class="fw-semibold">{{ $period ?: '-' }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Status Stock Opname</small>
                    <div class="fw-semibold">{{ $stockOpname->status_label ?? ucfirst((string) $stockOpname->status) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('internal-notes.stock-opname', $stockOpname->id) }}" class="row g-2">
                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari judul, deskripsi, atau catatan...">
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
                    <select name="asset_classification" class="form-select">
                        <option value="">Semua Klasifikasi</option>
                        @foreach($assetClassificationOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('asset_classification') == $key ? 'selected' : '' }}>
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

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
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

                @if(request()->hasAny(['search', 'request_type', 'asset_classification', 'priority', 'status']))
                    <div class="col-md-12 mt-2">
                        <a href="{{ route('internal-notes.stock-opname', $stockOpname->id) }}" class="btn btn-sm btn-outline-secondary">
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
                            <th>Catatan</th>
                            <th>Refer Detail</th>
                            <th>Jenis</th>
                            <th>Klasifikasi</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>PIC</th>
                            <th>Jadwal</th>
                            <th width="210">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($notes as $index => $note)
                            @php
                                $creatorName = $note->creator->name_karyawan
                                    ?? $note->creator->username
                                    ?? $note->creator->corporate_email
                                    ?? $note->creator->email
                                    ?? '-';

                                $assigneeName = $note->assignee->name_karyawan
                                    ?? $note->assignee->username
                                    ?? $note->assignee->corporate_email
                                    ?? $note->assignee->email
                                    ?? '-';

                                $priorityClass = match($note->priority) {
                                    'urgent' => 'bg-danger',
                                    'high' => 'bg-warning text-dark',
                                    'low' => 'bg-secondary',
                                    default => 'bg-info',
                                };

                                $statusClass = match($note->status) {
                                    'done' => 'bg-success',
                                    'in_progress' => 'bg-primary',
                                    'canceled' => 'bg-secondary',
                                    default => 'bg-warning text-dark',
                                };

                                $referUser = $note->stockOpnameUser?->user?->name_karyawan
                                    ?? $note->stockOpnameUser?->user?->username
                                    ?? $note->stockOpnameUser?->user?->corporate_email
                                    ?? $note->stockOpnameUser?->user?->email
                                    ?? $note->stockOpnameItem?->snapshot_user_name
                                    ?? null;

                                $referAsset = $note->stockOpnameItem?->snapshot_asset_name;
                                $referAssetNumber = $note->stockOpnameItem?->snapshot_asset_number;
                                $referLocation = $note->stockOpnameItem?->snapshot_location_name
                                    ?? $note->stockOpnameItem?->snapshot_location
                                    ?? null;
                            @endphp

                            <tr>
                                <td>{{ $notes->firstItem() + $index }}</td>

                                <td>
                                    <strong>{{ $note->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        Dibuat oleh: {{ $creatorName }}
                                        @if($note->created_at)
                                            | {{ $note->created_at->format('d/m/Y H:i') }}
                                        @endif
                                    </small>
                                </td>

                                <td>
                                    @if($referUser)
                                        <div class="small">Personel: <strong>{{ $referUser }}</strong></div>
                                    @endif

                                    @if($referAsset)
                                        <div class="small">Aset: <strong>{{ $referAsset }}</strong></div>
                                    @endif

                                    @if($referAssetNumber)
                                        <div class="small text-muted">No: {{ $referAssetNumber }}</div>
                                    @endif

                                    @if($referLocation)
                                        <div class="small text-muted">Lokasi: {{ $referLocation }}</div>
                                    @endif

                                    @if(!$referUser && !$referAsset && !$referAssetNumber && !$referLocation)
                                        <span class="text-muted">Umum</span>
                                    @endif
                                </td>

                                <td>{{ $note->request_type_label }}</td>
                                <td>{{ $note->asset_classification_label }}</td>
                                <td>
                                    <span class="badge {{ $priorityClass }}">{{ $note->priority_label }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $statusClass }}">{{ $note->status_label }}</span>
                                </td>
                                <td>{{ $assigneeName }}</td>
                                <td>{{ $note->scheduled_at ? $note->scheduled_at->format('d/m/Y H:i') : '-' }}</td>
                                <td style="width: 160px;">
                                    <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                        <a href="{{ route('internal-notes.show', $note->id) }}"
                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                            aria-label="Lihat detail" title="Lihat detail">
                                            <i class="sym sym-eye-solid"></i>
                                        </a>

                                        <a href="{{ route('internal-notes.edit', $note->id) }}"
                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                            aria-label="Edit" title="Edit">
                                            <i class="sym sym-edit-solid"></i>
                                        </a>

                                        @if($note->status !== 'done')
                                            <form action="{{ route('internal-notes.done', $note->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-icon btn-sm btn-outline-secondary"
                                                    aria-label="Tandai selesai" title="Tandai selesai"
                                                    onclick="return confirm('Tandai catatan ini selesai?')">
                                                    <i class="sym sym-check-circle-solid"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('internal-notes.reopen', $note->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-icon btn-sm btn-outline-secondary"
                                                    aria-label="Buka ulang" title="Buka ulang"
                                                    onclick="return confirm('Buka ulang catatan ini?')">
                                                    <i class="sym sym-refresh-ccw"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($canDeleteInternalNote)
                                            <form action="{{ route('internal-notes.destroy', $note->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-icon btn-sm btn-outline-secondary"
                                                    aria-label="Hapus" title="Hapus"
                                                    onclick="return confirm('Hapus catatan ini?')">
                                                    <i class="sym sym-trash-solid"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    Belum ada catatan internal pada Stock Opname ini sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($notes->hasPages())
            <div class="card-footer bg-white">
                {{ $notes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
