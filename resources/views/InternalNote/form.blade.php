@php
    $note = $note ?? null;
    $prefill = $prefill ?? [];

    $selectedRequestType = old('request_type', optional($note)->request_type ?? ($prefill['request_type'] ?? 'operasional'));
    $selectedAssetClassification = old('asset_classification', optional($note)->asset_classification ?? ($prefill['asset_classification'] ?? ''));
    $selectedPriority = old('priority', optional($note)->priority ?? ($prefill['priority'] ?? 'normal'));
    $selectedStatus = old('status', optional($note)->status ?? ($prefill['status'] ?? 'open'));
    $selectedAssignedTo = old('assigned_to', optional($note)->assigned_to ?? ($prefill['assigned_to'] ?? ''));

    $selectedStockOpname = old(
        'stock_opname_id',
        optional($note)->stock_opname_id ?? ($prefill['stock_opname_id'] ?? request('stock_opname_id', ''))
    );

    $selectedStockOpnameUser = old(
        'stock_opname_user_id',
        optional($note)->stock_opname_user_id ?? ($prefill['stock_opname_user_id'] ?? request('stock_opname_user_id', ''))
    );

    $selectedStockOpnameItem = old(
        'stock_opname_item_id',
        optional($note)->stock_opname_item_id ?? ($prefill['stock_opname_item_id'] ?? request('stock_opname_item_id', ''))
    );

    $isFromStockOpname = !empty($selectedStockOpname);
    $selectedStockOpnameData = collect($stockOpnames ?? [])->firstWhere('id', (int) $selectedStockOpname);

    if (!$selectedStockOpnameData && $isFromStockOpname && class_exists(\App\Models\StockOpname::class)) {
        $selectedStockOpnameData = \App\Models\StockOpname::query()->find($selectedStockOpname);
    }

    $baseStockOpnameLabel = null;

    if ($selectedStockOpnameData) {
        $baseStockOpnameLabel = trim(
            ($selectedStockOpnameData->code ?? '') . ' - ' . ($selectedStockOpnameData->title ?? ''),
            ' -'
        );
    }

    $baseStockOpnameLabel = $baseStockOpnameLabel ?: (
        $isFromStockOpname ? 'Stock Opname ID ' . $selectedStockOpname : null
    );

    $selectedStockOpnameUserData = null;
    $selectedStockOpnameItemData = null;

    if (!empty($selectedStockOpnameUser) && class_exists(\App\Models\StockOpnameUser::class)) {
        $selectedStockOpnameUserData = \App\Models\StockOpnameUser::with('user')->find($selectedStockOpnameUser);
    }

    if (!empty($selectedStockOpnameItem) && class_exists(\App\Models\StockOpnameItem::class)) {
        $selectedStockOpnameItemData = \App\Models\StockOpnameItem::query()->find($selectedStockOpnameItem);
    }

    $selectedTeamName = $selectedStockOpnameUserData?->team;

    $selectedUserName = $selectedStockOpnameUserData?->user?->name_karyawan
        ?? $selectedStockOpnameUserData?->user?->username
        ?? $selectedStockOpnameUserData?->user?->corporate_email
        ?? $selectedStockOpnameUserData?->user?->email
        ?? $selectedStockOpnameItemData?->snapshot_user_name
        ?? null;

    $selectedAssetName = $selectedStockOpnameItemData?->snapshot_asset_name ?? null;
    $selectedAssetNumber = $selectedStockOpnameItemData?->snapshot_asset_number ?? null;
    $selectedAssetSerial = $selectedStockOpnameItemData?->snapshot_serial_number ?? null;

    $selectedStockOpnameLabel = collect([
        $baseStockOpnameLabel,
        $selectedTeamName ? 'Tim ' . $selectedTeamName : null,
        $selectedUserName ? 'Personel ' . $selectedUserName : null,
        $selectedAssetName ? 'Aset ' . $selectedAssetName : null,
        $selectedAssetNumber ? 'No. ' . $selectedAssetNumber : null,
    ])->filter()->implode(' - ');

    $titleValue = old('title', optional($note)->title ?? ($prefill['title'] ?? ''));
    $descriptionValue = old('description', optional($note)->description ?? ($prefill['description'] ?? ''));
    $purchaseNeedValue = old('purchase_need_note', optional($note)->purchase_need_note ?? ($prefill['purchase_need_note'] ?? ''));
    $incidentValue = old('incident_note', optional($note)->incident_note ?? ($prefill['incident_note'] ?? ''));
    $configurationValue = old('configuration_note', optional($note)->configuration_note ?? ($prefill['configuration_note'] ?? ''));
    $routingValue = old('routing_note', optional($note)->routing_note ?? ($prefill['routing_note'] ?? ''));
    $followUpValue = old('follow_up_note', optional($note)->follow_up_note ?? ($prefill['follow_up_note'] ?? ''));
    $scheduledAtValue = old(
        'scheduled_at',
        optional($note)->scheduled_at
            ? optional($note)->scheduled_at->format('Y-m-d\TH:i')
            : ($prefill['scheduled_at'] ?? '')
    );
    $estimatedCostValue = old('estimated_cost', optional($note)->estimated_cost ?? ($prefill['estimated_cost'] ?? ''));
