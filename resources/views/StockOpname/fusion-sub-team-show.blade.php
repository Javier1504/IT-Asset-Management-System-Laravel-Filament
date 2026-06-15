@extends('layouts.admin')

@section('content')
@php
    $subTeamName = $fusionSubTeam->name ?? ('FUSION ' . ($fusionSubTeam->code ?? ''));
    $memberCollection = collect($fusionMembers ?? []);

    $totalPersonnel = $teamSummary['total_personnel']
        ?? $teamSummary['total']
        ?? $memberCollection->count();

    $totalAssets = $teamSummary['total_items']
        ?? $teamSummary['asset_count']
        ?? $memberCollection->sum(function ($member) {
            return (int) (
                data_get($member, 'items_count')
                ?? data_get($member, 'asset_count')
                ?? data_get($member, 'total_assets')
                ?? data_get($member, 'assets_count')
                ?? 0
            );
        });

    $totalMatched = $teamSummary['sesuai']
        ?? $teamSummary['matched_count']
        ?? $memberCollection->sum(fn ($member) => (int) data_get($member, 'summary.sesuai', 0));

    $totalNotMatched = $teamSummary['tidak_sesuai']
        ?? $teamSummary['not_matched_count']
        ?? $memberCollection->sum(fn ($member) => (int) data_get($member, 'summary.tidak_sesuai', 0));

    $totalNeedCheck = $teamSummary['perlu_cek_lanjut']
        ?? $teamSummary['need_check_count']
        ?? $memberCollection->sum(fn ($member) => (int) data_get($member, 'summary.perlu_cek_lanjut', 0));

    $totalUnchecked = $teamSummary['belum_dicek']
        ?? $teamSummary['unchecked_count']
        ?? $memberCollection->sum(fn ($member) => (int) data_get($member, 'summary.belum_dicek', 0));

    $backToSubTeamUrl = route('stock-opnames.team.show', [$stockOpname->id, $team->id]);
@endphp

