@extends('layouts.admin')

@section('title', 'Detail Review Stock Opname FUSION')

@section('content')
@php
    $userName = $user->name_karyawan
        ?? $user->name
        ?? $user->username
        ?? $user->email
        ?? '-';

    $subTeamName = $fusionSubTeam->name ?? ('FUSION ' . ($fusionSubTeam->code ?? ''));
    $stockOpnameTitle = $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id);

    $reviewStatusLabel = data_get($review, 'status_label', $isCompleted ? 'Selesai' : 'Masih on going');
    $reviewStatusClass = data_get($review, 'status_class', $isCompleted ? 'bg-success' : 'bg-warning text-dark');
    $reviewKetLabel = data_get($review, 'keterangan_label', '-');
    $reviewKetClass = data_get($review, 'keterangan_class', 'bg-secondary');

    $backUrl = route('stock-opnames.fusion-review', $stockOpname->id);
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

    .fr-info-card {
        border: 1px solid #e5e7eb;
        border-radius: .85rem;
        background: #ffffff;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .fr-info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .75rem;
    }

    .fr-info-item {
        border: 1px solid #edf2f7;
        border-radius: .65rem;
        background: #f8fafc;
        padding: .75rem;
    }

    .fr-info-label {
        color: #6b7280;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: .25rem;
    }

    .fr-info-value {
        color: #111827;
        font-size: .9rem;
        font-weight: 800;
        margin-bottom: 0;
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

    .fr-table-wrap {
        border: 1px solid #e5e7eb;
        border-radius: .85rem;
        background: #ffffff;
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
        vertical-align: top;
        font-size: .875rem;
    }

    .fr-asset-title {
        font-weight: 800;
        color: #111827;
    }

    .fr-asset-meta {
        color: #6b7280;
        font-size: .78rem;
        margin-top: .15rem;
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

    @media (max-width: 992px) {
        .fr-info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .fr-page-header {
            flex-direction: column;
        }

        .fr-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-3">
    <div class="fr-page-header">
        <div>
            <h5 class="fr-page-title">
                Detail Review {{ $userName }}
            </h5>
            <p class="fr-page-subtitle">
                {{ $stockOpnameTitle }} · {{ $subTeamName }} · Kode: {{ $stockOpname->code ?? '-' }}
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
                <i class="sym sym-arrow-left"></i>
                Kembali ke Review Fusion
            </a>
        </div>
    </div>

    @if(!$isCompleted)
        <div class="alert alert-warning">
            Stock opname masih <strong>on going</strong>. Hasil final belum dapat direview sepenuhnya sampai admin menyelesaikan stock opname.
        </div>
    @endif

    <div class="fr-info-card">
        <div class="fr-info-grid">
            <div class="fr-info-item">
                <div class="fr-info-label">Personel</div>
                <p class="fr-info-value">{{ $userName }}</p>
            </div>

            <div class="fr-info-item">
                <div class="fr-info-label">Sub Tim</div>
                <p class="fr-info-value">{{ $subTeamName }}</p>
            </div>

            <div class="fr-info-item">
                <div class="fr-info-label">Status</div>
                <span class="fr-badge {{ $reviewStatusClass }}">
                    {{ $reviewStatusLabel }}
                </span>
            </div>

            <div class="fr-info-item">
                <div class="fr-info-label">Keterangan</div>
                <span class="fr-badge {{ $reviewKetClass }}">
                    {{ $reviewKetLabel }}
                </span>
            </div>
        </div>
    </div>

    <div class="fr-table-wrap">
        <table class="fr-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Aset</th>
                    <th>Serial Number</th>
                    <th>PIC</th>
                    <th>Hasil</th>
                    <th>Kondisi</th>
                    <th>Catatan</th>
                    <th>Tindak Lanjut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $assetName = $item->snapshot_asset_name
                            ?? data_get($item, 'aset.nama_aset')
                            ?? data_get($item, 'aset.name')
                            ?? data_get($item, 'officeAset.aset.nama_aset')
                            ?? data_get($item, 'officeAset.aset.name')
                            ?? 'Aset';

                        $assetNumber = $item->snapshot_asset_number
                            ?? data_get($item, 'aset.nomor_aset')
                            ?? data_get($item, 'officeAset.aset.nomor_aset')
                            ?? '-';

                        $assetType = data_get($item, 'aset.jenisAset.name_jenis')
                            ?? data_get($item, 'aset.jenisAset.name')
                            ?? data_get($item, 'officeAset.aset.jenisAset.name_jenis')
                            ?? data_get($item, 'officeAset.aset.jenisAset.name')
                            ?? '-';

                        $serialNumber = $item->manual_serial_number
                            ?? $item->snapshot_serial_number
                            ?? data_get($item, 'aset.serial_number')
                            ?? '-';

                        $picName = data_get($item, 'checkedBy.name_karyawan')
                            ?? data_get($item, 'checkedBy.name')
                            ?? data_get($item, 'checkedByUser.name_karyawan')
                            ?? data_get($item, 'checkedByUser.name')
                            ?? data_get($item, 'checker.name_karyawan')
                            ?? data_get($item, 'checker.name')
                            ?? '-';

                        $resultStatus = $item->result_status ?? 'belum_dicek';

                        $resultLabel = match($resultStatus) {
                            'sesuai' => 'Sesuai',
                            'tidak_sesuai' => 'Tidak sesuai',
                            'perlu_cek_lanjut' => 'Perlu cek',
                            default => 'Belum dicek',
                        };

                        $resultClass = match($resultStatus) {
                            'sesuai' => 'bg-success',
                            'tidak_sesuai' => 'bg-warning text-dark',
                            'perlu_cek_lanjut' => 'bg-warning text-dark',
                            default => 'bg-secondary',
                        };

                        $conditionLabel = $item->physical_condition ?: '-';
                        $notes = trim((string) ($item->notes ?? ''));
                        $issueType = trim((string) ($item->issue_type ?? ''));
                        $followUp = (bool) ($item->need_follow_up ?? false);
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fr-asset-title">{{ $assetName }}</div>
                            <div class="fr-asset-meta">
                                {{ $assetType }} · No: {{ $assetNumber }}
                            </div>
                        </td>
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $picName }}</td>
                        <td>
                            <span class="fr-badge {{ $resultClass }}">
                                {{ $resultLabel }}
                            </span>
                        </td>
                        <td>{{ $conditionLabel }}</td>
                        <td>{{ $notes !== '' ? $notes : '-' }}</td>
                        <td>
                            @if($followUp || $issueType !== '')
                                <span class="fr-badge bg-warning text-dark">
                                    {{ $issueType !== '' ? $issueType : 'Perlu tindak lanjut' }}
                                </span>
                            @else
                                <span class="fr-badge bg-success">
                                    Tidak
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada aset untuk personel ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