@endphp

<input type="hidden" name="stock_opname_user_id" value="{{ $selectedStockOpnameUser }}">
<input type="hidden" name="stock_opname_item_id" value="{{ $selectedStockOpnameItem }}">

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Data belum valid.</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($isFromStockOpname)
    <div class="alert alert-info border-0 shadow-sm">
        <strong>Menindaklanjuti {{ $selectedStockOpnameLabel }}.</strong>
        <br>
        Gunakan form ini untuk menentukan PIC, prioritas, jadwal, estimasi biaya tindak lanjut, dan langkah penyelesaian.
    </div>
@endif

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Judul Catatan <span class="text-danger">*</span></label>
        <input type="text"
               name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ $titleValue }}"
               placeholder="Contoh: Tindak lanjut aset tidak sesuai hasil stock opname"
               required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Jenis Catatan <span class="text-danger">*</span></label>
        <select name="request_type"
                id="request_type"
                class="form-select @error('request_type') is-invalid @enderror"
                required>
            @foreach($requestTypeOptions as $key => $label)
                <option value="{{ $key }}" @selected($selectedRequestType === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Pilih jenis catatan agar field detail yang relevan muncul.</small>
        @error('request_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Klasifikasi Aset</label>
        <select name="asset_classification"
                class="form-select @error('asset_classification') is-invalid @enderror">
            <option value="">Tidak ada klasifikasi</option>
            @foreach($assetClassificationOptions as $key => $label)
                <option value="{{ $key }}" @selected($selectedAssetClassification === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('asset_classification')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prioritas <span class="text-danger">*</span></label>
        <select name="priority"
                class="form-select @error('priority') is-invalid @enderror"
                required>
            @foreach($priorityOptions as $key => $label)
                <option value="{{ $key }}" @selected($selectedPriority === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('priority')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status"
                class="form-select @error('status') is-invalid @enderror"
                required>
            @foreach($statusOptions as $key => $label)
                <option value="{{ $key }}" @selected($selectedStatus === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Jadwal Tindak Lanjut</label>
        <input type="datetime-local"
               name="scheduled_at"
               class="form-control @error('scheduled_at') is-invalid @enderror"
               value="{{ $scheduledAtValue }}">
        <small class="text-muted">Isi jika tindak lanjut memiliki target waktu.</small>
        @error('scheduled_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estimasi Biaya Tindak Lanjut</label>
        <input type="number"
               name="estimated_cost"
               min="0"
               step="1000"
               class="form-control @error('estimated_cost') is-invalid @enderror"
               value="{{ $estimatedCostValue }}"
               placeholder="Contoh: 500000 untuk biaya perbaikan/penggantian/pembelian">
        <small class="text-muted">Estimasi ini digunakan untuk tindak lanjut operasional, bukan harga final pembelian.</small>
        @error('estimated_cost')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">PIC / Assign ke User</label>
        <select name="assigned_to"
                class="form-select @error('assigned_to') is-invalid @enderror">
            <option value="">Tidak di-assign</option>
            @foreach($users as $user)
                @php
                    $userLabel = $user->name_karyawan
                        ?? $user->username
                        ?? $user->corporate_email
                        ?? $user->email
                        ?? '-';
                @endphp

                <option value="{{ $user->id }}" @selected((string) $selectedAssignedTo === (string) $user->id)>
                    {{ $userLabel }} {{ $user->role ? '(' . $user->role . ')' : '' }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">PIC adalah penanggung jawab follow up catatan ini.</small>
        @error('assigned_to')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Relasi Stock Opname</label>

        @if($isFromStockOpname)
            <input type="hidden" name="stock_opname_id" value="{{ $selectedStockOpname }}">

            <div class="border rounded bg-light p-2">
                <div class="fw-semibold text-dark">
                    Menindaklanjuti {{ $selectedStockOpnameLabel }}
                </div>

                @if($selectedTeamName || $selectedUserName || $selectedAssetName || $selectedAssetNumber || $selectedAssetSerial)
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @if($selectedTeamName)
                            <span class="badge bg-info text-dark">Tim: {{ $selectedTeamName }}</span>
                        @endif

                        @if($selectedUserName)
                            <span class="badge bg-primary">Personel: {{ $selectedUserName }}</span>
                        @endif

                        @if($selectedAssetName)
                            <span class="badge bg-success">Aset: {{ $selectedAssetName }}</span>
                        @endif

                        @if($selectedAssetNumber)
                            <span class="badge bg-secondary">No. Aset: {{ $selectedAssetNumber }}</span>
                        @endif

                        @if($selectedAssetSerial && $selectedAssetSerial !== '-')
                            <span class="badge bg-dark">Serial: {{ $selectedAssetSerial }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <small class="text-muted">
                Relasi otomatis dari halaman Stock Opname, termasuk tim, personel, dan aset yang ditindaklanjuti.
            </small>
        @else
            <select name="stock_opname_id"
                    class="form-select @error('stock_opname_id') is-invalid @enderror">
                <option value="">Tidak terkait stock opname</option>

                @foreach($stockOpnames as $stockOpname)
                    @php
                        $stockOpnameOptionLabel = trim(
                            ($stockOpname->code ?? '') . ' - ' . ($stockOpname->title ?? ''),
                            ' -'
                        );

                        $stockOpnameOptionLabel = $stockOpnameOptionLabel ?: 'Stock Opname ID ' . $stockOpname->id;
                    @endphp

                    <option value="{{ $stockOpname->id }}" @selected((string) $selectedStockOpname === (string) $stockOpname->id)>
                        {{ $stockOpnameOptionLabel }}
                    </option>
                @endforeach
            </select>

            <small class="text-muted">Pilih jika catatan ini merupakan tindak lanjut dari hasil stock opname.</small>
        @endif

        @error('stock_opname_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Deskripsi Umum</label>
        <textarea name="description"
                  rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Tuliskan ringkasan masalah atau kebutuhan tindak lanjut...">{{ $descriptionValue }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3 internal-note-special-field" data-types="kebutuhan_pembelian">
        <label class="form-label">Catatan Kebutuhan Pembelian / Penggantian</label>
        <textarea name="purchase_need_note"
                  rows="3"
                  class="form-control @error('purchase_need_note') is-invalid @enderror"
                  placeholder="Contoh: Perlu pembelian adaptor, RAM, mouse, kabel, atau perangkat pengganti...">{{ $purchaseNeedValue }}</textarea>
        @error('purchase_need_note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3 internal-note-special-field" data-types="insiden">
        <label class="form-label">Catatan Insiden</label>
        <textarea name="incident_note"
                  rows="3"
                  class="form-control @error('incident_note') is-invalid @enderror"
                  placeholder="Contoh: Aset rusak, hilang, tidak sesuai data, atau perlu pengecekan lanjutan...">{{ $incidentValue }}</textarea>
        @error('incident_note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3 internal-note-special-field" data-types="perubahan_konfigurasi">
        <label class="form-label">Catatan Perubahan Konfigurasi</label>
        <textarea name="configuration_note"
                  rows="3"
                  class="form-control @error('configuration_note') is-invalid @enderror"
                  placeholder="Contoh: Perubahan konfigurasi perangkat, sistem, software, atau jaringan...">{{ $configurationValue }}</textarea>
        @error('configuration_note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3 internal-note-special-field" data-types="routing">
        <label class="form-label">Catatan Routing</label>
        <textarea name="routing_note"
                  rows="3"
                  class="form-control @error('routing_note') is-invalid @enderror"
                  placeholder="Contoh: Catatan perubahan routing jaringan, VLAN, IP, atau alur koneksi...">{{ $routingValue }}</textarea>
        @error('routing_note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Catatan Tindak Lanjut</label>
        <textarea name="follow_up_note"
                  rows="3"
                  class="form-control @error('follow_up_note') is-invalid @enderror"
                  placeholder="Tuliskan rencana tindak lanjut, PIC, jadwal, keputusan internal, atau langkah penyelesaian...">{{ $followUpValue }}</textarea>
        <small class="text-muted">Field ini dipakai untuk merangkum langkah follow up yang harus dilakukan.</small>
        @error('follow_up_note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@php
    $backUrl = $isFromStockOpname
        ? route('internal-notes.stock-opname', $selectedStockOpname)
        : route('internal-notes.index');
@endphp

<div class="d-flex justify-content-end gap-2">
    <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $buttonText }}
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const requestTypeSelect = document.getElementById('request_type');
        const specialFields = document.querySelectorAll('.internal-note-special-field');

        function toggleSpecialFields(clearHidden = false) {
            const selectedType = requestTypeSelect ? requestTypeSelect.value : '';

            specialFields.forEach(function (field) {
                const allowedTypes = (field.dataset.types || '')
                    .split(',')
                    .map(function (item) {
                        return item.trim();
                    })
                    .filter(Boolean);

                const shouldShow = allowedTypes.includes(selectedType);

                field.style.display = shouldShow ? '' : 'none';

                if (!shouldShow && clearHidden) {
                    field.querySelectorAll('textarea, input, select').forEach(function (input) {
                        input.value = '';
                    });
                }
            });
        }

        toggleSpecialFields(false);

        if (requestTypeSelect) {
            requestTypeSelect.addEventListener('change', function () {
                toggleSpecialFields(true);
            });
        }
    });
</script>
