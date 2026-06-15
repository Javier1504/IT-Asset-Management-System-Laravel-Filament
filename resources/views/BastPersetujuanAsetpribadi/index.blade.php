@extends('layouts.admin')

@section('title', 'BAST Persetujuan Aset Pribadi')

@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Berita
                                        Acara</a></li>
                                <li class="breadcrumb-item active" aria-current="page">BA Persetujuan Aset Pribadi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0">Berita Acara Persetujuan Aset Pribadi</h4>
                        <span class="text-muted">Kelola dokumen berita acara persetujuan penggunaan aset pribadi
                            karyawan.</span>

                        <hr>

                        <form action="" id="categories">
                            <div class="row d-flex align-items-center justify-content-between gap-2">
                                <div class="col-md-3">
                                    <form>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control" name="search"
                                                    placeholder="Cari.." value="{{ request('search') }}" autocomplete="off">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 d-flex justify-content-end gap-2">
                                    @can('akses-admin-superadmin')
                                        <a href="{{ route('bast-persetujuan-asetpribadi.create') }}"
                                            class="btn btn-primary d-block d-lg-inline-block" aria-label="Tambah Data">
                                            <i class="sym sym-plus"></i> Tambah
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 200px;">Nomor Surat</th>
                                        <th style="min-width: 100px;">Tanggal</th>
                                        <th style="min-width: 200px;">Pihak Pertama</th>
                                        <th style="min-width: 200px;">Pihak Kedua</th>
                                        <th style="min-width: 80px;">Status</th>
                                        <th style="min-width: 150px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bastPersetujuanAsetpribadis as $bast)
                                        <tr>
                                            <td>{{ ($bastPersetujuanAsetpribadis->currentPage() - 1) * $bastPersetujuanAsetpribadis->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $bast->nomor_surat ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bast->tanggal)->format('d/m/Y') }}</td>
                                            <td>{{ $bast->pihakPertama->name_karyawan ?? '-' }}</td>
                                            <td>{{ $bast->pihakKedua->name_karyawan ?? '-' }}</td>
                                            <td style="text-align: center;">
                                                @if ($bast->status == 'pending')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">
                                                        Pending
                                                    </span>
                                                @elseif($bast->status == 'approved')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">
                                                        Disetujui
                                                    </span>
                                                @elseif ($bast->status == 'cancelled')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">
                                                        Dibatalkan
                                                    </span>
                                                @elseif ($bast->status == 'rejected')
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('bast-persetujuan-asetpribadi.show', $bast->id) }}"
                                                        class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Lihat Surat" title="Pertinjau Dokumen">
                                                        <i class="sym sym-eye-solid"></i>
                                                    </a>

                                                    @can('akses-admin-superadmin')
                                                        <a href="{{ route('bast-persetujuan-asetpribadi.edit', $bast->id) }}"
                                                            class="btn btn-icon btn-sm btn-outline-secondary" aria-label="Edit"
                                                            title="Edit">
                                                            <i class="sym sym-edit-solid"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Hapus" title="Hapus"
                                                            onclick="confirmDeletion({{ $bast->id }})">
                                                            <i class="sym sym-trash-solid"></i>
                                                        </button>

                                                        <form id="delete-form-{{ $bast->id }}"
                                                            action="{{ route('bast-persetujuan-asetpribadi.destroy', $bast->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center gap-3">
                                                    <i class="sym sym-folder-open"
                                                        style="font-size: 48px; color: #ccc;"></i>
                                                    <div>
                                                        <h6 class="mb-1">Tidak ada data</h6>
                                                        <p class="text-muted mb-0">Belum ada BAST Persetujuan Aset Pribadi
                                                            yang dibuat.</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted">Menampilkan</span>
                                <select class="form-select form-select-sm" style="width: auto;"
                                    onchange="window.location.href='?perPage=' + this.value + '&search={{ request('search') }}'">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <span class="text-muted">dari {{ $bastPersetujuanAsetpribadis->total() }} data</span>
                            </div>

                            <div class="d-flex">
                                {{ $bastPersetujuanAsetpribadis->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @section('footer')
        <p></p>
    @endsection

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: '{!! session('error') !!}',
                confirmButtonColor: '#d33'
            });
        @endif

        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
