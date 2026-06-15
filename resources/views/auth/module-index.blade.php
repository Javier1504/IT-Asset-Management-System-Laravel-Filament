@extends('layouts.app')
@section('title', 'Pilih Company')
@section('content')
    <main class="qn-main-module"
        style="--qn-main-module-background: url('{{ asset('assets/images/foto-kantor.png') }}')">
        <div class="container d-flex min-vh-100 py-3">
            <div class="card w-100 rounded-3 m-auto" style="max-width: 40rem; min-height: 542px;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9 d-flex align-items-center gap-2">
                            <div class="p-1 rounded-4 bg-light-subtle h-auto" style="width: 3.5rem; max-height: 3.5rem;">
                                <img class="w-100 h-100 object-fit-contain"
                                    src="{{ asset('assets/images/logo-sevima.png') }}" alt="Logo Kampus">
                            </div>
                            <div class="d-flex flex-column">
                                <p class="m-0 text-secondary">ITAM</p>
                                <div class="fs-5 fw-semibold">IT Aset Management</div>
                            </div>
                        </div>
                        <div class="col-3 d-flex">
                            <div class="dropdown rounded-4 bg-white text-black p-1 my-auto">
                                <a href="#"
                                    class="d-flex gap-1 align-items-center link-body-emphasis text-decoration-none dropdown-toggle pe-1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>
                                    <span class="qn-avatar-name d-none d-md-block text-truncate">
                                        {{ auth()->user()->name_karyawan ?? 'User' }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end pt-0 text-small">
                                    <li>
                                        <div class="d-flex flex-column gap-2 p-3 py-4 pb-3 text-nowrap">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>
                                                <div class="d-block">
                                                    <h6 class="mb-1">{{ auth()->user()->name_karyawan ?? 'User' }}</h6>
                                                    <span
                                                        class="text-muted">{{ auth()->user()->corporate_email ?? auth()->user()->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}">
                                            <i class="sym sym-arrow-left-solid me-2"></i>
                                            Keluar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4 px-4 ">
                    @if (session('alert_type'))
                        <div class="alert alert-{{ session('alert_type') }} alert-dismissible fade show mb-3"
                            role="alert">
                            <strong>{{ session('alert_title') }}</strong> {{ session('alert_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row row-cols-2 row-cols-sm-4 row-cols-md-3 align-content-center justify-content-center g-3">
                        @forelse($companies as $company)
                            <div class="col">
                                <form method="POST" action="{{ route('company.switch') }}">
                                    @csrf
                                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                                    <button type="submit"
                                        class="btn w-100 d-flex flex-column align-items-center justify-content-center gap-2 border rounded-4 shadow-sm py-4" style="min-height: 180px;">
                                        <div class="w-100 ratio ratio-1x1" style="max-width: 4rem;">
                                            @if ($company->logo)
                                                <img class="w-100 h-100 object-fit-contain"
                                                    src="{{ asset('storage/' . $company->logo) }}"
                                                    alt="Logo {{ $company->name }}" />
                                            @else
                                                <div
                                                    class="w-100 h-100 d-flex align-items-center justify-content-center bg-light rounded-3">
                                                    <span
                                                        class="fw-bold text-secondary fs-4">{{ substr($company->code, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="fw-medium text-center w-100" style="line-height: 1.3;">{{ $company->name }}</span>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                <p>Tidak ada organization yang tersedia. Hubungi Admin.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
