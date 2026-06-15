@extends('layouts.admin')

@section('title', 'Edit Vendor Aset')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Edit Vendor Aset</h4>
            <p class="text-muted mb-0">
                Perbarui data vendor: {{ $assetVendor->vendor_name }}.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('asset-vendors.show', $assetVendor->id) }}" class="btn btn-outline-primary">
                Detail
            </a>

            <a href="{{ route('asset-vendors.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> Periksa kembali input yang ditandai.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('asset-vendors.update', $assetVendor->id) }}">
                @method('PUT')

                @include('AssetOffers.vendors._form', [
                    'assetVendor' => $assetVendor,
                    'submitLabel' => 'Update Vendor'
                ])
            </form>
        </div>
    </div>
</div>
@endsection