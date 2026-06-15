@extends('layouts.admin')

@section('title', 'Penawaran Aset')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Penawaran Aset</h4>
            <p class="text-muted mb-0">
                Daftar kebutuhan aset sebagai objek utama untuk membandingkan penawaran vendor.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('asset-vendors.index') }}" class="btn btn-outline-secondary">
                List Vendor
            </a>

            <a href="{{ route('asset-offer-requests.history') }}" class="btn btn-outline-dark">
                History Pengadaan
            </a>

            <a href="{{ route('asset-offer-requests.create') }}" class="btn btn-primary">
                + Tambah Kebutuhan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('asset-offer-requests.index') }}" class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari nomor, nama aset, spesifikasi, atau PIC...">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categoryOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark">
                        Filter
                    </button>
                </div>

                @if(request()->hasAny(['search', 'category', 'status']))
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                @endif
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
                            <th>Kategori</th>
                            <th>Qty</th>
                            <th>Estimasi Budget</th>
                            <th>Penawaran Vendor</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th width="240">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($offerRequests as $index => $requestItem)
                            <tr>
                                <td>{{ $offerRequests->firstItem() + $index }}</td>

                                <td>
                                    <strong>{{ $requestItem->item_name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $requestItem->request_number ?: '-' }}
                                    </small>
                                    @if($requestItem->required_specification)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($requestItem->required_specification, 70) }}
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $requestItem->category_label }}</td>

                                <td>{{ $requestItem->quantity }}</td>

                                <td>
                                    @if($requestItem->estimated_unit_budget)
                                        <div>
                                            Rp {{ number_format((float) $requestItem->estimated_unit_budget, 0, ',', '.') }} / unit
                                        </div>
                                        <small class="text-muted">
                                            Total: Rp {{ number_format((float) $requestItem->estimated_total_budget, 0, ',', '.') }}
                                        </small>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $requestItem->vendor_offers_count }}</strong> vendor
                                </td>

                                <td>
                                    <div>{{ $requestItem->pic_name ?: '-' }}</div>
                                    @if($requestItem->pic_email)
                                        <small class="text-muted">{{ $requestItem->pic_email }}</small>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $requestItem->status_badge_class }}">
                                        {{ $requestItem->status_label }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('asset-offer-requests.show', $requestItem->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>

                                        <a href="{{ route('asset-offer-requests.edit', $requestItem->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteOfferRequestModal"
                                                data-delete-url="{{ route('asset-offer-requests.destroy', $requestItem->id) }}"
                                                data-item-name="{{ $requestItem->item_name }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada kebutuhan aset.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $offerRequests->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteOfferRequestModal" tabindex="-1" aria-labelledby="deleteOfferRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteOfferRequestModalLabel">
                    Konfirmasi Hapus Kebutuhan Aset
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin menghapus kebutuhan aset ini?</p>
                <div class="border rounded p-3 bg-light">
                    <strong id="deleteOfferRequestName">-</strong>
                </div>
                <p class="text-muted small mt-2 mb-0">
                    Data kebutuhan aset akan dihapus dari daftar Penawaran Aset.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteOfferRequestForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteOfferRequestModal');

        if (!deleteModal) {
            return;
        }

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            document.getElementById('deleteOfferRequestForm')
                .setAttribute('action', button.getAttribute('data-delete-url'));

            document.getElementById('deleteOfferRequestName')
                .textContent = button.getAttribute('data-item-name') || '-';
        });
    });
</script>
@endsection