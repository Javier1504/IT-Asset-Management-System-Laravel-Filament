@extends('layouts.admin')

@section('title', 'Pengaturan Company')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Pengaturan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Company</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                @if (session('alert_message'))
                    <div class="alert alert-{{ session('alert_type') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                        <strong>{{ session('alert_title') }}</strong> {{ session('alert_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-block ms-1">
                            <h4 class="m-0">Data Company</h4>
                            <span class="fs-6 text-secondary">Kelola data company beserta logo, header, dan footer.</span>
                        </div>
                        <hr>
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-3">
                            <div class="col-md-4">
                                <form method="GET" action="{{ route('company-settings.index') }}">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search"
                                                placeholder="Cari nama / kode..."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('company-settings.create') }}" class="btn btn-primary">
                                    <i class="sym sym-plus"></i> Tambah Company
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th style="width:40px;">No</th>
                                        <th>Nama Company</th>
                                        <th>Kode</th>
                                        <th style="width:90px;">Logo</th>
                                        <th style="width:110px;">Header</th>
                                        <th style="width:110px;">Footer</th>
                                        <th style="width:120px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($companies as $index => $company)
                                        <tr>
                                            <td>{{ $companies->firstItem() + $index }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td><span class="badge bg-secondary">{{ $company->code }}</span></td>
                                            <td class="text-center">
                                                @if ($company->logo_url)
                                                    <img src="{{ $company->logo_url }}" alt="Logo" class="img-thumbnail" style="max-height:48px;">
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($company->header_url)
                                                    <img src="{{ $company->header ? asset('storage/'.$company->header) : '' }}" alt="Header" class="img-thumbnail" style="max-height:48px;">
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($company->footer)
                                                    <img src="{{ asset('storage/'.$company->footer) }}" alt="Footer" class="img-thumbnail" style="max-height:48px;">
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-1 justify-content-center">
                                                    <a href="{{ route('company-settings.edit', $company->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="sym sym-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('company-settings.destroy', $company->id) }}"
                                                        onsubmit="return confirm('Yakin hapus company ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="sym sym-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">Tidak ada data company.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            {{ $companies->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
