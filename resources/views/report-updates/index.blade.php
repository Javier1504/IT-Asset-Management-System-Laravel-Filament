@extends('layouts.admin')

@section('title', 'Laporan Update')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Laporan Update</h4>
            <div class="text-muted">
                Rekap data update dari fitur Management License & Software dan Penawaran Aset.
            </div>
        </div>

        <a href="{{ route('report-updates.export', request()->query()) }}" class="btn btn-success">
            Export Excel
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Data</div>
                    <div class="fs-4 fw-bold">{{ $summary['total'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        @if ($reportType === 'asset_offer')
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Open</div>
                        <div class="fs-4 fw-bold">{{ $summary['open'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Selected</div>
                        <div class="fs-4 fw-bold">{{ $summary['selected'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Closed</div>
                        <div class="fs-4 fw-bold">{{ $summary['closed'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Aktif</div>
                        <div class="fs-4 fw-bold">{{ $summary['active'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Akan Expired</div>
                        <div class="fs-4 fw-bold">{{ $summary['expiring_soon'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Expired</div>
                        <div class="fs-4 fw-bold">{{ $summary['expired'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('report-updates.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Jenis Laporan</label>
                    <select name="report_type" class="form-select" onchange="this.form.submit()">
                        @foreach ($reportTypes as $value => $label)
                            <option value="{{ $value }}" @selected($reportType === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Keyword</label>
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        value="{{ $keyword }}"
                        placeholder="Cari data..."
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($status === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="date_from"
                        class="form-control"
                        value="{{ $dateFrom }}"
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input
                        type="date"
                        name="date_to"
                        class="form-control"
                        value="{{ $dateTo }}"
                    >
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('report-updates.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($reportType === 'asset_offer')
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No</th>
                                <th>Nomor Request</th>
                                <th>Nama Item</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Estimasi Budget</th>
                                <th>Tanggal Dibutuhkan</th>
                                <th>PIC</th>
                                <th>Vendor Offer</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $index }}</td>

                                    <td>
                                        <strong>{{ $item->request_number ?? '-' }}</strong>
                                    </td>

                                    <td>{{ $item->item_name ?? '-' }}</td>

                                    <td>{{ $item->category_label ?? '-' }}</td>

                                    <td>{{ $item->quantity ?? 0 }}</td>

                                    <td>
                                        Rp {{ number_format((float) $item->estimated_total_budget, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ optional($item->needed_date)->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        <div>{{ $item->pic_name ?? '-' }}</div>
                                        @if ($item->pic_email)
                                            <small class="text-muted">{{ $item->pic_email }}</small>
                                        @endif
                                    </td>

                                    <td>{{ $item->vendor_offers_count ?? 0 }}</td>

                                    <td>
                                        <span class="badge {{ $item->status_badge_class }}">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">
                                        Data penawaran aset tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No</th>
                                <th>Software</th>
                                <th>Kategori</th>
                                <th>Vendor</th>
                                <th>Tipe Lisensi</th>
                                <th>Lisensi</th>
                                <th>Expired</th>
                                <th>Reminder</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $index }}</td>

                                    <td>
                                        <strong>{{ $item->software_name ?? '-' }}</strong>
                                    </td>

                                    <td>{{ $item->category_label ?? '-' }}</td>

                                    <td>{{ $item->vendor_name ?? '-' }}</td>

                                    <td>{{ $item->license_type_label ?? '-' }}</td>

                                    <td>
                                        <strong>{{ $item->used_license ?? 0 }}</strong> / {{ $item->total_license ?? 0 }}
                                        <br>
                                        <small class="text-muted">
                                            Sisa: {{ $item->remaining_license ?? 0 }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ optional($item->expired_date)->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ optional($item->renewal_reminder_date)->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        <div>{{ $item->pic_name ?? '-' }}</div>
                                        @if ($item->pic_email)
                                            <small class="text-muted">{{ $item->pic_email }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge {{ $item->status_badge_class }}">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">
                                        Data license software tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="p-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
@endsection