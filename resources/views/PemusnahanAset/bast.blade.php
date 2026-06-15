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
$formattedDate = \Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Penghancuran Aset IT - {{ $pemusnahan->nomor_surat }}</title>

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
            013/TMP.RO.BRT/TIS/SVM <br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <p style="position: fixed; bottom: 10px; right: 10px; font-size: 10px; margin: 0;">{{ $page ?? 1 }} / 1</p>
        <img src="{{ asset('assets/images/footer.png') }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="align-center" rowspan="4">
                        <h2>BERITA ACARA <br> PENGHANCURAN ASET IT</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>013/TMP.RO.BRT/TIS/SVM</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>1.0 - 2025.07.31</td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td>{{ $pemusnahan->nomor_surat }}</td>
                </tr>
            </tbody>
        </table>

        <p>Pada hari ini,
            <b>{{ \Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->locale('id')->isoFormat('dddd') }} tanggal
                {{ $dayInWords }} bulan
                {{ \Carbon\Carbon::parse($pemusnahan->tanggal_pemusnahan)->locale('id')->isoFormat('MMMM') }} tahun
                {{ $yearInWords }} ({{ $formattedDate }})</b>, telah dilakukan proses penghancuran Aset IT oleh tim
            pelaksana yang ditunjuk, bertempat di {{ $pemusnahan->lokasi_pemusnahan }}. <br> Adapun pihak-pihak yang
            terlibat dalam kegiatan ini adalah:
        </p>

        <b>Tim Pelaksana:</b>
        @foreach ($pelaksana as $person)
            <table
                style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
                <tr>
                    <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $loop->iteration }}.</td>
                    <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">Nama
                        Lengkap
                    </td>
                    <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->user->name_karyawan }}</td>
                </tr>
                <tr>
                    <td style="padding: 0; line-height: 1.2; border: none;"></td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Jabatan</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->user->job_role }}</td>
                </tr>
                <tr>
                    <td style="padding: 0; line-height: 1.2; border: none;"></td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Peran</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->peran }}</td>
                </tr>
            </table>
        @endforeach
        <b>Pihak yang Terlibat:</b>
        @foreach ($saksi as $person)
            <table
                style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
                <tr>
                    <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $loop->iteration }}.</td>
                    <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">Nama
                        Lengkap
                    </td>
                    <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->user->name_karyawan }}</td>
                </tr>
                <tr>
                    <td style="padding: 0; line-height: 1.2; border: none;"></td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Jabatan</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->user->job_role }}</td>
                </tr>
                <tr>
                    <td style="padding: 0; line-height: 1.2; border: none;"></td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Peran</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                    <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                        {{ $person->peran }}</td>
                </tr>
            </table>
        @endforeach

        <p style="margin-top: 10px;">Adapun aset yang dihancurkan:</p>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="align-center tabel"><strong>No</strong></th>
                        <th class="align-center tabel"><strong>Jenis Aset</strong></th>
                        <th class="align-center tabel"><strong>Qty</strong></th>
                        <th class="align-center tabel"><strong>Spesifikasi/Merk</strong></th>
                        <th class="align-center tabel"><strong>Nomor Aset</strong></th>
                        <th class="align-center tabel"><strong>Harga</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemusnahan->pemusnahanAsets as $index => $item)
                        <tr>
                            <td class="align-center">{{ $index + 1 }}</td>
                            <td class="align-left">
                                {{ $item->aset ? $item->aset->jenisAset->name_jenis : ($item->sparepart ? $item->sparepart->jenisSparepart->jenis_sparepart : $item->manual_jenis) ?? '-' }}
                            </td>
                            <td class="align-center">{{ $item->qty ?? '-' }}</td>
                            <td class="align-left">
                                {{ $item->aset ? $item->aset->merk_aset : ($item->sparepart ? $item->sparepart->nama_sparepart : $item->manual_merk) ?? '-' }}
                            </td>
                            <td class="align-center">
                                {{ $item->aset ? $item->aset->nomor_aset : ($item->sparepart ? $item->sparepart->nomor : $item->manual_nomor) ?? '-' }}
                            </td>
                            <td class="align-right">
                                {{ 'Rp ' . number_format($item->aset ? $item->aset->harga_pembelian : ($item->sparepart ? $item->sparepart->harga : $item->manual_harga), 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p>Aset yang dihancurkan meliputi <b>{{ $pemusnahan->pemusnahanAsets->count() }} Aset </b>dengan metode
            {{ $pemusnahan->metode_pemusnahan }}. Proses ini dilakukan untuk menjamin bahwa tidak ada data perusahaan
            yang dapat diakses ulang, sesuai SOP Pemusnahan dan Penggunaan Kembali Aset IT No.002/PO.SOP/TIS/SVM.</p>

        <Strong>Dokumentasi Proses Penghancuran:</Strong>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="align-center tabel"><strong>Sebelum Dihancurkan</strong></th>
                        <th class="align-center tabel"><strong>Sesudah Dihancurkan</strong></th>
                    </tr>
                </thead>
                @php
                    $maxRows = max($buktiBefore->count(), $buktiAfter->count());
                @endphp

                <tbody>
                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            {{-- BEFORE --}}
                            <td class="align-center">
                                @php
                                    $before = $buktiBefore->values()->get($i);
                                @endphp

                                @if ($before)
                                    <img src="{{ asset('storage/' . $before->file_path) }}"
                                        style="height: 250px; width: auto; margin: 5px;">
                                @else
                                    -
                                @endif
                            </td>

                            {{-- AFTER --}}
                            <td class="align-center">
                                @php
                                    $after = $buktiAfter->values()->get($i);
                                @endphp

                                @if ($after)
                                    <img src="{{ asset('storage/' . $after->file_path) }}"
                                        style="height: 250px; width: auto; margin: 5px;">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <p>Berita acara ini dibuat sebagai bukti bahwa penghancuran telah dilakukan secara sah, aman, dan sesuai
            prosedur yang berlaku.</p>
        <div class="signature-section">
            <table style="width: 100%; margin: 30px auto 0; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px; text-decoration: underline;">PELAKSANA</p>
                        @php
                            $total = count($pelaksana);
                        @endphp
                        <div style="margin-top: 15px; text-align: center;">
                            @foreach ($pelaksana as $row)
                                @php
                                    $isLast = $loop->last;
                                    $isOddTotal = $total % 2 == 1;
                                    $shouldCenter = $isLast && $isOddTotal;
                                @endphp
                                <div
                                    style="width: {{ $shouldCenter ? '100%' : '50%' }}; float: left; margin-bottom: 20px; text-align: center;">
                                    @if ($row->tanda_tangan)
                                        <img src="{{ asset('storage/' . $row->tanda_tangan) }}"
                                            style="width: 80px; margin: 8px 0;">
                                    @else
                                        <p style="margin: 10px 0;">(Belum Tanda Tangan)</p>
                                    @endif

                                    <p
                                        style="margin:0; font-weight:bold; text-decoration: underline; text-transform:capitalize;">
                                        {{ $row->user->name_karyawan }}
                                    </p>
                                    <p style="margin:0; font-weight:bold; text-transform:capitalize;">
                                        {{ $row->user->job_role }}
                                    </p>
                                </div>
                                @if (!$isLast && $loop->iteration % 2 == 0)
                                    <div style="clear: both;"></div>
                                @endif
                            @endforeach
                            <div style="clear: both;"></div>
                        </div>
                    </td>

                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px; text-decoration: underline;">SAKSI</p>

                        @php
                            $total = count($saksi);
                        @endphp

                        <div style="margin-top: 15px; text-align: center;">
                            @foreach ($saksi as $row)
                                @php
                                    $isLast = $loop->last;
                                    $isOddTotal = $total % 2 == 1;
                                    $shouldCenter = $isLast && $isOddTotal;
                                @endphp

                                <div
                                    style="width: {{ $shouldCenter ? '100%' : '50%' }}; float: left; margin-bottom: 20px; text-align: center;">
                                    @if ($row->tanda_tangan)
                                        <img src="{{ asset('storage/' . $row->tanda_tangan) }}"
                                            style="width: 80px; margin: 8px 0;">
                                    @else
                                        <p style="margin: 10px 0;">(Belum Tanda Tangan)</p>
                                    @endif

                                    <p
                                        style="margin:0; font-weight:bold; text-decoration: underline; text-transform:capitalize;">
                                        {{ $row->user->name_karyawan }}
                                    </p>

                                    <p style="margin:0; font-weight:bold; text-transform:capitalize;">
                                        {{ $row->user->job_role }}
                                    </p>
                                </div>

                                @if (!$isLast && $loop->iteration % 2 == 0)
                                    <div style="clear: both;"></div>
                                @endif
                            @endforeach

                            <div style="clear: both;"></div>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
    </div>
</body>

</html>
