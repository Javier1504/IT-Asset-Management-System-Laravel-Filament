@extends('layouts.admin')

@section('title', 'Pratinjau Surat Pemusnahan Aset')

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
                                <li class="breadcrumb-item"><a href="{{ route('pemusnahan-aset.index') }}"><i
                                            class="sym sym-home-line"></i> Pemusnahan
                                        Aset</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">Surat Pemusnahan Aset</h4>

                    <div class="d-flex gap-2 justify-content-end">
                        @if ($pemusnahanUser)
                            @if (!$pemusnahanUser->tanda_tangan)
                                <form action="{{ route('pemusnahan-aset.sign', $pemusnahan->id) }}" method="POST"
                                    id="signForm"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menandatangani dokumen ini?')">
                                    @csrf
                                    <button class="btn btn-success" type="submit" id="signButton">
                                        <i class="fas fa-signature"></i> Tanda Tangani
                                    </button>
                                </form>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Sudah Ditandatangani
                                    </span>
                                    @if ($pemusnahanUser->tanda_tangan_at)
                                        <small class="text-muted">
                                            {{ $pemusnahanUser->tanda_tangan_at->format('d/m/Y H:i') }}
                                        </small>
                                    @endif
                                </div>
                            @endif
                        @else
                            {{-- User tidak terdaftar dalam pemusnahan ini --}}
                            <span class="badge bg-secondary">
                                <i class="fas fa-info-circle"></i> Anda tidak terdaftar dalam dokumen ini
                            </span>
                        @endif
                    </div>
                </div>

                <!-- [START] Card for Tanda Tangani Section -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <!-- Judul dengan margin-bottom untuk jarak -->
                        <h4 class="card-title mb-3">Tanda Tangan</h4>

                        <!-- Tabel dengan data Tanda Tangan -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <!-- TIM PELAKSANA -->
                                <tr>
                                    <th width="200px">Tim Pelaksana</th>
                                    <td>
                                        @if ($pelaksana->isNotEmpty())
                                            @foreach ($pelaksana as $item)
                                                <div class="mb-2">
                                                    <strong>{{ $item->user->name_karyawan ?? '-' }}</strong><br>
                                                    <small>Peran: {{ $item->peran ?? '-' }}</small><br>
                                                    <small>
                                                        Tanda Tangan:
                                                        {{ $item->tanda_tangan_at ? \Carbon\Carbon::parse($item->tanda_tangan_at)->format('d/m/Y H:i') : 'Belum Ditandatangani' }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>

                                <!-- PIHAK TERLIBAT -->
                                <tr>
                                    <th width="200px">Pihak yang Terlibat</th>
                                    <td>
                                        @if ($saksi->isNotEmpty())
                                            @foreach ($saksi as $item)
                                                <div class="mb-2">
                                                    <strong>{{ $item->user->name_karyawan ?? '-' }}</strong><br>
                                                    <small>Peran: {{ $item->peran ?? '-' }}</small><br>
                                                    <small>
                                                        Tanda Tangan:
                                                        {{ $item->tanda_tangan_at ? \Carbon\Carbon::parse($item->tanda_tangan_at)->format('d/m/Y H:i') : 'Belum Ditandatangani' }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </thead>
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
                            <iframe id="printFrame" src="{{ route('pemusnahan-aset.download', $pemusnahan->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                </div>

                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
    </main>

@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi sebelum tanda tangan
    document.getElementById('signButton').addEventListener('click', function(event) {
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
@endsection
