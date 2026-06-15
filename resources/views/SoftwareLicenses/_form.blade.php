@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Software <span class="text-danger">*</span></label>
        <input type="text"
               name="software_name"
               value="{{ old('software_name', $softwareLicense->software_name ?? '') }}"
               class="form-control @error('software_name') is-invalid @enderror"
               placeholder="Contoh: Microsoft Office 365">
        @error('software_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Kategori Software</label>
        <select name="category" class="form-select @error('category') is-invalid @enderror">
            <option value="">-- Pilih Kategori Software --</option>

            @foreach($categoryOptions as $key => $label)
                <option value="{{ $key }}" {{ old('category', $softwareLicense->category ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Vendor / Publisher</label>
        <input type="text"
               name="vendor_name"
               value="{{ old('vendor_name', $softwareLicense->vendor_name ?? '') }}"
               class="form-control @error('vendor_name') is-invalid @enderror"
               placeholder="Contoh: Microsoft">
        @error('vendor_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Jenis License</label>
        <select name="license_type" class="form-select @error('license_type') is-invalid @enderror">
            <option value="">-- Pilih Jenis License --</option>

            @foreach($licenseTypeOptions as $key => $label)
                <option value="{{ $key }}" {{ old('license_type', $softwareLicense->license_type ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('license_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label class="form-label">License Key / Serial / Subscription ID</label>
        <input type="text"
               name="license_key"
               value="{{ old('license_key', $softwareLicense->license_key ?? '') }}"
               class="form-control @error('license_key') is-invalid @enderror"
               placeholder="Opsional">
        @error('license_key')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Total License <span class="text-danger">*</span></label>
        <input type="number"
               name="total_license"
               min="1"
               value="{{ old('total_license', $softwareLicense->total_license ?? 1) }}"
               class="form-control @error('total_license') is-invalid @enderror">
        @error('total_license')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">License Terpakai <span class="text-danger">*</span></label>
        <input type="number"
               name="used_license"
               min="0"
               value="{{ old('used_license', $softwareLicense->used_license ?? 0) }}"
               class="form-control @error('used_license') is-invalid @enderror">
        @error('used_license')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Pembelian</label>
        <input type="date"
               name="purchase_date"
               value="{{ old('purchase_date', isset($softwareLicense) && $softwareLicense && $softwareLicense->purchase_date ? $softwareLicense->purchase_date->format('Y-m-d') : '') }}"
               class="form-control @error('purchase_date') is-invalid @enderror">
        @error('purchase_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Mulai Berlaku</label>
        <input type="date"
               name="start_date"
               value="{{ old('start_date', isset($softwareLicense) && $softwareLicense && $softwareLicense->start_date ? $softwareLicense->start_date->format('Y-m-d') : '') }}"
               class="form-control @error('start_date') is-invalid @enderror">
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Expired</label>
        <input type="date"
               name="expired_date"
               value="{{ old('expired_date', isset($softwareLicense) && $softwareLicense && $softwareLicense->expired_date ? $softwareLicense->expired_date->format('Y-m-d') : '') }}"
               class="form-control @error('expired_date') is-invalid @enderror">
        @error('expired_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Reminder Renewal</label>
        <input type="date"
               name="renewal_reminder_date"
               value="{{ old('renewal_reminder_date', isset($softwareLicense) && $softwareLicense && $softwareLicense->renewal_reminder_date ? $softwareLicense->renewal_reminder_date->format('Y-m-d') : '') }}"
               class="form-control @error('renewal_reminder_date') is-invalid @enderror">
        @error('renewal_reminder_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statusOptions as $key => $label)
                <option value="{{ $key }}" {{ old('status', $softwareLicense->status ?? 'active') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">
            Status "Akan Expired" dibuat otomatis jika tanggal expired kurang/sama dengan 30 hari.
        </small>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-9">
        <label class="form-label">PIC / Owner</label>
        <select name="pic_user_id" class="form-select @error('pic_user_id') is-invalid @enderror">
            <option value="">-- Pilih PIC / Owner --</option>

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

                    $selectedPic = old('pic_user_id', $softwareLicense->pic_user_id ?? '');
                @endphp

                <option value="{{ $picUser->id }}" {{ (string) $selectedPic === (string) $picUser->id ? 'selected' : '' }}>
                    {{ $displayName }} - {{ $displayRole }} - {{ $displayEmail }}
                </option>
            @endforeach
        </select>

        <small class="text-muted">
            Pilih user internal sebagai PIC/Owner. Nama, role, dan email akan mengikuti data user.
        </small>

        @error('pic_user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes"
                  rows="4"
                  class="form-control @error('notes') is-invalid @enderror"
                  placeholder="Catatan tambahan terkait software license">{{ old('notes', $softwareLicense->notes ?? '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('software-licenses.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>