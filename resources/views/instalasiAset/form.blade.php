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
$formattedDate = \Carbon\Carbon::parse($instalasiAset->tanggal_surat)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($instalasiAset->tanggal_surat)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($instalasiAset->tanggal_surat)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Instalasi Aset IT - {{ $instalasiAset->nomor_surat }}</title>

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
        <img src="{{ $headerPath }}" style="width: 100%; margin-bottom: 10px;">
    </header>

    <!-- FOOTER -->
    <footer>
        <p
            style="position: fixed; right: 80px; bottom: 96.5%; margin: 0; text-align: right; font-size: 10px; line-height: 1.2;">
            007/TMP.RO.FRM/TIS/{{ $instalasiAset->company->code ?? '-' }}<br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ $footerPath }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="align-center" rowspan="4">
                        <h2>FORMULIR INSTALASI ASET IT</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>032/TMP.RO.BRT/TIS/{{ $instalasiAset->company->code ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>1.0 - 2025.08.29</td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td>{{ $instalasiAset->nomor_surat }}</td>
                </tr>
            </tbody>
        </table>
        <span class="judul-form">I. Data Aset & Penerimaan</span>
        <div class="table-container">
            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Nama Pemegang Aset Sebelumnya</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->baPengembalianAset->pengembali->name_karyawan ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Nama Petugas IT Support (Penerima Aset)</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->penerima->user->name_karyawan ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">No. Form Pengembalian Aset IT</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->baPengembalianAset->nomor_surat ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Nomor Aset</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->aset->nomor_aset ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Detail Aset</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->aset->merk_aset ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Sistem Operasi Sebelumnya</th>
                        <td class="align-left" style="width: 60%; border-left: 1px solid black;">
                            {{ $instalasiAset->os_sebelumnya ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">II. Verifikasi Penghapusan Data & Aplikasi</span>
        <div class="table-container">
            @php
                // is_asset_data_cleared
                $isDataCleared = (bool) ($instalasiAset->is_asset_data_cleared ?? false);
                $dataCleared_ya = $isDataCleared ? '☑' : '☐';
                $dataCleared_tidak = $isDataCleared ? '☐' : '☑';

                // is_sensitive_data_checked
                $isSensitiveChecked = (bool) ($instalasiAset->is_sensitive_data_checked ?? false);
                $sensitiveChecked_ya = $isSensitiveChecked ? '☑' : '☐';
                $sensitiveChecked_tidak = $isSensitiveChecked ? '☐' : '☑';

                // has_unauthorized_apps
                $hasUnauthorizedApps = (bool) ($instalasiAset->has_unauthorized_apps ?? false);
                $unauthorizedApps_ya = $hasUnauthorizedApps ? '☑' : '☐';
                $unauthorizedApps_tidak = $hasUnauthorizedApps ? '☐' : '☑';
            @endphp
            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Data pada aset telah dihapus oleh pemegang
                            sebelumnya</th>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $dataCleared_ya }}</span> YA
                        </td>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $dataCleared_tidak }}</span> TIDAK
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Petugas telah memastikan tidak ada data
                            pribadi/sensitif yang tersisa</th>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $sensitiveChecked_ya }}</span> YA
                        </td>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $sensitiveChecked_tidak }}</span>
                            TIDAK
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Terdapat aplikasi ilegal/tidak sah dalam
                            perangkat</th>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $unauthorizedApps_ya }}</span> YA
                        </td>
                        <td class="align-center" style="width: 30%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $unauthorizedApps_tidak }}</span>
                            TIDAK
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Daftar Aplikasi Ilegal</th>
                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            {{ $instalasiAset->daftar_aplikasi_ilegal }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">III. Checklist Instalasi Ulang</span>
        <div class="table-container">
            @php
                $resetOS = $instalasiAset->reset_sistem_operasi ?? [];
                $hasWindows = isset($resetOS['Windows']);
                $hasLinux = isset($resetOS['Linux']);
                $hasMacOS = isset($resetOS['Mac OS']);

                $windows_ya = $hasWindows ? '☑' : '☐';
                $windows_tidak = $hasWindows ? '☐' : '☑';
                $linux_ya = $hasLinux ? '☑' : '☐';
                $linux_tidak = $hasLinux ? '☐' : '☑';
                $macos_ya = $hasMacOS ? '☑' : '☐';
                $macos_tidak = $hasMacOS ? '☐' : '☑';
            @endphp
            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Instalasi / Reset Sistem Operasi</th>
                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                                <span>
                                    <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $windows_ya }}</span>
                                    Windows
                                    @if ($hasWindows)
                                        - {{ $resetOS['Windows'] }}
                                    @endif
                                </span>
                                <span>
                                    <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $linux_ya }}</span>
                                    Linux
                                    @if ($hasLinux)
                                        - {{ $resetOS['Linux'] }}
                                    @endif
                                </span>
                                <span>
                                    <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $macos_ya }}</span>
                                    Mac OS
                                    @if ($hasMacOS)
                                        - {{ $resetOS['Mac OS'] }}
                                    @endif
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Instalasi Anti Malware</th>
                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            @php
                                $allMalware = ['Windows Security', 'Windows Firewall', 'Clamav'];
                                $selectedMalware = $instalasiAset->instalasi_antimalware ?? [];
                                $lainnya = collect($selectedMalware)->first(function ($item) {
                                    return str_starts_with($item, 'Lainnya:');
                                });
                            @endphp
                            <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                                @foreach ($allMalware as $malware)
                                    <span style="margin-right: 10px;">
                                        <span
                                            style="font-family: 'DejaVu Sans', sans-serif;">{{ in_array($malware, $selectedMalware) ? '☑' : '☐' }}</span>
                                        {{ $malware }}
                                    </span>
                                @endforeach
                                <span>
                                    <span
                                        style="font-family: 'DejaVu Sans', sans-serif;">{{ $lainnya ? '☑' : '☐' }}</span>
                                    Lainnya
                                    @if ($lainnya)
                                        : {{ str_replace('Lainnya: ', '', $lainnya) }}
                                    @endif
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Aplikasi Wajib Terpasang</th>
                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            {{ $instalasiAset->aplikasi_terpasang ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="tabel align-left" style="width: 40%;">Aplikasi Tambahan</th>
                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            {{ $instalasiAset->aplikasi_tambahan ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <table style="width: 100%; margin: 30px auto 0; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PENERIMA ASET</p>
                        @if ($instalasiAset->penerima->tanda_tangan)
                            <img src="{{ asset('storage/' . $instalasiAset->penerima->tanda_tangan) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $instalasiAset->penerima->user->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $instalasiAset->penerima->user->job_role ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PETUGAS INSTALASI</p>
                        @if ($instalasiAset->petugas->tanda_tangan)
                            <img src="{{ asset('storage/' . $instalasiAset->petugas->tanda_tangan) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $instalasiAset->petugas->user->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $instalasiAset->petugas->user->job_role ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">VERIFIKATOR</p>
                        @if ($instalasiAset->verifikator->tanda_tangan)
                            <img src="{{ asset('storage/' . $instalasiAset->verifikator->tanda_tangan) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $instalasiAset->verifikator->user->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $instalasiAset->verifikator->user->job_role ?? '-' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
