@extends('layouts.admin')

@section('title', 'Detail Tim Stock Opname')

@section('content')
<div class="container-fluid py-4">
    <style>
        .so-summary-group {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .so-summary-chip {
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            gap: .35rem;
            padding: .35rem .55rem;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            background: #f8fafc;
        }

        .so-summary-chip__parent {
            font-size: .78rem;
            font-weight: 700;
            color: #1f2937;
            white-space: nowrap;
        }

        .so-summary-chip__segments {
            display: inline-flex;
            flex-wrap: wrap;
            gap: .35rem;
        }

        .so-summary-segment {
            display: inline-flex;
            align-items: center;
            padding: .18rem .5rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .so-summary-segment--success { background: #198754; color: #fff; }
        .so-summary-segment--danger { background: #dc3545; color: #fff; }
        .so-summary-segment--warning { background: #ffc107; color: #212529; }
        .so-summary-segment--secondary { background: #6c757d; color: #fff; }

        .so-status-badge {
            display: inline-flex;
            align-items: center;
            padding: .3rem .7rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .so-card-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: start;
        }

        .so-action-col {
            min-width: 120px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: .65rem;
        }

        .so-action-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: .4rem;
        }

        .so-action-title {
            font-size: .72rem;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .btn.btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .so-pic-line {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .35rem;
            margin-bottom: .6rem;
            font-size: .8rem;
        }

        .so-pic-badge {
            display: inline-flex;
            align-items: center;
            padding: .18rem .5rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
            color: #374151;
        }

        .so-clickable-card {
            cursor: pointer;
            transition: background-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .so-clickable-card:hover {
            background-color: #f8fafc;
            box-shadow: 0 .35rem .9rem rgba(15, 23, 42, .08);
            transform: translateY(-1px);
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

        .so-fusion-list {
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .so-fusion-row {
            border: 1px solid #e5e7eb;
            border-radius: .65rem;
            background: #fff;
            cursor: pointer;
            transition: background-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .so-fusion-row:hover {
            background-color: #f8fafc;
            box-shadow: 0 .35rem .9rem rgba(15, 23, 42, .08);
            transform: translateY(-1px);
        }

        .so-fusion-row-inner {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
        }

        .so-fusion-main {
            display: flex;
            align-items: flex-start;
            gap: .85rem;
            min-width: 0;
        }

        .so-fusion-name {
            font-size: 1rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: .2rem;
        }

        .so-fusion-meta {
            color: #6b7280;
            font-size: .82rem;
        }

        .so-fusion-action {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .5rem;
            flex-wrap: wrap;
        }

        @media (max-width: 991.98px) {
            .so-card-row,
            .so-fusion-row-inner {
                grid-template-columns: 1fr;
            }

            .so-action-col,
            .so-action-buttons,
            .so-fusion-action {
                align-items: flex-start;
                justify-content: flex-start;
            }
        }
    </style>

    @php
        $isCompleted = $stockOpname->status === 'completed';
        $isFusionTeam = !empty($isFusionTeam);

        $teamName = $team->team ?? '-';

        if ($isFusionTeam) {
            $totalPersonnel = collect($fusionSubTeams ?? [])->sum('opname_members_count');
            $totalAssets = 0;
        } else {
            $totalPersonnel = $teamUsers->count();
            $totalAssets = $teamUsers->sum('asset_count');
        }

        $teamSummary = $teamSummary ?? [
            'asset_summary' => [],
            'status_badge' => [
                'label' => 'Belum ada aset',
                'class' => 'bg-secondary',
                'icon' => '-',
            ],
        ];

        $hasDestroyPersonnelRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.personnel.destroy');
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Tim {{ $teamName }}</h4>
            <p class="text-muted mb-0">
                Stock Opname: {{ $stockOpname->title ?? ('#' . $stockOpname->id) }}
                |
                {{ $stockOpname->code ?? '-' }}
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            @if($isFusionTeam)
                <span class="badge bg-primary">{{ collect($fusionSubTeams ?? [])->count() }} sub-tim</span>
                <span class="badge bg-info">{{ $totalPersonnel }} personel terpilih</span>
            @else
                <span class="badge bg-info">{{ $totalPersonnel }} personel</span>
                <span class="badge bg-secondary">{{ $totalAssets }} aset</span>

                @if(!empty($teamSummary['status_badge']))
                    <span class="badge {{ $teamSummary['status_badge']['class'] ?? 'bg-secondary' }}">
                        {{ $teamSummary['status_badge']['label'] ?? 'Belum ada aset' }}
                    </span>
                @endif
            @endif

            <a href="{{ route('stock-opnames.show', $stockOpname->id) }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
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

    @if($isFusionTeam)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <strong>Sub Tim FUSION</strong>
                    </div>

                    <div class="so-summary-group justify-content-end">
                        <span class="so-summary-segment so-summary-segment--secondary">
                            {{ collect($fusionSubTeams ?? [])->count() }} sub-tim
                        </span>
                        <span class="so-summary-segment so-summary-segment--success">
                            {{ $totalPersonnel }} personel masuk stock opname
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <strong>Daftar Sub Tim FUSION</strong>
            </div>

            <div class="card-body">
                <div class="so-fusion-list">
                    @forelse(($fusionSubTeams ?? collect()) as $subTeam)
                        @php
                            $subTeamCode = strtoupper((string) ($subTeam->code ?? '-'));
                            $subTeamName = $subTeam->name ?? ('FUSION ' . $subTeamCode);
                            $memberCount = (int) ($subTeam->members_count ?? 0);
                            $opnameMemberCount = (int) ($subTeam->opname_members_count ?? 0);
                            $subTeamUrl = route('stock-opnames.fusion-sub-team.show', [$stockOpname->id, $subTeam->id]);
                        @endphp

                        <div class="so-fusion-row so-clickable-card"
                             data-detail-url="{{ $subTeamUrl }}"
                             role="button"
                             tabindex="0">
                            <div class="so-fusion-row-inner">
                                <div class="so-fusion-main">

                                    <div class="min-w-0">
                                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                            <strong class="so-fusion-name mb-0">
                                                {{ $loop->iteration }}. {{ $subTeamName }}
                                            </strong>
                                        </div>

                                        <div class="so-fusion-meta mb-2">
                                            {{ $opnameMemberCount }} personel masuk stock opname dari {{ $memberCount }} total member.
                                        </div>

                                        <div class="so-summary-group">
                                            <span class="so-summary-segment so-summary-segment--success">
                                                {{ $opnameMemberCount }} dipilih
                                            </span>

                                            <span class="so-summary-segment so-summary-segment--secondary">
                                                {{ $memberCount }} total member
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="so-fusion-action">
                                    <a href="{{ $subTeamUrl }}"
                                       class="btn btn-icon btn-sm btn-outline-secondary"
                                       title="Lihat Personel">
                                        <i class="sym sym-eye-solid"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            Belum ada data sub-tim FUSION.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <strong>Ringkasan Aset Tim {{ $teamName }}</strong>
                        <div class="text-muted small">
                            Total {{ $totalAssets }} aset dari {{ $totalPersonnel }} personel.
                        </div>
                    </div>

                    <div class="so-summary-group justify-content-end">
                        @forelse(($teamSummary['asset_summary'] ?? []) as $assetRow)
                            <div class="so-summary-chip">
                                <span class="so-summary-chip__parent">
                                    {{ $assetRow['count'] ?? 0 }} {{ $assetRow['label'] ?? 'Aset' }}
                                </span>
                                <span class="so-summary-chip__segments">
                                    @forelse(($assetRow['segments'] ?? []) as $segment)
                                        <span class="so-summary-segment so-summary-segment--{{ $segment['class'] ?? 'secondary' }}">
                                            {{ $segment['count'] ?? 0 }} {{ $segment['label'] ?? '-' }}
                                        </span>
                                    @empty
                                        <span class="so-summary-segment so-summary-segment--secondary">0 data</span>
                                    @endforelse
                                </span>
                            </div>
                        @empty
                            <span class="so-summary-segment so-summary-segment--secondary">Belum ada aset</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <strong>Daftar Personel Tim {{ $teamName }}</strong>
                <div class="text-muted small"></div>
            </div>

            <div class="card-body">
                @forelse($teamUsers as $person)
                    @php
                        $personName = $person->user->name_karyawan
                            ?? $person->user->username
                            ?? $person->user->corporate_email
                            ?? $person->user->email
                            ?? '-';

                        $personRole = $person->user->role ?? '-';

                        $personStatusBadge = $person->status_badge ?? [
                            'label' => 'Belum ada aset',
                            'class' => 'bg-secondary',
                            'icon' => '',
                        ];

                        $picSummary = collect($person->pic_summary ?? []);
                        $uniquePicNames = $picSummary->pluck('pic_name')->filter()->unique()->values();
                        $picLabel = $person->pic_label ?? '-';
                        $hasDifferentPicPerAsset = $picSummary->count() > 1 && $uniquePicNames->count() > 1;

                        $personDetailUrl = route('stock-opnames.person.show', [$stockOpname->id, $person->user_id]);
                    @endphp

                    <div class="border rounded mb-3 bg-white so-clickable-card"
                         data-detail-url="{{ $personDetailUrl }}"
                         role="button"
                         tabindex="0">
                        <div class="p-3 so-card-row">
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="so-index-badge">{{ $loop->iteration }}.</span>
                                    <strong>{{ $personName }}</strong>
                                </div>

                                <div class="text-muted small mb-2">
                                    Role: {{ $personRole }} | {{ $person->asset_count }} aset
                                </div>

                                <div class="so-pic-line">
                                    <span class="text-muted">PIC:</span>

                                    @if($hasDifferentPicPerAsset)
                                        @foreach($picSummary as $picRow)
                                            <span class="so-pic-badge">
                                                {{ $picRow['asset_name'] ?? 'Aset' }}: {{ $picRow['pic_name'] ?? '-' }}
                                            </span>
                                        @endforeach
                                    @else
                                        <strong>{{ $picLabel ?: '-' }}</strong>
                                    @endif
                                </div>

                                <div class="so-summary-group">
                                    @forelse(($person->asset_summary ?? []) as $assetRow)
                                        <div class="so-summary-chip">
                                            <span class="so-summary-chip__parent">
                                                {{ $assetRow['count'] ?? 0 }} {{ $assetRow['label'] ?? 'Aset' }}
                                            </span>
                                            <span class="so-summary-chip__segments">
                                                @forelse(($assetRow['segments'] ?? []) as $segment)
                                                    <span class="so-summary-segment so-summary-segment--{{ $segment['class'] ?? 'secondary' }}">
                                                        {{ $segment['count'] ?? 0 }} {{ $segment['label'] ?? '-' }}
                                                    </span>
                                                @empty
                                                    <span class="so-summary-segment so-summary-segment--secondary">0 data</span>
                                                @endforelse
                                            </span>
                                        </div>
                                    @empty
                                        <span class="so-summary-segment so-summary-segment--secondary">Belum ada aset</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="so-action-col">
                                <span class="so-status-badge {{ $personStatusBadge['class'] ?? 'bg-secondary' }}">
                                    {{ $personStatusBadge['label'] ?? 'Belum ada aset' }}
                                </span>

                                <div class="so-action-title">Aksi</div>

                                <div class="so-action-buttons">
                                    <a href="{{ $personDetailUrl }}"
                                       class="btn btn-icon btn-sm btn-outline-secondary"
                                       title="Lihat Aset">
                                        <i class="sym sym-eye-solid"></i>
                                    </a>

                                    @if(!$isCompleted && $hasDestroyPersonnelRoute)
                                        <button type="button"
                                                class="btn btn-icon btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deletePersonnelModal"
                                                data-delete-url="{{ route('stock-opnames.personnel.destroy', [$stockOpname->id, $person->id]) }}"
                                                data-person-name="{{ $personName }}"
                                                title="Hapus Personel">
                                            <i class="sym sym-trash-solid"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        Belum ada personel pada tim ini.
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

@if(!$isCompleted && !$isFusionTeam && $hasDestroyPersonnelRoute)
    <div class="modal fade" id="deletePersonnelModal" tabindex="-1" aria-labelledby="deletePersonnelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deletePersonnelModalLabel">
                        Konfirmasi Hapus Personel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">Apakah Anda yakin ingin menghapus personel ini dari stock opname?</p>

                    <div class="border rounded p-3 bg-light">
                        <strong id="deletePersonnelName">-</strong>
                    </div>

                    <p class="text-muted small mt-2 mb-0">
                        Data aset pengecekan milik personel ini juga akan dihapus dari sesi stock opname.
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form id="deletePersonnelForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.so-clickable-card').forEach(function (card) {
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

            const url = card.dataset.detailUrl;

            if (url) {
                window.location.href = url;
            }
        }

        card.addEventListener('click', openDetail);

        card.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            event.preventDefault();

            const url = card.dataset.detailUrl;

            if (url) {
                window.location.href = url;
            }
        });
    });

    const deleteModal = document.getElementById('deletePersonnelModal');

    if (!deleteModal) {
        return;
    }

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        if (!button) {
            return;
        }

        const deleteUrl = button.getAttribute('data-delete-url') || '';
        const personName = button.getAttribute('data-person-name') || '-';

        const deleteForm = document.getElementById('deletePersonnelForm');
        const deleteName = document.getElementById('deletePersonnelName');

        if (deleteForm) {
            deleteForm.setAttribute('action', deleteUrl);
        }

        if (deleteName) {
            deleteName.textContent = personName;
        }
    });
});
</script>
@endsection