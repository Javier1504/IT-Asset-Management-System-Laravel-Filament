@extends('layouts.admin')

@section('title', 'List Vendor Aset')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">List Vendor Aset</h4>
            <p class="text-muted mb-0">
                Daftar vendor yang dapat memberikan penawaran aset.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('asset-offer-requests.index') }}" class="btn btn-outline-secondary">
                Kembali ke Penawaran Aset
            </a>

            <a href="{{ route('asset-vendors.create') }}" class="btn btn-primary">
                + Tambah Vendor
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('asset-offer-requests.index') }}"
                   class="btn btn-outline-dark btn-sm">
                    Kebutuhan Aset
                </a>

                <a href="{{ route('asset-vendors.index') }}"
                   class="btn btn-dark btn-sm">
                    List Vendor
                </a>

                <a href="{{ route('asset-offer-requests.history') }}"
                   class="btn btn-outline-dark btn-sm">
                    History Pengadaan
                </a>
            </div>
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
            <form method="GET" action="{{ route('asset-vendors.index') }}" class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari vendor, PIC, email, telepon, kategori...">
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
                        <a href="{{ route('asset-vendors.index') }}" class="btn btn-outline-secondary">
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
                            <th>Vendor</th>
                            <th>PIC Vendor</th>
                            <th>Kontak</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vendors as $index => $vendor)
                            <tr>
                                <td>{{ $vendors->firstItem() + $index }}</td>

                                <td>
                                    <strong>{{ $vendor->vendor_name }}</strong>
                                    @if($vendor->notes)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($vendor->notes, 60) }}
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $vendor->pic_name ?: '-' }}</td>

                                <td>
                                    <div>{{ $vendor->email ?: '-' }}</div>
                                    @if($vendor->phone)
                                        <small class="text-muted">{{ $vendor->phone }}</small>
                                    @endif
                                </td>

                                <td>{{ $vendor->category_label }}</td>

                                <td>
                                    <span class="badge {{ $vendor->status_badge_class }}">
                                        {{ $vendor->status_label }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('asset-vendors.show', $vendor->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>

                                        <a href="{{ route('asset-vendors.edit', $vendor->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteVendorModal"
                                                data-delete-url="{{ route('asset-vendors.destroy', $vendor->id) }}"
                                                data-vendor-name="{{ $vendor->vendor_name }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data vendor.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteVendorModal" tabindex="-1" aria-labelledby="deleteVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteVendorModalLabel">
                    Konfirmasi Hapus Vendor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin menghapus vendor ini?</p>

                <div class="border rounded p-3 bg-light">
                    <strong id="deleteVendorName">-</strong>
                </div>

                <p class="text-muted small mt-2 mb-0">
                    Vendor yang dihapus tidak tampil lagi di daftar vendor.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteVendorForm" method="POST">
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
        const deleteModal = document.getElementById('deleteVendorModal');

        if (!deleteModal) {
            return;
        }

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const deleteUrl = button.getAttribute('data-delete-url');
            const vendorName = button.getAttribute('data-vendor-name');

            const deleteForm = document.getElementById('deleteVendorForm');
            const deleteName = document.getElementById('deleteVendorName');

            if (deleteForm) {
                deleteForm.setAttribute('action', deleteUrl);
            }

            if (deleteName) {
                deleteName.textContent = vendorName || '-';
            }
        });
    });
</script>
@endsection