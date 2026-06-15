@extends('layouts.admin')

@section('title', 'Buat Stock Opname')

@section('content')
<style>
    .asset-source-card {
        cursor: pointer;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        padding: 16px;
        transition: 0.15s ease;
        height: 100%;
    }

    .asset-source-card:hover {
        border-color: #2563eb;
        background: #f8fbff;
    }

    .asset-source-card.active {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .asset-source-title {
        font-weight: 700;
        color: #111827;
    }

    .asset-source-desc {
        color: #6b7280;
        font-size: 13px;
    }

    .stock-section-muted {
        color: #6b7280;
        font-size: 13px;
    }

    .preview-panel {
        min-height: 140px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
        padding: 14px;
    }

    .preview-empty {
        color: #6b7280;
        padding: 12px 4px;
    }

    .asset-mini-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        background: #ffffff;
        height: 100%;
    }

    .asset-mini-title {
        font-weight: 700;
        color: #111827;
        font-size: 14px;
    }

    .asset-mini-meta {
        color: #6b7280;
        font-size: 12px;
        line-height: 1.45;
    }

    .selected-office-location-card .card-header,
    .selected-team-card .card-header {
        background: #f8fafc;
    }

    .fusion-sub-team-row {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .fusion-sub-team-summary {
        cursor: pointer;
        padding: 12px;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        list-style: none;
    }

    .fusion-sub-team-summary::-webkit-details-marker {
        display: none;
    }

    .fusion-sub-team-body {
        padding: 12px;
        border-top: 1px solid #e5e7eb;
    }

    .fusion-sub-team-title {
        font-weight: 700;
        color: #111827;
    }

    .fusion-sub-team-meta {
        font-size: 12px;
        color: #6b7280;
    }

</style>

@php
    $officeAssetsCollection = collect($officeAssets ?? [])->values();

    $oldOfficeAssetIds = collect(old('office_aset_ids', []))
        ->map(fn ($id) => (string) $id)
        ->values()
        ->all();

    $oldIncludeEndUserAssets = old('include_end_user_assets', null);
    $oldIncludeOfficeAssets = old('include_office_assets', null);

    $includeEndUserDefault = $oldIncludeEndUserAssets === null
        ? true
        : (bool) $oldIncludeEndUserAssets;

    $includeOfficeDefault = (bool) $oldIncludeOfficeAssets;

    $normalizedOfficeAssets = $officeAssetsCollection->map(function ($officeAsset) {
        $officeAssetArray = is_array($officeAsset) ? $officeAsset : $officeAsset->toArray();

        $assetNumber = data_get($officeAssetArray, 'asset_number')
            ?? data_get($officeAssetArray, 'aset.nomor_aset')
            ?? data_get($officeAssetArray, 'aset.asset_number')
            ?? data_get($officeAssetArray, 'aset.kode_aset')
            ?? '-';

        $assetType = data_get($officeAssetArray, 'asset_type')
            ?? data_get($officeAssetArray, 'asset_name')
            ?? data_get($officeAssetArray, 'aset.jenis_aset.name_jenis')
            ?? data_get($officeAssetArray, 'aset.jenisAset.name_jenis')
            ?? data_get($officeAssetArray, 'aset.jenis_aset.nama_jenis')
            ?? data_get($officeAssetArray, 'aset.jenisAset.nama_jenis')
            ?? 'Office Asset';

        $assetName = data_get($officeAssetArray, 'asset_name')
            ?? $assetType
            ?? 'Office Asset';

        $brand = data_get($officeAssetArray, 'brand')
            ?? data_get($officeAssetArray, 'merk_aset')
            ?? data_get($officeAssetArray, 'aset.merk_aset')
            ?? data_get($officeAssetArray, 'aset.merk')
            ?? '-';

        $specification = data_get($officeAssetArray, 'specification')
            ?? data_get($officeAssetArray, 'spesifikasi_aset')
            ?? data_get($officeAssetArray, 'aset.spesifikasi_aset')
            ?? data_get($officeAssetArray, 'aset.spesifikasi')
            ?? '-';

        $locationId = data_get($officeAssetArray, 'location_id')
            ?? data_get($officeAssetArray, 'lokasi_id')
            ?? data_get($officeAssetArray, 'lokasi.id');

        $locationName = data_get($officeAssetArray, 'location_name')
            ?? data_get($officeAssetArray, 'lokasi.lokasi')
            ?? data_get($officeAssetArray, 'lokasi.nama_lokasi')
            ?? data_get($officeAssetArray, 'lokasi.name')
            ?? (filled($locationId) ? 'Lokasi ID ' . $locationId . ' tidak ditemukan' : 'Tanpa Lokasi');

        $locationKey = data_get($officeAssetArray, 'location_key')
            ?? (filled($locationId) ? (string) $locationId : 'tanpa-lokasi');

        $status = data_get($officeAssetArray, 'status')
            ?? data_get($officeAssetArray, 'status_aset')
            ?? '-';

        $officeAsetId = data_get($officeAssetArray, 'office_aset_id')
            ?? data_get($officeAssetArray, 'id');

        return [
            'id' => (int) $officeAsetId,
            'office_aset_id' => (int) $officeAsetId,
            'aset_id' => data_get($officeAssetArray, 'aset_id'),
            'lokasi_id' => $locationId,
            'location_key' => (string) $locationKey,
            'location_name' => $locationName,
            'asset_number' => $assetNumber,
            'asset_name' => $assetName,
            'asset_type' => $assetType,
            'brand' => $brand,
            'specification' => $specification,
            'serial_number' => data_get($officeAssetArray, 'serial_number'),
            'status' => $status,
        ];
    })->values();

    $officeLocationOptions = $normalizedOfficeAssets
        ->groupBy('location_key')
        ->map(function ($group) {
            $first = $group->first();

            return [
                'key' => $first['location_key'],
                'name' => $first['location_name'],
                'count' => $group->count(),
            ];
        })
        ->sortBy('name')
        ->values();

    $officeAssetsByLocation = $normalizedOfficeAssets
        ->groupBy('location_key')
        ->map(fn ($group) => $group->values()->all())
        ->toArray();
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h4 class="mb-1">Buat Stock Opname</h4>
            <p class="text-muted mb-0">
            </p>
        </div>

        <a href="{{ route('stock-opnames.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <strong>Data belum valid.</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <strong>Form Sesi Stock Opname</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('stock-opnames.store') }}" method="POST" id="stockOpnameCreateForm">
                @csrf

                <input type="hidden" name="office_asset_mode" value="selected">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">
                            Judul Stock Opname <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Stock Opname Juni 2026"
                               required>
                        <small class="text-muted">
                        </small>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Tanggal Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="start_date"
                               value="{{ old('start_date') }}"
                               class="form-control @error('start_date') is-invalid @enderror"
                               required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date"
                               name="end_date"
                               value="{{ old('end_date') }}"
                               class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border shadow-sm mb-3">
                    <div class="card-header bg-light">
                        <strong>Pilih Sumber Aset</strong>
                        <div class="stock-section-muted">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="asset-source-card" id="endUserSourceCard" for="includeEndUserAssets">
                                    <div class="d-flex align-items-start gap-2">
                                        <input type="checkbox"
                                               name="include_end_user_assets"
                                               value="1"
                                               id="includeEndUserAssets"
                                               class="form-check-input mt-1"
                                               {{ $includeEndUserDefault ? 'checked' : '' }}>
                                        <div>
                                            <div class="asset-source-title">End User Asset</div>
                                            <div class="asset-source-desc">
                                                Aset yang melekat ke user berdasarkan tim dan personel yang dipilih.
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="asset-source-card" id="officeSourceCard" for="includeOfficeAssets">
                                    <div class="d-flex align-items-start gap-2">
                                        <input type="checkbox"
                                               name="include_office_assets"
                                               value="1"
                                               id="includeOfficeAssets"
                                               class="form-check-input mt-1"
                                               {{ $includeOfficeDefault ? 'checked' : '' }}>
                                        <div>
                                            <div class="asset-source-title">Office Asset</div>
                                            <div class="asset-source-desc">
                                                Aset kantor dari menu Daftar Aset → Office Asset, dikelompokkan berdasarkan lokasi.
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        @error('asset_source')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border shadow-sm mb-3" id="endUserAssetSection">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong>Tambah Tim ke Stock Opname Ini</strong>
                            <div class="text-muted small">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pilih Tim</label>
                                <select id="teamSelector" class="form-select">
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach(($teams ?? []) as $team)
                                        <option value="{{ $team }}">{{ $team }}</option>
                                    @endforeach
                                </select>

                                <small class="text-muted d-block mt-2">
                                </small>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">Personel Tim</label>
                                <div class="preview-panel" id="teamPreviewPanel">
                                    <div class="preview-empty">Pilih tim terlebih dahulu untuk menampilkan personel.</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <button type="button"
                                    class="btn btn-outline-success"
                                    id="addAllTeamsButton">
                                Tambahkan Seluruh Tim dan Personelnya
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        id="selectAllPreviewPersonnelButton">
                                    Pilih Semua Personel
                                </button>

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        id="clearPreviewPersonnelButton">
                                    Reset Pilihan
                                </button>

                                <button type="button"
                                        class="btn btn-primary"
                                        id="addTeamButton">
                                    Tambahkan Tim ke Stock Opname
                                </button>
                            </div>
                        </div>

                        <div id="selectedTeamsEmpty" class="text-muted text-center py-4 border rounded">
                            Belum ada tim yang ditambahkan.
                        </div>

                        <div id="selectedTeamsWrapper"></div>

                        @error('team_user_ids')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        @error('team_user_ids.*')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        @error('team_user_ids.*.*')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border shadow-sm mb-3" id="officeAssetSection">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong>Tambah Asset Office ke Stock Opname Ini</strong>
                            <div class="text-muted small">
                                Pilih lokasi aset, lalu pilih Office Asset yang ingin dimasukkan ke sesi stock opname.
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pilih Lokasi Aset</label>
                                <select id="officeLocationSelector" class="form-select">
                                    <option value="">-- Pilih Lokasi Aset --</option>
                                    @foreach($officeLocationOptions as $locationOption)
                                        <option value="{{ $locationOption['key'] }}">
                                            {{ $locationOption['name'] }} ({{ $locationOption['count'] }} asset)
                                        </option>
                                    @endforeach
                                </select>

                                <small class="text-muted d-block mt-2">
                                    Asset office yang sudah dimasukkan ke lokasi terpilih tidak perlu dipilih ulang.
                                </small>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">Daftar Office Asset</label>
                                <div class="preview-panel" id="officeAssetPreviewPanel">
                                    <div class="preview-empty">Pilih lokasi terlebih dahulu untuk menampilkan Office Asset.</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <button type="button"
                                    class="btn btn-outline-success"
                                    id="addAllOfficeAssetsButton">
                                Tambahkan Seluruh Office Asset
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        id="selectAllPreviewOfficeAssetsButton">
                                    Pilih Semua Asset
                                </button>

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        id="clearPreviewOfficeAssetsButton">
                                    Reset Pilihan
                                </button>

                                <button type="button"
                                        class="btn btn-primary"
                                        id="addOfficeLocationButton">
                                    Tambahkan Asset Office ke Stock Opname
                                </button>
                            </div>
                        </div>

                        <div id="selectedOfficeLocationsEmpty" class="text-muted text-center py-4 border rounded">
                            Belum ada Office Asset yang ditambahkan.
                        </div>

                        <div id="selectedOfficeLocationsWrapper"></div>

                        @error('office_aset_ids')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        @error('office_aset_ids.*')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes"
                              class="form-control @error('notes') is-invalid @enderror"
                              rows="4"
                              placeholder="Catatan tambahan untuk sesi stock opname ini">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('stock-opnames.index') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Buat Stock Opname
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usersByTeam = @json($usersByTeam ?? []);
        const fusionSubTeams = @json($fusionSubTeams ?? []);
        const oldTeamUserIds = @json(old('team_user_ids', []));
        const oldTeam = @json(old('team'));
        const oldTargetUserIds = @json(old('target_user_ids', []));

        const officeLocationOptions = @json($officeLocationOptions);
        const officeAssetsByLocation = @json($officeAssetsByLocation);
        const oldOfficeAssetIds = @json($oldOfficeAssetIds);

        const form = document.getElementById('stockOpnameCreateForm');

        const includeEndUserAssets = document.getElementById('includeEndUserAssets');
        const includeOfficeAssets = document.getElementById('includeOfficeAssets');
        const endUserSourceCard = document.getElementById('endUserSourceCard');
        const officeSourceCard = document.getElementById('officeSourceCard');

        const endUserAssetSection = document.getElementById('endUserAssetSection');
        const officeAssetSection = document.getElementById('officeAssetSection');

        const teamSelector = document.getElementById('teamSelector');
        const teamPreviewPanel = document.getElementById('teamPreviewPanel');
        const addTeamButton = document.getElementById('addTeamButton');
        const addAllTeamsButton = document.getElementById('addAllTeamsButton');
        const selectAllPreviewPersonnelButton = document.getElementById('selectAllPreviewPersonnelButton');
        const clearPreviewPersonnelButton = document.getElementById('clearPreviewPersonnelButton');
        const selectedTeamsWrapper = document.getElementById('selectedTeamsWrapper');
        const selectedTeamsEmpty = document.getElementById('selectedTeamsEmpty');

        const officeLocationSelector = document.getElementById('officeLocationSelector');
        const officeAssetPreviewPanel = document.getElementById('officeAssetPreviewPanel');
        const selectAllPreviewOfficeAssetsButton = document.getElementById('selectAllPreviewOfficeAssetsButton');
        const clearPreviewOfficeAssetsButton = document.getElementById('clearPreviewOfficeAssetsButton');
        const addOfficeLocationButton = document.getElementById('addOfficeLocationButton');
        const addAllOfficeAssetsButton = document.getElementById('addAllOfficeAssetsButton');
        const selectedOfficeLocationsWrapper = document.getElementById('selectedOfficeLocationsWrapper');
        const selectedOfficeLocationsEmpty = document.getElementById('selectedOfficeLocationsEmpty');

        let selectedTeams = new Set();
        let selectedOfficeLocations = new Set();

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function cssEscape(value) {
            if (window.CSS && typeof window.CSS.escape === 'function') {
                return window.CSS.escape(value);
            }

            return String(value).replace(/"/g, '\\"');
        }

        function isFusionTeam(team) {
            return String(team || '').trim().toUpperCase() === 'FUSION';
        }

        function getFusionUsers() {
            const unique = new Map();

            (fusionSubTeams || []).forEach(function (subTeam) {
                const members = Array.isArray(subTeam.members) ? subTeam.members : [];

                members.forEach(function (user) {
                    if (user && user.id) {
                        unique.set(String(user.id), {
                            ...user,
                            fusion_sub_team_code: subTeam.code || '',
                            fusion_sub_team_name: subTeam.name || ('FUSION ' + (subTeam.code || '')),
                        });
                    }
                });
            });

            return Array.from(unique.values());
        }

        function normalizeUsers(team) {
            if (isFusionTeam(team)) {
                return getFusionUsers();
            }

            const users = usersByTeam[team] || [];
            return Array.isArray(users) ? users : Object.values(users);
        }

        function oldSelectedUserIdsForTeam(team) {
            if (oldTeamUserIds && oldTeamUserIds[team]) {
                return Object.values(oldTeamUserIds[team]).map(String);
            }

            if (oldTeam && oldTeam === team && oldTargetUserIds) {
                return Object.values(oldTargetUserIds).map(String);
            }

            return [];
        }

        function syncSelectedTeamsEmptyState() {
            selectedTeamsEmpty.style.display = selectedTeams.size > 0 ? 'none' : 'block';
        }

        function syncSelectedOfficeLocationsEmptyState() {
            selectedOfficeLocationsEmpty.style.display = selectedOfficeLocations.size > 0 ? 'none' : 'block';
        }

        function updateSourceCards() {
            endUserSourceCard.classList.toggle('active', includeEndUserAssets.checked);
            officeSourceCard.classList.toggle('active', includeOfficeAssets.checked);
        }

        function updateSourceSections() {
            endUserAssetSection.style.display = includeEndUserAssets.checked ? '' : 'none';
            officeAssetSection.style.display = includeOfficeAssets.checked ? '' : 'none';
            updateSourceCards();
        }

        function syncFusionSubTeamCheckboxes() {
            teamPreviewPanel.querySelectorAll('.fusion-sub-team-checkbox').forEach(function (subTeamCheckbox) {
                const code = subTeamCheckbox.dataset.fusionSubTeamCode;
                const memberCheckboxes = teamPreviewPanel.querySelectorAll(
                    `.preview-personnel-checkbox[data-fusion-sub-team-code="${cssEscape(code)}"]`
                );

                const checkedCount = Array.from(memberCheckboxes).filter(function (checkbox) {
                    return checkbox.checked;
                }).length;

                subTeamCheckbox.checked = memberCheckboxes.length > 0 && checkedCount === memberCheckboxes.length;
                subTeamCheckbox.indeterminate = checkedCount > 0 && checkedCount < memberCheckboxes.length;
            });
        }

        function buildFusionPersonnelPreview(team) {
            if (!fusionSubTeams || !fusionSubTeams.length) {
                teamPreviewPanel.innerHTML = '<div class="preview-empty">Belum ada mapping sub-tim Fusion.</div>';
                return;
            }

            const alreadySelectedIds = oldSelectedUserIdsForTeam(team);

            teamPreviewPanel.innerHTML = `
                <div class="mb-2 text-muted small">
                    Pilih sub-tim Fusion, atau klik sub-tim untuk expand personelnya.
                </div>

                ${fusionSubTeams.map(function (subTeam) {
                    const members = Array.isArray(subTeam.members) ? subTeam.members : [];
                    const code = String(subTeam.code || '');
                    const name = subTeam.name || ('FUSION ' + code);

                    return `
                        <details class="fusion-sub-team-row">
                            <summary class="fusion-sub-team-summary">
                                <div class="d-flex align-items-start gap-2">
                                    <input type="checkbox"
                                           class="form-check-input mt-1 fusion-sub-team-checkbox"
                                           data-fusion-sub-team-code="${escapeHtml(code)}"
                                           onclick="event.stopPropagation();">
                                    <div>
                                        <div class="fusion-sub-team-title">${escapeHtml(name)}</div>
                                        <div class="fusion-sub-team-meta">${members.length} personel</div>
                                    </div>
                                </div>

                                <span class="badge bg-secondary">${members.length} personel</span>
                            </summary>

                            <div class="fusion-sub-team-body">
                                <div class="row">
                                    ${members.map(function (user) {
                                        const checked = alreadySelectedIds.includes(String(user.id)) ? 'checked' : '';

                                        return `
                                            <div class="col-md-6 mb-2">
                                                <label class="asset-mini-card d-flex align-items-start gap-2">
                                                    <input type="checkbox"
                                                           class="form-check-input mt-1 preview-personnel-checkbox"
                                                           value="${escapeHtml(user.id)}"
                                                           data-fusion-sub-team-code="${escapeHtml(code)}"
                                                           ${checked}>
                                                    <div>
                                                        <div class="asset-mini-title">${escapeHtml(user.name || '-')}</div>
                                                        <div class="asset-mini-meta">Role: ${escapeHtml(user.role || '-')}</div>
                                                        <div class="asset-mini-meta">Email: ${escapeHtml(user.email || '-')}</div>
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
            `;

            syncFusionSubTeamCheckboxes();
        }

        function buildPersonnelPreview(team) {
            if (!team) {
                teamPreviewPanel.innerHTML = '<div class="preview-empty">Pilih tim terlebih dahulu untuk menampilkan personel.</div>';
                return;
            }

            if (isFusionTeam(team)) {
                buildFusionPersonnelPreview(team);
                return;
            }

            const users = normalizeUsers(team);

            if (!users.length) {
                teamPreviewPanel.innerHTML = '<div class="preview-empty">Tidak ada personel aktif pada tim ini.</div>';
                return;
            }

            const alreadySelectedIds = oldSelectedUserIdsForTeam(team);

            teamPreviewPanel.innerHTML = `
                <div class="row">
                    ${users.map(function (user) {
                        const checked = alreadySelectedIds.includes(String(user.id)) ? 'checked' : '';
                        return `
                            <div class="col-md-6 mb-2">
                                <label class="asset-mini-card d-flex align-items-start gap-2">
                                    <input type="checkbox"
                                           class="form-check-input mt-1 preview-personnel-checkbox"
                                           value="${escapeHtml(user.id)}"
                                           ${checked}>
                                    <div>
                                        <div class="asset-mini-title">${escapeHtml(user.name || '-')}</div>
                                        <div class="asset-mini-meta">Role: ${escapeHtml(user.role || '-')}</div>
                                        <div class="asset-mini-meta">Email: ${escapeHtml(user.email || '-')}</div>
                                    </div>
                                </label>
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
        }

        function getPreviewPersonnelCheckboxes() {
            return teamPreviewPanel.querySelectorAll('.preview-personnel-checkbox');
        }

        function groupFusionSelectedUsers(selectedIds) {
            const selectedMap = new Set(selectedIds.map(String));

            return (fusionSubTeams || []).map(function (subTeam) {
                const members = (Array.isArray(subTeam.members) ? subTeam.members : []).filter(function (user) {
                    return selectedMap.has(String(user.id));
                });

                return {
                    code: subTeam.code || '',
                    name: subTeam.name || ('FUSION ' + (subTeam.code || '')),
                    members: members,
                };
            }).filter(function (subTeam) {
                return subTeam.members.length > 0;
            });
        }

        function renderTeamCard(team, selectedIds = []) {
            if (!team) {
                return;
            }

            const isFusion = isFusionTeam(team);
            const teamKey = isFusion ? 'FUSION' : team;

            if (selectedTeams.has(teamKey)) {
                return;
            }

            const users = normalizeUsers(team).filter(function (user) {
                return selectedIds.includes(String(user.id));
            });

            if (!users.length) {
                return;
            }

            selectedTeams.add(teamKey);

            const card = document.createElement('div');
            card.className = 'card border mb-3 selected-team-card';
            card.dataset.team = teamKey;

            if (isFusion) {
                const groupedSubTeams = groupFusionSelectedUsers(selectedIds);

                card.innerHTML = `
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong>Tim FUSION</strong>
                            <div class="text-muted small">${users.length} personel dipilih</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary select-all-team"
                                    data-team="FUSION">
                                Pilih Semua
                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary clear-team"
                                    data-team="FUSION">
                                Reset
                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-outline-danger remove-team"
                                    data-team="FUSION">
                                Hapus Tim
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-2 text-muted small">
                            Tim FUSION dikelompokkan berdasarkan sub-tim. Klik sub-tim untuk expand personelnya.
                        </div>

                        ${groupedSubTeams.map(function (subTeam) {
                            return `
                                <details class="fusion-sub-team-row">
                                    <summary class="fusion-sub-team-summary">
                                        <div>
                                            <div class="fusion-sub-team-title">${escapeHtml(subTeam.name)}</div>
                                            <div class="fusion-sub-team-meta">${subTeam.members.length} personel dipilih</div>
                                        </div>
                                        <span class="badge bg-secondary">${subTeam.members.length} personel</span>
                                    </summary>

                                    <div class="fusion-sub-team-body">
                                        <div class="row">
                                            ${subTeam.members.map(function (user) {
                                                return `
                                                    <div class="col-md-6 mb-2">
                                                        <label class="asset-mini-card d-flex align-items-start gap-2">
                                                            <input type="checkbox"
                                                                   name="team_user_ids[FUSION][]"
                                                                   value="${escapeHtml(user.id)}"
                                                                   class="form-check-input mt-1 personnel-checkbox"
                                                                   data-team="FUSION"
                                                                   data-fusion-sub-team-code="${escapeHtml(subTeam.code || '')}"
                                                                   checked>
                                                            <div>
                                                                <div class="asset-mini-title">${escapeHtml(user.name || '-')}</div>
                                                                <div class="asset-mini-meta">Role: ${escapeHtml(user.role || '-')}</div>
                                                                <div class="asset-mini-meta">Email: ${escapeHtml(user.email || '-')}</div>
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

                selectedTeamsWrapper.appendChild(card);
                syncSelectedTeamsEmptyState();
                return;
            }

            card.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <strong>Tim ${escapeHtml(team)}</strong>
                        <div class="text-muted small">${users.length} personel dipilih</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-sm btn-outline-primary select-all-team"
                                data-team="${escapeHtml(team)}">
                            Pilih Semua
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary clear-team"
                                data-team="${escapeHtml(team)}">
                            Reset
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-danger remove-team"
                                data-team="${escapeHtml(team)}">
                            Hapus Tim
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        ${users.map(function (user) {
                            return `
                                <div class="col-md-6 mb-2">
                                    <label class="asset-mini-card d-flex align-items-start gap-2">
                                        <input type="checkbox"
                                               name="team_user_ids[${escapeHtml(team)}][]"
                                               value="${escapeHtml(user.id)}"
                                               class="form-check-input mt-1 personnel-checkbox"
                                               data-team="${escapeHtml(team)}"
                                               checked>
                                        <div>
                                            <div class="asset-mini-title">${escapeHtml(user.name || '-')}</div>
                                            <div class="asset-mini-meta">Role: ${escapeHtml(user.role || '-')}</div>
                                            <div class="asset-mini-meta">Email: ${escapeHtml(user.email || '-')}</div>
                                        </div>
                                    </label>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `;

            selectedTeamsWrapper.appendChild(card);
            syncSelectedTeamsEmptyState();
        }

        function removeTeam(team) {
            const card = selectedTeamsWrapper.querySelector(`.selected-team-card[data-team="${cssEscape(team)}"]`);

            if (card) {
                card.remove();
            }

            selectedTeams.delete(team);
            syncSelectedTeamsEmptyState();
        }

        function getTeamCheckboxes(team) {
            return selectedTeamsWrapper.querySelectorAll(`.personnel-checkbox[data-team="${cssEscape(team)}"]`);
        }

        function getLocationLabel(locationKey) {
            const item = officeLocationOptions.find(function (loc) {
                return String(loc.key) === String(locationKey);
            });

            return item ? item.name : 'Tanpa Lokasi';
        }

        function buildOfficeAssetPreview(locationKey) {
            const assets = officeAssetsByLocation[locationKey] || [];

            if (!locationKey) {
                officeAssetPreviewPanel.innerHTML = '<div class="preview-empty">Pilih lokasi terlebih dahulu untuk menampilkan Office Asset.</div>';
                return;
            }

            if (!assets.length) {
                officeAssetPreviewPanel.innerHTML = '<div class="preview-empty">Tidak ada Office Asset pada lokasi ini.</div>';
                return;
            }

            officeAssetPreviewPanel.innerHTML = `
                <div class="row">
                    ${assets.map(function (asset) {
                        return `
                            <div class="col-md-6 mb-2">
                                <label class="asset-mini-card d-flex align-items-start gap-2">
                                    <input type="checkbox"
                                           class="form-check-input mt-1 preview-office-asset-checkbox"
                                           value="${escapeHtml(asset.id)}">
                                    <div class="flex-grow-1">
                                        <div class="asset-mini-title">${escapeHtml(asset.asset_name || '-')}</div>
                                        <div class="asset-mini-meta">No Aset: ${escapeHtml(asset.asset_number || '-')}</div>
                                        <div class="asset-mini-meta">Jenis: ${escapeHtml(asset.asset_type || '-')}</div>
                                        <div class="asset-mini-meta">Merk: ${escapeHtml(asset.brand || '-')}</div>
                                        <div class="asset-mini-meta">Lokasi: ${escapeHtml(asset.location_name || '-')}</div>
                                        <div class="asset-mini-meta">Status: ${escapeHtml(asset.status || '-')}</div>
                                    </div>
                                </label>
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
        }

        function getPreviewOfficeAssetCheckboxes() {
            return officeAssetPreviewPanel.querySelectorAll('.preview-office-asset-checkbox');
        }

        function renderOfficeLocationCard(locationKey, selectedIds = []) {
            if (!locationKey || selectedOfficeLocations.has(locationKey)) {
                return;
            }

            const assets = (officeAssetsByLocation[locationKey] || []).filter(function (asset) {
                return selectedIds.includes(String(asset.id));
            });

            if (!assets.length) {
                return;
            }

            selectedOfficeLocations.add(locationKey);

            const locationName = getLocationLabel(locationKey);
            const card = document.createElement('div');
            card.className = 'card border mb-3 selected-office-location-card';
            card.dataset.location = locationKey;

            card.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <strong>Lokasi ${escapeHtml(locationName)}</strong>
                        <div class="text-muted small">${assets.length} asset dipilih</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-sm btn-outline-primary select-all-office-location"
                                data-location="${escapeHtml(locationKey)}">
                            Pilih Semua
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary clear-office-location"
                                data-location="${escapeHtml(locationKey)}">
                            Reset
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-danger remove-office-location"
                                data-location="${escapeHtml(locationKey)}">
                            Hapus Lokasi
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        ${assets.map(function (asset) {
                            return `
                                <div class="col-md-6 mb-2">
                                    <label class="asset-mini-card d-flex align-items-start gap-2">
                                        <input type="checkbox"
                                               name="office_aset_ids[]"
                                               value="${escapeHtml(asset.id)}"
                                               class="form-check-input mt-1 office-asset-checkbox"
                                               data-location="${escapeHtml(locationKey)}"
                                               checked>
                                        <div class="flex-grow-1">
                                            <div class="asset-mini-title">${escapeHtml(asset.asset_name || '-')}</div>
                                            <div class="asset-mini-meta">No Aset: ${escapeHtml(asset.asset_number || '-')}</div>
                                            <div class="asset-mini-meta">Jenis: ${escapeHtml(asset.asset_type || '-')}</div>
                                            <div class="asset-mini-meta">Merk: ${escapeHtml(asset.brand || '-')}</div>
                                            <div class="asset-mini-meta">Lokasi: ${escapeHtml(asset.location_name || '-')}</div>
                                            <div class="asset-mini-meta">Status: ${escapeHtml(asset.status || '-')}</div>
                                        </div>
                                    </label>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `;

            selectedOfficeLocationsWrapper.appendChild(card);
            syncSelectedOfficeLocationsEmptyState();
        }

        function removeOfficeLocation(locationKey) {
            const card = selectedOfficeLocationsWrapper.querySelector(`.selected-office-location-card[data-location="${cssEscape(locationKey)}"]`);

            if (card) {
                card.remove();
            }

            selectedOfficeLocations.delete(locationKey);
            syncSelectedOfficeLocationsEmptyState();
        }

        function getOfficeLocationCheckboxes(locationKey) {
            return selectedOfficeLocationsWrapper.querySelectorAll(`.office-asset-checkbox[data-location="${cssEscape(locationKey)}"]`);
        }

        includeEndUserAssets.addEventListener('change', updateSourceSections);
        includeOfficeAssets.addEventListener('change', updateSourceSections);

        teamPreviewPanel.addEventListener('change', function (event) {
            const subTeamCheckbox = event.target.closest('.fusion-sub-team-checkbox');
            const personnelCheckbox = event.target.closest('.preview-personnel-checkbox');

            if (subTeamCheckbox) {
                const code = subTeamCheckbox.dataset.fusionSubTeamCode;

                teamPreviewPanel.querySelectorAll(
                    `.preview-personnel-checkbox[data-fusion-sub-team-code="${cssEscape(code)}"]`
                ).forEach(function (checkbox) {
                    checkbox.checked = subTeamCheckbox.checked;
                });

                syncFusionSubTeamCheckboxes();
                return;
            }

            if (personnelCheckbox && isFusionTeam(teamSelector.value)) {
                syncFusionSubTeamCheckboxes();
            }
        });

        teamSelector.addEventListener('change', function () {
            buildPersonnelPreview(teamSelector.value);
        });

        addAllTeamsButton.addEventListener('click', function () {
            Object.keys(usersByTeam || {}).forEach(function (team) {
                const users = normalizeUsers(team);
                const allIds = users.map(function (user) {
                    return String(user.id);
                });

                if (allIds.length) {
                    renderTeamCard(team, allIds);
                }
            });
        });

        selectAllPreviewPersonnelButton.addEventListener('click', function () {
            getPreviewPersonnelCheckboxes().forEach(function (checkbox) {
                checkbox.checked = true;
            });

            if (isFusionTeam(teamSelector.value)) {
                syncFusionSubTeamCheckboxes();
            }
        });

        clearPreviewPersonnelButton.addEventListener('click', function () {
            getPreviewPersonnelCheckboxes().forEach(function (checkbox) {
                checkbox.checked = false;
            });

            if (isFusionTeam(teamSelector.value)) {
                syncFusionSubTeamCheckboxes();
            }
        });

        addTeamButton.addEventListener('click', function () {
            const team = teamSelector.value;

            if (!team) {
                alert('Silakan pilih tim terlebih dahulu.');
                return;
            }

            if (selectedTeams.has(team)) {
                alert('Tim ini sudah ditambahkan ke sesi stock opname.');
                return;
            }

            const selectedIds = Array.from(getPreviewPersonnelCheckboxes())
                .filter(function (checkbox) {
                    return checkbox.checked;
                })
                .map(function (checkbox) {
                    return String(checkbox.value);
                });

            if (!selectedIds.length) {
                alert('Pilih minimal satu personel dari tim yang dipilih.');
                return;
            }

            renderTeamCard(team, selectedIds);
        });

        selectedTeamsWrapper.addEventListener('click', function (event) {
            const selectAllButton = event.target.closest('.select-all-team');
            const clearButton = event.target.closest('.clear-team');
            const removeButton = event.target.closest('.remove-team');

            if (selectAllButton) {
                const team = selectAllButton.dataset.team;
                getTeamCheckboxes(team).forEach(function (checkbox) {
                    checkbox.checked = true;
                });
                return;
            }

            if (clearButton) {
                const team = clearButton.dataset.team;
                getTeamCheckboxes(team).forEach(function (checkbox) {
                    checkbox.checked = false;
                });
                return;
            }

            if (removeButton) {
                const team = removeButton.dataset.team;

                if (confirm('Hapus tim ' + team + ' dari sesi stock opname ini?')) {
                    removeTeam(team);
                }
            }
        });

        officeLocationSelector.addEventListener('change', function () {
            buildOfficeAssetPreview(officeLocationSelector.value);
        });

        selectAllPreviewOfficeAssetsButton.addEventListener('click', function () {
            getPreviewOfficeAssetCheckboxes().forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        clearPreviewOfficeAssetsButton.addEventListener('click', function () {
            getPreviewOfficeAssetCheckboxes().forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });

        addOfficeLocationButton.addEventListener('click', function () {
            const locationKey = officeLocationSelector.value;

            if (!locationKey) {
                alert('Silakan pilih lokasi aset terlebih dahulu.');
                return;
            }

            if (selectedOfficeLocations.has(locationKey)) {
                alert('Lokasi ini sudah ditambahkan ke sesi stock opname.');
                return;
            }

            const selectedIds = Array.from(getPreviewOfficeAssetCheckboxes())
                .filter(function (checkbox) {
                    return checkbox.checked;
                })
                .map(function (checkbox) {
                    return String(checkbox.value);
                });

            if (!selectedIds.length) {
                alert('Pilih minimal satu Office Asset dari lokasi yang dipilih.');
                return;
            }

            renderOfficeLocationCard(locationKey, selectedIds);
        });

        addAllOfficeAssetsButton.addEventListener('click', function () {
            Object.keys(officeAssetsByLocation || {}).forEach(function (locationKey) {
                const assets = officeAssetsByLocation[locationKey] || [];
                const allIds = assets.map(function (asset) {
                    return String(asset.id);
                });

                if (allIds.length) {
                    renderOfficeLocationCard(String(locationKey), allIds);
                }
            });

            officeLocationSelector.value = '';
            buildOfficeAssetPreview('');
        });

        selectedOfficeLocationsWrapper.addEventListener('click', function (event) {
            const selectAllButton = event.target.closest('.select-all-office-location');
            const clearButton = event.target.closest('.clear-office-location');
            const removeButton = event.target.closest('.remove-office-location');

            if (selectAllButton) {
                const locationKey = selectAllButton.dataset.location;
                getOfficeLocationCheckboxes(locationKey).forEach(function (checkbox) {
                    checkbox.checked = true;
                });
                return;
            }

            if (clearButton) {
                const locationKey = clearButton.dataset.location;
                getOfficeLocationCheckboxes(locationKey).forEach(function (checkbox) {
                    checkbox.checked = false;
                });
                return;
            }

            if (removeButton) {
                const locationKey = removeButton.dataset.location;
                const locationName = getLocationLabel(locationKey);

                if (confirm('Hapus lokasi ' + locationName + ' dari sesi stock opname ini?')) {
                    removeOfficeLocation(locationKey);
                }
            }
        });

        form.addEventListener('submit', function (event) {
            const endUserEnabled = includeEndUserAssets.checked;
            const officeEnabled = includeOfficeAssets.checked;

            const checkedPersonnelCount = selectedTeamsWrapper.querySelectorAll('.personnel-checkbox:checked').length;
            const checkedOfficeAssetCount = selectedOfficeLocationsWrapper.querySelectorAll('.office-asset-checkbox:checked').length;

            const hasEndUserAsset = endUserEnabled && checkedPersonnelCount > 0;
            const hasOfficeAsset = officeEnabled && checkedOfficeAssetCount > 0;

            if (!endUserEnabled && !officeEnabled) {
                event.preventDefault();
                alert('Pilih minimal satu sumber aset: End User Asset atau Office Asset.');
                return;
            }

            if (endUserEnabled && checkedPersonnelCount < 1 && !hasOfficeAsset) {
                event.preventDefault();
                alert('Pilih minimal satu personel, atau nonaktifkan End User Asset.');
                return;
            }

            if (officeEnabled && checkedOfficeAssetCount < 1 && !hasEndUserAsset) {
                event.preventDefault();
                alert('Pilih minimal satu Office Asset, atau nonaktifkan Office Asset.');
                return;
            }

            if (!hasEndUserAsset && !hasOfficeAsset) {
                event.preventDefault();
                alert('Pilih minimal satu aset untuk dicek.');
            }
        });

        Object.keys(oldTeamUserIds || {}).forEach(function (team) {
            const ids = Object.values(oldTeamUserIds[team] || {}).map(String);
            if (ids.length) {
                renderTeamCard(team, ids);
            }
        });

        if (selectedTeams.size === 0 && oldTeam && oldTargetUserIds) {
            const ids = Object.values(oldTargetUserIds || {}).map(String);
            if (ids.length) {
                renderTeamCard(oldTeam, ids);
            }
        }

        const oldOfficeByLocation = {};
        oldOfficeAssetIds.forEach(function (assetId) {
            Object.keys(officeAssetsByLocation || {}).forEach(function (locationKey) {
                const found = (officeAssetsByLocation[locationKey] || []).find(function (asset) {
                    return String(asset.id) === String(assetId);
                });

                if (found) {
                    if (!oldOfficeByLocation[locationKey]) {
                        oldOfficeByLocation[locationKey] = [];
                    }
                    oldOfficeByLocation[locationKey].push(String(assetId));
                }
            });
        });

        Object.keys(oldOfficeByLocation).forEach(function (locationKey) {
            renderOfficeLocationCard(locationKey, oldOfficeByLocation[locationKey]);
        });

        syncSelectedTeamsEmptyState();
        syncSelectedOfficeLocationsEmptyState();
        updateSourceSections();
        buildPersonnelPreview('');
        buildOfficeAssetPreview('');
    });
</script>
@endsection