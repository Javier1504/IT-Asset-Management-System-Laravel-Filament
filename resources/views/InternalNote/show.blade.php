@extends('layouts.admin')

@section('title', 'Detail Catatan Internal Tim')

@section('content')
<div class="container-fluid py-4">
    @php
        $creatorName = $note->creator->name_karyawan
            ?? $note->creator->username
            ?? $note->creator->corporate_email
            ?? $note->creator->email
            ?? '-';

        $updaterName = $note->updater->name_karyawan
            ?? $note->updater->username
            ?? $note->updater->corporate_email
            ?? $note->updater->email
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

        $hasPurchaseNote = !empty($note->purchase_need_note);
        $hasIncidentNote = !empty($note->incident_note);
        $hasConfigurationNote = !empty($note->configuration_note);
        $hasRoutingNote = !empty($note->routing_note);

        $stockOpnameLabel = null;

        if ($note->stockOpname) {
            $stockOpnameLabel = trim(
                ($note->stockOpname->code ?? '') . ' - ' . ($note->stockOpname->title ?? ''),
                ' -'
            );

            $stockOpnameLabel = $stockOpnameLabel ?: 'Stock Opname ID ' . $note->stockOpname->id;
        }

        $stockOpnameUserName = $note->stockOpnameUser?->user?->name_karyawan
            ?? $note->stockOpnameUser?->user?->username
            ?? $note->stockOpnameUser?->user?->corporate_email
            ?? $note->stockOpnameUser?->user?->email
            ?? '-';

        $stockOpnameItemName = $note->stockOpnameItem?->snapshot_asset_name ?? '-';
        $stockOpnameItemNumber = $note->stockOpnameItem?->snapshot_asset_number ?? '-';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail Catatan Internal Tim</h4>
            <p class="text-muted mb-0">
                Detail catatan operasional internal dan tindak lanjutnya.
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge {{ $statusClass }}">
                {{ $note->status_label }}
            </span>

            <a href="{{ $note->stock_opname_id ? route('internal-notes.stock-opname', $note->stock_opname_id) : route('internal-notes.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>

            <a href="{{ route('internal-notes.edit', $note->id) }}" class="btn btn-warning">
                Edit
            </a>

            @if($note->status !== 'done')
                <button type="button"
                        class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#doneInternalNoteModal">
                    Tandai Selesai
                </button>
            @else
                <button type="button"
                        class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#reopenInternalNoteModal">
                    Buka Ulang
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $note->title }}</strong>
                <div class="text-muted small">
                    Dibuat oleh {{ $creatorName }}
                    @if($note->created_at)
                        pada {{ $note->created_at->format('d/m/Y H:i') }}
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2">
                <span class="badge {{ $priorityClass }}">
                    {{ $note->priority_label }}
                </span>

                <span class="badge {{ $statusClass }}">
                    {{ $note->status_label }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <small class="text-muted">Jenis Catatan</small>
                    <div class="fw-semibold">{{ $note->request_type_label }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <small class="text-muted">Klasifikasi Aset</small>
                    <div class="fw-semibold">{{ $note->asset_classification_label }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <small class="text-muted">Prioritas</small>
                    <div>
                        <span class="badge {{ $priorityClass }}">
                            {{ $note->priority_label }}
                        </span>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <small class="text-muted">Status</small>
                    <div>
                        <span class="badge {{ $statusClass }}">
                            {{ $note->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <small class="text-muted">Deskripsi Umum</small>
                <div class="mt-1">
                    {!! nl2br(e($note->description ?: '-')) !!}
                </div>
            </div>

            @if($hasPurchaseNote)
                <div class="mb-3">
                    <small class="text-muted">Kebutuhan Pembelian / Penggantian</small>
                    <div class="mt-1">{!! nl2br(e($note->purchase_need_note)) !!}</div>
                </div>
            @endif

            @if($hasIncidentNote)
                <div class="mb-3">
                    <small class="text-muted">Catatan Insiden</small>
                    <div class="mt-1">{!! nl2br(e($note->incident_note)) !!}</div>
                </div>
            @endif

            @if($hasConfigurationNote || $hasRoutingNote)
                <div class="row">
                    @if($hasConfigurationNote)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Perubahan Konfigurasi</small>
                            <div class="mt-1">{!! nl2br(e($note->configuration_note)) !!}</div>
                        </div>
                    @endif

                    @if($hasRoutingNote)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Routing</small>
                            <div class="mt-1">{!! nl2br(e($note->routing_note)) !!}</div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="mb-0">
                <small class="text-muted">Catatan Tindak Lanjut</small>
                <div class="mt-1">{!! nl2br(e($note->follow_up_note ?: '-')) !!}</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <strong>Informasi Tambahan</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width: 280px;">PIC / Assigned To</th>
                    <td>{{ $assigneeName }}</td>
                </tr>
                <tr>
                    <th>Dibuat Oleh</th>
                    <td>{{ $creatorName }}</td>
                </tr>
                <tr>
                    <th>Diupdate Oleh</th>
                    <td>{{ $updaterName }}</td>
                </tr>
                <tr>
                    <th>Jadwal Tindak Lanjut</th>
                    <td>{{ $note->scheduled_at ? $note->scheduled_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>Estimasi Biaya Tindak Lanjut</th>
                    <td>{{ $note->estimated_cost ? 'Rp ' . number_format($note->estimated_cost, 0, ',', '.') : '-' }}</td>
                </tr>
                <tr>
                    <th>Relasi Stock Opname</th>
                    <td>
                        @if($note->stockOpname)
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span>{{ $stockOpnameLabel }}</span>

                                @if(\Illuminate\Support\Facades\Route::has('stock-opnames.show'))
                                    <a href="{{ route('stock-opnames.show', [
                                            $note->stockOpname->id,
                                            'focus_opname_user_id' => $note->stock_opname_user_id,
                                            'focus_item_id' => $note->stock_opname_item_id,
                                        ]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat Stock Opname
                                    </a>
                                @endif
                            </div>

                            @if($note->stock_opname_user_id || $note->stock_opname_item_id)
                                <div class="small text-muted mt-1">
                                    Fokus: {{ $stockOpnameUserName }}
                                    @if($note->stock_opname_item_id)
                                        | Aset: {{ $stockOpnameItemName }} {{ $stockOpnameItemNumber !== '-' ? '(' . $stockOpnameItemNumber . ')' : '' }}
                                    @endif
                                </div>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $note->created_at ? $note->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $note->updated_at ? $note->updated_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>Selesai Pada</th>
                    <td>{{ $note->completed_at ? $note->completed_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="doneInternalNoteModal" tabindex="-1" aria-labelledby="doneInternalNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="doneInternalNoteModalLabel">Konfirmasi Selesaikan Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Apakah catatan ini sudah selesai ditindaklanjuti?</p>
                <strong>{{ $note->title }}</strong>
                <p class="text-muted small mt-2 mb-0">
                    Status catatan akan berubah menjadi <strong>Done</strong> dan waktu selesai akan tercatat.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('internal-notes.done', $note->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Ya, Selesaikan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reopenInternalNoteModal" tabindex="-1" aria-labelledby="reopenInternalNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="reopenInternalNoteModalLabel">Konfirmasi Buka Ulang Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Apakah Anda ingin membuka ulang catatan ini?</p>
                <strong>{{ $note->title }}</strong>
                <p class="text-muted small mt-2 mb-0">
                    Status catatan akan kembali menjadi <strong>Open</strong> dan bisa ditindaklanjuti lagi.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('internal-notes.reopen', $note->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Ya, Buka Ulang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
