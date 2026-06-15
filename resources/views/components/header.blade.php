<header class="qn-header z-2 sticky-top">
    <div class="qn-header-pattern p-md-3 py-3 px-xl-5 bg-primary text-white">
        <div class="container-fluid">
            <div class="d-flex flex-wrap flex-nowrap align-items-center justify-content-start">
                <div class="d-flex gap-2 gap-md-3 align-items-center">
                    <button class="btn btn-icon btn-lg btn-light rounded-1 bg-transparent text-white d-block d-lg-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="sym sym-menu-03"></i>
                    </button>
                    <a href="#"
                        class="qn-identity d-flex align-items-center link-body-emphasis text-decoration-none rounded-3 bg-white">
                        <img class="img-fluid w-auto h-100 object-fit-contain"
                            src="https://quantum.sevima.com/s/storybook-static/assets/logo-kampus-h-zGziEp.webp"
                            alt="Example Campus Logo" />
                    </a>
                    <div class="d-flex flex-column">
                        <span>ITAM | SENTINELS</span>
                        <h5 class="m-0">IT Asset Management</h5>
                    </div>
                </div>
                <div class="ms-auto d-flex align-items-center gap-1">
                    <div class="d-none d-md-flex align-items-center gap-1">
                        <!-- [START REDUNDANT CONTENT] Header Action (fmt. 1) -->
                        <a href="#" class="btn btn-light p-2 py-1 bg-transparent text-white border-0 me-1"
                            aria-label="Notifikasi">
                            <i class="sym sym-bell"></i>
                        </a>
                        <a href="#" class="btn btn-light p-2 py-1 bg-transparent text-white border-0 me-1"
                            aria-label="Bantuan">
                            <i class="sym sym-help-circle"></i>
                        </a>
                        <!-- [END REDUNDANT CONTENT] Header Action (fmt. 1) -->
                        <a href="#" class="btn btn-light p-2 py-1 bg-transparent text-white border-0"
                            aria-label="Pindah Modul">
                            <i class="sym sym-dots-grid-solid"></i>
                            <span class="d-none d-lg-inline-block ms-2">Module</span>
                        </a>
                    </div>
                    <hr class="d-none d-md-block vr mx-2" />
                    <!-- [START REDUNDANT CONTENT] Header Avatar Group (fmt. 1) -->
                    <div class="dropdown d-none d-md-block rounded-4 bg-white text-black p-1">
                        <a href="#"
                            class="d-flex gap-1 align-items-center link-body-emphasis text-decoration-none dropdown-toggle pe-1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://quantum.sevima.com/s/storybook-static/assets/profile-picture-DLXSk8tp.webp"
                                alt="mdo" width="32" height="32" class="rounded-4" />
                            <span class="qn-avatar-name d-none d-lg-block text-truncate">
                                Aditya Kara
                            </span>
                        </a>
                        <ul class="dropdown-menu pt-0 text-small" style="width: 296px;">
                            <li>
                                <div class="d-flex flex-column gap-2 p-3 py-4 pb-3 text-nowrap">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://quantum.sevima.com/s/storybook-static/assets/profile-picture-DLXSk8tp.webp"
                                            alt="mdo" width="56" height="56" class="rounded-4" />
                                        <div class="d-block">
                                            <h6 class="mb-1">Aditya Kara</h6>
                                            <span class="text-muted">Administrator</span>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <span class="text-muted m-0 fw-bold">Penyimpanan</span>
                                        <div class="progress mt-1" role="progressbar" aria-label="Basic example"
                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="height: .25rem;">
                                            <div class="progress-bar" style="width: 54%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item d-flex flex-nowrap justify-content-between" href="#">
                                    Ganti Role
                                    <i class="sym sym-refresh-ccw-02"></i>
                                </a>
                            </li>
                            <li class="d-block d-md-none">
                                <a class="dropdown-item" href="#">Pindah Modul</a>
                            </li>
                            <li class="d-block d-md-none">
                                <a class="dropdown-item" href="#">Notifikasi</a>
                            </li>
                            <li><a class="dropdown-item" href="#">Pengaturan Akun</a></li>
                            <li><a class="dropdown-item" href="#">Media Library</a></li>
                            <li><a class="dropdown-item" href="#">Upgrade PRO</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="sym sym-translate me-2"></i>
                                    Bahasa Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="sym sym-help-circle-solid me-2"></i>
                                    Bantuan
                                </a>
                            </li>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="sym sym-arrow-left-solid me-2"></i>
                                    Keluar
                                </button>
                            </form>
                        </ul>
                    </div>
                    <!-- [END REDUNDANT CONTENT] Header Avatar Group (fmt. 1) -->

                    <!-- [START REDUNDANT CONTENT] Header Avatar Group (fmt. 2) -->
                    <div class="d-block d-md-none rounded-4 bg-white text-black p-1">
                        <a href="#avatarModal"
                            class="d-flex gap-1 align-items-center link-body-emphasis text-decoration-none dropdown-toggle pe-1"
                            data-bs-toggle="modal">
                            <img src="https://quantum.sevima.com/s/storybook-static/assets/profile-picture-DLXSk8tp.webp"
                                alt="mdo" width="32" height="32" class="rounded-4" />
                            <span class="qn-avatar-name d-none d-lg-block text-truncate">
                                Aditya Kara
                            </span>
                        </a>
                    </div>
                    <!-- [END REDUNDANT CONTENT] Header Avatar Group (fmt. 2) -->
                </div>
            </div>
        </div>
    </div>
    <div class="p-md-3 py-md-0 px-xl-5 border-bottom shadow-sm bg-white">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg p-0 bg-white">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="w-100 navbar-nav py-1 gap-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active text-primary' : '' }}"aria-current="page"
                                href="/dashboard">Beranda</a>
                        </li>

                        @can('akses-admin-superadmin')
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ request()->is('asets') ? 'active text-primary' : '' }} dropdown-toggle"
                                    href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Aset</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('asets.index') }}">Data Aset</a></li>
                                    <li><a class="dropdown-item" href="{{ route('aset-maintenance.index') }}">Aset
                                            Maintenance</a></li>
                                    {{-- <li><hr class="dropdown-divider" /></li>
                  <li><a class="dropdown-item" href="#">Buat Form BAST</a></li>
                  <li><a class="dropdown-item" href="#">Buat Form BAA</a></li>
                  <li><a class="dropdown-item" href="#">Buat Form PO</a></li>
                  <li><hr class="dropdown-divider" /></li>
                  <li><a class="dropdown-item" href="#">Report Data Aset</a></li>
                  <li><a class="dropdown-item" href="#">Export Data Aset</a></li>
                  <li><a class="dropdown-item" href="#">Summary Data Aset</a></li> --}}
                                </ul>
                            </li>
                        @endcan


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Data Pegawai
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">Data Pegawai</a></li>
                            </ul>
                        </li>

                        @can('manager')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Permintaan
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('request-aset.index') }}">Request Aset</a>
                                    </li>
                                    {{-- <li><a class="dropdown-item" href="#">Request PO</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a> --}}
                            </li>
                        </ul>
                        </li>
                    @endcan

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Pengaturan
                        </a>
                        <ul class="dropdown-menu">
                            @can('akses-admin-superadmin')
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}">Jenis Aset</a></li>
                                <li><a class="dropdown-item" href="{{ route('role-aset.index') }}">Klasifikasi Aset</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                            @endcan
                            @can('akses-admin-superadmin')
                                <li><a class="dropdown-item" href="{{ route('users.indexRoleUser') }}">Role Akses User</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
