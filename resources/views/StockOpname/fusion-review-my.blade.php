@extends('layouts.admin')

@section('title', 'Review Stock Opname Tim Saya')

@section('content')
<style>
    .fr-page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1rem}.fr-page-title{font-size:1.15rem;font-weight:800;color:#111827;margin-bottom:.25rem}.fr-page-subtitle{color:#6b7280;font-size:.875rem;margin-bottom:0}.fr-card{border:1px solid #e5e7eb;border-radius:.9rem;background:#fff;box-shadow:0 2px 10px rgba(15,23,42,.04);overflow:hidden}.fr-table-wrap{overflow-x:auto}.fr-table{width:100%;border-collapse:separate;border-spacing:0;margin-bottom:0}.fr-table th{padding:.8rem;font-size:.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:.03em;border-bottom:1px solid #e5e7eb;background:#f8fafc;white-space:nowrap}.fr-table td{padding:.8rem;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:.875rem}.fr-title-cell{font-weight:800;color:#111827}.fr-meta{color:#6b7280;font-size:.78rem;margin-top:.15rem}.fr-badge{display:inline-flex;align-items:center;justify-content:center;border-radius:999px;padding:.28rem .65rem;font-size:.72rem;font-weight:800;line-height:1.1;white-space:nowrap}.fr-empty{border:1px dashed #d1d5db;border-radius:.75rem;background:#f9fafb;color:#6b7280;padding:1.5rem;text-align:center;font-size:.9rem}.fr-clickable-row{cursor:pointer;transition:background-color .15s ease, box-shadow .15s ease}.fr-clickable-row:hover{background:#f8fafc}.fr-clickable-row:focus{outline:2px solid rgba(37,99,235,.35);outline-offset:-2px;background:#f8fafc}.fr-action-cell{white-space:nowrap}
</style>

<div class="container-fluid py-3">
    <div class="fr-page-header">
        <div>
            <h5 class="fr-page-title">Review Stock Opname Tim Saya</h5>
            <p class="fr-page-subtitle">Halaman ini menampilkan sesi stock opname FUSION yang bisa Anda review sebagai Team Leader.</p>
        </div>
        <a href="{{ route('dashboard.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="sym sym-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    @if(!empty($canReviewAllFusion))
        <div class="alert alert-primary">Anda membuka halaman ini sebagai admin. Admin dapat melihat semua sub-tim FUSION.</div>
    @endif

    @if($reviewRows->isEmpty())
        <div class="fr-empty">Belum ada sesi stock opname FUSION yang bisa direview.</div>
    @else
        <div class="fr-card">
            <div class="fr-table-wrap">
                <table class="fr-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Sesi Stock Opname</th>
                            <th>Sub Tim</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviewRows as $row)
                            @php
                                $stockOpname = $row['stock_opname'];
                                $subTeamNames = collect($row['sub_team_names'] ?? [])->filter()->implode(', ');
                                $reviewUrl = $row['review_url'] ?? '#';
                            @endphp
                            <tr class="fr-clickable-row"
                                data-href="{{ $reviewUrl }}"
                                tabindex="0"
                                role="link"
                                aria-label="Lihat review {{ $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id) }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fr-title-cell">{{ $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id) }}</div>
                                    <div class="fr-meta">Kode: {{ $stockOpname->code ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="fr-title-cell">{{ $subTeamNames !== '' ? $subTeamNames : '-' }}</div>
                                    <div class="fr-meta">{{ $row['sub_team_count'] ?? 0 }} sub-tim</div>
                                </td>
                                <td><span class="fr-badge {{ $row['status_class'] ?? 'bg-secondary' }}">{{ $row['status_label'] ?? '-' }}</span></td>
                                <td class="text-end fr-action-cell">
                                    <a href="{{ $reviewUrl }}" class="btn btn-primary btn-sm fw-semibold" onclick="event.stopPropagation();">
                                        <i class="sym sym-eye-solid me-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.fr-clickable-row[data-href]').forEach(function (row) {
            row.addEventListener('click', function (event) {
                if (event.target.closest('a, button, input, select, textarea')) {
                    return;
                }

                const href = row.getAttribute('data-href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });

            row.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter' && event.key !== ' ') {
                    return;
                }

                event.preventDefault();
                const href = row.getAttribute('data-href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endsection
