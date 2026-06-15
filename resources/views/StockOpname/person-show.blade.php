@extends('layouts.admin')

@section('title', 'Detail Personel Stock Opname')

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
        .so-checklist-row {
            display: grid;
            grid-template-columns: minmax(240px, 1.2fr) minmax(180px, .9fr) minmax(260px, 1.2fr) auto;
            gap: .5rem;
            align-items: center;
            margin-bottom: .5rem;
        }
        .so-asset-info {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .so-asset-info__title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: .85rem;
        }
        .so-asset-info__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .65rem 1.25rem;
        }
        .so-asset-info__row {
            display: grid;
            grid-template-columns: 155px minmax(0, 1fr);
            gap: .75rem;
            align-items: start;
        }
        .so-asset-info__label {
            font-weight: 700;
            color: #667085;
        }
        .so-asset-info__value {
            color: #475467;
            word-break: break-word;
        }
        @media (max-width: 991.98px) {
            .so-checklist-row {
                grid-template-columns: 1fr;
            }
            .so-asset-info__grid {
                grid-template-columns: 1fr;
            }
            .so-asset-info__row {
                grid-template-columns: 125px minmax(0, 1fr);
            }
        }
    </style>
    @php
        $isCompleted = $stockOpname->status === 'completed';

        $stockOpnameTitle = $stockOpname->title ?? ('Stock Opname #' . $stockOpname->id);

        $totalItems = $items->count();
        $totalSesuai = $items->where('result_status', 'sesuai')->count();
        $totalTidakSesuai = $items->where('result_status', 'tidak_sesuai')->count();
        $totalPerluCekLanjut = $items->where('result_status', 'perlu_cek_lanjut')->count();

        $personName = $user->name_karyawan
            ?? $user->username
            ?? $user->corporate_email
            ?? $user->email
            ?? '-';

        $personRole = $user->role ?? '-';
        $personEmail = $user->corporate_email ?? $user->email ?? '-';

        $hasInternalNoteCreateRoute = \Illuminate\Support\Facades\Route::has('internal-notes.create');
        $hasInternalNoteEditRoute = \Illuminate\Support\Facades\Route::has('internal-notes.edit');
        $hasChecklistTemplateStoreRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.items.checklist-templates.store');
        $hasChecklistTemplateDestroyRoute = \Illuminate\Support\Facades\Route::has('stock-opnames.items.checklist-templates.destroy');

        $internalNotesByItemId = collect();

        if (
            \Illuminate\Support\Facades\Schema::hasTable('internal_notes')
            && \Illuminate\Support\Facades\Schema::hasColumn('internal_notes', 'stock_opname_id')
            && \Illuminate\Support\Facades\Schema::hasColumn('internal_notes', 'stock_opname_item_id')
        ) {
            $internalNotesByItemId = \App\Models\InternalNote::query()
                ->where('stock_opname_id', $stockOpname->id)
                ->whereNotNull('stock_opname_item_id')
                ->latest('id')
                ->get()
                ->keyBy('stock_opname_item_id');
        }

        $focusItemId = request('focus_item_id');

        /*
        |--------------------------------------------------------------------------
        | Back Context untuk FUSION Sub Tim
        |--------------------------------------------------------------------------
        | Jika halaman ini dibuka dari daftar personel FUSION A/B/C/dst, URL membawa
        | fusion_sub_team_id. Context ini disimpan ke session supaya setelah submit
        | opname item/refresh/filter, tombol kembali tetap balik ke daftar personel
        | sub-tim yang benar, bukan ke daftar tim.
        */
        $fusionBackSessionKey = 'stock_opname_fusion_sub_team_back.' . $stockOpname->id . '.' . $user->id;
        $fusionSubTeamIdFromRequest = request('fusion_sub_team_id');

        if (!empty($fusionSubTeamIdFromRequest)) {
            session([$fusionBackSessionKey => $fusionSubTeamIdFromRequest]);
        }

        $fusionSubTeamId = $fusionSubTeamIdFromRequest ?: session($fusionBackSessionKey);

        $personShowRouteParams = [$stockOpname->id, $user->id];

        if (!empty($fusionSubTeamId)) {
            $personShowRouteParams['fusion_sub_team_id'] = $fusionSubTeamId;
        }

        $backTeam = collect($stockOpname->opnameTeams ?? [])
            ->first(function ($team) use ($opnameUser) {
                return trim((string) ($team->team ?? '')) === trim((string) ($opnameUser->team ?? ''));
            });

        $backUrl = !empty($fusionSubTeamId)
            ? route('stock-opnames.fusion-sub-team.show', [$stockOpname->id, $fusionSubTeamId])
            : (
                $backTeam
                    ? route('stock-opnames.team.show', [$stockOpname->id, $backTeam->id])
                    : route('stock-opnames.show', $stockOpname->id)
            );
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">{{ $personName }}</h4>
            <p class="text-muted mb-0">
                Role: {{ $personRole }}
                |
                Email: {{ $personEmail }}
                |
                Stock Opname: {{ $stockOpnameTitle }}
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge bg-primary">{{ $totalItems }} aset</span>
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                Kembali ke Daftar Personel
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info border-0 shadow-sm">
        <strong>Checklist Aset Personel.</strong>
        menampilkan aset milik personel yang dipilih beserta checklist komponennya.
    </div>

    <div class="row mb-3">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Aset</small>
                    <h4 class="mb-0">{{ $totalItems }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Sesuai</small>
                    <h4 class="mb-0">{{ $totalSesuai }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Tidak Sesuai</small>
                    <h4 class="mb-0">{{ $totalTidakSesuai }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Perlu Cek Lanjut</small>
                    <h4 class="mb-0">{{ $totalPerluCekLanjut }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('stock-opnames.person.show', $personShowRouteParams) }}" class="row g-2">
                @if(!empty($fusionSubTeamId))
                    <input type="hidden" name="fusion_sub_team_id" value="{{ $fusionSubTeamId }}">
                @endif

                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari aset, serial number, status...">
                </div>

                <div class="col-md-4">
                    <select name="result_status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum_dicek" {{ request('result_status') == 'belum_dicek' ? 'selected' : '' }}>Belum Dicek</option>
                        <option value="sesuai" {{ request('result_status') == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                        <option value="tidak_sesuai" {{ request('result_status') == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                        <option value="perlu_cek_lanjut" {{ request('result_status') == 'perlu_cek_lanjut' ? 'selected' : '' }}>Perlu Cek Lanjut</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">
                        Filter
                    </button>
                    <a href="{{ route('stock-opnames.person.show', $personShowRouteParams) }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @forelse($items as $item)
        @php
            $itemStatusLabel = match($item->result_status) {
                'sesuai' => 'Sesuai',
                'tidak_sesuai' => 'Tidak Sesuai',
                'perlu_cek_lanjut' => 'Perlu Cek Lanjut',
                default => 'Belum Dicek',
            };

            $itemStatusBadge = match($item->result_status) {
                'sesuai' => 'bg-success',
                'tidak_sesuai' => 'bg-danger',
                'perlu_cek_lanjut' => 'bg-warning text-dark',
                default => 'bg-secondary',
            };

            $physicalConditionLabel = match($item->physical_condition) {
                'baik' => 'Baik',
                'rusak_ringan' => 'Rusak Ringan',
                'rusak_berat' => 'Rusak Berat',
                default => '-',
            };

            $assetName = $item->snapshot_asset_name
                ?? $item->aset?->jenisAset?->name_jenis
                ?? $item->aset?->merk_aset
                ?? '-';

            $assetNumber = $item->snapshot_asset_number ?? $item->aset?->nomor_aset ?? '-';
            $serialNumber = $item->snapshot_serial_number ?? $item->aset?->serial_number ?? '-';
            $serialNumber = $serialNumber ?: '-';
            $manualSerialNumber = $item->manual_serial_number ?? '';
            $assetBrand = $item->snapshot_asset_brand ?? $item->aset?->merk_aset ?? '-';
            $assetGenreLabel = $item->asset_genre_label ?? 'Aset';
            $assetSpecSummary = $item->asset_spec_summary ?? [];

            $needInternalNote = $item->need_follow_up
                || $item->result_status === 'perlu_cek_lanjut'
                || $item->result_status === 'tidak_sesuai'
                || in_array($item->physical_condition, ['rusak_ringan', 'rusak_berat'], true);

            $internalNoteType = ($item->additional_budget ?? 0) > 0
                ? 'kebutuhan_pembelian'
                : 'insiden';

            $internalNoteParams = [
                'stock_opname_id' => $stockOpname->id,
                'stock_opname_user_id' => $opnameUser->id ?? null,
                'stock_opname_item_id' => $item->id,
                'request_type' => $internalNoteType,
                'asset_classification' => 'hardware',
                'priority' => $item->result_status === 'tidak_sesuai' ? 'high' : 'normal',
                'estimated_cost' => $item->additional_budget,
                'title' => 'Tindak Lanjut Temuan Aset - ' . $assetName,
                'description' => 'Temuan dari Stock Opname: aset ' . $assetName . ' dengan nomor ' . $assetNumber . ' membutuhkan tindak lanjut.',
                'incident_note' => 'Status pengecekan: ' . $itemStatusLabel . '. Kondisi fisik: ' . $physicalConditionLabel . '.',
                'follow_up_note' => $item->follow_up_summary ?: 'Tentukan PIC, jadwal, dan langkah tindak lanjut dari temuan aset ini.',
            ];

            $existingInternalNote = $internalNotesByItemId->get($item->id);

            $checklistTemplateStoreUrl = $hasChecklistTemplateStoreRoute
                ? route('stock-opnames.items.checklist-templates.store', [$stockOpname->id, $item->id])
                : '';
        @endphp

        <div class="card border-0 shadow-sm mb-3" id="stock-opname-item-{{ $item->id }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                    <div>
                        <h5 class="mb-1">{{ $loop->iteration }}. {{ $assetName }}</h5>
                        <div class="text-muted small">
                            Nomor: {{ $assetNumber }}
                            |
                            Serial: {{ $serialNumber }}
                            |
                            Brand: {{ $assetBrand }}
                            |
                            Genre: {{ $assetGenreLabel }}
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge {{ $itemStatusBadge }}">
                            {{ $itemStatusLabel }}
                        </span>

                        @if($needInternalNote && $hasInternalNoteCreateRoute)
                            @if($existingInternalNote && $hasInternalNoteEditRoute)
                                <a href="{{ route('internal-notes.edit', $existingInternalNote->id) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    Edit Catatan Tindak Lanjut
                                </a>
                            @else
                                <a href="{{ route('internal-notes.create', $internalNoteParams) }}"
                                   class="btn btn-sm btn-outline-danger">
                                    Buat Catatan Tindak Lanjut
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="so-asset-info">
                    <div class="so-asset-info__title">Informasi Aset</div>

                    <div class="so-asset-info__grid">
                        @forelse($assetSpecSummary as $label => $value)
                            <div class="so-asset-info__row">
                                <div class="so-asset-info__label">{{ $label }}:</div>
                                <div class="so-asset-info__value">{{ $value ?: '-' }}</div>
                            </div>
                        @empty
                            <div class="text-muted">Informasi aset tidak tersedia.</div>
                        @endforelse
                    </div>
                </div>

                <form action="{{ route('stock-opnames.items.update', !empty($fusionSubTeamId) ? [$stockOpname->id, $item->id, 'fusion_sub_team_id' => $fusionSubTeamId] : [$stockOpname->id, $item->id]) }}"
                      method="POST"
                      class="stock-opname-item-form">
                    @csrf
                    @method('PUT')

                    @if(!empty($fusionSubTeamId))
                        <input type="hidden" name="fusion_sub_team_id" value="{{ $fusionSubTeamId }}">
                    @endif

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Status Hasil</label>
                            <select name="result_status" class="form-select" {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="belum_dicek" {{ ($item->result_status ?? '') === 'belum_dicek' ? 'selected' : '' }}>Belum Dicek</option>
                                <option value="sesuai" {{ ($item->result_status ?? '') === 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                                <option value="tidak_sesuai" {{ ($item->result_status ?? '') === 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                                <option value="perlu_cek_lanjut" {{ ($item->result_status ?? '') === 'perlu_cek_lanjut' ? 'selected' : '' }}>Perlu Cek Lanjut</option>
                            </select>
                            <small class="text-muted">Pilih hasil akhir pengecekan item aset ini.</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Kondisi Fisik</label>
                            <select name="physical_condition" class="form-select" {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="">-- Pilih --</option>
                                <option value="baik" {{ ($item->physical_condition ?? '') === 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ ($item->physical_condition ?? '') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ ($item->physical_condition ?? '') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            <small class="text-muted">Kondisi fisik aset saat dicek.</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">User Sesuai</label>
                            <select name="user_match" class="form-select" {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="">-- Pilih --</option>
                                <option value="1" {{ (string) $item->user_match === '1' ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ (string) $item->user_match === '0' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            <small class="text-muted">Apakah aset dipegang user yang benar.</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Butuh Tindak Lanjut</label>
                            <select name="need_follow_up" class="form-select" {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="0" {{ !$item->need_follow_up ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $item->need_follow_up ? 'selected' : '' }}>Ya</option>
                            </select>
                            <small class="text-muted">Pilih Ya jika perlu follow up internal.</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Serial Number Manual</label>
                            <input type="text"
                                   name="manual_serial_number"
                                   class="form-control"
                                   value="{{ $manualSerialNumber }}"
                                   placeholder="{{ $serialNumber !== '-' ? $serialNumber : 'Isi serial number jika belum ada di database' }}"
                                   {{ $isCompleted ? 'readonly' : '' }}>
                            <small class="text-muted">
                                Jika serial number dari database kosong, isi manual di sini. Jika tidak ada, tampil sebagai "-".
                            </small>
                        </div>
                    </div>

                        <div class="col-md-4">
                            <label class="form-label">PIC</label>
                            <select name="checked_by" class="form-select" {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="">-- Pilih PIC --</option>
                                @foreach($picUsers ?? [] as $picUser)
                                    @php
                                        $picDisplayName = $picUser->display_name
                                            ?? $picUser->name_karyawan
                                            ?? $picUser->username
                                            ?? $picUser->corporate_email
                                            ?? $picUser->email
                                            ?? ('User #' . $picUser->id);
                                    @endphp
                                    <option value="{{ $picUser->id }}" {{ (string) old('checked_by', $item->checked_by ?? '') === (string) $picUser->id ? 'selected' : '' }}>
                                        {{ $picDisplayName }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">PIC pengecekan khusus untuk item aset ini.</small>
                        </div>
                    <div class="mb-3">
                        <label class="form-label">Checklist Komponen</label>

                        <div class="checklist-component-wrapper" data-checklist-wrapper>
                            @if(!empty($item->resolved_checklist_data))
                                @foreach($item->resolved_checklist_data as $componentValue)
                                    @php
                                        $componentKey = $componentValue['key'] ?? ('template_' . ($componentValue['template_id'] ?? uniqid()));
                                        $templateId = $componentValue['template_id'] ?? null;

                                        $deleteChecklistUrl = ($templateId && $hasChecklistTemplateDestroyRoute)
                                            ? route('stock-opnames.items.checklist-templates.destroy', [
                                                $stockOpname->id,
                                                $item->id,
                                                $templateId,
                                            ])
                                            : '';
                                    @endphp

                                    <div class="so-checklist-row checklist-component-row" data-checklist-row>
                                        <div>
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $componentValue['label'] ?? $componentKey }}"
                                                   readonly>

                                            <input type="hidden"
                                                   name="checklist_data[{{ $componentKey }}][label]"
                                                   value="{{ $componentValue['label'] ?? $componentKey }}">
                                        </div>

                                        <div>
                                            <select name="checklist_data[{{ $componentKey }}][status]"
                                                    class="form-select"
                                                    {{ $isCompleted ? 'disabled' : '' }}>
                                                <option value="belum_dicek" {{ ($componentValue['status'] ?? '') === 'belum_dicek' ? 'selected' : '' }}>Belum Dicek</option>
                                                <option value="baik" {{ ($componentValue['status'] ?? '') === 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak_ringan" {{ ($componentValue['status'] ?? '') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                <option value="rusak_berat" {{ ($componentValue['status'] ?? '') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                <option value="tidak_ada" {{ ($componentValue['status'] ?? '') === 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            </select>
                                        </div>

                                        <div>
                                            <input type="text"
                                                   name="checklist_data[{{ $componentKey }}][note]"
                                                   class="form-control"
                                                   placeholder="Catatan komponen"
                                                   value="{{ $componentValue['note'] ?? '' }}"
                                                   {{ $isCompleted ? 'readonly' : '' }}>
                                        </div>

                                        @if(!$isCompleted)
                                            <div>
                                                <button type="button"
                                                        class="btn btn-icon btn-sm btn-outline-danger"
                                                        data-delete-checklist
                                                        data-url="{{ $deleteChecklistUrl }}"
                                                        title="Hapus Pengecekan"
                                                        {{ $deleteChecklistUrl === '' ? 'disabled' : '' }}>
                                                    <i class="sym sym-trash-solid"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if(!$isCompleted)
                            <div class="d-flex align-items-center gap-2 flex-wrap mt-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-add-checklist
                                        data-url="{{ $checklistTemplateStoreUrl }}"
                                        {{ !$hasChecklistTemplateStoreRoute ? 'disabled' : '' }}>
                                    + Tambah Pengecekan
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="follow-up-fields">
                        <div class="alert alert-warning border-0 shadow-sm py-2">
                            <strong>Detail tindak lanjut.</strong>
                            Bagian ini hanya perlu diisi jika aset bermasalah atau membutuhkan follow up.
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ringkasan Masalah</label>
                                <input type="text"
                                       name="issue_type"
                                       value="{{ $item->issue_type }}"
                                       class="form-control"
                                       placeholder="Contoh: layar rusak, aset tidak sesuai data, kabel hilang"
                                       {{ $isCompleted ? 'readonly' : '' }}>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jadwal Cek Lanjut</label>
                                <input type="datetime-local"
                                       name="scheduled_at"
                                       value="{{ $item->scheduled_at ? \Carbon\Carbon::parse($item->scheduled_at)->format('Y-m-d\TH:i') : '' }}"
                                       class="form-control"
                                       {{ $isCompleted ? 'readonly' : '' }}>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Estimasi Awal Biaya Temuan</label>
                                <input type="number"
                                       name="additional_budget"
                                       value="{{ $item->additional_budget }}"
                                       class="form-control"
                                       min="0"
                                       step="1000"
                                       placeholder="Estimasi awal biaya dari temuan pengecekan"
                                       {{ $isCompleted ? 'readonly' : '' }}>
                                <small class="text-muted">
                                    Estimasi awal dari hasil pengecekan, bukan harga final pembelian.
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rencana Tindak Lanjut</label>
                            <textarea name="follow_up_summary"
                                      class="form-control"
                                      rows="2"
                                      placeholder="Isi jika aset perlu tindak lanjut"
                                      {{ $isCompleted ? 'readonly' : '' }}>{{ $item->follow_up_summary }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Pemeriksaan</label>
                        <textarea name="notes"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Catatan hasil pengecekan item aset ini (Opsional)"
                                  {{ $isCompleted ? 'readonly' : '' }}>{{ $item->notes }}</textarea>
                    </div>

                    @if(!$isCompleted)
                        <div class="mt-3 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary">
                                Simpan Hasil Item
                            </button>

                            @if($needInternalNote && $hasInternalNoteCreateRoute)
                                @if($existingInternalNote && $hasInternalNoteEditRoute)
                                    <a href="{{ route('internal-notes.edit', $existingInternalNote->id) }}"
                                       class="btn btn-outline-warning">
                                        Edit Catatan Tindak Lanjut
                                    </a>
                                @else
                                    <a href="{{ route('internal-notes.create', $internalNoteParams) }}"
                                       class="btn btn-outline-danger">
                                        Buat Catatan Tindak Lanjut
                                    </a>
                                @endif
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Tidak ada aset yang terhubung ke personel ini.
        </div>
    @endforelse
</div>

<div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="addChecklistModalLabel">
                    Tambah Pengecekan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="addChecklistError"></div>

                <label class="form-label">Judul Pengecekan</label>
                <input type="text"
                       id="customChecklistLabel"
                       class="form-control"
                       maxlength="150"

                <small class="text-muted">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button" class="btn btn-primary" id="saveCustomChecklistBtn">
                    Oke
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteChecklistModal" tabindex="-1" aria-labelledby="deleteChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteChecklistModalLabel">
                    Konfirmasi Hapus Pengecekan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">
                    Yakin ingin menghapus?
                </p>

                <div class="border rounded p-3 bg-light">
                    <strong id="deleteChecklistName">-</strong>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button" class="btn btn-danger" id="confirmDeleteChecklistBtn">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let activeChecklistButton = null;
    let activeChecklistForm = null;
    let activeChecklistWrapper = null;

    let pendingDeleteChecklist = {
        button: null,
        row: null,
        form: null,
        url: '',
    };

    const addChecklistModalElement = document.getElementById('addChecklistModal');
    const addChecklistModal = addChecklistModalElement ? new bootstrap.Modal(addChecklistModalElement) : null;
    const customChecklistLabel = document.getElementById('customChecklistLabel');
    const addChecklistError = document.getElementById('addChecklistError');
    const saveCustomChecklistBtn = document.getElementById('saveCustomChecklistBtn');

    const deleteChecklistModalElement = document.getElementById('deleteChecklistModal');
    const deleteChecklistModal = deleteChecklistModalElement ? new bootstrap.Modal(deleteChecklistModalElement) : null;
    const deleteChecklistName = document.getElementById('deleteChecklistName');
    const confirmDeleteChecklistBtn = document.getElementById('confirmDeleteChecklistBtn');

    function isFollowUpNeeded(form) {
        const resultStatus = form.querySelector('select[name="result_status"]')?.value || '';
        const physicalCondition = form.querySelector('select[name="physical_condition"]')?.value || '';
        const needFollowUp = form.querySelector('select[name="need_follow_up"]')?.value || '0';

        return (
            resultStatus === 'tidak_sesuai' ||
            resultStatus === 'perlu_cek_lanjut' ||
            physicalCondition === 'rusak_ringan' ||
            physicalCondition === 'rusak_berat' ||
            needFollowUp === '1'
        );
    }

    function toggleFollowUpFields(form, shouldClear = false) {
        const followUpWrapper = form.querySelector('.follow-up-fields');

        if (!followUpWrapper) {
            return;
        }

        const show = isFollowUpNeeded(form);
        followUpWrapper.style.display = show ? '' : 'none';

        if (!show && shouldClear) {
            const fields = followUpWrapper.querySelectorAll('input, textarea, select');

            fields.forEach(function (field) {
                if (field.tagName === 'SELECT') {
                    field.selectedIndex = 0;
                } else {
                    field.value = '';
                }
            });
        }
    }

    function escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function getCsrfToken(form) {
        const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const inputToken = form.querySelector('input[name="_token"]')?.value;

        return metaToken || inputToken || '';
    }

    function showChecklistError(message) {
        if (!addChecklistError) {
            alert(message);
            return;
        }

        addChecklistError.textContent = message;
        addChecklistError.classList.remove('d-none');
    }

    function clearChecklistError() {
        if (!addChecklistError) {
            return;
        }

        addChecklistError.textContent = '';
        addChecklistError.classList.add('d-none');
    }

    function setSaveButtonLoading(isLoading) {
        if (!saveCustomChecklistBtn) {
            return;
        }

        if (isLoading) {
            saveCustomChecklistBtn.disabled = true;
            saveCustomChecklistBtn.dataset.originalText = saveCustomChecklistBtn.innerHTML;
            saveCustomChecklistBtn.innerHTML = 'Menyimpan...';
        } else {
            saveCustomChecklistBtn.disabled = false;
            saveCustomChecklistBtn.innerHTML = saveCustomChecklistBtn.dataset.originalText || 'Oke';
        }
    }

    function createChecklistRow(key, label, status = 'belum_dicek', note = '', deleteUrl = '') {
        const row = document.createElement('div');
        row.className = 'so-checklist-row checklist-component-row';
        row.setAttribute('data-checklist-row', 'true');

        const safeKey = escapeHtml(key);
        const safeLabel = escapeHtml(label);
        const safeNote = escapeHtml(note || '');
        const safeDeleteUrl = escapeHtml(deleteUrl || '');

        row.innerHTML = `
            <div>
                <input type="text"
                       class="form-control"
                       value="${safeLabel}"
                       readonly>

                <input type="hidden"
                       name="checklist_data[${safeKey}][label]"
                       value="${safeLabel}">
            </div>

            <div>
                <select name="checklist_data[${safeKey}][status]" class="form-select">
                    <option value="belum_dicek" ${status === 'belum_dicek' ? 'selected' : ''}>Belum Dicek</option>
                    <option value="baik" ${status === 'baik' ? 'selected' : ''}>Baik</option>
                    <option value="rusak_ringan" ${status === 'rusak_ringan' ? 'selected' : ''}>Rusak Ringan</option>
                    <option value="rusak_berat" ${status === 'rusak_berat' ? 'selected' : ''}>Rusak Berat</option>
                    <option value="tidak_ada" ${status === 'tidak_ada' ? 'selected' : ''}>Tidak Ada</option>
                </select>
            </div>

            <div>
                <input type="text"
                       name="checklist_data[${safeKey}][note]"
                       class="form-control"
                       placeholder="Catatan komponen"
                       value="${safeNote}">
            </div>

            <div>
                <button type="button"
                        class="btn btn-icon btn-sm btn-outline-danger"
                        data-delete-checklist
                        data-url="${safeDeleteUrl}"
                        title="Hapus Pengecekan"
                        ${safeDeleteUrl ? '' : 'disabled'}>
                    <i class="sym sym-trash-solid"></i>
                </button>
            </div>
        `;

        return row;
    }

    document.querySelectorAll('.stock-opname-item-form').forEach(function (form) {
        const resultStatus = form.querySelector('select[name="result_status"]');
        const physicalCondition = form.querySelector('select[name="physical_condition"]');
        const needFollowUp = form.querySelector('select[name="need_follow_up"]');

        if (!resultStatus || !physicalCondition || !needFollowUp) {
            return;
        }

        toggleFollowUpFields(form, false);

        [resultStatus, physicalCondition, needFollowUp].forEach(function (select) {
            select.addEventListener('change', function () {
                toggleFollowUpFields(form, true);
            });
        });
    });

    document.querySelectorAll('[data-add-checklist]').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = button.closest('form');
            const wrapper = form?.querySelector('[data-checklist-wrapper]');
            const url = button.dataset.url || '';

            if (!form || !wrapper || !url) {
                alert('Route AJAX tambah pengecekan belum tersedia.');
                return;
            }

            activeChecklistButton = button;
            activeChecklistForm = form;
            activeChecklistWrapper = wrapper;

            clearChecklistError();

            if (customChecklistLabel) {
                customChecklistLabel.value = '';
            }

            if (addChecklistModal) {
                addChecklistModal.show();

                setTimeout(function () {
                    customChecklistLabel?.focus();
                }, 300);
            }
        });
    });

    saveCustomChecklistBtn?.addEventListener('click', async function () {
        if (!activeChecklistButton || !activeChecklistForm || !activeChecklistWrapper) {
            showChecklistError('Target form tidak ditemukan.');
            return;
        }

        const url = activeChecklistButton.dataset.url || '';
        const label = customChecklistLabel?.value?.trim() || '';

        clearChecklistError();

        if (!label) {
            showChecklistError('Judul pengecekan wajib diisi.');
            customChecklistLabel?.focus();
            return;
        }

        setSaveButtonLoading(true);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(activeChecklistForm),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    label: label,
                }),
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal menambahkan pengecekan.');
            }

            const item = result.data || {};

            activeChecklistWrapper.appendChild(
                createChecklistRow(
                    item.key,
                    item.label,
                    item.status || 'belum_dicek',
                    item.note || '',
                    item.delete_url || ''
                )
            );

            if (addChecklistModal) {
                addChecklistModal.hide();
            }

            activeChecklistButton = null;
            activeChecklistForm = null;
            activeChecklistWrapper = null;
        } catch (error) {
            showChecklistError(error.message || 'Gagal menambahkan pengecekan.');
        } finally {
            setSaveButtonLoading(false);
        }
    });

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-delete-checklist]');

        if (!button) {
            return;
        }

        const row = button.closest('[data-checklist-row]');
        const form = button.closest('form');
        const url = button.dataset.url || '';
        const checklistName = row?.querySelector('input[readonly]')?.value || '-';

        if (!row || !form || !url) {
            alert('Konfigurasi hapus pengecekan tidak ditemukan.');
            return;
        }

        pendingDeleteChecklist = {
            button: button,
            row: row,
            form: form,
            url: url,
        };

        if (deleteChecklistName) {
            deleteChecklistName.textContent = checklistName;
        }

        if (deleteChecklistModal) {
            deleteChecklistModal.show();
        }
    });

    confirmDeleteChecklistBtn?.addEventListener('click', async function () {
        const button = pendingDeleteChecklist.button;
        const row = pendingDeleteChecklist.row;
        const form = pendingDeleteChecklist.form;
        const url = pendingDeleteChecklist.url;

        if (!button || !row || !form || !url) {
            return;
        }

        const originalText = confirmDeleteChecklistBtn.innerHTML;

        confirmDeleteChecklistBtn.disabled = true;
        confirmDeleteChecklistBtn.innerHTML = 'Menghapus...';
        button.disabled = true;

        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(form),
                    'Accept': 'application/json',
                },
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal menghapus pengecekan.');
            }

            row.remove();

            if (deleteChecklistModal) {
                deleteChecklistModal.hide();
            }

            pendingDeleteChecklist = {
                button: null,
                row: null,
                form: null,
                url: '',
            };
        } catch (error) {
            alert(error.message || 'Gagal menghapus pengecekan.');
            button.disabled = false;
        } finally {
            confirmDeleteChecklistBtn.disabled = false;
            confirmDeleteChecklistBtn.innerHTML = originalText;
        }
    });

    customChecklistLabel?.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            saveCustomChecklistBtn?.click();
        }
    });

    const focusItemId = @json($focusItemId);

    if (focusItemId) {
        const element = document.getElementById('stock-opname-item-' + focusItemId);

        if (element) {
            setTimeout(function () {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                element.classList.add('border-primary', 'shadow-sm');
            }, 300);
        }
    }
});
</script>
@endsection
