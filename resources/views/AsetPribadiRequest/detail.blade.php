@extends('layouts.admin')

<title>{{ $incrementNumber }}. Formulir Permintaan Aset Pribadi_SEVIMA</title>

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
                                @if (request()->routeIs('aset-pribadi-request-show', $asetpribadiRequest->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i>
                                            Permintaan</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailAsetpribadi', $asetpribadiRequest->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif
                                @if (request()->routeIs('aset-pribadi-request-show', $asetpribadiRequest->id))
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('aset-pribadi-request-show', $asetpribadiRequest->id) }}">Permintaan
                                            Aset Pribadi</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailAsetpribadi', $asetpribadiRequest->id))
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('aset-pribadi-request-show', $asetpribadiRequest->id) }}">Permintaan
                                            Aset Pribadi</a>
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
                    <h4 class="m-0">Formulir Permintaan Aset Pribadi</h4>

                    <!-- Tombol Tanda Tangani dan Batal Tanda Tangannya di sebelah kanan -->
                    {{-- <div class="d-flex gap-2 justify-content-end">
                        @if (auth()->id() === $asetpribadiRequest->id_user || auth()->id() === $asetpribadiRequest->id_manager || auth()->id() === $asetpribadiRequest->id_admin)
                            <!-- Tombol Tanda Tangani -->
                            <form
                                action="{{ request()->routeIs('aset-pribadi-request-show', $asetpribadiRequest->id) ? '#' : (request()->routeIs('daftar-tanda-tangan.detailAsetpribadi', $asetpribadiRequest->id) ? route('daftar-tanda-tangan.signAsetpribadi', $asetpribadiRequest->id) : '') }}"
                                method="POST" id="signForm">
                                @csrf
                                <button type="submit" class="btn btn-primary" title="Tanda Tangani"
                                    aria-label="Tanda Tangani" id="signButton">
                                    Tanda Tangani
                                </button>
                            </form>
                        @endif
                    </div> --}}
                </div>

                <!-- [START] Card for Tanda Tangani Section -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <!-- Judul dengan margin-bottom untuk jarak -->
                        <h4 class="card-title mb-3">Tanda Tangan</h4>

                        <!-- Tabel dengan data Tanda Tangan -->
                        <table class="table table-bordered">
                            <tr>
                                <th width="200px">Pemohon</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $asetpribadiRequest->user->name_karyawan ?? '-' }}
                                        @if ($asetpribadiRequest->tanda_tangan_user)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($asetpribadiRequest->tanda_tangan_user_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Manager</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $asetpribadiRequest->manager->name_karyawan ?? '-' }}
                                        @if ($asetpribadiRequest->tanda_tangan_manager)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($asetpribadiRequest->tanda_tangan_manager_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Admin</th>
                                <td>
                                    <h5 class="mb-0">
                                        @if ($asetpribadiRequest->keputusan_manager == 'ditolak')
                                            Ditolak oleh manager
                                        @elseif ($asetpribadiRequest->keputusan_manager == null)
                                            Menunggu keputusan manager
                                        @else
                                            {{ $asetpribadiRequest->admin->name_karyawan ?? 'Belum ada admin yang menandatangani' }}
                                        @endif
                                        @if ($asetpribadiRequest->tanda_tangan_admin)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($asetpribadiRequest->tanda_tangan_admin_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->

                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe id="printFrame"
                                src="{{ route('aset-pribadi-request.download', $asetpribadiRequest->id) }}"
                                class="w-100 h-100 border-0" allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
        </div>
    </main>

@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi sebelum tanda tangan
    document.getElementById('signButton')?.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form langsung submit

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
                // Jika pengguna mengonfirmasi, kirim form
                document.getElementById('signForm').submit();
            }
        });
    });

    // Menampilkan notifikasi jika ada session success atau error
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
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Tutup'
        });
    @endif

    // Fungsi untuk mencetak konten iframe
    document.getElementById('printButton')?.addEventListener('click', function() {
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
@endsection
