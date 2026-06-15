@csrf

@php
    $currentRequest = $assetOfferRequest ?? $assetVendorOffer->assetOfferRequest ?? null;
    $quantity = $currentRequest?->quantity ?? 1;
    $currentUnitPrice = old('unit_price', isset($assetVendorOffer) && $assetVendorOffer ? (float) $assetVendorOffer->unit_price : '');
    $currentTotal = is_numeric($currentUnitPrice) && $currentUnitPrice !== ''
        ? (float) $currentUnitPrice * max((int) $quantity, 1)
        : 0;
@endphp

<div class="row g-3">
    <div class="col-md-12">
        <div class="alert alert-info mb-0">
            <strong>Kebutuhan Aset:</strong>
            {{ $currentRequest->item_name ?? '-' }}
            <br>
            <small>
                Nomor: {{ $currentRequest->request_number ?? '-' }} |
                Qty: {{ $quantity }} |
                Kategori: {{ $currentRequest->category_label ?? '-' }}
            </small>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Vendor <span class="text-danger">*</span></label>
        <select name="asset_vendor_id" class="form-select @error('asset_vendor_id') is-invalid @enderror">
            <option value="">-- Pilih Vendor --</option>

            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}"
                    {{ old('asset_vendor_id', $assetVendorOffer->asset_vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                    {{ $vendor->vendor_name }}
                    @if($vendor->pic_name)
                        - PIC: {{ $vendor->pic_name }}
                    @endif
                    @if($vendor->email)
                        - {{ $vendor->email }}
                    @endif
                </option>
            @endforeach
        </select>

        @error('asset_vendor_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <small class="text-muted">
            Data vendor diambil dari List Vendor Aset.
        </small>
    </div>

    <div class="col-md-3">
        <label class="form-label">Nomor Penawaran</label>
        <input type="text"
               value="{{ $assetVendorOffer->offer_number ?? 'Akan dibuat otomatis setelah disimpan' }}"
               class="form-control bg-light text-muted border-secondary-subtle"
               readonly
               tabindex="-1"
               style="cursor: not-allowed;">
        <small class="text-muted">
            Nomor penawaran dibuat otomatis oleh sistem.
        </small>
    </div>

    <div class="col-md-3">
        <label class="form-label">Status Penawaran <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statusOptions as $key => $label)
                <option value="{{ $key }}"
                    {{ old('status', $assetVendorOffer->status ?? \App\Models\AssetVendorOffer::STATUS_SUBMITTED) == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">
            Status Dipilih hanya melalui tombol Pilih pada tabel benchmark.
        </small>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Penawaran</label>
        <input type="date"
               name="offer_date"
               value="{{ old('offer_date', isset($assetVendorOffer) && $assetVendorOffer && $assetVendorOffer->offer_date ? $assetVendorOffer->offer_date->format('Y-m-d') : '') }}"
               class="form-control @error('offer_date') is-invalid @enderror">
        @error('offer_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Berlaku Sampai</label>
        <input type="date"
               name="valid_until"
               value="{{ old('valid_until', isset($assetVendorOffer) && $assetVendorOffer && $assetVendorOffer->valid_until ? $assetVendorOffer->valid_until->format('Y-m-d') : '') }}"
               class="form-control @error('valid_until') is-invalid @enderror">
        @error('valid_until')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Harga Satuan <span class="text-danger">*</span></label>
        <input type="number"
               id="unit_price"
               name="unit_price"
               min="0"
               step="1"
               value="{{ $currentUnitPrice }}"
               class="form-control @error('unit_price') is-invalid @enderror"
               placeholder="Contoh: 12500000">
        @error('unit_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Total Otomatis</label>
        <input type="text"
               id="total_price_preview"
               value="Rp {{ number_format($currentTotal, 0, ',', '.') }}"
               class="form-control bg-light text-muted border-secondary-subtle"
               readonly
               tabindex="-1"
               style="cursor: not-allowed;">
        <small class="text-muted">
            Total = harga satuan × qty kebutuhan.
        </small>
    </div>

    <div class="col-md-4">
        <label class="form-label">Garansi</label>
        <input type="text"
               name="warranty"
               value="{{ old('warranty', $assetVendorOffer->warranty ?? '') }}"
               class="form-control @error('warranty') is-invalid @enderror"
               placeholder="Contoh: 3 tahun">
        @error('warranty')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Estimasi Pengiriman</label>
        <input type="text"
               name="delivery_estimation"
               value="{{ old('delivery_estimation', $assetVendorOffer->delivery_estimation ?? '') }}"
               class="form-control @error('delivery_estimation') is-invalid @enderror"
               placeholder="Contoh: 7 hari kerja">
        @error('delivery_estimation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Dokumen Penawaran</label>
        <input type="file"
               name="document"
               class="form-control @error('document') is-invalid @enderror"
               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">

        @if(isset($assetVendorOffer) && $assetVendorOffer && $assetVendorOffer->document_path)
            <small class="text-muted">
                Dokumen saat ini:
                <a href="{{ asset('storage/' . $assetVendorOffer->document_path) }}" target="_blank">
                    Lihat dokumen
                </a>
            </small>
        @else
            <small class="text-muted">Opsional. Maksimal 5 MB.</small>
        @endif

        @error('document')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes"
                  rows="4"
                  class="form-control @error('notes') is-invalid @enderror"
                  placeholder="Catatan tambahan terkait penawaran vendor">{{ old('notes', $assetVendorOffer->notes ?? '') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('asset-offer-requests.show', $currentRequest->id) }}"
       class="btn btn-outline-secondary">
        Batal
    </a>

    <button type="submit" class="btn btn-primary" {{ $vendors->isEmpty() ? 'disabled' : '' }}>
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const unitPriceInput = document.getElementById('unit_price');
        const totalPreview = document.getElementById('total_price_preview');
        const quantity = {{ (int) $quantity }};

        function formatRupiah(value) {
            const numberValue = Number(value || 0);
            return 'Rp ' + numberValue.toLocaleString('id-ID');
        }

        function updateTotalPreview() {
            if (!unitPriceInput || !totalPreview) {
                return;
            }

            const unitPrice = Number(unitPriceInput.value || 0);
            totalPreview.value = formatRupiah(unitPrice * Math.max(quantity, 1));
        }

        if (unitPriceInput) {
            unitPriceInput.addEventListener('input', updateTotalPreview);
            updateTotalPreview();
        }
    });
</script>