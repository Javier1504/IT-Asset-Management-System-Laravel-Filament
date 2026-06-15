@extends('layouts.admin')

@section('title', 'Tambah Kebutuhan Aset')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Tambah Kebutuhan Aset</h4>
            <p class="text-muted mb-0">
                Buat barang/kebutuhan aset yang akan dibandingkan penawaran vendornya.
            </p>
        </div>

        <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> Periksa kembali input yang ditandai.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('asset-offer-requests.store') }}">
                @include('AssetOffers.requests._form', [
                    'assetOfferRequest' => null,
                    'submitLabel' => 'Simpan Kebutuhan'
                ])
            </form>
        </div>
    </div>
</div>
@endsection