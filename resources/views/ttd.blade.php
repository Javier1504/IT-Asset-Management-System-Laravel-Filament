@extends('layouts.app')

@section('title', 'Verifikasi Tanda Tangan')

@section('content')
    <main
        class="qn-main bg-body-tertiary d-flex flex-column justify-content-center align-items-center flex-grow-1 min-vh-100 py-4">

        <div class="card shadow-sm border-0 rounded-4 p-3" style="max-width: 480px; width: 100%; background-color: #fff;">

            <!-- Header Card -->
            <div
                class="card-header d-flex gap-2 align-items-center justify-content-between flex-wrap bg-white border-light-subtle px-3 py-3 rounded-top-4 border-2">
                <div class="d-flex gap-2 align-items-center">
                    <div class="ratio ratio-1x1" style="width: 42px; min-width: 42px;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle p-2 border"
                            style="color: #0072c6;">
                            <i class="sym sym-check-circle-solid" style="font-size: 1.3rem;"></i>
                        </span>
                    </div>
                    <div class="d-block ms-1">
                        <h5 class="m-0" style="color: #0072c6;">Verifikasi Tanda Tangan</h5>
                        <span class="fs-6 text-secondary">Detail verifikasi tanda tangan digital</span>
                    </div>
                </div>
            </div>

            <!-- Body Card -->
            <div class="px-3 py-3">

                <div class="row gy-3 align-items-center" style="color: #004a87;">
                    <div class="col-12 col-md-5 fw-semibold text-md-end pe-md-3">Nomor Surat:</div>
                    <div class="col-12 col-md-7">
                        {{ $bast->nomor_surat ?? $bast->nomor_formulir ?? $bast->nomor_pencabutan_user ?? '' }}</div>

                    <div class="col-12 col-md-5 fw-semibold text-md-end pe-md-3">Tanggal Surat:</div>
                    <div class="col-12 col-md-7">
                        {{ \Carbon\Carbon::parse($bast->tanggal ?? $bast->tanggal_surat)->format('d M Y') }}</div>

                    <div class="col-12 col-md-5 fw-semibold text-md-end pe-md-3">Ditandatangani oleh:</div>
                    <div class="col-12 col-md-7">{{ $petugas->name_karyawan }}</div>

                    <div class="col-12 col-md-5 fw-semibold text-md-end pe-md-3">Tanggal Tanda Tangan:</div>
                    <div class="col-12 col-md-7">{{ \Carbon\Carbon::parse($tanggalTtd)->format('d M Y H:i') }}</div>

                    <div class="col-12 col-md-5 fw-semibold text-md-end pe-md-3">Perihal:</div>
                    <div class="col-12 col-md-7">{{ $subject }}</div>
                </div>

                <hr class="my-4">

            </div>

        </div>

    </main>
@endsection
