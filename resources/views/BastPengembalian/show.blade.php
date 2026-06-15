@extends('layouts.admin')

<title>{{ $incrementNumber }}. Surat BAST Pengembalian Aset IT_SEVIMA</title>

@section('content')
    <!-- Main Content -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                @if (request()->routeIs('bast-pengembalian.show', $bast->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Berita
                                            Acara</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailBastPengembalian', $bast->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif
                                @if (request()->routeIs('bast-pengembalian.show', $bast->id))
                                    <li class="breadcrumb-item"><a href="{{ route('bast-pengembalian.index') }}">BA Serah
                                            Terima Pengembalian Aset</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailBastPengembalian', $bast->id))
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('daftar-tanda-tangan.bastPengembalian') }}">BA Serah Terima
                                            Pengembalian Aset</a></li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">Surat Berita Acara Serah Terima Pengembalian Aset</h4>

                    @php
                        $showButton = false;
                        if (auth()->id() === $bast->petugas_id && !$bast->tanda_tangan_petugas) {
                            $showButton = true;
                        }
                        if (auth()->id() === $bast->pengembali_id && !$bast->tanda_tangan_pengembali) {
                            $showButton = true;
                        }
                    @endphp


                    @if ($showButton)
                        <!-- Tombol Tanda Tangani -->
                        <form
                            action="{{ request()->routeIs('bast-pengembalian.show', $bast->id) || request()->routeIs('bast-pengembalian.edit', $bast->id) || request()->routeIs('bast-pengembalian.destroy', $bast->id) || request()->routeIs('bast-pengembalian.create') ? route('bast-pengembalian.sign', $bast->id) : (request()->routeIs('daftar-tanda-tangan.detailBastPengembalian', $bast->id) ? route('daftar-tanda-tangan.signBastPengembalian', $bast->id) : '') }}"
                            method="POST" id="signForm" class="d-none">
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
                                <th width="200px">Pihak Pertama</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $bast->petugas->name_karyawan ?? '-' }}
                                        @if ($bast->tanda_tangan_petugas)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($bast->tanda_tangan_petugas_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Pihak Kedua</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $bast->pengembali->name_karyawan ?? '-' }}
                                        @if ($bast->tanda_tangan_pengembali)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($bast->tanda_tangan_pengembali_at)->format('d-m-Y H:i:s') }}
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
                            <iframe id="printFrame" src="{{ route('bast-pengembalian.download', $bast->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                </div>
                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
        </div>
    </main>

    @if ($showButton)
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
        <
        div class = "alert alert-danger" >
        {{ session('error') }}
            <
            /div>
    @endif
</script>
<!-- Include Review Modal -->
@include('review.partials.modal-review')

<!-- Auto-trigger Review Modal after successful signing -->
@if (session('show_review_modal') && session('review_data'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a moment for the success alert to show first
            setTimeout(function() {
                // Auto-open modal with review data
                openReviewModal(@json(session('review_data')));
            }, 500); // 2 second delay to let success message show
        });
    </script>
@endif
@endsection
