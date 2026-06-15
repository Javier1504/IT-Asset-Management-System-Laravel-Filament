@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Nomor Kebutuhan</label>
        <input type="text"
            value="{{ $assetOfferRequest->request_number ?? 'Akan dibuat otomatis setelah disimpan' }}"
            class="form-control bg-light text-muted border-secondary-subtle"
            readonly
            tabindex="-1"
            style="cursor: not-allowed;">
        <small class="text-muted">
            Nomor kebutuhan dibuat otomatis oleh sistem.
        </small>
    </div>

    <div class="col-md-5">
        <label class="form-label">Nama Barang / Kebutuhan Aset <span class="text-danger">*</span></label>
        <input type="text"
               name="item_name"
               value="{{ old('item_name', $assetOfferRequest->item_name ?? '') }}"
               class="form-control @error('item_name') is-invalid @enderror"
               placeholder="Contoh: Lenovo ThinkPad E14">
        @error('item_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Kategori</label>
        <select name="item_category" class="form-select @error('item_category') is-invalid @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categoryOptions as $key => $label)
                <option value="{{ $key }}" {{ old('item_category', $assetOfferRequest->item_category ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('item_category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Spesifikasi Kebutuhan</label>
        <textarea name="required_specification"
                  rows="4"
                  class="form-control @error('required_specification') is-invalid @enderror"
                  placeholder="Contoh: RAM 16GB, SSD 512GB, Intel i5, garansi minimal 2 tahun">{{ old('required_specification', $assetOfferRequest->required_specification ?? '') }}</textarea>
        @error('required_specification')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Jumlah Kebutuhan <span class="text-danger">*</span></label>
        <input type="number"
               name="quantity"
               min="1"
               value="{{ old('quantity', $assetOfferRequest->quantity ?? 1) }}"
               class="form-control @error('quantity') is-invalid @enderror">
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Estimasi Budget / Unit</label>
        <input type="number"
               name="estimated_unit_budget"
               min="0"
               step="1"
               value="{{ old('estimated_unit_budget', isset($assetOfferRequest) && $assetOfferRequest ? (float) $assetOfferRequest->estimated_unit_budget : '') }}"
               class="form-control @error('estimated_unit_budget') is-invalid @enderror"
               placeholder="Contoh: 12500000">
        @error('estimated_unit_budget')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Dibutuhkan</label>
        <input type="date"
               name="needed_date"
               value="{{ old('needed_date', isset($assetOfferRequest) && $assetOfferRequest && $assetOfferRequest->needed_date ? $assetOfferRequest->needed_date->format('Y-m-d') : '') }}"
               class="form-control @error('needed_date') is-invalid @enderror">
        @error('needed_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statusOptions as $key => $label)
                <option value="{{ $key }}" {{ old('status', $assetOfferRequest->status ?? 'open') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">PIC Internal</label>
        <select name="pic_user_id" class="form-select @error('pic_user_id') is-invalid @enderror">
            <option value="">-- Pilih PIC Internal --</option>

            @foreach($picUsers as $picUser)
                @php
                    $displayName = $picUser->name_karyawan
                        ?? $picUser->username
                        ?? $picUser->corporate_email
                        ?? $picUser->email
                        ?? 'User #' . $picUser->id;

                    $displayEmail = $picUser->corporate_email
                        ?? $picUser->email
                        ?? '-';

                    $displayRole = $picUser->role
                        ? ucwords(str_replace('_', ' ', $picUser->role))
                        : 'Tanpa Role';

                    $selectedPic = old('pic_user_id', $assetOfferRequest->pic_user_id ?? '');
                @endphp

                <option value="{{ $picUser->id }}" {{ (string) $selectedPic === (string) $picUser->id ? 'selected' : '' }}>
                    {{ $displayName }} - {{ $displayRole }} - {{ $displayEmail }}
                </option>
            @endforeach
        </select>

        @error('pic_user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes"
                  rows="4"
                  class="form-control @error('notes') is-invalid @enderror"
                  placeholder="Catatan tambahan terkait kebutuhan aset ini">{{ old('notes', $assetOfferRequest->notes ?? '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>