@extends('layouts.admin')

<title>{{ $incrementNumber }}. Surat BABP Aset IT_SEVIMA</title>

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
                                @if (request()->routeIs('babp.show', $babp->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Berita
                                            Acara</a></li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailBabp', $babp->id))
                                    <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Tanda
                                            Tangan</a></li>
                                @endif
                                @if (request()->routeIs('babp.show', $babp->id))
                                    <li class="breadcrumb-item"><a href="{{ route('babp.index') }}">BA Bukti Pembelian</a>
                                    </li>
                                @elseif(request()->routeIs('daftar-tanda-tangan.detailBabp', $babp->id))
                                    <li class="breadcrumb-item"><a href="{{ route('daftar-tanda-tangan.babp') }}">BA Bukti
                                            Pembelian</a></li>
                                @endif

                                <li class="breadcrumb-item active" aria-current="page">Pertinjau</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- [END] Breadcrumbs -->

                <!-- Title and Button Alignment -->
                <div class="d-flex align-items-center justify-content-between gap-2 px-0">
                    <h4 class="m-0">Surat Berita Acara Bukti Pembelian Aset</h4>

                    @php
                        $canSign = false;
                        $signMessage = '';

                        if (auth()->id() === $babp->petugas_id && !$babp->tanda_tangan_petugas) {
                            $canSign = true;
                            $signMessage = 'Tanda Tangani sebagai Penyedia Barang';
                        } elseif (auth()->id() === $babp->penerima_id && !$babp->tanda_tangan_penerima) {
                            $canSign = true;
                            $signMessage = 'Tanda Tangani sebagai Validator';
                        } elseif (auth()->id() === $babp->verifier_id && !$babp->verifier_signature) {
                            $canSign = true;
                            $signMessage = 'Tanda Tangani sebagai Verifikator';
                        }
                    @endphp

                    @if ($canSign)
                        <form
                            action="{{ request()->routeIs('babp.show', $babp->id) ? route('babp.sign', $babp->id) : (request()->routeIs('daftar-tanda-tangan.detailBabp', $babp->id) ? route('daftar-tanda-tangan.signBabp', $babp->id) : '') }}"
                            method="POST" id="signForm" class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>

                <!-- [START] Card for Tanda Tangani Section -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <!-- Judul dengan margin-bottom untuk jarak -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Tanda Tangan</h4>
                            @if ($babp->status === 'waiting_verification')
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @elseif($babp->status === 'waiting_validator')
                                <span class="badge bg-info text-dark">Menunggu Validator</span>
                            @elseif($babp->status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </div>
                        <!-- Tabel dengan data Tanda Tangan -->
                        <table class="table table-bordered">
                            <tr>
                                <th width="200px">Penyedia Barang</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $babp->petugas->name_karyawan ?? '-' }}
                                        @if ($babp->tanda_tangan_petugas)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($babp->tanda_tangan_petugas_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Verifikator</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $babp->verifier->name_karyawan ?? '-' }}
                                        @if ($babp->verifier_signature)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($babp->verifier_signature_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                            <tr>
                                <th width="200px">Validator</th>
                                <td>
                                    <h5 class="mb-0">
                                        {{ $babp->penerima->name_karyawan ?? '-' }}
                                        @if ($babp->tanda_tangan_penerima)
                                            <span class="text-muted m-2" style="font-size: 0.875rem;">
                                                Ditandatangani pada
                                                {{ \Carbon\Carbon::parse($babp->tanda_tangan_penerima_at)->format('d-m-Y H:i:s') }}
                                            </span>
                                        @endif
                                    </h5>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <!-- [END] Card for Tanda Tangani Section -->
                @can('finance')
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Catatan Pengecekan Finance</h4>

                            @if ($babp->jumlah_barang_sesuai !== null)
                                {{-- Display Saved Data --}}
                                <div class="alert alert-info">
                                    <h5>Data Tersimpan:</h5>
                                    <p class="mb-1"><strong>Jumlah Barang Sesuai:</strong>
                                        {{ $babp->jumlah_barang_sesuai == 1 ? 'Ya' : 'Tidak' }}</p>
                                    @if ($babp->jumlah_barang_sesuai == 0 && $babp->rincian_perbedaan_jumlah)
                                        <p class="mb-0"><strong>Rincian Perbedaan:</strong>
                                            {{ $babp->rincian_perbedaan_jumlah }}</p>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('babp.checklist', $babp->id) }}" method="POST"
                                    id="financeChecklistForm">
                                    @csrf
                                    <input type="hidden" name="checklist_type" value="finance">

                                    {{-- Checklist Pemeriksaan --}}
                                    <div class="col-md-12 mt-0">
                                        <div class="d-flex flex-column gap-1 mb-2">
                                            <h1 class="fs-5 fw-medium mb-0">Checklist Pemeriksaan Jumlah Barang</h1>
                                            <p class="fs-6 fw-medium text-secondary mb-0">
                                                Isi checklist pemeriksaan jumlah barang yang diterima.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- 1. Jumlah Barang Sesuai --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Jumlah Barang Sesuai</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jumlah_barang_sesuai"
                                                    id="jumlahYa" value="1" required
                                                    {{ old('jumlah_barang_sesuai', $babp->jumlah_barang_sesuai) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jumlahYa">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jumlah_barang_sesuai"
                                                    id="jumlahTidak" value="0" required
                                                    {{ old('jumlah_barang_sesuai', $babp->jumlah_barang_sesuai) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jumlahTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="rincianJumlahDiv" style="display: none;">
                                        <label for="rincianJumlah" class="form-label">Jika tidak, rincian
                                            perbedaannya:</label>
                                        <textarea class="form-control" id="rincianJumlah" name="rincian_perbedaan_jumlah" rows="3"
                                            placeholder="Jelaskan perbedaan jumlah barang">{{ old('rincian_perbedaan_jumlah', $babp->rincian_perbedaan_jumlah) }}</textarea>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan Checklist Finance</button>
                                    </div>
                                </form>
                            @endif

                            <hr class="border-dark-subtle my-4 col-md-12" />
                        </div>
                    </div>
                @endcan

                @if (auth()->id() === $babp->verifier_id)
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Catatan Pengecekan Verifikator</h4>

                            @if ($babp->kondisi_barang !== null)
                                {{-- Display Saved Data --}}
                                <div class="alert alert-info">
                                    <h5>Data Tersimpan:</h5>
                                    <p class="mb-1"><strong>Kondisi Barang:</strong>
                                        {{ ucfirst($babp->kondisi_barang) }}</p>
                                    @if ($babp->kondisi_barang == 'rusak' && $babp->rincian_kerusakan)
                                        <p class="mb-1"><strong>Rincian Kerusakan:</strong>
                                            {{ $babp->rincian_kerusakan }}</p>
                                    @endif
                                    <p class="mb-1"><strong>Spesifikasi Barang Sesuai:</strong>
                                        {{ $babp->spesifikasi_sesuai == 1 ? 'Ya' : 'Tidak' }}</p>
                                    @if ($babp->spesifikasi_sesuai == 0 && $babp->rincian_perbedaan_spesifikasi)
                                        <p class="mb-1"><strong>Rincian Perbedaan Spesifikasi:</strong>
                                            {{ $babp->rincian_perbedaan_spesifikasi }}</p>
                                    @endif
                                    <p class="mb-1"><strong>Tindakan yang Diambil:</strong>
                                        {{ $babp->tindakan_diambil == 'lain' && $babp->tindakan_lain ? $babp->tindakan_lain : $babp->tindakan_diambil }}
                                    </p>
                                </div>
                            @else
                                <form action="{{ route('babp.checklist', $babp->id) }}" method="POST"
                                    id="verifierChecklistForm">
                                    @csrf
                                    <input type="hidden" name="checklist_type" value="verifier">

                                    {{-- Checklist Pemeriksaan --}}
                                    <div class="col-md-12 mt-0">
                                        <div class="d-flex flex-column gap-1 mb-2">
                                            <h1 class="fs-5 fw-medium mb-0">Checklist Pemeriksaan Barang</h1>
                                            <p class="fs-6 fw-medium text-secondary mb-0">
                                                Isi checklist pemeriksaan kondisi, spesifikasi, dan tindakan barang.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- 2. Kondisi Barang --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">1. Kondisi Barang</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kondisi_barang"
                                                    id="kondisiBaik" value="baik" required
                                                    {{ old('kondisi_barang', $babp->kondisi_barang) == 'baik' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kondisiBaik">Baik</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kondisi_barang"
                                                    id="kondisiRusak" value="rusak" required
                                                    {{ old('kondisi_barang', $babp->kondisi_barang) == 'rusak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kondisiRusak">Rusak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="rincianKerusakanDiv" style="display: none;">
                                        <label for="rincianKerusakan" class="form-label">Jika rusak, rincian
                                            kerusakannya:</label>
                                        <textarea class="form-control" id="rincianKerusakan" name="rincian_kerusakan" rows="3"
                                            placeholder="Jelaskan kerusakan barang">{{ old('rincian_kerusakan', $babp->rincian_kerusakan) }}</textarea>
                                    </div>

                                    {{-- 3. Spesifikasi Barang Sesuai --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fw-semibold">2. Spesifikasi Barang Sesuai</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="spesifikasi_sesuai"
                                                    id="spesifikasiYa" value="1" required
                                                    {{ old('spesifikasi_sesuai', $babp->spesifikasi_sesuai) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="spesifikasiYa">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="spesifikasi_sesuai"
                                                    id="spesifikasiTidak" value="0" required
                                                    {{ old('spesifikasi_sesuai', $babp->spesifikasi_sesuai) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="spesifikasiTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="rincianSpesifikasiDiv" style="display: none;">
                                        <label for="rincianSpesifikasi" class="form-label">Jika tidak, rincian
                                            perbedaannya:</label>
                                        <textarea class="form-control" id="rincianSpesifikasi" name="rincian_perbedaan_spesifikasi" rows="3"
                                            placeholder="Jelaskan perbedaan spesifikasi">{{ old('rincian_perbedaan_spesifikasi', $babp->rincian_perbedaan_spesifikasi) }}</textarea>
                                    </div>

                                    {{-- 4. Tindakan yang Diambil --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fw-semibold">3. Tindakan yang Diambil</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tindakan_diambil"
                                                    id="tindakanDiterima"
                                                    value="Barang diterima dan disimpan di ruang tim IT" required
                                                    {{ old('tindakan_diambil', $babp->tindakan_diambil) == 'Barang diterima dan disimpan di ruang tim IT' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tindakanDiterima">
                                                    Barang diterima dan disimpan di ruang tim IT
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tindakan_diambil"
                                                    id="tindakanLain" value="lain" required
                                                    {{ old('tindakan_diambil', $babp->tindakan_diambil) == 'lain' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tindakanLain">Tindakan
                                                    lain</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2" id="tindakanLainDiv" style="display: none;">
                                        <label for="tindakanLainText" class="form-label">Jelaskan tindakan
                                            lain:</label>
                                        <textarea class="form-control" id="tindakanLainText" name="tindakan_lain" rows="3"
                                            placeholder="Jelaskan tindakan yang diambil">{{ old('tindakan_lain', $babp->tindakan_lain) }}</textarea>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan Checklist
                                            Verifikator</button>
                                    </div>
                                </form>
                            @endif

                            <hr class="border-dark-subtle my-4 col-md-12" />
                        </div>
                    </div>
                @endif

                <!-- [START] Card for Evidence Files -->
                @include('Babp.partials.evidence-detail')

                @include('Babp.partials.image-detail-barang')

                <!-- [START] Card for Pratinjau Dokumen -->
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Pratinjau Dokumen</h4>
                        </div>

                        <!-- Container dengan aspect ratio A4 -->
                        <div
                            style="width: 100%; max-height: 900px; aspect-ratio: 210 / 297; border: 1px solid #dee2e6; border-radius: 0.5rem; overflow: hidden;">
                            <iframe id="printFrame" src="{{ route('babp.download', $babp->id) }}"
                                style="width: 100%; height: 100%; border: none;" allowfullscreen>
                            </iframe>
                        </div>


                    </div>
                </div>
                <!-- [END] Card for Pratinjau Dokumen -->

            </div>
    </main>
    <!-- [START] Sticky Floating Button Tanda Tangan -->
    @if ($canSign)
        <div
            style="
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1050;
        ">
            <button type="button" id="signButtonSticky"
                class="btn btn-primary d-flex align-items-center gap-2 shadow-lg"
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
                {{ $signMessage }}
            </button>
        </div>
    @endif

    @include('Babp.partials.modal-detail-barang')

@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi untuk menampilkan gambar di modal
    function showImageModal(imageSrc, namaBarang = 'Bukti Dokumen') {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('downloadImageBtn').href = imageSrc;
        document.getElementById('imageModalLabel').textContent = 'Detail Gambar - ' + namaBarang;
    }

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
    // Show/hide rincian jumlah barang
    document.querySelectorAll('input[name="jumlah_barang_sesuai"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const rincianDiv = document.getElementById('rincianJumlahDiv');
            if (this.value === '0') {
                rincianDiv.style.display = 'block';
            } else {
                rincianDiv.style.display = 'none';
                document.getElementById('rincianJumlah').value = '';
            }
        });
    });

    // Show/hide rincian kerusakan
    document.querySelectorAll('input[name="kondisi_barang"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const rincianDiv = document.getElementById('rincianKerusakanDiv');
            if (this.value === 'rusak') {
                rincianDiv.style.display = 'block';
            } else {
                rincianDiv.style.display = 'none';
                document.getElementById('rincianKerusakan').value = '';
            }
        });
    });

    // Show/hide rincian spesifikasi
    document.querySelectorAll('input[name="spesifikasi_sesuai"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const rincianDiv = document.getElementById('rincianSpesifikasiDiv');
            if (this.value === '0') {
                rincianDiv.style.display = 'block';
            } else {
                rincianDiv.style.display = 'none';
                document.getElementById('rincianSpesifikasi').value = '';
            }
        });
    });

    // Show/hide tindakan lain
    document.querySelectorAll('input[name="tindakan_diambil"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const tindakanDiv = document.getElementById('tindakanLainDiv');
            if (this.value === 'lain') {
                tindakanDiv.style.display = 'block';
            } else {
                tindakanDiv.style.display = 'none';
                document.getElementById('tindakanLainText').value = '';
            }
        });
    });

    // Check on page load for old values
    document.addEventListener('DOMContentLoaded', function() {
        const jumlahChecked = document.querySelector('input[name="jumlah_barang_sesuai"]:checked');
        if (jumlahChecked && jumlahChecked.value === '0') {
            document.getElementById('rincianJumlahDiv').style.display = 'block';
        }

        const kondisiChecked = document.querySelector('input[name="kondisi_barang"]:checked');
        if (kondisiChecked && kondisiChecked.value === 'rusak') {
            document.getElementById('rincianKerusakanDiv').style.display = 'block';
        }

        const spesifikasiChecked = document.querySelector('input[name="spesifikasi_sesuai"]:checked');
        if (spesifikasiChecked && spesifikasiChecked.value === '0') {
            document.getElementById('rincianSpesifikasiDiv').style.display = 'block';
        }

        const tindakanChecked = document.querySelector('input[name="tindakan_diambil"]:checked');
        if (tindakanChecked && tindakanChecked.value === 'lain') {
            document.getElementById('tindakanLainDiv').style.display = 'block';
        }
    });
</script>
@endsection
