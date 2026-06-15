@extends('layouts.admin')

@section('title', 'Tambah Penawaran Vendor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Tambah Penawaran Vendor</h4>
            <p class="text-muted mb-0">
                Tambahkan harga dan detail penawaran vendor untuk kebutuhan aset.
            </p>
        </div>

        <a href="{{ route('asset-offer-requests.show', $assetOfferRequest->id) }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($vendors->isEmpty())
        <div class="alert alert-warning">
            Belum ada vendor aktif. Tambahkan vendor terlebih dahulu melalui menu
            <a href="{{ route('asset-vendors.index') }}" class="alert-link">List Vendor</a>.
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('asset-vendor-offers.store', $assetOfferRequest->id) }}"
                  enctype="multipart/form-data">
                @include('AssetOffers.vendor_offers._form', [
                    'assetOfferRequest' => $assetOfferRequest,
                    'assetVendorOffer' => null,
                    'submitLabel' => 'Simpan Penawaran'
                ])
            </form>
        </div>
    </div>
</div>
@endsection