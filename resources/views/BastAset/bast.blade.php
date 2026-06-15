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
$formattedDate = \Carbon\Carbon::parse($bastAset->tanggal)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($bastAset->tanggal)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($bastAset->tanggal)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAST Aset IT - {{ $bastAset->nomor_surat }}</title>
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
            padding: 95px 20px 95px 20px;
            box-sizing: border-box;
            line-height: 1.2;
            /* atau ganti jadi 1.2 atau 1.15 */
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
            {{ $nomorTemplate ?? '035/TMP.RO.BRT/TIS/' . ($bastAset->company->code ?? '-') }}<br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ $footerPath }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="align-center" rowspan="4" style="width: 50%;">
                        <h2>BERITA ACARA <br>SERAH TERIMA ASET IT</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>{{ $nomorTemplate ?? '035/TMP.RO.BRT/TIS/' . ($bastAset->company->code ?? '-') }}</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>{{ $nomorVersion ?? '1.0 - 2025.07.10' }}</td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td>{{ $bastAset->nomor_surat }}</td>
                </tr>
            </tbody>
        </table>

        <p>Pada hari ini, <b>{{ \Carbon\Carbon::parse($bastAset->tanggal)->locale('id')->isoFormat('dddd') }} tanggal
                {{ $dayInWords }} bulan
                {{ \Carbon\Carbon::parse($bastAset->tanggal)->locale('id')->isoFormat('MMMM') }} tahun
                {{ $yearInWords }} ({{ $formattedDate }})</b>, telah dibuat dan ditandatangani Berita Acara Serah
            Terima (BAST) Aset IT oleh dan antara yang bertanda tangan di bawah ini:</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1; border: none;">1.</td>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakPertama->name_karyawan }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Alamat</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakPertama->alamat }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakPertama->job_role }}</td>
            </tr>
        </table>

        <p style="margin: 0 0 5px 15px;">Selanjutnya disebut sebagai <b>PIHAK PERTAMA</b>.</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1; border: none;">2.</td>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakKedua->name_karyawan }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Alamat</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakKedua->alamat }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $bastAset->pihakKedua->job_role }}</td>
            </tr>
        </table>
        <p>Selanjutnya disebut sebagai <b>PIHAK KEDUA</b>.</p>

        <p><b>PIHAK PERTAMA</b> menyerahkan kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> telah menerima dari
            <b>PIHAK PERTAMA</b> aset dalam kondisi baik berupa:
        </p>

        <div class="table-container">
            <table>
                <thead>
                    <tr style="text-align: center">
                        <th class="align-center tabel">No.</th>
                        <th class="align-center tabel">Nama Aset</th>
                        <th class="align-center tabel">Qty</th>
                        <th class="align-center tabel">Merk</th>
                        <th class="align-center tabel">Nomor Aset</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bastAset->items as $index => $item)
                        <tr>
                            <td style="text-align: center">{{ $index + 1 }}</td>
                            <td>
                                @if ($item->endUserAset)
                                    {{ $item->endUserAset->aset->jenisAset->name_jenis ?? '-' }}
                                @elseif ($item->sparepart)
                                    {{ $item->sparepart->jenisSparepart->jenis_sparepart ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center">{{ $item->qty }}</td>
                            <td>
                                @if ($item->endUserAset)
                                    {{ $item->endUserAset->aset->merk_aset ?? '-' }}
                                @else
                                    {{ $item->sparepart->nama_sparepart ?? '-' }}
                                @endif
                            </td>
                            <td>
                                @if ($item->endUserAset)
                                    {{ $item->endUserAset->aset->nomor_aset ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p><b>PIHAK KEDUA</b> menerima tanggung jawab penuh untuk menjaga dan merawat aset tersebut, termasuk data dan
            informasi perusahaan yang terkandung di dalamnya. Jika terjadi kerusakan atau kehilangan aset, serta
            kebocoran informasi akibat kelalaian <b>PIHAK KEDUA</b>, <b>PIHAK KEDUA</b> akan bertanggung jawab sesuai
            dengan SOP NO. {{ $nomorSop ?? '001/PO.SOP/TIS/SVM' }}. Ketentuan Ganti Rugi Biaya Kerusakan dan Kehilangan Aset IT.</p>

        <p><b>PIHAK KEDUA</b> juga menjamin bahwa hanya terdapat aplikasi penunjang pekerjaan yang ada pada inventaris
            yang diserahkan. Jika ditemukan aplikasi selain penunjang pekerjaan, <b>PIHAK PERTAMA</b> berhak menarik
            kembali inventaris tersebut.</p>
        <p>Demikian Berita Acara Serah Terima (BAST) Aset IT ini dibuat dan ditandatangani oleh para pihak dengan
            sebenar-benarnya dan digunakan sebagaimana mestinya.</p>
        <div style="page-break-inside: avoid; margin-top: 0;">

            <table style="width: 100%; margin: 0 auto; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK PERTAMA</p>
                        @if ($bastAset->tanda_tangan_pihak_pertama)
                            <img src="{{ asset('storage/' . $bastAset->tanda_tangan_pihak_pertama) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $bastAset->pihakPertama->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $bastAset->pihakPertama->job_role }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK KEDUA</p>
                        @if ($bastAset->tanda_tangan_pihak_kedua)
                            <img src="{{ asset('storage/' . $bastAset->tanda_tangan_pihak_kedua) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $bastAset->pihakKedua->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $bastAset->pihakKedua->job_role }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
