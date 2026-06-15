@extends('layouts.admin')

@section('title', 'Detail Stock Opname')

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
        }
        .so-card-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: start;
        }
        .so-action-col {
            min-width: 92px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            align-self: center;
        }
        .so-meta-wrap {
            display: none;
        }
        .so-action-buttons {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            gap: .45rem;
        }
        .so-action-title {
            font-size: .72rem;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            line-height: 1;
        }
        .so-person-card {
            border: 1px solid #e5e7eb;
            border-radius: .85rem;
            background: #fff;
            padding: .9rem;
            height: 100%;
        }
        .so-person-card .so-action-col {
            min-width: 120px;
        }

        .so-clickable-card {
            cursor: pointer;
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }
        .so-clickable-card:hover {
            border-color: #93c5fd !important;
            box-shadow: 0 .35rem 1rem rgba(15, 23, 42, .10) !important;
            transform: translateY(-1px);
        }
        .so-clickable-card:focus-within {
            border-color: #93c5fd !important;
        }
        .so-title-row {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap;
            margin-bottom: .25rem;
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
        .so-action-status {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .btn.btn-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .so-page-header {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: start;
            margin-bottom: 1rem;
        }
        .so-page-meta {
            color: #6b7280;
            margin-bottom: 0;
            line-height: 1.55;
            word-break: break-word;
        }
        .so-page-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .5rem;
            flex-wrap: wrap;
            min-width: 240px;
        }
        .so-add-team-actions {
            display: flex;
            justify-content: space-between;
            gap: .75rem;
            align-items: center;
            flex-wrap: wrap;
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        @media (max-width: 991.98px) {
            .so-page-header,
            .so-card-row {
                grid-template-columns: 1fr;
            }
            .so-page-actions,
            .so-action-col,
            .so-meta-wrap,
            .so-action-buttons {
                align-items: flex-start;
                justify-content: flex-start;
            }
        }
    </style>
    @php
        $isCompleted = $stockOpname->status === 'completed';

        $statusLabel = match($stockOpname->status) {
            'completed' => 'Selesai',
            'ongoing' => 'Berjalan',
            'need_follow_up' => 'Perlu Tindak Lanjut',
            default => 'Draft',
        };

        $statusClass = match($stockOpname->status) {
            'completed' => 'bg-success',
            'ongoing' => 'bg-primary',
            'need_follow_up' => 'bg-danger',
            default => 'bg-warning text-dark',
        };

        $stockOpnameTitle = $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id);

        $rawOpnameTeams = $stockOpname->opnameTeams ?? collect();
        $opnameUsers = $stockOpname->opnameUsers ?? collect();
        $stockOpnameItems = $stockOpname->items ?? collect();
        $personnelsByTeam = collect($personnels ?? []);
        $teamSummaries = collect($teamSummaries ?? []);

        $opnameTeams = $rawOpnameTeams
            ->filter(fn($team) => !empty($team->team))
            ->groupBy(fn($team) => trim((string) $team->team))
            ->map(function ($teams) {
                $firstTeam = $teams->first();

                $mergedUsers = $teams
                    ->flatMap(fn($team) => $team->opnameUsers ?? collect())
                    ->filter(fn($opnameUser) => !empty($opnameUser->user_id))
                    ->unique('user_id')
                    ->values();

                $firstTeam->setRelation('opnameUsers', $mergedUsers);

                return $firstTeam;
            })
            ->values();

        $registeredUserIds = $opnameUsers
            ->pluck('user_id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $teamSummaryText = $opnameTeams->pluck('team')->filter()->unique()->values()->implode(', ');
        $teamSummaryText = $teamSummaryText !== '' ? $teamSummaryText : ($stockOpname->team ?? '-');

        $totalPersonnel = $opnameUsers
            ->pluck('user_id')
            ->filter()
            ->unique()
            ->count();

        $totalTeam = $opnameTeams
            ->pluck('team')
            ->filter()
            ->unique()
            ->count();

        if ($totalTeam < 1) {
            $totalTeam = $opnameTeams->count();
        }

        $totalItemCount = $summary['total_items']
            ?? $summary['total']
            ?? ($stockOpnameItems->count() ?? 0);

        /*
         * Counter END USER ASSET harus dipisah dari OFFICE ASSET.
         * Jangan pakai $totalItemCount / $summary global untuk blok End User,
         * karena nilai global ikut menghitung office asset.
         */
        $endUserItemsForCounter = $stockOpnameItems
            ->filter(fn($item) => (($item->asset_source ?? null) === 'end_user') || !empty($item->end_user_aset_id))
            ->values();

        $endUserTotalItemCount = $endUserItemsForCounter->count();

        /*
         * Total Tim harus tetap dihitung dari tim yang sudah masuk ke stock opname.
         * Jangan diikat hanya ke item, karena beberapa kondisi data membuat relasi tim ada
         * tetapi item belum lengkap / team pada item kosong. Kalau opnameTeams kosong,
         * baru fallback ke kolom team pada item End User.
         */
        $endUserTotalTeam = $opnameTeams
            ->pluck('team')
            ->filter()
            ->unique()
            ->count();

        if ($endUserTotalTeam < 1) {
            $endUserTotalTeam = $endUserItemsForCounter
                ->pluck('team')
                ->filter()
                ->unique()
                ->count();
        }

        if ($endUserTotalTeam < 1 && $totalTeam > 0) {
            $endUserTotalTeam = $totalTeam;
        }

        $endUserSummary = [
            'sesuai' => $endUserItemsForCounter->where('result_status', 'sesuai')->count(),
            'tidak_sesuai' => $endUserItemsForCounter->where('result_status', 'tidak_sesuai')->count(),
            'perlu_cek_lanjut' => $endUserItemsForCounter->where('result_status', 'perlu_cek_lanjut')->count(),
            'belum_dicek' => $endUserItemsForCounter->where('result_status', 'belum_dicek')->count(),
        ];

        $hasAddAllTeamsRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.add-all-teams');
        $hasDestroyTeamRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.teams.destroy');
        $hasDestroyPersonnelRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.personnel.destroy');
        $hasAddTeamRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.add-team');
        $hasInternalNoteCreateRoute = \Illuminate\Support\Facades\Route::has('internal-notes.create');
        $hasExportExcelRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.export-excel');
        $hasTeamShowRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.team.show');
        $hasFusionReviewRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.fusion-review');
        $canAccessFusionReview = (bool) ($canAccessFusionReview ?? false);
        $hasPersonShowRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.person.show');
        $hasAddOfficeItemsRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.office-items.store');
        $hasOfficeLocationShowRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.office-location.show');
        $hasOfficeLocationDestroyRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.office-location.destroy');

        $selectableOfficeAssets = collect($selectableOfficeAssets ?? []);
        $officeLocationOptions = collect($officeLocationOptions ?? $selectableOfficeLocationOptions ?? []);
        $officeAssetsByLocation = $officeAssetsByLocation ?? $selectableOfficeAssetsByLocation ?? [];
        $officeItems = $stockOpnameItems
            ->filter(fn($item) => (($item->asset_source ?? null) === 'office') || !empty($item->office_aset_id))
            ->values();

        $officeItemsByLocation = $officeItems
            ->groupBy(fn($item) => filled($item->location_id) ? (string) $item->location_id : 'tanpa-lokasi')
            ->sortBy(function ($items) {
                return trim((string) ($items->first()->snapshot_location_name ?? 'Tanpa Lokasi'));
            });

        $officeAssetTotal = $officeItems->count();
        $officeLocationTotal = $officeItemsByLocation->count();
        $officeAssetSummary = [
            'sesuai' => $officeItems->where('result_status', 'sesuai')->count(),
            'tidak_sesuai' => $officeItems->where('result_status', 'tidak_sesuai')->count(),
            'perlu_cek_lanjut' => $officeItems->where('result_status', 'perlu_cek_lanjut')->count(),
            'belum_dicek' => $officeItems->where('result_status', 'belum_dicek')->count(),
        ];

        $focusOpnameUserId = request('focus_opname_user_id');

        $resolveAssetBadgeClass = function (?string $status) {
            return match($status) {
                'done' => 'bg-success',
                'problem' => 'bg-danger',
                'pending' => 'bg-warning text-dark',
                default => 'bg-secondary',
            };
        };

        $resolveAssetBadgeIcon = function (?string $status) {
            return match($status) {
                'done' => '✓',
                'problem' => '!',
                'pending' => '…',
                default => '-',
            };
        };

        $resolveSummaryLabel = function ($assetSummary) {
            return collect($assetSummary ?? [])
                ->map(fn($row) => ($row['count'] ?? 0) . ' ' . ($row['label'] ?? 'Aset'))
                ->filter()
                ->implode(', ');
        };

        $fallbackStatusBadge = [
            'label' => 'Belum ada aset',
            'class' => 'bg-secondary',
            'icon' => '-',
        ];

        $availableTeamsCollection = collect($availableTeams ?? [])->filter()->values();

        $hasEndUserSection = $endUserItemsForCounter->isNotEmpty()
            || $opnameTeams->isNotEmpty()
            || $opnameUsers->isNotEmpty()
            || (!$isCompleted && $hasAddTeamRoute && $availableTeamsCollection->isNotEmpty());

        $hasOfficeAssetSection = $officeItems->isNotEmpty() || $hasAddOfficeItemsRoute;
    @endphp

    <div class="so-page-header">
        <div>
            <h4 class="mb-1">{{ $stockOpnameTitle }}</h4>
            <p class="so-page-meta">
                {{ $stockOpname->code ?? '-' }}
                |
                {{ $stockOpname->category_label ?? 'Stock Opname' }}
                |
                Tim: {{ $teamSummaryText }}
                |
                Personel: {{ $totalPersonnel }}
            </p>
        </div>

        <div class="so-page-actions">
            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>

            @if($hasExportExcelRoute)
                <a href="{{ route('stock-opnames.export-excel', $stockOpname->id) }}" class="btn btn-success">
                    <i class="sym sym-download-solid me-1"></i>
                    Export Excel
                </a>
            @endif

            @if($hasInternalNoteCreateRoute)
                <a href="{{ route('internal-notes.create', [
                    'stock_opname_id' => $stockOpname->id,
                    'request_type' => 'operasional',
                    'title' => 'Tindak Lanjut Stock Opname - ' . $stockOpnameTitle,
                    'description' => 'Catatan ini dibuat sebagai tindak lanjut dari hasil pengecekan aset pada Stock Opname ' . ($stockOpname->code ?? ('#' . $stockOpname->id)) . '.',
                    'follow_up_note' => 'Tentukan PIC, prioritas, jadwal tindak lanjut, dan langkah penyelesaian dari temuan stock opname.',
                ]) }}" class="btn btn-primary">
                    + Buat Catatan Tindak Lanjut
                </a>
            @endif

            <a href="{{ route('stock-opnames.index') }}" class="btn btn-outline-secondary">
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

    @if($hasEndUserSection)
    <div class="alert alert-info border-0 shadow-sm">
    <strong>Tim → Personel → Aset</strong> untuk <strong>END USER ASSET</strong>
    </div>

    <div class="row mb-3">
        <div class="col-md mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Aset</small>
                    <h4 class="mb-0">{{ $endUserTotalItemCount }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Tim</small>
                    <h4 class="mb-0">{{ $endUserTotalTeam }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Sesuai</small>
                    <h4 class="mb-0">{{ $endUserSummary['sesuai'] ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Tidak Sesuai</small>
                    <h4 class="mb-0">{{ $endUserSummary['tidak_sesuai'] ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Perlu Cek Lanjut</small>
                    <h4 class="mb-0">{{ $endUserSummary['perlu_cek_lanjut'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    @if(!$isCompleted)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <strong>Tambah TIM ke Stock Opname Ini</strong>
                    <div class="text-muted small">
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($hasAddTeamRoute)
                    <form action="{{ route('stock-opnames.add-team', $stockOpname->id) }}"
                          method="POST"
                          id="addTeamToStockOpnameForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pilih Tim</label>
                                <select name="team" id="add_team_select" class="form-select" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach(($availableTeams ?? []) as $team)
                                        <option value="{{ $team }}">{{ $team }}</option>
                                    @endforeach
                                </select>

                                @if(collect($availableTeams ?? [])->isEmpty())
                                    <small class="text-muted">
                                        Tidak ada personel lain yang tersedia untuk ditambahkan.
                                    </small>
                                @else
                                    <small class="text-muted">
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Personel Tim</label>

                                <div id="addTeamPersonnelEmpty" class="border rounded p-3 text-muted bg-light">
                                    Pilih tim terlebih dahulu untuk menampilkan personel.
                                </div>

                                <div id="addTeamPersonnelList" class="row g-2"></div>
                            </div>
                        </div>

                        <div class="so-add-team-actions">
                            <div>
                                @if($hasAddAllTeamsRoute)
                                    <button type="submit"
                                            form="addAllTeamsToStockOpnameForm"
                                            class="btn btn-outline-success btn-sm">
                                        Tambahkan Seluruh Tim dan Personelnya
                                    </button>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addTeamSelectAll">
                                    Pilih Semua Personel
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-sm" id="addTeamClearAll">
                                    Reset Pilihan
                                </button>

                                <button type="submit" class="btn btn-primary btn-sm">
                                    Tambahkan Tim ke Stock Opname
                                </button>
                            </div>
                        </div>
                    </form>
                @endif

                @if($hasAddAllTeamsRoute)
                    <form id="addAllTeamsToStockOpnameForm"
                          action="{{ route('stock-opnames.add-all-teams', $stockOpname->id) }}"
                          method="POST"
                          class="d-none js-confirm-submit"
                          data-confirm-title="Tambahkan seluruh tim?"
                          data-confirm-message="Semua tim aktif beserta personelnya akan dimasukkan ke stock opname ini. Aset personel juga akan digenerate otomatis.">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    @endif
@endif

    @if($hasAddOfficeItemsRoute || $officeItems->isNotEmpty())
        <div class="alert alert-info border-0 shadow-sm">
        <strong>Lokasi → Aset</strong> untuk <strong>OFFICE ASSET</strong>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Total Office Asset</small>
                        <h4 class="mb-0">{{ $officeAssetTotal }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Lokasi</small>
                        <h4 class="mb-0">{{ $officeLocationTotal }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Sesuai</small>
                        <h4 class="mb-0">{{ $officeAssetSummary['sesuai'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Tidak Sesuai</small>
                        <h4 class="mb-0">{{ $officeAssetSummary['tidak_sesuai'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Perlu Cek Lanjut</small>
                        <h4 class="mb-0">{{ $officeAssetSummary['perlu_cek_lanjut'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$isCompleted && $hasAddOfficeItemsRoute)
        @php
            $officeLocationOptionsCollection = collect($officeLocationOptions ?? []);
            $hasAvailableOfficeLocation = $officeLocationOptionsCollection->isNotEmpty();
        @endphp

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <strong>Tambah Office Asset ke Stock Opname Ini</strong>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('stock-opnames.office-items.store', $stockOpname->id) }}"
                    method="POST"
                    id="addOfficeAssetsForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pilih Lokasi Aset</label>

                            <select id="add_office_location_select"
                                    class="form-select"
                                    {{ !$hasAvailableOfficeLocation ? 'disabled' : '' }}>
                                <option value="">-- Pilih Lokasi Aset --</option>

                                @foreach($officeLocationOptionsCollection as $locationOption)
                                    <option value="{{ $locationOption['key'] }}">
                                        {{ $locationOption['name'] }} ({{ $locationOption['count'] }} asset)
                                    </option>
                                @endforeach
                            </select>

                            @if($hasAvailableOfficeLocation)
                            @else
                                <small class="text-muted">
                                    Tidak ada Office Asset lain yang tersedia untuk ditambahkan.
                                </small>
                            @endif
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label">Office Asset</label>

                            <div id="addOfficeAssetEmpty" class="border rounded p-3 text-muted bg-light">
                                @if($hasAvailableOfficeLocation)
                                    Pilih lokasi aset terlebih dahulu untuk menampilkan Office Asset.
                                @else
                                    Semua Office Asset sudah masuk ke stock opname ini.
                                @endif
                            </div>

                            <div id="addOfficeAssetList" class="row g-2"></div>
                        </div>
                    </div>

                    <div class="so-add-team-actions">
                        <div>
                            <button type="submit"
                                    name="add_all_office_assets"
                                    value="1"
                                    class="btn btn-outline-success btn-sm js-office-add-all"
                                    {{ !$hasAvailableOfficeLocation ? 'disabled' : '' }}>
                                Tambahkan Seluruh Office Asset
                            </button>
                        </div>

                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    id="addOfficeLocationSelectAll"
                                    {{ !$hasAvailableOfficeLocation ? 'disabled' : '' }}>
                                Pilih Semua Asset
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    id="addOfficeLocationClearAll"
                                    {{ !$hasAvailableOfficeLocation ? 'disabled' : '' }}>
                                Reset Pilihan
                            </button>

                            <button type="submit"
                                    class="btn btn-primary btn-sm"
                                    {{ !$hasAvailableOfficeLocation ? 'disabled' : '' }}>
                                Tambahkan Asset Office ke Stock Opname
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($officeItems->isNotEmpty())
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong>Daftar Pengecekan Berdasarkan LOKASI OFFICE ASSET</strong>
                </div>

                @if(!$isCompleted)
                    <button type="button"
                            class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#completeStockOpnameModal">
                        Selesaikan Stock Opname
                    </button>
                @else
                    <span class="badge bg-success">Sudah Selesai</span>
                @endif
            </div>

            <div class="card-body">
                @foreach($officeItemsByLocation as $locationIndex => $locationItems)
                    @php
                        $locationKey = $locationIndex;
                        $locationName = trim((string) ($locationItems->first()->snapshot_location_name ?? 'Tanpa Lokasi')) ?: 'Tanpa Lokasi';
                        $locationTotal = $locationItems->count();

                        $locationChecked = $locationItems
                            ->filter(fn($item) => in_array($item->result_status, ['sesuai', 'tidak_sesuai', 'perlu_cek_lanjut'], true))
                            ->count();

                        $locationStatusBadge = [
                            'label' => $locationTotal > 0 && $locationChecked >= $locationTotal ? 'Selesai' : 'Belum selesai',
                            'class' => $locationTotal > 0 && $locationChecked >= $locationTotal ? 'bg-success' : 'bg-warning text-dark',
                        ];

                        $officeAssetSummaryByType = $locationItems
                            ->groupBy(fn($item) => trim((string) ($item->snapshot_asset_name ?? 'Office Asset')) ?: 'Office Asset')
                            ->map(function ($items, $assetName) {
                                return [
                                    'label' => $assetName,
                                    'count' => $items->count(),
                                    'segments' => [
                                        [
                                            'count' => $items->where('result_status', 'sesuai')->count(),
                                            'label' => 'sesuai',
                                            'class' => 'success',
                                        ],
                                        [
                                            'count' => $items->where('result_status', 'tidak_sesuai')->count(),
                                            'label' => 'tidak sesuai',
                                            'class' => 'danger',
                                        ],
                                        [
                                            'count' => $items->where('result_status', 'perlu_cek_lanjut')->count(),
                                            'label' => 'perlu cek',
                                            'class' => 'warning',
                                        ],
                                        [
                                            'count' => $items->where('result_status', 'belum_dicek')->count(),
                                            'label' => 'belum dicek',
                                            'class' => 'warning',
                                        ],
                                    ],
                                ];
                            })
                            ->sortBy('label')
                            ->values();
                    @endphp

                    <div class="card border shadow-sm mb-3 so-clickable-card"
                         data-detail-url="{{ $hasOfficeLocationShowRoute ? route('stock-opnames.office-location.show', [$stockOpname->id, $locationKey]) : '' }}"
                         role="button"
                         tabindex="0">
                        <div class="card-body">
                            <div class="so-card-row">
                                <div>
                                    <div class="so-title-row">
                                        <span class="so-index-badge">{{ $loop->iteration }}.</span>
                                        <h5 class="mb-0">Lokasi {{ $locationName }}</h5>
                                    </div>

                                    <div class="text-muted small mb-2">
                                        {{ $locationTotal }} office asset
                                    </div>

                                    <div class="so-summary-group">
                                        @forelse($officeAssetSummaryByType as $assetRow)
                                            <div class="so-summary-chip">
                                                <span class="so-summary-chip__parent">
                                                    {{ $assetRow['count'] ?? 0 }} {{ $assetRow['label'] ?? 'Office Asset' }}
                                                </span>

                                                <span class="so-summary-chip__segments">
                                                    @foreach(($assetRow['segments'] ?? []) as $segment)
                                                        @if(($segment['count'] ?? 0) > 0)
                                                            <span class="so-summary-segment so-summary-segment--{{ $segment['class'] ?? 'secondary' }}">
                                                                {{ $segment['count'] ?? 0 }} {{ $segment['label'] ?? '-' }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </div>
                                        @empty
                                            <span class="so-summary-segment so-summary-segment--secondary">Belum ada office asset</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="so-action-col">
                                    <div class="so-action-status">
                                        <span class="so-status-badge {{ $locationStatusBadge['class'] }}">
                                            {{ $locationStatusBadge['label'] }}
                                        </span>
                                    </div>

                                    <div class="so-action-title">Aksi</div>

                                    <div class="so-action-buttons">
                                        @if($hasOfficeLocationShowRoute)
                                            <a href="{{ route('stock-opnames.office-location.show', [$stockOpname->id, $locationKey]) }}"
                                               class="btn btn-icon btn-sm btn-outline-secondary"
                                               title="Lihat Detail Office Asset">
                                                <i class="sym sym-eye-solid"></i>
                                            </a>
                                        @endif

                                        @if(!$isCompleted && $hasOfficeLocationDestroyRoute)
                                            <form action="{{ route('stock-opnames.office-location.destroy', [$stockOpname->id, $locationKey]) }}"
                                                  method="POST"
                                                  class="d-inline js-confirm-submit"
                                                  data-confirm-title="Hapus office asset dari lokasi ini?"
                                                  data-confirm-message="Yakin ingin menghapus OFFICE ASSET pada lokasi {{ $locationName }} dari Stock Opname ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Hapus Office Asset Lokasi Ini">
                                                    <i class="sym sym-trash-solid"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($hasEndUserSection)
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <strong>Daftar Pengecekan Berdasarkan TIM</strong>
            </div>

            @if(!$isCompleted)
                <button type="button"
                        class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#completeStockOpnameModal">
                    Selesaikan Stock Opname
                </button>
            @else
                <span class="badge bg-success">Sudah Selesai</span>
            @endif
        </div>

        <div class="card-body">
            @forelse($opnameTeams as $teamIndex => $opnameTeam)
                @php
                    $teamName = trim((string) ($opnameTeam->team ?? '-'));
                    $isFusionTeamCard = strtoupper(trim($teamName)) === 'FUSION';
                    $teamUsers = $opnameTeam->opnameUsers ?? collect();
                    $teamPersonnelCount = $teamUsers->count();
                    $teamSummaryData = $teamSummaries->get($teamName, []);
                    $teamAssetSummary = $teamSummaryData['asset_summary'] ?? [];
                    $teamStatusBadge = $teamSummaryData['status_badge'] ?? $fallbackStatusBadge;

                    $teamPeople = collect($personnelsByTeam->get($teamName, []));

                    if ($teamPeople->isEmpty()) {
                        $teamPeople = collect($teamUsers)->map(function ($opnameUser) use ($stockOpnameItems) {
                            $items = $stockOpnameItems->filter(function ($item) use ($opnameUser) {
                                if (!empty($item->opname_user_id)) {
                                    return (int) $item->opname_user_id === (int) $opnameUser->id;
                                }

                                return (int) ($item->user_id ?? 0) === (int) $opnameUser->user_id;
                            });

                            return (object) [
                                'id' => $opnameUser->id,
                                'user_id' => $opnameUser->user_id,
                                'team' => $opnameUser->team,
                                'user' => $opnameUser->user,
                                'asset_count' => $items->count(),
                                'asset_summary' => [],
                                'status_badge' => [
                                    'label' => $items->count() > 0 ? 'Belum selesai' : 'Belum ada aset',
                                    'class' => $items->count() > 0 ? 'bg-warning text-dark' : 'bg-secondary',
                                    'icon' => '',
                                ],
                            ];
                        })->values();
                    }

                    $teamItemCount = collect($teamAssetSummary)->sum('count');

                    if ($teamItemCount < 1) {
                        $teamItemCount = $teamPeople->sum('asset_count');
                    }
                @endphp

                <div class="card border shadow-sm mb-3 so-clickable-card"
                     data-detail-url="{{ $hasTeamShowRoute ? route('stock-opnames.team.show', [$stockOpname->id, $opnameTeam->id]) : '' }}"
                     role="button"
                     tabindex="0">
                    <div class="card-body">
                        <div class="so-card-row">
                            <div>
                                <div class="so-title-row">
                                    <span class="so-index-badge">{{ $loop->iteration }}.</span>
                                    <h5 class="mb-0">Tim {{ $teamName }}</h5>
                                </div>

                                <div class="text-muted small mb-2">
                                    {{ $teamPersonnelCount }} personel | {{ $teamItemCount }} aset
                                </div>

                                <div class="so-summary-group">
                                    @forelse($teamAssetSummary as $assetRow)
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
                                <div class="so-action-status">
                                    <span class="so-status-badge {{ $teamStatusBadge['class'] ?? 'bg-secondary' }}">
                                        {{ $teamStatusBadge['label'] ?? 'Belum ada aset' }}
                                    </span>
                                </div>

                                <div class="so-action-title">Aksi</div>

                                <div class="so-action-buttons">
                                    @if($hasTeamShowRoute)
                                        <a href="{{ route('stock-opnames.team.show', [$stockOpname->id, $opnameTeam->id]) }}"
                                           class="btn btn-icon btn-sm btn-outline-secondary"
                                           title="Lihat Personel">
                                            <i class="sym sym-eye-solid"></i>
                                        </a>
                                    @endif

                                    @if($isFusionTeamCard && $hasFusionReviewRoute && $canAccessFusionReview)
                                        <a href="{{ route('stock-opnames.fusion-review', $stockOpname->id) }}"
                                           class="btn btn-icon btn-sm btn-outline-primary"
                                           title="Review Fusion">
                                            <i class="sym sym-clipboard-list-solid"></i>
                                        </a>
                                    @endif

                                    @if(!$isCompleted && $hasDestroyTeamRoute)
                                        <form action="{{ route('stock-opnames.teams.destroy', [$stockOpname->id, $opnameTeam->id]) }}"
                                              method="POST"
                                              class="d-inline js-confirm-submit"
                                              data-confirm-title="Hapus tim dari stock opname?"
                                              data-confirm-message="Yakin ingin menghapus Tim {{ $teamName }} dari Stock Opname ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Hapus Tim">
                                                <i class="sym sym-trash-solid"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    Belum ada tim dalam stock opname ini.
                </div>
            @endforelse
        </div>
    </div>
    @endif
</div>

<div class="modal fade" id="stockOpnameActionConfirmModal" tabindex="-1" aria-labelledby="stockOpnameActionConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="stockOpnameActionConfirmModalLabel">Konfirmasi Aksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0" id="stockOpnameActionConfirmMessage">
                    Apakah Anda yakin ingin melanjutkan aksi ini?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" id="stockOpnameActionConfirmButton">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="completeStockOpnameModal" tabindex="-1" aria-labelledby="completeStockOpnameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="completeStockOpnameModalLabel">Konfirmasi Selesaikan Stock Opname</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="mb-1">Apakah stock opname ini sudah selesai?</p>

                <div class="border rounded p-3 bg-light">
                    <div><strong>{{ $stockOpname->title ?? 'Stock Opname #' . $stockOpname->id }}</strong></div>
                    <small class="text-muted">Kode: {{ $stockOpname->code ?? '-' }}</small>
                </div>

                <p class="text-muted small mt-2 mb-0">
                    Setelah diselesaikan, item stock opname tidak dapat diedit kembali.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>

                <form action="{{ route('stock-opnames.complete', $stockOpname->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Ya, Selesaikan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const usersByTeamForAdd = @json($usersByTeam ?? []);
    const fusionSubTeamsForAdd = @json($fusionSubTeamsForAdd ?? []);
    const officeAssetsByLocationForAdd = @json($officeAssetsByLocation ?? []);
    const addTeamSelect = document.getElementById('add_team_select');
    const personnelEmpty = document.getElementById('addTeamPersonnelEmpty');
    const personnelList = document.getElementById('addTeamPersonnelList');
    const selectAllButton = document.getElementById('addTeamSelectAll');
    const clearAllButton = document.getElementById('addTeamClearAll');
    const addTeamForm = document.getElementById('addTeamToStockOpnameForm');
    const addOfficeAssetsForm = document.getElementById('addOfficeAssetsForm');
    const addOfficeLocationSelect = document.getElementById('add_office_location_select');
    const addOfficeAssetEmpty = document.getElementById('addOfficeAssetEmpty');
    const addOfficeAssetList = document.getElementById('addOfficeAssetList');
    const addOfficeAssetSelectAll = document.getElementById('addOfficeLocationSelectAll');
    const addOfficeAssetClearAll = document.getElementById('addOfficeLocationClearAll');

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    document.querySelectorAll(".js-collapse-toggle").forEach(function (button) {
        const targetSelector = button.getAttribute("data-bs-target");
        const target = document.querySelector(targetSelector);

        if (!target) return;

        const openText = button.getAttribute("data-open-text") || "Tutup";
        const closeText = button.getAttribute("data-close-text") || button.textContent.trim();

        function setOpened() {
            button.textContent = openText;
            button.classList.remove("btn-outline-primary");
            button.classList.add("btn-outline-secondary");
            button.setAttribute("aria-expanded", "true");
        }

        function setClosed() {
            button.textContent = closeText;
            button.classList.remove("btn-outline-secondary");
            button.classList.add("btn-outline-primary");
            button.setAttribute("aria-expanded", "false");
        }

        target.addEventListener("shown.bs.collapse", function (event) {
            if (event.target !== target) return;
            setOpened();
        });

        target.addEventListener("hidden.bs.collapse", function (event) {
            if (event.target !== target) return;
            setClosed();
        });

        if (target.classList.contains("show")) {
            setOpened();
        } else {
            setClosed();
        }
    });


    document.querySelectorAll('.so-clickable-card[data-detail-url]').forEach(function (card) {
        const detailUrl = card.getAttribute('data-detail-url');

        if (!detailUrl) {
            return;
        }

        function shouldIgnoreClick(target) {
            return Boolean(target.closest('a, button, form, input, select, textarea, label, .js-confirm-submit'));
        }

        card.addEventListener('click', function (event) {
            if (shouldIgnoreClick(event.target)) {
                return;
            }

            window.location.href = detailUrl;
        });

        card.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            if (shouldIgnoreClick(event.target)) {
                return;
            }

            event.preventDefault();
            window.location.href = detailUrl;
        });
    });

    let pendingSubmitForm = null;

    const actionConfirmModalEl = document.getElementById('stockOpnameActionConfirmModal');
    const actionConfirmTitle = document.getElementById('stockOpnameActionConfirmModalLabel');
    const actionConfirmMessage = document.getElementById('stockOpnameActionConfirmMessage');
    const actionConfirmButton = document.getElementById('stockOpnameActionConfirmButton');

    const actionConfirmModal = actionConfirmModalEl && window.bootstrap
        ? new bootstrap.Modal(actionConfirmModalEl)
        : null;

    document.querySelectorAll('.js-confirm-submit').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!actionConfirmModal) return;

            event.preventDefault();
            pendingSubmitForm = form;

            actionConfirmTitle.textContent = form.getAttribute('data-confirm-title') || 'Konfirmasi Aksi';
            actionConfirmMessage.textContent = form.getAttribute('data-confirm-message') || 'Apakah Anda yakin ingin melanjutkan aksi ini?';

            actionConfirmModal.show();
        });
    });

    if (actionConfirmButton) {
        actionConfirmButton.addEventListener('click', function () {
            if (pendingSubmitForm) {
                const form = pendingSubmitForm;
                pendingSubmitForm = null;
                form.submit();
            }
        });
    }

    function getOfficeAssetCheckboxes() {
        return document.querySelectorAll('.add-office-asset-checkbox');
    }

    function renderOfficeAssetsByLocation() {
        if (!addOfficeLocationSelect || !addOfficeAssetList || !addOfficeAssetEmpty) {
            return;
        }

        const locationKey = addOfficeLocationSelect.value;
        const assets = officeAssetsByLocationForAdd[locationKey] || [];

        addOfficeAssetList.innerHTML = '';

        if (!locationKey) {
            addOfficeAssetEmpty.style.display = 'block';
            addOfficeAssetEmpty.textContent = 'Pilih lokasi aset terlebih dahulu untuk menampilkan Office Asset.';
            return;
        }

        if (!assets.length) {
            addOfficeAssetEmpty.style.display = 'block';
            addOfficeAssetEmpty.textContent = 'Tidak ada Office Asset tersedia pada lokasi ini.';
            return;
        }

        addOfficeAssetEmpty.style.display = 'none';

        assets.forEach(function (asset) {
            const col = document.createElement('div');
            col.className = 'col-md-6';

            col.innerHTML = `
                <label class="border rounded p-2 bg-white h-100 d-flex align-items-start gap-2">
                    <input type="checkbox"
                           name="office_aset_ids[]"
                           value="${escapeHtml(asset.id)}"
                           class="form-check-input mt-1 add-office-asset-checkbox">

                    <div>
                        <div class="fw-semibold">${escapeHtml(asset.asset_name || '-')}</div>
                        <div class="text-muted small">No: ${escapeHtml(asset.asset_number || '-')}</div>
                        <div class="text-muted small">Jenis: ${escapeHtml(asset.asset_type || '-')}</div>
                        <div class="text-muted small">Merk: ${escapeHtml(asset.brand || '-')}</div>
                        <div class="text-muted small">Spesifikasi: ${escapeHtml(asset.specification || '-')}</div>
                        <div class="text-muted small">Lokasi: ${escapeHtml(asset.location_name || '-')}</div>
                        <div class="text-muted small">Status: ${escapeHtml(asset.status || '-')}</div>
                    </div>
                </label>
            `;

            addOfficeAssetList.appendChild(col);
        });
    }

    if (addOfficeLocationSelect) {
        addOfficeLocationSelect.addEventListener('change', renderOfficeAssetsByLocation);
    }

    if (addOfficeAssetSelectAll) {
        addOfficeAssetSelectAll.addEventListener('click', function () {
            getOfficeAssetCheckboxes().forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });
    }

    if (addOfficeAssetClearAll) {
        addOfficeAssetClearAll.addEventListener('click', function () {
            getOfficeAssetCheckboxes().forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
    }

    if (addOfficeAssetsForm) {
        addOfficeAssetsForm.addEventListener('submit', function (event) {
            const submitter = event.submitter;

            if (submitter && submitter.classList.contains('js-office-add-all')) {
                return;
            }

            const selectedCount = Array.from(getOfficeAssetCheckboxes()).filter(function (checkbox) {
                return checkbox.checked;
            }).length;

            if (selectedCount < 1) {
                event.preventDefault();
                alert('Minimal pilih satu office asset.');
            }
        });
    }

    if (addTeamSelect && personnelList && addTeamForm) {
        function isFusionTeamForAdd(team) {
            return String(team || '').trim().toUpperCase() === 'FUSION';
        }

        function normalizeUsers(team) {
            const users = usersByTeamForAdd[team] || [];
            return Array.isArray(users) ? users : Object.values(users);
        }

        function getFusionSubTeamsForAdd() {
            const subTeams = Array.isArray(fusionSubTeamsForAdd)
                ? fusionSubTeamsForAdd
                : Object.values(fusionSubTeamsForAdd || {});

            return subTeams.map(function (subTeam) {
                const members = Array.isArray(subTeam.members)
                    ? subTeam.members
                    : Object.values(subTeam.members || {});

                return {
                    id: subTeam.id,
                    code: subTeam.code || '',
                    name: subTeam.name || ('FUSION ' + (subTeam.code || '')),
                    member_count: Number(subTeam.member_count || members.length || 0),
                    members: members
                };
            });
        }

        function syncFusionSubTeamCheckboxesForAdd() {
            personnelList.querySelectorAll('.add-fusion-sub-team-checkbox').forEach(function (subTeamCheckbox) {
                const subTeamId = subTeamCheckbox.dataset.fusionSubTeamId;
                const memberCheckboxes = personnelList.querySelectorAll(
                    '.add-team-personnel-checkbox[data-fusion-sub-team-id="' + subTeamId + '"]'
                );

                const checkedCount = Array.from(memberCheckboxes).filter(function (checkbox) {
                    return checkbox.checked;
                }).length;

                subTeamCheckbox.checked = memberCheckboxes.length > 0 && checkedCount === memberCheckboxes.length;
                subTeamCheckbox.indeterminate = checkedCount > 0 && checkedCount < memberCheckboxes.length;
            });
        }

        function renderFusionPersonnelForAdd() {
            const subTeams = getFusionSubTeamsForAdd();
            personnelList.innerHTML = '';

            if (!subTeams.length) {
                personnelEmpty.style.display = 'block';
                personnelEmpty.textContent = 'Belum ada mapping sub-tim Fusion.';
                return;
            }

            personnelEmpty.style.display = 'none';

            const wrapper = document.createElement('div');
            wrapper.className = 'col-12';

            wrapper.innerHTML = `
                <div class="border rounded p-3 bg-light">
                    <div class="text-muted small mb-2">
                        Pilih sub-tim FUSION, atau klik sub-tim untuk expand personelnya.
                    </div>

                    ${subTeams.map(function (subTeam) {
                        const members = Array.isArray(subTeam.members) ? subTeam.members : [];
                        const subTeamId = String(subTeam.id || subTeam.code || subTeam.name || '');

                        return `
                            <details class="border rounded bg-white mb-2 overflow-hidden">
                                <summary class="d-flex justify-content-between align-items-center gap-2 p-2" style="cursor:pointer; list-style:none;">
                                    <div class="d-flex align-items-start gap-2">
                                        <input type="checkbox"
                                               class="form-check-input mt-1 add-fusion-sub-team-checkbox"
                                               data-fusion-sub-team-id="${escapeHtml(subTeamId)}"
                                               onclick="event.stopPropagation();">

                                        <div>
                                            <div class="fw-semibold">${escapeHtml(subTeam.name || '-')}</div>
                                            <div class="text-muted small">${members.length} personel</div>
                                        </div>
                                    </div>

                                    <span class="badge bg-secondary">${members.length} personel</span>
                                </summary>

                                <div class="border-top p-2">
                                    <div class="row g-2">
                                        ${members.map(function (user) {
                                            return `
                                                <div class="col-md-6">
                                                    <label class="border rounded p-2 bg-white h-100 d-flex align-items-start gap-2">
                                                        <input type="checkbox"
                                                               name="target_user_ids[]"
                                                               value="${escapeHtml(user.id)}"
                                                               class="form-check-input mt-1 add-team-personnel-checkbox"
                                                               data-fusion-sub-team-id="${escapeHtml(subTeamId)}">

                                                        <div>
                                                            <div class="fw-semibold">${escapeHtml(user.name || '-')}</div>
                                                            <div class="text-muted small">Role: ${escapeHtml(user.role || user.job_role || '-')}</div>
                                                            <div class="text-muted small">Email: ${escapeHtml(user.email || '-')}</div>
                                                        </div>
                                                    </label>
                                                </div>
                                            `;
                                        }).join('')}
                                    </div>
                                </div>
                            </details>
                        `;
                    }).join('')}
                </div>
            `;

            personnelList.appendChild(wrapper);
            syncFusionSubTeamCheckboxesForAdd();
        }

        function renderPersonnel() {
            const team = addTeamSelect.value;
            const users = normalizeUsers(team);

            personnelList.innerHTML = '';

            if (!team) {
                personnelEmpty.style.display = 'block';
                personnelEmpty.textContent = 'Pilih tim terlebih dahulu untuk menampilkan personel.';
                return;
            }

            if (isFusionTeamForAdd(team)) {
                renderFusionPersonnelForAdd();
                return;
            }

            if (!users.length) {
                personnelEmpty.style.display = 'block';
                personnelEmpty.textContent = 'Tidak ada personel aktif pada tim ini.';
                return;
            }

            personnelEmpty.style.display = 'none';

            users.forEach(function (user) {
                const col = document.createElement('div');
                col.className = 'col-md-6';

                col.innerHTML = `
                    <label class="border rounded p-2 bg-white h-100 d-flex align-items-start gap-2">
                        <input type="checkbox"
                               name="target_user_ids[]"
                               value="${escapeHtml(user.id)}"
                               class="form-check-input mt-1 add-team-personnel-checkbox">

                        <div>
                            <div class="fw-semibold">${escapeHtml(user.name || '-')}</div>
                            <div class="text-muted small">Role: ${escapeHtml(user.role || '-')}</div>
                        </div>
                    </label>
                `;

                personnelList.appendChild(col);
            });
        }

        function getCheckboxes() {
            return document.querySelectorAll('.add-team-personnel-checkbox');
        }

        personnelList.addEventListener('change', function (event) {
            const subTeamCheckbox = event.target.closest('.add-fusion-sub-team-checkbox');
            const personnelCheckbox = event.target.closest('.add-team-personnel-checkbox');

            if (subTeamCheckbox) {
                const subTeamId = subTeamCheckbox.dataset.fusionSubTeamId;

                personnelList.querySelectorAll(
                    '.add-team-personnel-checkbox[data-fusion-sub-team-id="' + subTeamId + '"]'
                ).forEach(function (checkbox) {
                    checkbox.checked = subTeamCheckbox.checked;
                });

                syncFusionSubTeamCheckboxesForAdd();
                return;
            }

            if (personnelCheckbox && isFusionTeamForAdd(addTeamSelect.value)) {
                syncFusionSubTeamCheckboxesForAdd();
            }
        });

        addTeamSelect.addEventListener('change', renderPersonnel);

        if (selectAllButton) {
            selectAllButton.addEventListener('click', function () {
                getCheckboxes().forEach(function (checkbox) {
                    checkbox.checked = true;
                });

                if (isFusionTeamForAdd(addTeamSelect.value)) {
                    syncFusionSubTeamCheckboxesForAdd();
                }
            });
        }

        if (clearAllButton) {
            clearAllButton.addEventListener('click', function () {
                getCheckboxes().forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                if (isFusionTeamForAdd(addTeamSelect.value)) {
                    syncFusionSubTeamCheckboxesForAdd();
                }
            });
        }

        addTeamForm.addEventListener('submit', function (event) {
            const selectedCount = Array.from(getCheckboxes()).filter(function (checkbox) {
                return checkbox.checked;
            }).length;

            if (!addTeamSelect.value) {
                event.preventDefault();
                alert('Silakan pilih tim terlebih dahulu.');
                return;
            }

            if (selectedCount < 1) {
                event.preventDefault();
                alert('Minimal pilih satu personel dari tim yang akan ditambahkan.');
            }
        });
    }

    const focusPersonnelId = @json($focusOpnameUserId);

    function openParentCollapses(element) {
        if (!element || !window.bootstrap) return;

        let parentCollapse = element.closest('.collapse');

        while (parentCollapse) {
            const collapseInstance = bootstrap.Collapse.getOrCreateInstance(parentCollapse, { toggle: false });
            collapseInstance.show();

            parentCollapse = parentCollapse.parentElement
                ? parentCollapse.parentElement.closest('.collapse')
                : null;
        }
    }

    function focusElementById(id, highlightClass = 'border-primary') {
        if (!id) return;

        const element = document.getElementById(id);
        if (!element) return;

        openParentCollapses(element);

        setTimeout(function () {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            element.classList.add(highlightClass, 'shadow-sm');
        }, 450);
    }

    if (focusPersonnelId) {
        focusElementById('opname-user-' + focusPersonnelId);
    }
});
</script>
@endsection
