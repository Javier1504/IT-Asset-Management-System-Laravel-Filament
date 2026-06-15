@extends('layouts.admin')

@section('title', 'Detail License Software')

@section('content')
@php
    $picUser = $softwareLicense->picUser ?? null;
    $createdBy = $softwareLicense->createdByUser ?? null;
    $updatedBy = $softwareLicense->updatedByUser ?? null;

    $picRole = $picUser && $picUser->role
        ? ucwords(str_replace('_', ' ', $picUser->role))
        : '-';

    $picName = $softwareLicense->pic_name
        ?: ($picUser->name_karyawan
            ?? $picUser->name
            ?? $picUser->username
            ?? $picUser->corporate_email
            ?? $picUser->email
            ?? '-');

    $picEmail = $softwareLicense->pic_email
        ?: ($picUser->corporate_email
            ?? $picUser->email
            ?? '-');

    $createdByName = $createdBy->name_karyawan
        ?? $createdBy->name
        ?? $createdBy->username
        ?? $createdBy->corporate_email
        ?? $createdBy->email
        ?? '-';

    $updatedByName = $updatedBy->name_karyawan
        ?? $updatedBy->name
        ?? $updatedBy->username
        ?? $updatedBy->corporate_email
        ?? $updatedBy->email
        ?? '-';
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail License Software</h4>
            <p class="text-muted mb-0">
                Informasi detail software, license, PIC/Owner, dan masa berlaku.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('software-licenses.edit', $softwareLicense->id) }}" class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('software-licenses.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Informasi Software</strong>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nama Software</small>
                            <div class="fw-semibold">{{ $softwareLicense->software_name }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Kategori</small>
                            <div>{{ $softwareLicense->category ?: '-' }}</div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Vendor / Publisher</small>
                            <div>{{ $softwareLicense->vendor_name ?: '-' }}</div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Jenis License</small>
                            <div>{{ $softwareLicense->license_type_label }}</div>
                        </div>

                        <div class="col-md-8">
                            <small class="text-muted">License Key / Serial / Subscription ID</small>
                            <div class="text-break">{{ $softwareLicense->license_key ?: '-' }}</div>
                        </div>

                        <div class="col-md-12">
                            <small class="text-muted">Catatan</small>
                            <div class="border rounded p-3 bg-light mt-1">
                                {!! nl2br(e($softwareLicense->notes ?: '-')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <strong>Informasi Tanggal</strong>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <small class="text-muted">Tanggal Pembelian</small>
                            <div>
                                {{ $softwareLicense->purchase_date ? $softwareLicense->purchase_date->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Mulai Berlaku</small>
                            <div>
                                {{ $softwareLicense->start_date ? $softwareLicense->start_date->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Expired</small>
                            <div>
                                {{ $softwareLicense->expired_date ? $softwareLicense->expired_date->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted">Reminder Renewal</small>
                            <div>
                                {{ $softwareLicense->renewal_reminder_date ? $softwareLicense->renewal_reminder_date->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Status & Penggunaan</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div>
                            <span class="badge {{ $softwareLicense->status_badge_class }}">
                                {{ $softwareLicense->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Total License</small>
                        <div class="fw-semibold">{{ $softwareLicense->total_license }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">License Terpakai</small>
                        <div class="fw-semibold">{{ $softwareLicense->used_license }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Sisa License</small>
                        <div class="fw-semibold">{{ $softwareLicense->remaining_license }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>PIC / Owner</strong>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Nama PIC</small>
                        <div class="fw-semibold">{{ $picName }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Role PIC</small>
                        <div>
                            <span class="badge bg-light text-dark border">
                                {{ $picRole }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Email PIC</small>
                        <div class="text-break">{{ $picEmail }}</div>
                    </div>

                    <div>
                        <small class="text-muted">User ID PIC</small>
                        <div>{{ $softwareLicense->pic_user_id ?: '-' }}</div>
                    </div>
                </div>
            </div>

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
                        <div>
                            {{ $softwareLicense->created_at ? $softwareLicense->created_at->format('d/m/Y H:i') : '-' }}
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">Terakhir Update</small>
                        <div>
                            {{ $softwareLicense->updated_at ? $softwareLicense->updated_at->format('d/m/Y H:i') : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection