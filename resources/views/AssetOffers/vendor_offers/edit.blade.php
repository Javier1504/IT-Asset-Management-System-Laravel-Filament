@extends('layouts.admin')

@section('title', 'Edit Penawaran Vendor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Edit Penawaran Vendor</h4>
            <p class="text-muted mb-0">
                Perbarui detail harga dan penawaran vendor.
            </p>
        </div>

        <a href="{{ route('asset-offer-requests.show', $assetVendorOffer->asset_offer_request_id) }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('asset-vendor-offers.update', $assetVendorOffer->id) }}"
                  enctype="multipart/form-data">
                @method('PUT')

                @include('AssetOffers.vendor_offers._form', [
                    'assetOfferRequest' => $assetVendorOffer->assetOfferRequest,
                    'assetVendorOffer' => $assetVendorOffer,
                    'submitLabel' => 'Update Penawaran'
                ])
            </form>
        </div>
    </div>
</div>
@endsection