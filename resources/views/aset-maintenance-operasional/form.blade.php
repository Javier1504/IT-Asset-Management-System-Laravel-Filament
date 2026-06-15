<?php

function numberToWords($number)
{
    $words = [
        1 => 'Satu',
        2 => 'Dua',
        3 => 'Tiga',
        4 => 'Empat',
        5 => 'Lima',
        6 => 'Enam',
        7 => 'Tujuh',
        8 => 'Delapan',
        9 => 'Sembilan',
        10 => 'Sepuluh',
        11 => 'Sebelas',
        12 => 'Dua Belas',
        13 => 'Tiga Belas',
        14 => 'Empat Belas',
        15 => 'Lima Belas',
        16 => 'Enam Belas',
        17 => 'Tujuh Belas',
        18 => 'Delapan Belas',
        19 => 'Sembilan Belas',
        20 => 'Dua Puluh',
        30 => 'Tiga Puluh',
        40 => 'Empat Puluh',
        50 => 'Lima Puluh',
        60 => 'Enam Puluh',
        70 => 'Tujuh Puluh',
        80 => 'Delapan Puluh',
        90 => 'Sembilan Puluh',
        100 => 'Seratus',
        1000 => 'Seribu',
    ];

    if ($number <= 100) {
        return $words[$number] ?? $words[floor($number / 10) * 10] . ' ' . $words[$number % 10];
    }

    $thousands = floor($number / 1000);
    $hundreds = floor(($number % 1000) / 100);
    $tens = floor(($number % 100) / 10) * 10;
    $ones = $number % 10;

    $result = '';
    if ($thousands > 0) {
        $result .= $words[$thousands] . ' Ribu ';
    }
    if ($hundreds > 0) {
        $result .= $words[$hundreds] . ' Ratus ';
    }
    if ($tens > 0) {
        $result .= $words[$tens] . ' ';
    }
    if ($ones > 0) {
        $result .= $words[$ones];
    }

    return $result;
}