<style>
    .so-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .so-page-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: .25rem;
    }

    .so-page-subtitle {
        color: #6b7280;
        font-size: .875rem;
        margin-bottom: 0;
    }

    .so-summary-pills {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .4rem;
        margin-top: .75rem;
    }

    .so-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: .25rem .55rem;
        font-size: .75rem;
        font-weight: 800;
        line-height: 1;
    }

    .so-pill-dark { color: #111827; background: #e5e7eb; }
    .so-pill-success { color: #ffffff; background: #198754; }
    .so-pill-danger { color: #ffffff; background: #dc3545; }
    .so-pill-warning { color: #111827; background: #ffc107; }
    .so-pill-secondary { color: #ffffff; background: #6c757d; }


    .so-pic-pills {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .35rem;
        margin-top: .25rem;
        margin-bottom: .45rem;
    }

    .so-pic-chip {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        color: #1f2937;
        border-radius: 999px;
        padding: .25rem .55rem;
        font-size: .75rem;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .so-asset-chip {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        background: #f9fafb;
        font-size: .75rem;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
    }

    .so-asset-chip-main,
    .so-asset-chip-segment {
        display: inline-flex;
        align-items: center;
        padding: .32rem .55rem;
    }

    .so-asset-chip-main {
        color: #111827;
        background: #f9fafb;
    }

    .so-asset-chip-segment.success { color: #ffffff; background: #198754; }
    .so-asset-chip-segment.danger { color: #ffffff; background: #dc3545; }
    .so-asset-chip-segment.warning { color: #111827; background: #ffc107; }
    .so-asset-chip-segment.secondary { color: #111827; background: #e5e7eb; }

    .so-personnel-list {
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .so-personnel-row {
        border: 1px solid #e5e7eb;
        border-radius: .75rem;
        background: #ffffff;
        cursor: pointer;
        transition: background-color .15s ease, box-shadow .15s ease, transform .15s ease;
    }

    .so-personnel-row:hover {
        background: #f8fafc;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .06);
        transform: translateY(-1px);
    }

    .so-personnel-inner {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 1rem;
        align-items: center;
        padding: 1rem;
    }

    .so-personnel-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .35rem;
        color: #111827;
        font-weight: 800;
        font-size: 1rem;
    }

    .so-personnel-meta {
        color: #4b5563;
        font-size: .875rem;
        margin-bottom: .35rem;
    }

    .so-personnel-meta strong {
        color: #111827;
    }

    .so-personnel-action {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .so-empty {
        border: 1px dashed #d1d5db;
        border-radius: .75rem;
        background: #f9fafb;
        color: #6b7280;
        padding: 1.5rem;
        text-align: center;
        font-size: .9rem;
    }

    @media (max-width: 768px) {
        .so-page-header { flex-direction: column; }
        .so-personnel-inner { grid-template-columns: 1fr; }
        .so-personnel-action { justify-content: flex-start; }
    }
</style>

<div class="container-fluid py-3">
    <div class="so-page-header">
        <div>
            <h5 class="so-page-title mb-1">
                Daftar Personel {{ $subTeamName }}
            </h5>

            <p class="so-page-subtitle">
                Klik personel untuk melihat asetnya.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ $backToSubTeamUrl }}" class="btn btn-outline-secondary btn-sm">
                <i class="sym sym-arrow-left"></i>
                Kembali ke Sub Tim
            </a>
        </div>
    </div>

    <div class="so-personnel-list">
        @forelse($memberCollection as $member)
            @php
                $user = data_get($member, 'user');

                $userId = data_get($member, 'user_id')
                    ?? data_get($member, 'opnameUser.user_id')
                    ?? data_get($member, 'id')
                    ?? data_get($user, 'id');

                $userName = data_get($member, 'name')
                    ?? data_get($member, 'user_name')
                    ?? data_get($member, 'name_karyawan')
                    ?? data_get($user, 'name_karyawan')
                    ?? data_get($user, 'name')
                    ?? data_get($user, 'username')
                    ?? data_get($user, 'email')
                    ?? '-';

                $roleLabel = data_get($member, 'role_label')
                    ?? data_get($member, 'role')
                    ?? data_get($member, 'job_role')
                    ?? data_get($user, 'job_role')
                    ?? data_get($user, 'role')
                    ?? '-';

                $assetCount = (int) (
                    data_get($member, 'items_count')
                    ?? data_get($member, 'summary.total')
                    ?? data_get($member, 'asset_count')
                    ?? data_get($member, 'total_assets')
                    ?? data_get($member, 'assets_count')
                    ?? 0
                );

                $assignedPicLabel = trim((string) data_get($member, 'pic_label', '-'));
                $assignedPicLabel = $assignedPicLabel !== '' ? $assignedPicLabel : '-';
                $picSummary = collect(data_get($member, 'pic_summary', []))->filter(fn ($row) => filled(data_get($row, 'pic_name')))->values();
                $assetSummary = collect(data_get($member, 'asset_summary', []))->filter(fn ($row) => (int) data_get($row, 'count', 0) > 0)->values();

                $matchedCount = (int) data_get($member, 'summary.sesuai', 0);
                $notMatchedCount = (int) data_get($member, 'summary.tidak_sesuai', 0);
                $needCheckCount = (int) data_get($member, 'summary.perlu_cek_lanjut', 0);
                $uncheckedCount = (int) data_get($member, 'summary.belum_dicek', 0);

                $detailUrl = $userId
                    ? route('stock-opnames.person.show', [
                        $stockOpname->id,
                        $userId,
                        'fusion_sub_team_id' => $fusionSubTeam->id,
                    ])
                    : '#';
            @endphp

            <div class="so-personnel-row so-clickable-card"
                 data-detail-url="{{ $detailUrl }}"
                 role="button"
                 tabindex="0">
                <div class="so-personnel-inner">
                    <div>
                        <div class="so-personnel-title">
                            <span>{{ $loop->iteration }}.</span>
                            <span>{{ $userName }}</span>
                        </div>

                        <div class="so-personnel-meta">
                            Role: {{ $roleLabel }} | {{ $assetCount }} aset
                        </div>

                        <div class="so-personnel-meta mb-1">
                            PIC:
                            @if($picSummary->isNotEmpty())
                                <div class="so-pic-pills d-inline-flex">
                                    @foreach($picSummary as $picRow)
                                        <span class="so-pic-chip">
                                            {{ data_get($picRow, 'asset_name', 'Aset') }}: {{ data_get($picRow, 'pic_name') }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <strong>-</strong>
                            @endif
                        </div>

                        <div class="so-summary-pills">
                            @forelse($assetSummary as $assetRow)
                                <span class="so-asset-chip">
                                    <span class="so-asset-chip-main">
                                        {{ (int) data_get($assetRow, 'count', 0) }} {{ data_get($assetRow, 'label', 'aset') }}
                                    </span>

                                    @php
                                        $segments = collect(data_get($assetRow, 'segments', []))
                                            ->filter(fn ($segment) => (int) data_get($segment, 'count', 0) > 0)
                                            ->values();
                                    @endphp

                                    @forelse($segments as $segment)
                                        <span class="so-asset-chip-segment {{ data_get($segment, 'class', 'secondary') }}">
                                            {{ (int) data_get($segment, 'count', 0) }} {{ data_get($segment, 'label', '-') }}
                                        </span>
                                    @empty
                                        <span class="so-asset-chip-segment secondary">
                                            {{ $assetCount > 0 ? 'belum dicek' : 'belum ada aset' }}
                                        </span>
                                    @endforelse
                                </span>
                            @empty
                                <span class="so-asset-chip">
                                    <span class="so-asset-chip-main">0 aset</span>
                                    <span class="so-asset-chip-segment secondary">belum ada aset</span>
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <div class="so-personnel-action">
                        <a href="{{ $detailUrl }}"
                           class="btn btn-icon btn-sm btn-outline-secondary"
                           title="Lihat Aset">
                            <i class="sym sym-eye-solid"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="so-empty">
                Belum ada personel pada sub-tim ini.
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('click', function (event) {
        const clickableCard = event.target.closest('.so-clickable-card');

        if (!clickableCard) {
            return;
        }

        if (event.target.closest('a, button, input, label, textarea, select')) {
            return;
        }

        const detailUrl = clickableCard.dataset.detailUrl;

        if (detailUrl && detailUrl !== '#') {
            window.location.href = detailUrl;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!['Enter', ' '].includes(event.key)) {
            return;
        }

        const clickableCard = event.target.closest('.so-clickable-card');

        if (!clickableCard) {
            return;
        }

        event.preventDefault();

        const detailUrl = clickableCard.dataset.detailUrl;

        if (detailUrl && detailUrl !== '#') {
            window.location.href = detailUrl;
        }
    });
</script>
@endsection
