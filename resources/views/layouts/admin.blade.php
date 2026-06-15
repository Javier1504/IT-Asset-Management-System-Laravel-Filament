<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="your-meta-description">
    <meta name="keywords" content="your-meta-keywords">
    <meta name="author" content="type-author">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/logo-sevima.png') }}" type="image/png">

    <!-- [START] Stylesheet -->
    <link rel="stylesheet" href="/vendor/@quantum_web-3.0.0/dist/css/quantum.min.css">
    <link rel="stylesheet" href="/vendor/@quantum_symbols-1.0.0/symbols/font/quantum-symbols.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- [END] Stylesheet -->

    <title>IT Asset Management | @yield('title')</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .main-flex-wrapper {
            flex: 1;
            overflow: hidden;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            height: 100%;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: sticky;
            bottom: 0;
            width: 100%;
        }
    </style>
    @stack('styles')
</head>


<body>
    <div class="main-container d-flex flex-column min-vh-100">

        <!-- [START] Header -->
        <header class="qn-header z-4">
            <div class="qn-header-pattern p-md-3 py-3 px-xl-5 bg-primary text-white">
                <div class="container-fluid">
                    <div class="d-flex flex-wrap flex-nowrap align-items-center justify-content-start">
                        <div class="d-flex gap-2 gap-md-3 align-items-center">
                            <button
                                class="btn btn-icon btn-lg btn-light rounded-1 bg-transparent text-white d-block d-lg-none"
                                type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="sym sym-menu-03"></i>
                            </button>
                            <a href="#"
                                class="qn-identity d-flex align-items-center link-body-emphasis text-decoration-none rounded-3 bg-white">

                                <img class="img-fluid w-auto h-100 object-fit-contain"
                                    src="{{ asset('assets/images/logo-sevima.png') }}" alt="Logo Kampus">

                            </a>
                            <div class="d-flex flex-column">
                                <span>IT Asset Management</span>
                                <h5 class="m-0">SEVIMA</h5>
                            </div>
                        </div>
                        <div class="ms-auto d-flex align-items-center gap-1">
                            @if (isset($userCompanies) && $userCompanies->count() > 1)
                                <!-- Company Switcher Dropdown -->
                                <div class="dropdown d-none d-md-block">
                                    <button
                                        class="btn btn-sm btn-light rounded-3 d-flex align-items-center gap-2 dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="sym sym-building-06" style="font-size: 18px;"></i>
                                        <span class="d-inline-block text-truncate" style="max-width: 120px;">
                                            {{ session('active_company_name', 'Pilih Company') }}
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
                                        <li>
                                            <h6 class="dropdown-header">Ganti Company</h6>
                                        </li>
                                        @foreach ($userCompanies as $comp)
                                            <li>
                                                <form method="POST" action="{{ route('company.switch') }}">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{ $comp->id }}">
                                                    <input type="hidden" name="_redirect"
                                                        value="{{ route('dashboard.dashboard') }}">
                                                    <button type="submit"
                                                        class="dropdown-item d-flex align-items-center gap-2 {{ session('active_company_id') == $comp->id ? 'active' : '' }}">
                                                        <i class="sym sym-building-06" style="font-size: 16px;"></i>
                                                        <span class="text-truncate">{{ $comp->name }}</span>
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- Mobile Company Switcher -->
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-sm btn-light rounded-3 btn-icon" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="sym sym-building-06" style="font-size: 18px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
                                        <li>
                                            <h6 class="dropdown-header">Ganti Company</h6>
                                        </li>
                                        @foreach ($userCompanies as $comp)
                                            <li>
                                                <form method="POST" action="{{ route('company.switch') }}">
                                                    @csrf
                                                    <input type="hidden" name="company_id"
                                                        value="{{ $comp->id }}">
                                                    <input type="hidden" name="_redirect"
                                                        value="{{ route('dashboard.dashboard') }}">
                                                    <button type="submit"
                                                        class="dropdown-item d-flex align-items-center gap-2 {{ session('active_company_id') == $comp->id ? 'active' : '' }}">
                                                        <i class="sym sym-building-06" style="font-size: 16px;"></i>
                                                        <span class="text-truncate">{{ $comp->name }}</span>
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @elseif(isset($activeCompany))
                                <!-- Single company display -->
                                <div class="d-none d-md-flex align-items-center gap-2 text-white">
                                    <i class="sym sym-building-06" style="font-size: 18px;"></i>
                                    <span class="d-inline-block text-truncate"
                                        style="max-width: 120px;">{{ $activeCompany->name }}</span>
                                </div>
                            @endif

                            <!-- Notification Dropdown -->
                            @include('notifications.partials.dropdown')

                            <hr class="d-none d-md-block vr mx-2" />
                            <!-- [START REDUNDANT CONTENT] Header Avatar Group (fmt. 1) -->
                            <div class="dropdown d-none d-md-block rounded-4 bg-white text-black p-1"
                                style="z-index: 100">
                                <a href="#"
                                    class="d-flex gap-1 align-items-center link-body-emphasis text-decoration-none dropdown-toggle pe-1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>

                                    <span class="d-inline-block text-truncate" style="max-width: 80px;">
                                        {{ $loggedInUser->username ?? 'Guest' }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu pt-0 text-small" style="width: 260px;">
                                    <li>
                                        <div class="d-flex flex-column gap-2 p-3 py-4 pb-3 text-nowrap">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>
                                                <div class="d-block">
                                                    <h6 class="mb-1 text-truncate" style="max-width: 150px;">
                                                        {{ $loggedInUser->username ?? 'Guest' }}
                                                    </h6>
                                                    <span class="text-muted text-truncate" style="max-width: 150px;">
                                                        {{ $loggedInUser->role ?? 'Unknown Role' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <a href="{{ route('auth.logout') }}"
                                            class="list-group-item list-group-item-action text-danger rounded-3 border-0 px-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="sym sym-arrow-left-solid" style="font-size: 20px;"></i>
                                                <span>Keluar</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Mobile version -->
                            <div class="d-block d-md-none rounded-4 bg-white text-black p-1">
                                <a href="#avatarModal"
                                    class="d-flex gap-1 align-items-center link-body-emphasis text-decoration-none dropdown-toggle pe-1"
                                    data-bs-toggle="modal">
                                    <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>

                                    <span class="qn-avatar-name d-none d-lg-block text-truncate"
                                        style="max-width: 150px;">
                                        {{ $loggedInUser->username ?? 'Guest' }}
                                    </span>
                                </a>
                            </div>

                            <!-- [END REDUNDANT CONTENT] Header Avatar Group (fmt. 2) -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-md-3 py-md-0 px-xl-5 border-bottom shadow-sm bg-white position-relative"
                style="z-index: 50;">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg p-0 bg-white">
                        <div class="collapse navbar-collapse" id="navbarNav">

                            <ul
                                class="w-100 navbar-nav py-1 gap-2 gap-lg-0 align-items-lg-center justify-content-start">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('dashboard') ? 'active text-primary' : '' }}"
                                        aria-current="page" href="/dashboard">Beranda</a>
                                </li>

                                <!-- Dropdown Aset -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Aset Saya</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('aset-karyawan') }}">Data Aset
                                                Saya
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                @can('finance')
                                    <!-- Dropdown Aset -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link {{ request()->is('asets') ? 'active text-primary' : '' }} dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">Aset</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('end-user-aset.index') }}">End-User
                                                    Aset</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('physical-host-aset.index') }}">Physical Host</a></li>
                                            <li><a class="dropdown-item" href="{{ route('office-aset.index') }}">Office
                                                    Aset</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('security-peripheral.index') }}">Security
                                                    Peripheral</a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('aset-hibah.index') }}">Aset
                                                    Hibah</a></li>
                                        </ul>
                                    </li>
                                @endcan

                                @can('akses-karyawan-manager-finance')
                                    <!-- Dropdown Aset -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">Aset Pribadi</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('aset-pribadi.index') }}">Aset
                                                    Pribadi Saya</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('aset-pribadi-request') }}">Ajukan Penggunaan Aset
                                                    Pribadi</a></li>
                                        </ul>
                                    </li>
                                @endcan

                                <!-- Dropdown Permintaan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Permintaan</a>
                                    <ul class="dropdown-menu">
                                        @can('akses-admin-superadmin-manager')
                                            <li><a class="dropdown-item"
                                                    href="{{ route('aset-request.my-requests') }}">Ajukan Permintaan</a>
                                            </li>
                                        @endcan
                                        @can('akses-karyawan-finance')
                                            <li><a class="dropdown-item"
                                                    href="{{ route('aset-request.my-requests') }}">Permintaan Aset</a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>

                                @can('akses-admin-superadmin-finance')
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">Laporan</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('report.depreciation') }}">Penyusutan Aset</a></li>

                                        </ul>
                                    </li>
                                @endcan
                                <!-- Dropdown Tanda Tangan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Tanda Tangan</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <h1 class="dropdown-header">Berita Acara</h1>
                                        </li>

                                        <li><a class="dropdown-item"
                                                href="{{ route('daftar-tanda-tangan.bast') }}">BA Serah Terima</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('daftar-tanda-tangan.bastPengembalian') }}">BA
                                                Pengembalian Aset</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('bast-persetujuan-asetpribadi.index') }}">BA
                                                Persetujuan Aset Pribadi</a></li>
                                        @if ($isPemusnahanUser)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pemusnahan-aset.index') }}">
                                                    BA Pemusnahan Aset
                                                </a>
                                            </li>
                                        @endif
                                        @can('finance')
                                            <li><a class="dropdown-item"
                                                    href="{{ route('daftar-tanda-tangan.babp') }}">BA
                                                    Bukti Pembelian</a></li>
                                            <!-- Link ini akan mengarah ke route babp.index dengan query parameter from=tandatangan -->
                                        @endcan
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>

                                        <li>
                                            <h1 class="dropdown-header">Form</h1>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('daftar-tanda-tangan.maintenance') }}">Form
                                                Pemeliharaan Aset</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('daftar-tanda-tangan.PencabutanAsetpribadi') }}">Form
                                                Pencabutan Aset Pribadi</a></li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- [END] Header -->

        <!-- [START REDUNDANT CONTENT] Header Avatar Group (fmt. 3) -->
        <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="avatarModalLabel">
                            {{ $loggedInUser->username ?? 'Guest' }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div class="list-group">
                            <div class="d-flex flex-column gap-2 p-3 pb-3 text-nowrap">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="sym sym-user-circle-solid" style="font-size: 32px;"></i>

                                    <div class="d-block">
                                        <h6 class="mb-1">{{ $loggedInUser->username ?? 'Guest' }}</h6>
                                        <span class="text-muted">
                                            {{ $loggedInUser->role ?? 'Unknown Role' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('auth.logout') }}"
                                class="list-group-item list-group-item-action text-danger rounded-3 border-0 px-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="sym sym-arrow-left-solid" style="font-size: 20px;"></i>
                                    <span>Keluar</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="d-flex flex-grow-1 main-flex-wrapper">
            <!-- Sidebar -->
            @can('akses-admin-superadmin')
                @include('layouts.sidebar')
            @endcan
            <!-- Main Content -->
            <div class="content bg-body-tertiary flex-grow-1"
                style="min-width: 0; transition: all .25s cubic-bezier(.4,0,.2,1);">
                @yield('content')
            </div>
        </div>

        @if (trim($__env->yieldContent('footer')))
            <!-- Footer -->
            <div class="container-fluid mt-auto bg-white border-top">
                <footer
                    class="d-flex flex-column-reverse flex-lg-row flex-wrap justify-content-center justify-content-lg-between align-items-center py-1 py-md-3 gap-3 bg-white">
                    <div class="d-flex gap-2 align-items-center">
                        <a href="#"
                            class="d-none d-md-block mb-md-0 text-body-secondary text-decoration-none lh-1">
                            <img src="data:image/webp;base64,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"
                                class="w-auto" height="18" alt="Logo SEVIMA" />
                        </a>
                        <span class="mb-0 fs-7 text-body-tertiary">
                            © 2005-2023 SEVIMA. All Rights Reserved
                        </span>
                    </div>
                </footer>
            </div>
        @endif
        {{-- </main> --}}
        <!-- [END] Main -->
    </div>
    <script src="/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/@quantum_web-3.0.0/dist/js/quantum.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    @if (request()->is('dashboard'))
        @include('components.chatbot-widget')
    @endif
</body>

</html>
