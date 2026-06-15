@extends('layouts.admin')

@section('title', 'History Pengadaan')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">History Pengadaan</h4>
            <p class="text-muted mb-0">
                Riwayat kebutuhan aset yang sudah dipilih atau selesai.
            </p>
        </div>

        <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
            Kembali ke Penawaran Aset
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('asset-offer-requests.history') }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari nomor, nama aset, spesifikasi, PIC...">
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Kebutuhan Aset</th>
                            <th>Vendor Dipilih</th>
                            <th>Total Terpilih</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($histories as $index => $history)
                            @php
                                $selectedOffer = $history->vendorOffers
                                    ->where('status', \App\Models\AssetVendorOffer::STATUS_SELECTED)
                                    ->first();
                            @endphp

                            <tr>
                                <td>{{ $histories->firstItem() + $index }}</td>

                                <td>
                                    <strong>{{ $history->item_name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $history->request_number ?: '-' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $selectedOffer
                                        ? ($selectedOffer->vendor_name ?: ($selectedOffer->vendor->vendor_name ?? '-'))
                                        : '-' }}
                                </td>

                                <td>
                                    {{ $selectedOffer
                                        ? 'Rp ' . number_format((float) $selectedOffer->total_price, 0, ',', '.')
                                        : '-' }}
                                </td>

                                <td>
                                    <div>{{ $history->pic_name ?: '-' }}</div>
                                    @if($history->pic_email)
                                        <small class="text-muted">{{ $history->pic_email }}</small>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $history->status_badge_class }}">
                                        {{ $history->status_label }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('asset-offer-requests.show', $history->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada history pengadaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection