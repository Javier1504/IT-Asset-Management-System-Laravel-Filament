@extends('layouts.admin')

@section('title', 'Management License & Software')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Management License & Software</h4>
            <p class="text-muted mb-0">
                Pengelolaan data software internal, lisensi, masa berlaku, PIC, dan status renewal.
            </p>
        </div>

        <a href="{{ route('software-licenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah License
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
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
            <form method="GET" action="{{ route('software-licenses.index') }}" class="row g-2">
                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari software, vendor, kategori software, jenis license, atau PIC...">
                </div>

                <div class="col-md-3">
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

                @if(request()->hasAny(['search', 'status']))
                    <div class="col-md-2 d-grid">
                        <a href="{{ route('software-licenses.index') }}" class="btn btn-outline-secondary">
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
                            <th>Software</th>
                            <th>Vendor</th>
                            <th>License</th>
                            <th>Penggunaan</th>
                            <th>Expired</th>
                            <th>Status</th>
                            <th>PIC</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($softwareLicenses as $index => $license)
                            <tr>
                                <td>{{ $softwareLicenses->firstItem() + $index }}</td>

                                <td>
                                    <strong>{{ $license->software_name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $license->category_label !== '-' ? $license->category_label : 'Tanpa kategori software' }}
                                    </small>
                                </td>

                                <td>{{ $license->vendor_name ?: '-' }}</td>

                                <td>
                                    <div>{{ $license->license_type_label }}</div>

                                    @if($license->license_key)
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($license->license_key, 30) }}
                                        </small>
                                    @else
                                        <small class="text-muted">Tanpa license key</small>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $license->used_license }}</strong> / {{ $license->total_license }}
                                    <br>
                                    <small class="text-muted">
                                        Sisa: {{ $license->remaining_license }}
                                    </small>
                                </td>

                                <td>
                                    @if($license->expired_date)
                                        {{ $license->expired_date->format('d/m/Y') }}

                                        @if($license->renewal_reminder_date)
                                            <br>
                                            <small class="text-muted">
                                                Reminder: {{ $license->renewal_reminder_date->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $license->status_badge_class }}">
                                        {{ $license->status_label }}
                                    </span>
                                </td>

                                <td>
                                    <div>{{ $license->pic_name ?: '-' }}</div>
                                    @if($license->pic_email)
                                        <small class="text-muted">{{ $license->pic_email }}</small>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('software-licenses.show', $license->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>

                                        <a href="{{ route('software-licenses.edit', $license->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteSoftwareLicenseModal"
                                                data-delete-url="{{ route('software-licenses.destroy', $license->id) }}"
                                                data-license-name="{{ $license->software_name }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada data license software.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $softwareLicenses->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSoftwareLicenseModal" tabindex="-1" aria-labelledby="deleteSoftwareLicenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteSoftwareLicenseModalLabel">
                    Konfirmasi Hapus License
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin menghapus data license ini?</p>

                <div class="border rounded p-3 bg-light">
                    <strong id="deleteLicenseName">-</strong>
                </div>

                <p class="text-muted small mt-2 mb-0">
                    Data akan dihapus dari daftar Management License & Software.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteSoftwareLicenseForm" method="POST">
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
        const deleteModal = document.getElementById('deleteSoftwareLicenseModal');

        if (!deleteModal) {
            return;
        }

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const deleteUrl = button.getAttribute('data-delete-url');
            const licenseName = button.getAttribute('data-license-name');

            const deleteForm = document.getElementById('deleteSoftwareLicenseForm');
            const deleteName = document.getElementById('deleteLicenseName');

            if (deleteForm) {
                deleteForm.setAttribute('action', deleteUrl);
            }

            if (deleteName) {
                deleteName.textContent = licenseName || '-';
            }
        });
    });
</script>
@endsection