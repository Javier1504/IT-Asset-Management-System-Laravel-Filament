@extends('layouts.admin')

<title>Pratinjau BAST Persetujuan Aset Pribadi</title>

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Facades\Auth;
    @endphp
    <!-- Main Content -->
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
                                <li class="breadcrumb-item"><a href="{{ route('bast-persetujuan-asetpribadi.index') }}">BA
                                        Persetujuan Aset Pribadi</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">BAST Persetujuan Aset Pribadi</h4>
                </div>

                <!-- [START] Card for Data BAST -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Informasi BAST</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150px">Nomor Surat</th>
                                        <td>: {{ $bast->nomor_surat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>: {{ \Carbon\Carbon::parse($bast->tanggal)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:
                                            @if ($bast->status == 'pending')
                                                <span
                                                    class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                            @elseif($bast->status == 'approved')
                                                <span
                                                    class="badge text-success bg-success bg-opacity-10 border border-success">Disetujui</span>
                                            @elseif ($bast->status == 'cancelled')
                                                <span
                                                    class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dibatalkan</span>
                                            @else
                                                <span
                                                    class="badge text-danger bg-danger bg-opacity-10 border border-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                        {{ $bast->pihakPertama->name_karyawan ?? '-' }}
                                        @if ($bast->tanda_tangan_pihak_pertama)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($bast->tanda_tangan_pihak_pertama_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Pihak Kedua</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $bast->pihakKedua->name_karyawan ?? '-' }}
                                        @if ($bast->tanda_tangan_pihak_kedua)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($bast->tanda_tangan_pihak_kedua_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->

                <!-- [START] Card for Aset Pribadi Requests -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Request Aset Pribadi</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>Manager</th>
                                        <th>Aset pribadi</th>
                                        <th>Tanggal Request</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bast->asetpribadiRequests as $request)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $request->user->name_karyawan ?? '-' }}</td>
                                            <td>{{ $request->jabatan_user ?? '-' }}</td>
                                            <td>{{ $request->divisi ?? '-' }}</td>
                                            <td>{{ $request->manager->name_karyawan ?? '-' }}</td>
                                            <td>
                                                <div class="mb-1">
                                                    <strong>{{ $request->aset_pribadi[0]['nama'] ?? '-' }}</strong><br>
                                                    <small>S/N:
                                                        {{ $request->aset_pribadi[0]['no_seri'] ?? '-' }}</small><br>
                                                    <small>MAC:
                                                        {{ $request->aset_pribadi[0]['mac_address'] ?? '-' }}</small>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <span
                                                        class="badge text-warning bg-warning bg-opacity-10 border border-warning">Pending</span>
                                                @elseif($request->status == 'disetujui')
                                                    <span
                                                        class="badge text-success bg-success bg-opacity-10 border border-success">Disetujui</span>
                                                @elseif ($request->status == 'cancelled')
                                                    <span
                                                        class="badge text-secondary bg-secondary bg-opacity-10 border border-secondary">Dibatalkan</span>
                                                @else
                                                    <span
                                                        class="badge text-danger bg-danger bg-opacity-10 border border-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center gap-3">
                                                    <i class="sym sym-folder-open"
                                                        style="font-size: 48px; color: #ccc;"></i>
                                                    <div>
                                                        <h6 class="mb-1">Tidak ada data</h6>
                                                        <p class="text-muted mb-0">Belum ada request aset pribadi yang
                                                            terkait.</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        @if ($bast->status != 'cancelled')
                            <h4 class="card-title mb-3">Alasan Memutuskan Penggunaan Aset Pribadi</h4>
                            <p class="text-muted">{{ $bast->asetpribadiRequests[0]->catatan_user ?? '-' }}</p>
                        @elseif ($bast->status == 'cancelled')
                            <h4 class="card-title mb-3">Alasan Membatalkan Penggunaan Aset Pribadi</h4>
                            <p class="text-muted">{{ $bast->reason_cancelled ?? '-' }}</p>
                        @endif
                    </div>
                </div>

                <!-- [START] Card for Pratinjau Dokumen -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe id="printFrame" src="{{ route('bast-persetujuan-asetpribadi.download', $bast->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>
                        <!-- Tombol Tanda Tangani dan Aksi -->
                        <div class="d-flex gap-2 justify-content-end mt-3">
                            <!-- Tombol Tanda Tangani -->
                            @if (Auth::user()->id === $bast->user_pihak_pertama_id &&
                                    !$bast->tanda_tangan_pihak_pertama &&
                                    $bast->tanda_tangan_pihak_kedua !== null &&
                                    $bast->status != 'cancelled')
                                <form action="{{ route('daftar-tanda-tangan.signBAAsetpribadi', $bast->id) }}"
                                    method="POST" class="d-none" id="signForm">
                                    @csrf
                                </form>
                                <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050;">
                                    <button type="button" id="signButtonSticky"
                                        class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                                        style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease, box-shadow 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 28px rgba(13,110,253,0.55) !important'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 20px rgba(13,110,253,0.45) !important'">
                                        <i class="sym sym-pen-to-square"></i>
                                        Tanda Tangani
                                    </button>
                                </div>
                            @elseif (Auth::user()->id === $bast->user_pihak_kedua_id && !$bast->tanda_tangan_pihak_kedua && $bast->status != 'cancelled')
                                <!-- Tombol Setujui dan Batalkan -->
                                <div
                                    style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1050; display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end;">
                                    <button type="button" class="btn btn-danger d-flex align-items-center gap-2 shadow-lg"
                                        data-bs-toggle="modal" data-bs-target="#batalModal"
                                        style="padding: 0.75rem 1.5rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(220, 53, 69, 0.45) !important; transition: transform 0.15s ease, box-shadow 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="sym sym-xmark"></i>
                                        Batalkan
                                    </button>

                                    <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
                                        data-bs-toggle="modal" data-bs-target="#setujuiModal"
                                        style="padding: 0.75rem 1.5rem;border-radius: 50px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45) !important; transition: transform 0.15s ease, box-shadow 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="sym sym-check"></i>
                                        Setujui
                                    </button>
                                </div>
                                <!-- Modal Setujui Persyaratan -->
                                <div class="modal fade" id="setujuiModal" tabindex="-1"
                                    aria-labelledby="setujuiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('daftar-tanda-tangan.signBAAsetpribadi', $bast->id) }}"
                                            method="POST" id="setujuiForm">
                                            @csrf

                                            <div class="modal-content">
                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="setujuiModalLabel">
                                                        Setujui Persyaratan Aset Pribadi
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    <ol class="mb-3">
                                                        <li>Setujui persyaratan penggunaan aset pribadi.</li>
                                                        <li>
                                                            Apakah Anda yakin ingin menyetujui penggunaan aset pribadi
                                                            sesuai ketentuan yang terlampir dalam
                                                            <strong>Berita Acara Persetujuan Aset Pribadi</strong>?
                                                        </li>
                                                        <li>
                                                            Setelah disetujui, proses akan diteruskan kepada admin
                                                            untuk dilakukan tanda tangan Berita Acara.
                                                        </li>
                                                    </ol>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="confirmApprove" name="confirm_approve" value="1"
                                                            required>

                                                        <label class="form-check-label" for="confirmApprove">
                                                            Dengan ini saya
                                                            <strong>{{ Auth::user()->name_karyawan }}</strong>
                                                            menyetujui dan bersedia mematuhi seluruh ketentuan
                                                            penggunaan aset pribadi yang berlaku.
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        Tandatangani &amp; Setujui
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Batalkan Penggunaan Aset Pribadi -->
                                <div class="modal fade" id="batalModal" tabindex="-1" aria-labelledby="batalModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('bast-persetujuan-asetpribadi.cancelled', $bast->id) }}"
                                            method="POST" id="batalForm">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="batalModalLabel">Batalkan Penggunaan Aset
                                                        Pribadi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin membatalkan penggunaan aset pribadi?</p>
                                                    <p class="text-danger">Setelah dibatalkan, seluruh proses pengajuan
                                                        penggunaan aset pribadi tidak dapat diproses lebih lanjut.</p>
                                                    <div class="mb-3">
                                                        <label for="reason_cancelled" class="form-label">Alasan Penolakan
                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="reason_cancelled" name="reason_cancelled" rows="3" required></textarea>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="confirmCancel" name="confirm_cancel" required>
                                                        <label class="form-check-label" for="confirmCancel">
                                                            Dengan ini saya
                                                            <strong>{{ Auth::user()->name_karyawan }}</strong> membatalkan
                                                            penggunaan aset pribadi yang telah saya ajukan sebelumnya
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
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
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Tutup'
            });
        @endif
    </script>

    <script>
        // Fungsi untuk mencetak konten iframe
        const printButton = document.getElementById('printButton');
        if (printButton) {
            printButton.addEventListener('click', function() {
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
        }
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
