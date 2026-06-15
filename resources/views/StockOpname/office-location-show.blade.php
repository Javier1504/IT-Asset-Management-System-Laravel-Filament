@extends('layouts.admin')

@section('title', 'Detail Lokasi Office Asset')

@section('content')
<div class="container-fluid py-4">
    <style>
        .btn.btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .so-summary-chip {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .35rem .7rem;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            background: #f8fafc;
            font-weight: 700;
            font-size: .78rem;
        }

        .so-summary-segment {
            display: inline-flex;
            align-items: center;
            padding: .18rem .55rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
        }

        .so-summary-segment--success { background: #198754; color: #fff; }
        .so-summary-segment--danger { background: #dc3545; color: #fff; }
        .so-summary-segment--warning { background: #ffc107; color: #212529; }
        .so-summary-segment--secondary { background: #6c757d; color: #fff; }

        .so-pic-text {
            font-size: .82rem;
            color: #374151;
            font-weight: 600;
        }

        .so-pic-empty {
            color: #9ca3af;
            font-weight: 500;
        }

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
    </style>

    @php
        $isCompleted = $stockOpname->status === 'completed';
        $stockOpnameTitle = $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id);
        $backUrl = route('stock-opnames.show', $stockOpname->id);
        $items = collect($items ?? []);

        $firstFilled = function (array $values, $default = '-') {
            foreach ($values as $value) {
                if (filled($value) && trim((string) $value) !== '-') {
                    return $value;
                }
            }

            return $default;
        };

        $resolveOfficeItemLocationName = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'officeAset.lokasi.lokasi'),
                data_get($item, 'location.lokasi'),
                data_get($item, 'snapshot_location_name'),
                data_get($item, 'officeAset.lokasi.nama_lokasi'),
                data_get($item, 'location.nama_lokasi'),
                data_get($item, 'officeAset.lokasi.name'),
                data_get($item, 'location.name'),
            ], 'Tanpa Lokasi');
        };

        $resolveOfficeItemAssetName = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'officeAset.aset.jenisAset.name_jenis'),
                data_get($item, 'aset.jenisAset.name_jenis'),
                data_get($item, 'snapshot_asset_name'),
                data_get($item, 'officeAset.aset.nama_aset'),
                data_get($item, 'aset.nama_aset'),
            ], 'Office Asset');
        };

        $resolveOfficeItemAssetNumber = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'officeAset.aset.nomor_aset'),
                data_get($item, 'aset.nomor_aset'),
                data_get($item, 'snapshot_asset_number'),
            ], '-');
        };

        $resolveOfficeItemAssetBrand = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'officeAset.aset.merk_aset'),
                data_get($item, 'aset.merk_aset'),
                data_get($item, 'snapshot_asset_brand'),
            ], '-');
        };

        $resolveOfficeItemSerialNumber = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'officeAset.aset.serial_number'),
                data_get($item, 'aset.serial_number'),
                data_get($item, 'snapshot_serial_number'),
                data_get($item, 'manual_serial_number'),
            ], '-');
        };

        $resolvePicName = function ($item) use ($firstFilled) {
            return $firstFilled([
                data_get($item, 'checker.name_karyawan'),
                data_get($item, 'checker.username'),
                data_get($item, 'checker.corporate_email'),
                data_get($item, 'checker.email'),

                data_get($item, 'checkedBy.name_karyawan'),
                data_get($item, 'checkedBy.username'),
                data_get($item, 'checkedBy.corporate_email'),
                data_get($item, 'checkedBy.email'),

                data_get($item, 'checkedByUser.name_karyawan'),
                data_get($item, 'checkedByUser.username'),
                data_get($item, 'checkedByUser.corporate_email'),
                data_get($item, 'checkedByUser.email'),
            ], '-');
        };

        $locationName = filled($locationName ?? null)
            ? $locationName
            : ($items->isNotEmpty() ? $resolveOfficeItemLocationName($items->first()) : 'Tanpa Lokasi');

        $assetSummaryForView = $items
            ->groupBy(fn($item) => $resolveOfficeItemAssetName($item))
            ->map(fn($group, $label) => [
                'label' => $label,
                'count' => $group->count(),
                'belum_dicek' => $group->where('result_status', 'belum_dicek')->count(),
                'sesuai' => $group->where('result_status', 'sesuai')->count(),
                'tidak_sesuai' => $group->where('result_status', 'tidak_sesuai')->count(),
                'perlu_cek_lanjut' => $group->where('result_status', 'perlu_cek_lanjut')->count(),
            ])
            ->sortBy('label')
            ->values();
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Lokasi {{ $locationName }}</h4>
            <p class="text-muted mb-0">
                Detail Office Asset pada lokasi ini | Stock Opname: {{ $stockOpnameTitle }}
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge bg-primary">{{ $summary['total'] ?? $items->count() }} office asset</span>
            <span class="badge bg-success">{{ $summary['sesuai'] ?? 0 }} sesuai</span>
            <span class="badge bg-secondary">{{ $summary['belum_dicek'] ?? 0 }} belum dicek</span>
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary">Kembali</a>
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

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white">
            <strong>Ringkasan Jenis Office Asset</strong>
            <div class="text-muted small"></div>
        </div>

        <div class="card-body d-flex gap-2 flex-wrap">
            @forelse($assetSummaryForView as $asset)
                <span class="so-summary-chip">
                    {{ $asset['count'] }} {{ $asset['label'] }}

                    @if(($asset['belum_dicek'] ?? 0) > 0)
                        <span class="so-summary-segment so-summary-segment--warning">
                            {{ $asset['belum_dicek'] }} belum dicek
                        </span>
                    @endif

                    @if(($asset['sesuai'] ?? 0) > 0)
                        <span class="so-summary-segment so-summary-segment--success">
                            {{ $asset['sesuai'] }} sesuai
                        </span>
                    @endif

                    @if(($asset['tidak_sesuai'] ?? 0) > 0)
                        <span class="so-summary-segment so-summary-segment--danger">
                            {{ $asset['tidak_sesuai'] }} tidak sesuai
                        </span>
                    @endif

                    @if(($asset['perlu_cek_lanjut'] ?? 0) > 0)
                        <span class="so-summary-segment so-summary-segment--secondary">
                            {{ $asset['perlu_cek_lanjut'] }} perlu cek
                        </span>
                    @endif
                </span>
            @empty
                <span class="text-muted">Belum ada ringkasan asset.</span>
            @endforelse
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <strong>Daftar Office Asset</strong>
            <div class="text-muted small"></div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;" class="text-center">No</th>
                            <th style="width: 25%;">Aset</th>
                            <th style="width: 20%;">Nomor / SN</th>
                            <th style="width: 13%;">Kondisi</th>
                            <th style="width: 13%;">Status Cek</th>
                            <th style="width: 14%;">PIC</th>
                            <th style="width: 8%;" class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($items as $item)
                            @php
                                $itemStatusLabel = match($item->result_status) {
                                    'sesuai' => 'Sesuai',
                                    'tidak_sesuai' => 'Tidak Sesuai',
                                    'perlu_cek_lanjut' => 'Perlu Cek Lanjut',
                                    default => 'Belum Dicek',
                                };

                                $itemStatusClass = match($item->result_status) {
                                    'sesuai' => 'bg-success',
                                    'tidak_sesuai' => 'bg-danger',
                                    'perlu_cek_lanjut' => 'bg-warning text-dark',
                                    default => 'bg-secondary',
                                };

                                $picName = $resolvePicName($item);
                                $itemDetailUrl = route('stock-opnames.office-items.show', [$stockOpname->id, $item->id]);
                            @endphp

                            <tr id="item-{{ $item->id }}"
                                class="so-row-clickable"
                                data-detail-url="{{ $itemDetailUrl }}"
                                role="button"
                                tabindex="0">
                                <td class="text-center">
                                    <span class="so-index-badge">{{ $loop->iteration }}.</span>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $resolveOfficeItemAssetName($item) }}</div>
                                    <div class="text-muted small">Merk: {{ $resolveOfficeItemAssetBrand($item) }}</div>
                                    <div class="text-muted small">Lokasi: {{ $resolveOfficeItemLocationName($item) }}</div>
                                </td>

                                <td>
                                    <div class="text-muted small">No: {{ $resolveOfficeItemAssetNumber($item) }}</div>
                                    <div class="text-muted small">SN: {{ $resolveOfficeItemSerialNumber($item) }}</div>
                                </td>

                                <td>
                                    {{ $item->physical_condition ? str_replace('_', ' ', ucfirst($item->physical_condition)) : '-' }}
                                </td>

                                <td>
                                    <span class="badge {{ $itemStatusClass }}">{{ $itemStatusLabel }}</span>
                                </td>

                                <td>
                                    @if($picName !== '-')
                                        <span class="so-pic-text">{{ $picName }}</span>
                                    @else
                                        <span class="so-pic-empty">-</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ $itemDetailUrl }}"
                                       class="btn btn-sm btn-outline-secondary btn-icon"
                                       title="Lihat Detail">
                                        <i class="sym sym-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada Office Asset pada lokasi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

            if (url) {
                window.location.href = url;
            }
        }

        row.addEventListener('click', openDetail);

        row.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            event.preventDefault();

            const url = row.dataset.detailUrl;

            if (url) {
                window.location.href = url;
            }
        });
    });
});
</script>
@endsection
