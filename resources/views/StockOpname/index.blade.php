@extends('layouts.admin')

@section('title', 'Stock Opname')

@section('content')
<div class="container-fluid py-4">
    <style>
        .so-row-clickable {
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .so-row-clickable:hover {
            background-color: #f8fafc;
        }

        .so-index-badge {
            display: inline;
            width: auto;
            height: auto;
            border-radius: 0;
            background: transparent;
            border: 0;
            color: #334155;
            font-size: .95rem;
            font-weight: 700;
            margin-right: .35rem;
        }

        .btn.btn-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .so-action-buttons {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
        }

        .so-table td {
            vertical-align: middle;
        }

        .so-muted-small {
            font-size: .82rem;
            color: #6b7280;
        }
    </style>

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h4 class="mb-1">Stock Opname</h4>
        </div>

        <a href="{{ route('stock-opnames.create') }}" class="btn btn-primary">
            + Buat Stock Opname
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('stock-opnames.index') }}" class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari kode, judul, tim, status...">
                </div>

                <div class="col-md-3">
                    <select name="team" class="form-select">
                        <option value="">Semua Tim</option>
                        @foreach(($teams ?? []) as $team)
                            <option value="{{ $team }}" {{ request('team') == $team ? 'selected' : '' }}>
                                {{ $team }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berjalan</option>
                        <option value="need_follow_up" {{ request('status') == 'need_follow_up' ? 'selected' : '' }}>Perlu Tindak Lanjut</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">
                        Filter
                    </button>

                    <a href="{{ route('stock-opnames.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @php
        $hasShowRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.show');
        $hasDestroyRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.destroy');
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <strong>Daftar Stock Opname</strong>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 so-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 72px;" class="text-center">No</th>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Tim</th>
                            <th>Personel</th>
                            <th>Jumlah Aset</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Dibuat / Dicek Oleh</th>
                            <th style="width: 124px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($stockOpnames as $item)
                            @php
                                $rowNumber = method_exists($stockOpnames, 'currentPage')
                                    ? (($stockOpnames->currentPage() - 1) * $stockOpnames->perPage()) + $loop->iteration
                                    : $loop->iteration;

                                $statusLabel = $item->status_label ?? match($item->status) {
                                    'completed' => 'Selesai',
                                    'ongoing' => 'Berjalan',
                                    'need_follow_up' => 'Perlu Tindak Lanjut',
                                    default => 'Draft',
                                };

                                $statusClass = $item->status_badge_class ?? match($item->status) {
                                    'completed' => 'bg-success',
                                    'ongoing' => 'bg-primary',
                                    'need_follow_up' => 'bg-danger',
                                    default => 'bg-warning text-dark',
                                };

                                $teamsList = [];

                                if ($item->relationLoaded('opnameTeams') && $item->opnameTeams->isNotEmpty()) {
                                    $teamsList = $item->opnameTeams
                                        ->pluck('team')
                                        ->filter()
                                        ->unique()
                                        ->values()
                                        ->all();
                                } elseif (!empty($item->team)) {
                                    $teamsList = [$item->team];
                                }

                                $teamCount = count($teamsList);

                                if ($teamCount === 0) {
                                    $teamPreview = '-';
                                } elseif ($teamCount <= 3) {
                                    $teamPreview = implode(', ', $teamsList);
                                } else {
                                    $teamPreview = implode(', ', array_slice($teamsList, 0, 3)) . ' +' . ($teamCount - 3) . ' tim lainnya';
                                }

                                $personnelCount = $item->opname_users_count
                                    ?? $item->opnameUsers?->count()
                                    ?? $item->targetUsers?->count()
                                    ?? 0;

                                $itemsCount = $item->items_count ?? $item->items?->count() ?? 0;

                                $checkerName = $item->checker->name_karyawan
                                    ?? $item->checker->username
                                    ?? $item->checker->corporate_email
                                    ?? $item->checker->email
                                    ?? '-';

                                $personnelPreview = '-';

                                if ($item->relationLoaded('targetUsers') && $item->targetUsers->isNotEmpty()) {
                                    $personnelPreview = $item->targetUsers
                                        ->take(3)
                                        ->map(function ($user) {
                                            return $user->name_karyawan
                                                ?? $user->username
                                                ?? $user->corporate_email
                                                ?? $user->email
                                                ?? '-';
                                        })
                                        ->filter()
                                        ->implode(', ');

                                    if ($item->targetUsers->count() > 3) {
                                        $personnelPreview .= ' +' . ($item->targetUsers->count() - 3) . ' lainnya';
                                    }
                                } elseif ($item->relationLoaded('opnameUsers') && $item->opnameUsers->isNotEmpty()) {
                                    $personnelPreview = $item->opnameUsers
                                        ->take(3)
                                        ->map(function ($row) {
                                            return $row->user->name_karyawan
                                                ?? $row->user->username
                                                ?? $row->user->corporate_email
                                                ?? $row->user->email
                                                ?? '-';
                                        })
                                        ->filter()
                                        ->implode(', ');

                                    if ($item->opnameUsers->count() > 3) {
                                        $personnelPreview .= ' +' . ($item->opnameUsers->count() - 3) . ' lainnya';
                                    }
                                } elseif ($item->targetUser) {
                                    $personnelPreview = $item->targetUser->name_karyawan
                                        ?? $item->targetUser->username
                                        ?? $item->targetUser->corporate_email
                                        ?? $item->targetUser->email
                                        ?? '-';

                                    $personnelCount = 1;
                                }

                                $showUrl = $hasShowRoute ? route('stock-opnames.show', $item->id) : '#';
                                $canDelete = $hasDestroyRoute && $item->status !== 'completed';
                            @endphp

                            <tr class="so-row-clickable"
                                data-detail-url="{{ $showUrl }}"
                                role="button"
                                tabindex="0">
                                <td class="text-center">
                                    <span class="so-index-badge">{{ $rowNumber }}</span>
                                </td>

                                <td>
                                    <strong>{{ $item->code ?? '-' }}</strong>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $item->title ?? '-' }}</div>
                                    <small class="text-muted">
                                        {{ $item->category_label ?? 'Stock Opname' }}
                                    </small>
                                </td>

                                <td>
                                    <div>
                                        <span class="badge bg-info">
                                            {{ $teamCount }} tim
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $teamPreview }}
                                    </small>
                                </td>

                                <td>
                                    <div>{{ $personnelCount }} personel</div>
                                    <small class="text-muted">
                                        {{ $personnelPreview }}
                                    </small>
                                </td>

                                <td>
                                    <span class="fw-semibold">{{ $itemsCount }}</span>
                                    <small class="text-muted">aset</small>
                                </td>

                                <td>
                                    <span class="badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') : '-' }}

                                    @if($item->end_date)
                                        <br>
                                        <small class="text-muted">
                                            s/d {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    {{ $checkerName }}
                                    @if($item->created_at)
                                        <br>
                                        <small class="text-muted">
                                            {{ $item->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="so-action-buttons">
                                        @if($hasShowRoute)
                                            <a href="{{ $showUrl }}"
                                               class="btn btn-sm btn-outline-secondary btn-icon"
                                               title="Lihat Detail">
                                                <i class="sym sym-eye-solid"></i>
                                            </a>
                                        @endif

                                        @if($canDelete)
                                            <form action="{{ route('stock-opnames.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus stock opname {{ $item->title ?? $item->code ?? '' }}?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger btn-icon"
                                                        title="Hapus">
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
                                    Belum ada data stock opname.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($stockOpnames, 'links'))
                <div class="p-3">
                    {{ $stockOpnames->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.so-row-clickable').forEach(function (row) {
            function openDetail(event) {
                if (
                    event.target.closest('a') ||
                    event.target.closest('button') ||
                    event.target.closest('form') ||
                    event.target.closest('input') ||
                    event.target.closest('select') ||
                    event.target.closest('textarea')
                ) {
                    return;
                }

                const url = row.dataset.detailUrl;

                if (url && url !== '#') {
                    window.location.href = url;
                }
            }

            row.addEventListener('click', openDetail);

            row.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter' && event.key !== ' ') {
                    return;
                }

                if (
                    event.target.closest('a') ||
                    event.target.closest('button') ||
                    event.target.closest('form') ||
                    event.target.closest('input') ||
                    event.target.closest('select') ||
                    event.target.closest('textarea')
                ) {
                    return;
                }

                event.preventDefault();

                const url = row.dataset.detailUrl;

                if (url && url !== '#') {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endsection