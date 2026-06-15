@extends('layouts.admin')

@section('title', 'Page Detail User')

@section('content')

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Data
                                        Pegawai</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data Pegawai</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 p-2"> <!-- Gunakan p-4 agar padding seragam -->

                    <div
                        class="card-header d-flex gap-2 align-items-center justify-content-between flex-wrap bg-white border-light-subtle px-3 py-3 rounded-top-4 border-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="ratio ratio-1x1" style="width: 42px; min-width: 42px;">
                                <span class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                                    <i class="sym sym-shopping-bag-solid"></i>
                                </span>
                            </div>
                            <div class="d-block ms-1">
                                <h5 class="m-0">Informasi Pegawai</h5>
                                <span class="fs-6 text-secondary">Informasi detail data pegawai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Aset -->
                    <div class="col-12 px-3 py-3"> <!-- Samakan padding dengan header -->
                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Nama</span>
                                </div>
                                <span class="mb-2">{{ $user->name_karyawan }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Tanggal Masuk</span>
                                </div>
                                <span class="mb-2">{{ $user->tanggal_masuk }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Alamat</span>
                                </div>
                                <span class="mb-2">{{ $user->alamat }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Email</span>
                                </div>
                                <span class="mb-2">{{ $user->email }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Corporate Email</span>
                                </div>
                                <span class="mb-2">{{ $user->corporate_email }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Status Pegawai</span>
                                </div>
                                @switch($user->status_karyawan)
                                    @case('Kontrak')
                                        <span
                                            class="badge text-primary bg-primary bg-opacity-10 border border-primary">Kontrak</span>
                                    @break

                                    @case('Tetap')
                                        <span class="badge text-success bg-success bg-opacity-10 border border-success">Tetap</span>
                                    @break

                                    @case('Onboard')
                                        <span class="badge text-info bg-info bg-opacity-10 border border-info">Onboard</span>
                                    @break

                                    @case('Magang')
                                        <span
                                            class="badge text-warning bg-warning bg-opacity-10 border border-warning">Magang</span>
                                    @break

                                    @case('Dosen Kontrak')
                                        <span class="badge text-danger bg-danger bg-opacity-10 border border-danger">Dosen
                                            Kontrak</span>
                                    @break

                                    @case('Dosen Magang')
                                        <span class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dosen
                                            Magang</span>
                                    @break

                                    @default
                                        <span>{{ $user->status_karyawan }}</span>
                                @endswitch
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Job Role</span>
                                </div>
                                <span class="mb-2">{{ $user->job_role ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Job Family</span>
                                </div>
                                <span class="mb-2">{{ $user->job_family ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Team</span>
                                </div>
                                <span class="mb-2">{{ $user->team ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-1 justify-content-between">
                                    <span class="text-muted">Company</span>
                                </div>
                                <span class="mb-2">{{ $user->company ?? '-' }}</span>
                            </div>
                            <div class="col-12">
                                <hr class="my-1">
                                <span class="text-muted d-block mb-2">Set Company ID</span>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif
                                <form action="{{ route('users.updateCompany', $user->id) }}" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                                    @csrf
                                    @method('PATCH')
                                    <select name="company_id" class="form-select w-auto @error('company_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Company --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Data Aset Yang Sedang Dipegang</h4>
                        {{-- Search Form --}}
                        <form method="GET" class="mt-4">
                            <input type="hidden">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari.."
                                        value="{{ request('search') }}" autocomplete="off">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th>No</th>
                                        <th>Jenis Aset</th>
                                        <th>Merk Aset</th>
                                        <th>Spesifikasi</th>
                                        <th>Nomor Aset</th>
                                        <th>Klasifikasi Laptop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($userAsets as $aset)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $aset->aset->jenisAset->name_jenis ?? '-' }}</td>
                                            <td>{{ $aset->aset->merk_aset ?? '-' }}</td>
                                            <td>{{ $aset->aset->spesifikasi_aset ?? '-' }}</td>
                                            <td>{{ $aset->aset->nomor_aset ?? '-' }}</td>
                                            <td>{{ $aset->klasifikasiLaptop->klasifikasi_laptop ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada aset yang dipegang
                                                saat ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    @section('footer')
        <p></p>
    @endsection

@endsection
