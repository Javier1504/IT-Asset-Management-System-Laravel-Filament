@extends('layouts.admin')

@section('title', 'Review Stock Opname FUSION')

@section('content')
@php
    $stockOpnameTitle = $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id);
    $statusText = $isCompleted ? 'Selesai' : 'Masih on going';
    $statusClass = $isCompleted ? 'bg-success' : 'bg-warning text-dark';

    $backUrl = route('stock-opnames.fusion-review.my');
@endphp

<style>
    .fr-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .fr-page-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: .25rem;
    }

    .fr-page-subtitle {
        color: #6b7280;
        font-size: .875rem;
        margin-bottom: 0;
    }

    .fr-subteam-block {
        border: 1px solid #e5e7eb;
        border-radius: .85rem;
        background: #ffffff;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .fr-subteam-header {
        padding: .9rem 1rem;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .fr-subteam-title {
        font-weight: 800;
        color: #111827;
        margin-bottom: .15rem;
    }

    .fr-subteam-meta {
        font-size: .82rem;
        color: #6b7280;
    }

    .fr-table-wrap {
        overflow-x: auto;
    }

    .fr-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .fr-table th {
        padding: .75rem;
        font-size: .75rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .03em;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .fr-table td {
        padding: .75rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: .875rem;
    }

    .fr-table tr.fr-clickable-row {
        cursor: pointer;
        transition: background-color .15s ease;
    }

    .fr-table tr.fr-clickable-row:hover {
        background: #f8fafc;
    }

    .fr-member-name {
        font-weight: 800;
        color: #111827;
    }

    .fr-member-role {
        font-size: .78rem;
        color: #6b7280;
        margin-top: .15rem;
    }

    .fr-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: .28rem .65rem;
        font-size: .72rem;
        font-weight: 800;
        line-height: 1.1;
        white-space: nowrap;
    }

    .fr-action-cell {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .4rem;
    }

    .fr-empty {
        border: 1px dashed #d1d5db;
        border-radius: .75rem;
        background: #f9fafb;
        color: #6b7280;
        padding: 1.5rem;
        text-align: center;
        font-size: .9rem;
    }

    @media (max-width: 768px) {
        .fr-page-header {
            flex-direction: column;
        }

        .fr-subteam-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container-fluid py-3">
    <div class="fr-page-header">
        <div>
            <h5 class="fr-page-title">
                Review Stock Opname FUSION
            </h5>
            <p class="fr-page-subtitle">
                {{ $stockOpnameTitle }} · Kode: {{ $stockOpname->code ?? '-' }}
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <span class="badge {{ $statusClass }}">
                {{ $statusText }}
            </span>

            @if(!empty($canReviewAllFusion))
                <span class="badge bg-primary">
                    Admin View
                </span>
            @endif

            <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
                <i class="sym sym-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if(!$isCompleted)
        <div class="alert alert-warning">
            Stock opname masih <strong>on going</strong>. Team Leader bisa melihat daftar anggota sub-timnya, tetapi hasil final baru bisa direview setelah admin menyelesaikan stock opname.
        </div>
    @endif

    @forelse($reviewGroups as $group)
        @php
            $subTeam = $group['sub_team'] ?? null;
            $subTeamName = $group['sub_team_name'] ?? data_get($subTeam, 'name', '-');
            $members = collect($group['members'] ?? []);
            $summary = $group['summary'] ?? [];
        @endphp

        <div class="fr-subteam-block">
            <div class="fr-subteam-header">
                <div>
                    <div class="fr-subteam-title">{{ $subTeamName }}</div>
                    <div class="fr-subteam-meta">
                        {{ $members->count() }} anggota · {{ $summary['total_items'] ?? 0 }} aset
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <span class="fr-badge bg-secondary text-white">
                        {{ $summary['sesuai'] ?? 0 }} sesuai
                    </span>
                    <span class="fr-badge bg-warning text-dark">
                        {{ $summary['tidak_sesuai'] ?? 0 }} belum sesuai
                    </span>
                    <span class="fr-badge bg-secondary text-white">
                        {{ $summary['belum_dicek'] ?? 0 }} belum dicek
                    </span>
                </div>
            </div>

            <div class="fr-table-wrap">
                <table class="fr-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Anggota</th>
                            <th>Jumlah Aset</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $memberIndex => $member)
                            @php
                                $userId = (int) data_get($member, 'user_id', 0);
                                $userName = data_get($member, 'user_name')
                                    ?? data_get($member, 'user.name_karyawan')
                                    ?? data_get($member, 'user.name')
                                    ?? data_get($member, 'user.email')
                                    ?? '-';

                                $roleLabel = data_get($member, 'role_label')
                                    ?? data_get($member, 'user.job_role')
                                    ?? data_get($member, 'user.role')
                                    ?? '-';

                                $assetCount = (int) data_get($member, 'items_count', 0);
                                $review = data_get($member, 'review', []);
                                $statusLabel = data_get($review, 'status_label', $isCompleted ? 'Selesai' : 'Masih on going');
                                $statusClass = data_get($review, 'status_class', $isCompleted ? 'bg-success' : 'bg-warning text-dark');
                                $ketLabel = data_get($review, 'keterangan_label', '-');
                                $ketClass = data_get($review, 'keterangan_class', 'bg-secondary');

                                if ($assetCount > 0 && $ketLabel === 'Belum ada aset') {
                                    $ketLabel = 'Belum dicek';
                                    $ketClass = 'bg-secondary text-white';
                                }

                                $detailUrl = $userId
                                    ? route('stock-opnames.fusion-review.person', [
                                        $stockOpname->id,
                                        $userId,
                                        'fusion_sub_team_id' => data_get($subTeam, 'id'),
                                    ])
                                    : '#';
                            @endphp

                            <tr class="fr-clickable-row"
                                data-detail-url="{{ $detailUrl }}"
                                tabindex="0">
                                <td>{{ $memberIndex + 1 }}</td>
                                <td>
                                    <div class="fr-member-name">{{ $userName }}</div>
                                    <div class="fr-member-role">{{ $roleLabel }}</div>
                                </td>
                                <td>{{ $assetCount }} aset</td>
                                <td>
                                    <span class="fr-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fr-badge {{ $ketClass }}">
                                        {{ $ketLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fr-action-cell">
                                        <a href="{{ $detailUrl }}"
                                           class="btn btn-icon btn-sm btn-outline-secondary"
                                           title="Lihat Detail">
                                            <i class="sym sym-eye-solid"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada anggota sub-tim yang masuk stock opname ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="fr-empty">
            Belum ada data review FUSION yang bisa ditampilkan.
        </div>
    @endforelse
</div>

<script>
    document.addEventListener('click', function (event) {
        const row = event.target.closest('.fr-clickable-row');

        if (!row || event.target.closest('a, button, input, select, textarea')) {
            return;
        }

        const detailUrl = row.dataset.detailUrl;

        if (detailUrl && detailUrl !== '#') {
            window.location.href = detailUrl;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!['Enter', ' '].includes(event.key)) {
            return;
        }

        const row = event.target.closest('.fr-clickable-row');

        if (!row) {
            return;
        }

        event.preventDefault();

        const detailUrl = row.dataset.detailUrl;

        if (detailUrl && detailUrl !== '#') {
            window.location.href = detailUrl;
        }
    });
</script>
@endsection
