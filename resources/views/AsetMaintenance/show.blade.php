@extends('layouts.admin')

<title>{{ $incrementNumber }}. Formulir Pemeliharaan Aset IT_SEVIMA</title>

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
                                @if (request()->routeIs('aset-maintenance.show', $maintenance->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>
                                            Pemeliharaan</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailMaintenance', $maintenance->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif
                                @if (request()->routeIs('aset-maintenance.show', $maintenance->id))
                                    <li class="breadcrumb-item"><a href="{{ route('aset-maintenance.index') }}">Form
                                            Pemeliharaan Aset</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailMaintenance', $maintenance->id))
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('daftar-tanda-tangan.maintenance') }}">Form Pemeliharaan Aset</a>
                                    </li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">Formulir Pemeliharaan Aset</h4>

                    @php
                        $showButton = false;
                        if (auth()->id() === $maintenance->petugas_id && !$maintenance->tanda_tangan_petugas) {
                            $showButton = true;
                        }
                        if (auth()->id() === $maintenance->pemegang_id && !$maintenance->tanda_tangan_pemegang) {
                            $showButton = true;
                        }
                    @endphp

                    @if ($showButton)
                        <!-- Tombol Tanda Tangani -->
                        <form
                            action="{{ request()->routeIs('aset-maintenance.show', $maintenance->id) ? route('aset-maintenance.sign', $maintenance->id) : (request()->routeIs('daftar-tanda-tangan.detailMaintenance', $maintenance->id) ? route('daftar-tanda-tangan.signMaintenance', $maintenance->id) : '') }}"
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
                                        {{ $maintenance->petugas->name_karyawan ?? '-' }}
                                        @if ($maintenance->tanda_tangan_petugas)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($maintenance->tanda_tangan_petugas_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Pihak Kedua</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $maintenance->pemegang->name_karyawan ?? '-' }}
                                        @if ($maintenance->tanda_tangan_pemegang)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($maintenance->tanda_tangan_pemegang_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->

                <!-- Pending History Card -->
                @if (!empty($maintenance->pending_history) && count($maintenance->pending_history) > 0)
                    <div class="card shadow-sm border-0 rounded-4 p-3">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="sym sym-clock"></i> Riwayat Status Pending</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Mulai Pending</th>
                                            <th width="20%">Selesai Pending</th>
                                            <th width="20%">Durasi</th>
                                            <th width="20%">Alasan</th>
                                            <th width="15%">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($maintenance->pending_history as $index => $history)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($history['started_at'])->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    @if ($history['ended_at'])
                                                        {{ \Carbon\Carbon::parse($history['ended_at'])->format('d/m/Y H:i') }}
                                                    @else
                                                        <span class="badge bg-warning">Masih Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($history['ended_at'])
                                                        @php
                                                            $start = \Carbon\Carbon::parse($history['started_at']);
                                                            $end = \Carbon\Carbon::parse($history['ended_at']);
                                                            $diff = $start->diff($end);
                                                        @endphp
                                                        {{ $diff->d > 0 ? $diff->d . ' hari ' : '' }}
                                                        {{ $diff->h > 0 ? $diff->h . ' jam ' : '' }}
                                                        {{ $diff->i > 0 ? $diff->i . ' menit' : '' }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td><small>{{ is_array($history['reason']) ? implode(',', $history['reason']) : $history['reason'] ?? '-' }}</small>
                                                </td>
                                                <td>{{ $history['note'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- [END] Pending History Card -->

                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe id="printFrame" src="{{ route('aset-maintenance.download', $maintenance->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                </div>
                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
    </main>

    @if ($showButton)
        <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
            <button type="button" id="signButtonSticky" class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease, box-shadow 0.15s ease;"
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
<script>
    // Fungsi untuk mencetak konten iframe
    document.getElementById('printButton').addEventListener('click', function() {
        var iframe = document.getElementById('printFrame');

        // Cek apakah iframe sudah dimuat
        iframe.onload = function() {
            // Log untuk memastikan iframe sudah dimuat
            console.log('Iframe sudah dimuat, memanggil fungsi print...');

            // Memberikan sedikit jeda sebelum memanggil print()
            setTimeout(function() {
                // Memanggil fungsi print di dalam iframe
                iframe.contentWindow.print();
            }, 500); // Delay 500ms untuk memastikan iframe siap
        };

        // Pastikan iframe sudah dimuat sebelum menunggu
        if (iframe.contentWindow.document.readyState === 'complete') {
            console.log('Iframe sudah dimuat sebelumnya, langsung memanggil print...');
            iframe.contentWindow.print();
        }
    });
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