// Get date and convert it to the required format
$formattedDate = \Carbon\Carbon::parse($asetMaintenanceOperasional->tanggal)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($asetMaintenanceOperasional->tanggal)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($asetMaintenanceOperasional->tanggal)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Instalasi Aset IT - {{ $asetMaintenanceOperasional->nomor_surat }}</title>

    <style>
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            src: url("{{ public_path('assets/fonts/Inter-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            src: url("{{ public_path('assets/fonts/Inter-SemiBold.ttf') }}") format('truetype');
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            text-align: justify;
            margin: 0;
            padding: 95px 20px 20px 20px;
            box-sizing: border-box;
            line-height: 1.2;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            padding: 0;
            box-sizing: border-box;
        }

        /* h2 {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 0;
        }

        h2+h2 {
            margin-top: 0;
        }

        h2:last-of-type {
            margin-bottom: 30px;
        } */
        hr {
            border: none;
            border-top: 1px solid black;
            margin: 20px 0 0 0px;
        }

        .table-container {
            margin: 15px 0;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
        }

        input[type="checkbox"] {
            margin: 0 5px;
            vertical-align: bottom;
        }

        .bold {
            font-weight: 600;
        }

        .data-section {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .data-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .data-content div {
            display: flex;
            align-items: baseline;
            gap: 10px;
        }

        .data-content b {
            display: inline-block;
            min-width: 140px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .data-content span {
            flex: 1;
        }

        .align-center {
            text-align: center;
            padding: 5px;
        }

        .align-left {
            text-align: left;
        }

        .tabel {
            background-color: #ffcc9c;
            font-weight: 600;
        }

        .restricted-text {
            color: #ff9900 !important;
            font-weight: 600;
        }

        .judul-form {
            text-align: center;
            vertical-align: middle !important;
            font-weight: 700;
            font-size: 18px;
            padding: 0 10px;
        }

        .judul-form span {
            display: block;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header>
        <img src="{{ asset('assets/images/header.png') }}" style="width: 100%;">
    </header>

    <!-- FOOTER -->
    <footer>
        <p
            style="position: fixed; right: 80px; bottom: 96.5%; margin: 0; text-align: right; font-size: 10px; line-height: 1.2;">
            011/TMP.RO.FRM/TIS/SVM<br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ asset('assets/images/footer.png') }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="align-center judul-form" rowspan="4" style="vertical-align: middle;">
                        <span>FORMULIR PEMELIHARAAN ASET IT</span>
                        <span>OPERASIONAL</span>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>011/TMP.RO.FRM/TIS/SVM</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>1.0 - 2025.09.02</td>
                </tr>
            </tbody>
        </table>
        <div class="table-container">
            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Nomor Formulir</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $asetMaintenanceOperasional->nomor_surat ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Tanggal Pemeliharaan</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ \Carbon\Carbon::parse($asetMaintenanceOperasional->tanggal)->locale('id')->translatedFormat('d F Y') ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Nama Petugas IT Support</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $asetMaintenanceOperasional->petugas->user->name_karyawan ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">1. Jenis Pemeliharaan</span>
        <div class="table-container">

            <table>
                <thead>
                    <tr style="text-align: center">
                        <th class="align-center tabel">No.</th>
                        <th class="align-center tabel">Deskripsi</th>
                        <th class="align-center tabel">Centang Yang Dipilih</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-center">1</td>
                        <td class="align-left">Perawatan</td>
                        <td class="align-center">
                            <input type="checkbox" disabled
                                {{ $asetMaintenanceOperasional->jenis_pemeliharaan == 'perawatan' ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-center">2</td>
                        <td class="align-left">Perbaikan</td>
                        <td class="align-center">
                            <input type="checkbox" disabled
                                {{ $asetMaintenanceOperasional->jenis_pemeliharaan == 'perbaikan' ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-center">3</td>
                        <td class="align-left">Pergantian Sparepart</td>
                        <td class="align-center">
                            <input type="checkbox" disabled
                                {{ $asetMaintenanceOperasional->jenis_pemeliharaan == 'pergantian' ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">2. Detail Pemeliharaan Aset IT</span>
        <div class="table-container">
            <table>
                <thead>
                    <tr style="text-align: center">
                        <th class="align-center tabel">No.</th>
                        <th class="align-center tabel">Jenis Aset</th>
                        <th class="align-center tabel">Detail Aset</th>
                        <th class="align-center tabel">Nomor Aset</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($asetMaintenanceOperasional->aset_id == null)
                        @php
                            $details = $asetMaintenanceOperasional->detail_aset_operasional;

                            // Jika string JSON, decode dulu
                            if (is_string($details)) {
                                $details = json_decode($details, true) ?? [];
                            }

                            if (!is_array($details) && !is_object($details)) {
                                $details = [];
                            }
                        @endphp

                        @foreach ($details as $index => $detail)
                            <tr>
                                <td class="align-center">{{ $index + 1 }}</td>
                                <td class="align-left">
                                    @if (is_array($detail))
                                        {{ $detail['Jenis Aset'] ?? '-' }}
                                    @else
                                        {{ $detail->aset->kategori->nama ?? ($detail->jenis_aset ?? '-') }}
                                    @endif
                                </td>
                                <td class="align-left">
                                    @if (is_array($detail))
                                        {{ $detail['Detail Aset'] ?? '-' }}
                                    @else
                                        {{ $detail->aset->nama ?? ($detail->detail_aset ?? '-') }}
                                    @endif
                                </td>
                                <td class="align-left">
                                    @if (is_array($detail))
                                        {{ $detail['Nomor Aset'] ?? '-' }}
                                    @else
                                        {{ $detail->aset->nomor_aset ?? ($detail->nomor_aset ?? '-') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="align-center">1</td>
                            <td class="align-left">
                                {{ $asetMaintenanceOperasional->aset->jenisAset->name_jenis ?? '-' }}</td>
                            <td class="align-left">{{ $asetMaintenanceOperasional->aset->merk_aset ?? '-' }}</td>
                            <td class="align-left">{{ $asetMaintenanceOperasional->aset->nomor_aset ?? '-' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="table-container" style="margin-top: 50px;">

            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 30%; height: 70px; vertical-align: top;">Deskripsi
                            Permasalahan</th>
                        <td class="align-left"
                            style="width: 70%; height: 70px; border-left: 1px solid black; vertical-align: top;">
                            {{ $asetMaintenanceOperasional->deskripsi_permasalahan ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 30%; height: 70px; vertical-align: top;">Solusi yang
                            Dilakukan</th>
                        <td class="align-left"
                            style="width: 70%; height: 70px; border-left: 1px solid black; vertical-align: top;">
                            {{ $asetMaintenanceOperasional->solusi ?? '-' }}

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <table style="width: 100%; margin: 30px auto 0; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PETUGAS PERBAIKAN</p>
                        @if ($asetMaintenanceOperasional->petugas->tanda_tangan)
                            <img src="{{ asset('storage/' . $asetMaintenanceOperasional->petugas->tanda_tangan) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetMaintenanceOperasional->petugas->user->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetMaintenanceOperasional->petugas->user->job_role ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">VERIFIKATOR</p>
                        @if ($asetMaintenanceOperasional->verifikator->tanda_tangan)
                            <img src="{{ asset('storage/' . $asetMaintenanceOperasional->verifikator->tanda_tangan) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetMaintenanceOperasional->verifikator->user->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetMaintenanceOperasional->verifikator->user->job_role ?? '-' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
