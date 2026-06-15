@extends('layouts.admin')

@section('title', 'Detail Permintaan Aset')

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row gy-3 p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Permintaan</a>
                                </li>
                                @php
                                    $role = auth()->user()->role;
                                    $isShowUserPage = request()->routeIs('aset-request.showUser');
                                @endphp

                                {{-- Untuk admin dan superadmin: tampilkan dua link --}}
                                @if (in_array($role, ['admin', 'super_admin']))
                                    <li class="breadcrumb-item">
                                        <a
                                            href="{{ $isShowUserPage ? route('aset-request.my-requests') : route('aset-request.index') }}">
                                            {{ $isShowUserPage ? 'Ajukan Permintaan' : 'Daftar Permintaan' }}
                                        </a>
                                    </li>
                                @endif

                                {{-- Untuk manager: hanya Ajukan Permintaan --}}
                                @if ($role === 'manager')
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('aset-request.my-requests') }}">Ajukan Permintaan</a>
                                    </li>
                                @endif

                                {{-- Untuk karyawan dan finance: hanya Permintaan Aset --}}
                                @if (in_array($role, ['karyawan', 'finance']))
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('aset-request.my-requests') }}">Permintaan Aset</a>
                                    </li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>


                {{-- Grid layout --}}
                <div class="row g-3">
                    {{-- KIRI - Informasi Permintaan --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-4 d-flex flex-column">
                            <div
                                class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="m-0">Informasi Permintaan</h5>
                                    <span class="fs-6 text-secondary">Informasi Detail Permintaan</span>
                                </div>
                                @if ($asetRequest->status == 'pending')
                                    <span
                                        class="badge fs-6 text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                @elseif ($asetRequest->status == 'on_progress')
                                    <span
                                        class="badge fs-6 text-primary bg-primary bg-opacity-10 border border-primary">Diproses</span>
                                @elseif ($asetRequest->status == 'diterima')
                                    <span
                                        class="badge fs-6 text-success bg-success bg-opacity-10 border border-success">Diterima</span>
                                @elseif ($asetRequest->status == 'ditolak')
                                    <span
                                        class="badge fs-6 text-danger bg-danger bg-opacity-10 border border-danger">Ditolak</span>
                                @else
                                    <span>{{ $asetRequest->status }}</span>
                                @endif
                            </div>

                            <div class="card-body flex-grow-1">
                                <div class="row mb-2">
                                    <div class="col-md-4 text-muted">Tipe Permintaan</div>
                                    <div class="col-md-8">{{ ucfirst($asetRequest->tipe_permintaan) }} Aset</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 text-muted">Judul Permintaan</div>
                                    <div class="col-md-8">{{ $asetRequest->judul_permintaan }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 text-muted">Jenis Aset</div>
                                    <div class="col-md-8">
                                        @if ($asetRequest->tipe_permintaan === 'penambahan')
                                            {{ $asetRequest->jenis_aset ?? '-' }}
                                        @elseif ($asetRequest->tipe_permintaan === 'perubahan')
                                            {{ $asetRequest->aset->jenisAset->name_jenis ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 text-muted">Aset</div>
                                    <div class="col-md-8">
                                        @if ($asetRequest->tipe_permintaan === 'penambahan')
                                            {{ $asetRequest->nama_aset ?? '-' }}
                                        @elseif ($asetRequest->tipe_permintaan === 'perubahan')
                                            {{ $asetRequest->aset->merk_aset ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>

                                @if (request()->routeIs('aset-request.showUser'))
                                    <div class="row mb-2">
                                        <div class="col-md-4 text-muted">Nama Personil Diajukan</div>
                                        <div class="col-md-8">{{ $asetRequest->targetUser->name_karyawan }}</div>
                                    </div>
                                @endif

                                <div class="row mb-2">
                                    <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                                    <div class="col-md-8">{{ $asetRequest->tanggal_diajukan->format('d-m-Y H:i:s') }}</div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-muted">Alasan</div>
                                    <div class="col-md-8">{{ $asetRequest->alasan }}</div>
                                </div>

                                @if ($asetRequest->catatan_admin)
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div
                                                class="p-3 border-start border-4 border-primary bg-light rounded-3 shadow-sm">
                                                <div class="fw-semibold text-primary mb-1">Catatan Admin</div>
                                                <div class="text-muted small">{{ $asetRequest->catatan_admin }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            @if (request()->routeIs('aset-request.showAdmin'))
                                <div
                                    class="card-footer bg-white border-top rounded-bottom-4 px-3 py-3 d-flex justify-content-end gap-2">
                                    @if ($asetRequest->status === 'pending')
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak">
                                            Tolak Permintaan
                                        </button>
                                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#modalOnProgress">
                                            Proses Permintaan
                                        </button>
                                    @elseif ($asetRequest->status === 'on_progress')
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak">
                                            Tolak Permintaan
                                        </button>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modalSetujui">
                                            Setujui Permintaan
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary" disabled>
                                            Permintaan Selesai
                                        </button>
                                    @endif
                                </div>
                            @elseif(request()->routeIs('aset-request.showUser'))
                                @can('akses-admin-superadmin-manager')
                                    <div
                                        class="card-footer bg-white border-top rounded-bottom-4 px-3 py-3 d-flex justify-content-end gap-2">

                                        <button type="button" class="btn btn-primary"
                                            onclick="{{ $asetRequest->status === 'pending' ? "window.location='" . route('aset-request.edit', $asetRequest->id) . "'" : '' }}"
                                            {{ $asetRequest->status !== 'pending' ? 'disabled' : '' }}>
                                            Edit Permintaan
                                        </button>
                                    </div>
                                @endcan
                            @endif
                        </div>
                    </div>



                    {{-- KANAN - Info Lainnya --}}
                    <div class="col-lg-4 d-flex flex-column gap-3">
                        @if (request()->routeIs('aset-request.showAdmin'))
                            {{-- Data Pemohon --}}
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom">
                                    <h5 class="m-0">Data Pemohon</h5>
                                    <span class="fs-6 text-secondary">Data informasi yang mengajukan permintaan</span>
                                </div>
                                <div class="card-body small">
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Nama</div>
                                        <div class="col-8">{{ $asetRequest->requestedBy->name_karyawan }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Job Role</div>
                                        <div class="col-8">{{ $asetRequest->requestedBy->job_role ?? '-' }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Team</div>
                                        <div class="col-8">{{ $asetRequest->requestedBy->team ?? '-' }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Alamat</div>
                                        <div class="col-8">{{ $asetRequest->requestedBy->alamat ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Data Personil --}}
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom">
                                    <h5 class="m-0">Data Personil Yang Diajukan</h5>
                                    <span class="fs-6 text-secondary">Data informasi personil yang diajukan</span>
                                </div>
                                <div class="card-body small">
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Nama</div>
                                        <div class="col-8">{{ $asetRequest->targetUser->name_karyawan }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Job Role</div>
                                        <div class="col-8">{{ $asetRequest->targetUser->job_role ?? '-' }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Team</div>
                                        <div class="col-8">{{ $asetRequest->targetUser->team ?? '-' }}</div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-4 text-muted">Alamat</div>
                                        <div class="col-8">{{ $asetRequest->targetUser->alamat ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (request()->routeIs('aset-request.showUser'))
                            @php
                                $statusSekarang = $asetRequest->status;

                                // Mapping status ke indeks step keberapa (0 = dibuat, 1 = menunggu, 2 = selesai)
                                $statusToStep = [
                                    'pending' => 1,
                                    'on_progress' => 2,
                                    'diterima' => 3,
                                    'ditolak' => 3,
                                ];

                                // Cek dulu isi status
                                $currentStep = $statusToStep[$statusSekarang] ?? 0;

                                // Langkah-langkah visual
                                $statusSteps = ['Permintaan dibuat', 'Menunggu Persetujuan', 'Diterima/Ditolak'];
                                // Ubah label terakhir sesuai status
                                if ($statusSekarang === 'diterima') {
                                    $statusSteps[2] = 'Permintaan Diterima';
                                } elseif ($statusSekarang === 'ditolak') {
                                    $statusSteps[2] = 'Permintaan Ditolak';
                                } elseif ($statusSekarang === 'on_progress') {
                                    $statusSteps[2] = 'Permintaan Sedang Diproses';
                                }
                            @endphp

                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom">
                                    <h5 class="m-0">Status Permintaan</h5>
                                    <span class="fs-6 text-secondary">Pantau info terkini permintaanmu sampai mana</span>
                                </div>
                                <div class="card-body small">
                                    <div class="d-flex flex-column gap-3 position-relative ps-3">

                                        @foreach ($statusSteps as $index => $label)
                                            <div class="d-flex align-items-start position-relative">
                                                <div class="position-relative me-3 mt-1">
                                                    @if ($index < $currentStep)
                                                        <span class="bg-primary rounded-circle d-inline-block"
                                                            style="width:16px; height:16px;"></span>
                                                    @elseif ($index === $currentStep)
                                                        <span class="border border-primary rounded-circle d-inline-block"
                                                            style="width:16px; height:16px;"></span>
                                                    @else
                                                        <span class="bg-secondary rounded-circle d-inline-block"
                                                            style="width:16px; height:16px; opacity: 0.3;"></span>
                                                    @endif

                                                    @if ($index < count($statusSteps) - 1)
                                                        <div
                                                            style="position: absolute; left: 7px; top: 16px; height: 32px; width: 2px; background-color: #ccc;">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="{{ $index <= $currentStep ? 'text-dark' : 'text-muted' }}">
                                                    {{ $label }}
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Lampiran --}}
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-white px-3 py-3 rounded-top-4 border-bottom">
                                <h5 class="m-0">Lampiran</h5>
                                <span class="fs-6 text-secondary">Dokumen pendukung Anda</span>
                            </div>
                            <div class="card-body">
                                @php
                                    $lampiran = $asetRequest->lampiran ? json_decode($asetRequest->lampiran, true) : [];
                                @endphp

                                @if (!empty($lampiran))
                                    <ul class="list-unstyled small mb-0">
                                        @foreach ($lampiran as $file)
                                            <li class="mb-2">
                                                <i class="sym sym-attachment"></i>
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                    class="text-decoration-underline">
                                                    {{ pathinfo($file, PATHINFO_BASENAME) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">Tidak ada lampiran yang disertakan.</p>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>

                {{-- Comments Section --}}
                <x-comments-section 
                    :commentable-type="'App\Models\AsetRequest'" 
                    :commentable-id="$asetRequest->id"
                    :comments="$asetRequest->comments ?? collect([])"
                />

            </div>
        </div>
    </main>

    <!-- Modal Tolak -->
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('aset-request.prosesHasilAdmin', $asetRequest->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Tolak Permintaan Aset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="catatan_admin_tolak" class="form-label">Catatan Admin (Opsional)</label>
                            <textarea name="catatan_admin" id="catatan_admin_tolak" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal On Progress --}}

    <div class="modal fade" id="modalOnProgress" tabindex="-1" aria-labelledby="modalOnProgressLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('aset-request.prosesHasilAdmin', $asetRequest->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="on_progress">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOnProgressLabel">Proses Permintaan Aset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="catatan_admin_on_progress" class="form-label">Catatan Admin <span
                                    class="text-danger">*</span></label>
                            <textarea name="catatan_admin" id="catatan_admin_on_progress" class="form-control" rows="3" required></textarea>
                            <div class="form-text">Catatan admin wajib diisi untuk memproses permintaan.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white">Proses</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Setujui -->
    <div class="modal fade" id="modalSetujui" tabindex="-1" aria-labelledby="modalSetujuiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('aset-request.prosesHasilAdmin', $asetRequest->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="diterima">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSetujuiLabel">Setujui Permintaan Aset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="catatan_admin_setujui" class="form-label">Catatan Admin (Opsional)</label>
                            <textarea name="catatan_admin" id="catatan_admin_setujui" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Setujui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
            });
        @endif
    </script>
    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3 shadow',
                    confirmButton: 'btn btn-primary mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
