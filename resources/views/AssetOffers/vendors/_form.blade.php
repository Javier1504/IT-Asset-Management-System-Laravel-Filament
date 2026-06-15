@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Vendor <span class="text-danger">*</span></label>
        <input type="text"
               name="vendor_name"
               value="{{ old('vendor_name', $assetVendor->vendor_name ?? '') }}"
               class="form-control @error('vendor_name') is-invalid @enderror"
               placeholder="Contoh: PT Sumber Teknologi Indonesia">
        @error('vendor_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Kategori Vendor</label>
        <select name="category" class="form-select @error('category') is-invalid @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categoryOptions as $key => $label)
                <option value="{{ $key }}" {{ old('category', $assetVendor->category ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statusOptions as $key => $label)
                <option value="{{ $key }}" {{ old('status', $assetVendor->status ?? 'active') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">PIC Vendor</label>
        <input type="text"
               name="pic_name"
               value="{{ old('pic_name', $assetVendor->pic_name ?? '') }}"
               class="form-control @error('pic_name') is-invalid @enderror"
               placeholder="Nama kontak vendor">
        @error('pic_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Email Vendor</label>
        <input type="email"
               name="email"
               value="{{ old('email', $assetVendor->email ?? '') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="vendor@example.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Telepon Vendor</label>
        <input type="text"
               name="phone"
               value="{{ old('phone', $assetVendor->phone ?? '') }}"
               class="form-control @error('phone') is-invalid @enderror"
               placeholder="08xxxxxxxxxx / nomor kantor">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Alamat</label>
        <textarea name="address"
                  rows="3"
                  class="form-control @error('address') is-invalid @enderror"
                  placeholder="Alamat vendor">{{ old('address', $assetVendor->address ?? '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes"
                  rows="4"
                  class="form-control @error('notes') is-invalid @enderror"
                  placeholder="Catatan tambahan terkait vendor">{{ old('notes', $assetVendor->notes ?? '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('asset-vendors.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>