@extends('layouts.admin')

@section('title', 'Detail Vendor Aset')

@section('content')
@php
    $createdBy = $assetVendor->createdByUser ?? null;
    $updatedBy = $assetVendor->updatedByUser ?? null;

    $createdByName = $createdBy->name_karyawan
        ?? $createdBy->username
        ?? $createdBy->corporate_email
        ?? $createdBy->email
        ?? '-';

    $updatedByName = $updatedBy->name_karyawan
        ?? $updatedBy->username
        ?? $updatedBy->corporate_email
        ?? $updatedBy->email
        ?? '-';
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail Vendor Aset</h4>
            <p class="text-muted mb-0">
                Informasi vendor dan riwayat penawaran yang pernah diberikan.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('asset-vendors.edit', $assetVendor->id) }}" class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('asset-vendors.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Informasi Vendor</strong>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nama Vendor</small>
                            <div class="fw-semibold">{{ $assetVendor->vendor_name }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Kategori</small>
                            <div>{{ $assetVendor->category_label }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Status</small>
                            <div>
                                <span class="badge {{ $assetVendor->status_badge_class }}">
                                    {{ $assetVendor->status_label }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">PIC Vendor</small>
                            <div>{{ $assetVendor->pic_name ?: '-' }}</div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Email</small>
                            <div class="text-break">{{ $assetVendor->email ?: '-' }}</div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Telepon</small>
                            <div>{{ $assetVendor->phone ?: '-' }}</div>
                        </div>

                        <div class="col-md-12">
                            <small class="text-muted">Alamat</small>
                            <div class="border rounded p-3 bg-light mt-1">
                                {!! nl2br(e($assetVendor->address ?: '-')) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <small class="text-muted">Catatan</small>
                            <div class="border rounded p-3 bg-light mt-1">
                                {!! nl2br(e($assetVendor->notes ?: '-')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <strong>Riwayat Penawaran Vendor</strong>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kebutuhan Aset</th>
                                    <th>No. Penawaran</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assetVendor->offers as $index => $offer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $offer->assetOfferRequest->item_name ?? '-' }}
                                        </td>
                                        <td>{{ $offer->offer_number ?: '-' }}</td>
                                        <td>
                                            Rp {{ number_format((float) $offer->total_price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $offer->status_badge_class }}">
                                                {{ $offer->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada riwayat penawaran dari vendor ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <strong>Riwayat Data</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Dibuat Oleh</small>
                        <div>{{ $createdByName }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Diperbarui Oleh</small>
                        <div>{{ $updatedByName }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Dibuat Pada</small>
                        <div>{{ $assetVendor->created_at ? $assetVendor->created_at->format('d/m/Y H:i') : '-' }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Terakhir Update</small>
                        <div>{{ $assetVendor->updated_at ? $assetVendor->updated_at->format('d/m/Y H:i') : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection