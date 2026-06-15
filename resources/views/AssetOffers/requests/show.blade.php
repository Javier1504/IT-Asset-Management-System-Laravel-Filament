@extends('layouts.admin')

@section('title', 'Detail Penawaran Aset')

@section('content')
@php
    $picUser = $assetOfferRequest->picUser ?? null;

    $picRole = $picUser && $picUser->role
        ? ucwords(str_replace('_', ' ', $picUser->role))
        : '-';

    $lowestOffer = $assetOfferRequest->vendorOffers
        ->sortBy('total_price')
        ->first();

    $selectedOffer = $assetOfferRequest->vendorOffers
        ->where('status', \App\Models\AssetVendorOffer::STATUS_SELECTED)
        ->first();

    $isClosedOrCancelled = in_array($assetOfferRequest->status, [
        \App\Models\AssetOfferRequest::STATUS_CLOSED,
        \App\Models\AssetOfferRequest::STATUS_CANCELLED,
    ], true);
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail Penawaran Aset</h4>
            <p class="text-muted mb-0">
                Detail kebutuhan aset, perbandingan penawaran vendor, dokumen, dan email rekomendasi.
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap justify-content-end">
            <a href="{{ route('asset-offer-documents.comparison', $assetOfferRequest->id) }}"
               target="_blank"
               class="btn btn-outline-dark">
                Cetak Perbandingan PDF
            </a>

            @if($selectedOffer)
                <a href="{{ route('asset-offer-documents.selected-vendor', $assetOfferRequest->id) }}"
                   target="_blank"
                   class="btn btn-outline-success">
                    Cetak Rekomendasi PDF
                </a>

                @if($assetOfferRequest->pic_email)
                    <form method="POST"
                          action="{{ route('asset-offer-requests.send-selected-email', $assetOfferRequest->id) }}"
                          onsubmit="return confirm('Kirim email rekomendasi vendor terpilih ke PIC internal?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            Kirim Email ke PIC
                        </button>
                    </form>
                @endif
            @endif

            @if($assetOfferRequest->status === \App\Models\AssetOfferRequest::STATUS_SELECTED)
                <form method="POST"
                      action="{{ route('asset-offer-requests.mark-closed', $assetOfferRequest->id) }}"
                      onsubmit="return confirm('Tandai kebutuhan aset ini selesai dan masukkan ke history pengadaan?')">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Tandai Selesai
                    </button>
                </form>
            @endif

            @if(!$isClosedOrCancelled)
                <a href="{{ route('asset-offer-requests.edit', $assetOfferRequest->id) }}" class="btn btn-warning">
                    Edit Kebutuhan
                </a>
            @endif

            <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($selectedOffer && !$assetOfferRequest->pic_email)
        <div class="alert alert-warning">
            Vendor sudah dipilih, tetapi tombol kirim email belum muncul karena PIC internal belum memiliki email.
            Silakan edit kebutuhan aset dan pilih PIC internal yang memiliki email.
        </div>
    @endif

    @if($isClosedOrCancelled)
        <div class="alert alert-info">
            Kebutuhan aset ini sudah berstatus <strong>{{ $assetOfferRequest->status_label }}</strong>.
            Data penawaran vendor dikunci dan hanya dapat dilihat/cetak dokumen.
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Informasi Kebutuhan Aset</strong>
                    <span class="badge {{ $assetOfferRequest->status_badge_class }}">
                        {{ $assetOfferRequest->status_label }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted">Nomor Kebutuhan</small>
                            <div class="fw-semibold">{{ $assetOfferRequest->request_number ?: '-' }}</div>
                        </div>

                        <div class="col-md-5">
                            <small class="text-muted">Nama Barang / Aset</small>
                            <div class="fw-semibold">{{ $assetOfferRequest->item_name }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Kategori</small>
                            <div>{{ $assetOfferRequest->category_label }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Jumlah</small>
                            <div>{{ $assetOfferRequest->quantity }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Budget / Unit</small>
                            <div>
                                {{ $assetOfferRequest->estimated_unit_budget
                                    ? 'Rp ' . number_format((float) $assetOfferRequest->estimated_unit_budget, 0, ',', '.')
                                    : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Estimasi Total</small>
                            <div>
                                {{ $assetOfferRequest->estimated_total_budget
                                    ? 'Rp ' . number_format((float) $assetOfferRequest->estimated_total_budget, 0, ',', '.')
                                    : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Tanggal Dibutuhkan</small>
                            <div>
                                {{ $assetOfferRequest->needed_date ? $assetOfferRequest->needed_date->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <small class="text-muted">Spesifikasi Kebutuhan</small>
                            <div class="border rounded p-3 bg-light mt-1">
                                {!! nl2br(e($assetOfferRequest->required_specification ?: '-')) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <small class="text-muted">Catatan</small>
                            <div class="border rounded p-3 bg-light mt-1">
                                {!! nl2br(e($assetOfferRequest->notes ?: '-')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Benchmark Penawaran Vendor</strong>
                        <br>
                        <small class="text-muted">
                            Bandingkan harga, garansi, estimasi pengiriman, dokumen quotation, dan status vendor.
                        </small>
                    </div>

                    @if(!$isClosedOrCancelled)
                        <a href="{{ route('asset-vendor-offers.create', $assetOfferRequest->id) }}"
                           class="btn btn-sm btn-primary">
                            + Tambah Penawaran Vendor
                        </a>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Vendor</th>
                                    <th>No. Penawaran</th>
                                    <th>Harga Unit</th>
                                    <th>Total</th>
                                    <th>Garansi</th>
                                    <th>Estimasi Kirim</th>
                                    <th>Status</th>
                                    <th width="250">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($assetOfferRequest->vendorOffers as $offer)
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $offer->vendor_name ?: ($offer->vendor->vendor_name ?? '-') }}
                                            </strong>

                                            @if($offer->vendor_pic_name)
                                                <br>
                                                <small class="text-muted">PIC: {{ $offer->vendor_pic_name }}</small>
                                            @endif

                                            @if($offer->vendor_email)
                                                <br>
                                                <small class="text-muted">{{ $offer->vendor_email }}</small>
                                            @endif

                                            @if($offer->vendor_phone)
                                                <br>
                                                <small class="text-muted">{{ $offer->vendor_phone }}</small>
                                            @endif
                                        </td>

                                        <td>
                                            <div>{{ $offer->offer_number ?: '-' }}</div>

                                            @if($offer->offer_date)
                                                <small class="text-muted">
                                                    {{ $offer->offer_date->format('d/m/Y') }}
                                                </small>
                                            @endif

                                            @if($offer->valid_until)
                                                <br>
                                                <small class="text-muted">
                                                    Berlaku sampai: {{ $offer->valid_until->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        </td>

                                        <td>
                                            Rp {{ number_format((float) $offer->unit_price, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <strong>
                                                Rp {{ number_format((float) $offer->total_price, 0, ',', '.') }}
                                            </strong>
                                        </td>

                                        <td>{{ $offer->warranty ?: '-' }}</td>

                                        <td>{{ $offer->delivery_estimation ?: '-' }}</td>

                                        <td>
                                            <span class="badge {{ $offer->status_badge_class }}">
                                                {{ $offer->status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-1 flex-wrap">
                                                @if($offer->document_path)
                                                    <a href="{{ asset('storage/' . $offer->document_path) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-secondary">
                                                        Dokumen
                                                    </a>
                                                @endif

                                                @if(!$isClosedOrCancelled)
                                                    <a href="{{ route('asset-vendor-offers.edit', $offer->id) }}"
                                                       class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>

                                                    @if(
                                                        $offer->status !== \App\Models\AssetVendorOffer::STATUS_SELECTED
                                                        && $offer->status !== \App\Models\AssetVendorOffer::STATUS_EXPIRED
                                                    )
                                                        <form method="POST"
                                                              action="{{ route('asset-vendor-offers.select', $offer->id) }}"
                                                              onsubmit="return confirm('Pilih vendor ini sebagai penawaran terbaik? Vendor lain akan otomatis ditolak.')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                Pilih
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form method="POST"
                                                          action="{{ route('asset-vendor-offers.destroy', $offer->id) }}"
                                                          onsubmit="return confirm('Hapus penawaran vendor ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted small">
                                                        Terkunci
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Belum ada penawaran vendor untuk kebutuhan aset ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <small class="text-muted">
                        Klik <strong>Pilih</strong> pada salah satu vendor untuk menetapkan penawaran terbaik.
                        Setelah kebutuhan ditandai selesai, data akan terkunci dan masuk ke History Pengadaan.
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>PIC Internal</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Nama PIC</small>
                        <div class="fw-semibold">{{ $assetOfferRequest->pic_name ?: '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Role PIC</small>
                        <div>{{ $picRole }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Email PIC</small>
                        <div class="text-break">{{ $assetOfferRequest->pic_email ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Ringkasan Benchmark</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Jumlah Penawaran Vendor</small>
                        <div class="fw-semibold">{{ $assetOfferRequest->vendorOffers->count() }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Penawaran Terendah</small>
                        <div class="fw-semibold">
                            @if($lowestOffer)
                                Rp {{ number_format((float) $lowestOffer->total_price, 0, ',', '.') }}
                                <br>
                                <small class="text-muted">
                                    {{ $lowestOffer->vendor_name ?: ($lowestOffer->vendor->vendor_name ?? '-') }}
                                </small>
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Vendor Terpilih</small>
                        <div class="fw-semibold">
                            @if($selectedOffer)
                                {{ $selectedOffer->vendor_name ?: ($selectedOffer->vendor->vendor_name ?? '-') }}
                                <br>
                                <small class="text-muted">
                                    Rp {{ number_format((float) $selectedOffer->total_price, 0, ',', '.') }}
                                </small>

                                @if($assetOfferRequest->pic_email)
                                    <br>
                                    <small class="text-success">
                                        Email dapat dikirim ke PIC.
                                    </small>
                                @else
                                    <br>
                                    <small class="text-warning">
                                        PIC belum memiliki email.
                                    </small>
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">Status Kebutuhan</small>
                        <div>
                            <span class="badge {{ $assetOfferRequest->status_badge_class }}">
                                {{ $assetOfferRequest->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <strong>Alur Pengadaan</strong>
                </div>

                <div class="card-body">
                    <ol class="mb-0 ps-3">
                        <li>Buat kebutuhan aset.</li>
                        <li>Tambahkan beberapa penawaran vendor.</li>
                        <li>Cetak dokumen perbandingan vendor.</li>
                        <li>Pilih vendor terbaik.</li>
                        <li>Cetak dokumen rekomendasi vendor terpilih.</li>
                        <li>Kirim email rekomendasi ke PIC internal.</li>
                        <li>Tandai selesai agar masuk history pengadaan.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection