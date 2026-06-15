@extends('layouts.admin')

@section('title', 'Detail Audit Trail')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                            <div>
                                <h4 class="m-0">Detail Audit Trail</h4>
                                <span class="text-muted">Detail perubahan data, konteks relasi, dan metadata request.</span>
                            </div>

                            <a href="{{ url()->previous() ?: route('audit-trails.index') }}" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 bg-light h-100">
                                    <div class="mb-2"><strong>Waktu:</strong> {{ $auditTrail->created_at?->format('d-m-Y H:i:s') ?? '-' }}</div>
                                    <div class="mb-2"><strong>User:</strong> {{ $auditTrail->user->name_karyawan ?? $auditTrail->user->username ?? $auditTrail->user->email ?? $auditTrail->user_name ?? '-' }}</div>
                                    <div class="mb-2"><strong>Role:</strong> {{ $auditTrail->user_role ?? '-' }}</div>
                                    <div class="mb-2"><strong>Modul:</strong> {{ $auditTrail->module ?? '-' }}</div>
                                    <div class="mb-2"><strong>Event:</strong> {{ $auditTrail->event ?? '-' }}</div>
                                    <div class="mb-2"><strong>Referensi:</strong> {{ $auditTrail->reference_no ?? '-' }}</div>
                                    <div class="mb-2"><strong>Subject:</strong> {{ $auditTrail->subject ?? '-' }}</div>
                                    <div class="mb-2"><strong>Method:</strong> {{ $auditTrail->method ?? '-' }}</div>
                                    <div class="mb-2"><strong>Route:</strong> {{ $auditTrail->route_name ?? '-' }}</div>
                                    <div class="mb-2"><strong>IP:</strong> {{ $auditTrail->ip_address ?? '-' }}</div>
                                    <div class="mb-0">
                                        <strong>URL:</strong>
                                        <span class="text-break">{{ $auditTrail->url ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="border rounded-3 p-3 mb-3 bg-white">
                                    <h6 class="mb-2">Deskripsi</h6>
                                    <p class="mb-0">{{ $auditTrail->description ?? '-' }}</p>
                                </div>

                                @php
                                    $oldValues = is_array($auditTrail->old_values) ? $auditTrail->old_values : [];
                                    $newValues = is_array($auditTrail->new_values) ? $auditTrail->new_values : [];
                                    $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                                @endphp

                                <div class="border rounded-3 p-3 mb-3 bg-white">
                                    <h6 class="mb-3">Ringkasan Perubahan</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 25%;">Field</th>
                                                    <th style="width: 37.5%;">Nilai Lama</th>
                                                    <th style="width: 37.5%;">Nilai Baru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($allKeys as $key)
                                                    <tr>
                                                        <td class="fw-semibold">{{ $key }}</td>
                                                        <td style="white-space: pre-wrap; word-break: break-word;">
                                                            {{ is_array($oldValues[$key] ?? null)
                                                                ? json_encode($oldValues[$key], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                                                                : var_export($oldValues[$key] ?? null, true) }}
                                                        </td>
                                                        <td style="white-space: pre-wrap; word-break: break-word;">
                                                            {{ is_array($newValues[$key] ?? null)
                                                                ? json_encode($newValues[$key], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                                                                : var_export($newValues[$key] ?? null, true) }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted py-3">
                                                            Tidak ada perubahan yang tercatat.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3 h-100 bg-white">
                                            <h6>Old Values</h6>
                                            <pre class="audit-json mb-0">{{ json_encode($auditTrail->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3 h-100 bg-white">
                                            <h6>New Values</h6>
                                            <pre class="audit-json mb-0">{{ json_encode($auditTrail->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .audit-json {
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 420px;
            overflow: auto;
            font-size: 12px;
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px;
        }
    </style>
@endsection