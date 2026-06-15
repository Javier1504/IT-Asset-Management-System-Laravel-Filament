@extends('layouts.admin')

<title>{{ $incrementNumber }}. Formulir Instalasi Aset IT_SEVIMA</title>
@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Instalasi
                                        Aset</a>
                                </li>
                                <li class="breadcrumb-item"><a href="/instalasi-aset"></i> Formulir Instalasi Aset</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">Formulir Instalasi Aset</h4>

                    @php
                        $canSign = $instalasiAset->instalasiAsetUsers
                            ->where('user_id', auth()->id())
                            ->whereNull('tanda_tangan')
                            ->isNotEmpty();
                    @endphp
                    <!-- Tombol Tanda Tangani dan Batal Tanda Tangannya di sebelah kanan -->

                    @if ($canSign)
                        <form id="signForm" action="{{ route('instalasi-aset.sign', $instalasiAset->id) }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>

                <!-- [START] Card for Tanda Tangani Section -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <!-- Judul dengan margin-bottom untuk jarak -->
                        <h4 class="card-title mb-3">Tanda Tangan</h4>

                        <!-- Tabel dengan data Tanda Tangan -->
                        <table class="table table-bordered">
                            <tr>
                                <th width="200px">Penerima</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $instalasiAset->penerima->user->name_karyawan ?? '-' }}
                                        @if ($instalasiAset->penerima->tanda_tangan_at && $instalasiAset->penerima->tanda_tangan)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($instalasiAset->penerima->tanda_tangan_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <th width="200px">Petugas</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $instalasiAset->petugas->user->name_karyawan ?? '-' }}
                                        @if ($instalasiAset->petugas->tanda_tangan_at && $instalasiAset->petugas->tanda_tangan)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($instalasiAset->petugas->tanda_tangan_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <th width="200px">Verifikator</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $instalasiAset->verifikator->user->name_karyawan ?? '-' }}
                                        @if ($instalasiAset->verifikator->tanda_tangan_at && $instalasiAset->verifikator->tanda_tangan)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($instalasiAset->verifikator->tanda_tangan_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->

                <!-- [START] Card for Pratinjau Dokumen -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe src="{{ route('instalasi-aset.downloadForm', $instalasiAset->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                </div>
                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
        </div>
    </main>
    @if ($canSign)
        <div
            style="
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1050;
        ">
            <button type="button" id="signButtonSticky" class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                style="
                    padding: 0.75rem 1.5rem;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 0.95rem;
                    box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important;
                    transition: transform 0.15s ease, box-shadow 0.15s ease;
                "
                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 28px rgba(13,110,253,0.55) !important'"
                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 20px rgba(13,110,253,0.45) !important'">
                <i class="sym sym-pen-to-square"></i>
                Tanda Tangani
            </button>
        </div>
    @endif

@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showSignConfirmation() {
        Swal.fire({
            title: 'Apakah Semua Data Sudah Benar?',
            text: 'Pastikan semua informasi sudah benar sebelum melakukan tanda tangan.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Tandatangani!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('signForm').submit();
            }
        });
    }

    // Tombol sticky di pojok kanan bawah
    const signButtonSticky = document.getElementById('signButtonSticky');
    if (signButtonSticky) {
        signButtonSticky.addEventListener('click', function(event) {
            event.preventDefault();
            showSignConfirmation();
        });
    }
</script>
<script>
    @if (session('success'))
        Swal.fire({
            title: 'Sukses!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Tutup'
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Tutup'
        });
    @endif
</script>
@endsection
