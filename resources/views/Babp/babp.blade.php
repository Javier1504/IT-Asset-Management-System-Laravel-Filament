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
$formattedDate = \Carbon\Carbon::parse($babp->tanggal_surat)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($babp->tanggal_surat)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($babp->tanggal_surat)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $incrementNumber }}. Surat BABP Aset IT_SEVIMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
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
            margin-top: 120px;
            margin-bottom: 80px;
            margin-left: 0;
            margin-right: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            text-align: justify;
            margin: 0;
            padding: 0 20px;
            box-sizing: border-box;
            line-height: 1.2;
        }

        header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            height: 120px;
        }

        footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            height: 80px;
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
        <img src="{{ $headerPath }}" style="width: 100%; margin-bottom: 10px;">
    </header>

    <!-- FOOTER -->
    <footer>
        <p
            style="position: fixed; right: 80px; bottom: 96.5%; margin: 0; text-align: right; font-size: 10px; line-height: 1.2;">
            035/TMP.RO.BRT/TIS/{{ $babp->company->code ?? '-' }}<br>
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
                        <h2>BERITA ACARA <br> BUKTI PEMBELIAN</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>023/TMP.RO.RPT/TIS/{{ $bastAset->company->code ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>1.0 - 2025.08.26</td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td>{{ $babp->nomor_surat }}</td>
                </tr>
            </tbody>
        </table>


        <p>
            Pada hari ini, <b>{{ \Carbon\Carbon::parse($babp->tanggal_surat)->locale('id')->isoFormat('dddd') }} tanggal
                {{ $dayInWords }} bulan
                {{ \Carbon\Carbon::parse($babp->tanggal_surat)->locale('id')->isoFormat('MMMM') }}
                tahun {{ $yearInWords }} ({{ $formattedDate }})</b>, telah dilakukan pengecekan kesesuaian barang
            pembelian yang dilakukan oleh tim IT dengan rincian sebagai berikut:
        </p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->petugas->name_karyawan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->petugas->job_role ?? '-' }}</td>
            </tr>
        </table>

        <p>Selanjutnya disebut sebagai <b>PENYEDIA BARANG (Tim IT)</b>.</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->verifier->name_karyawan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->verifier->job_role ?? '-' }}</td>
            </tr>
        </table>

        <p>Selanjutnya disebut sebagai <b>VERIFIKATOR (Tim IT)</b>.</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->penerima->name_karyawan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1; border: none;">
                    {{ $babp->penerima->job_role ?? '-' }}</td>
            </tr>
        </table>

        <p>Selanjutnya disebut sebagai <b>VALIDATOR (Tim Keuangan)</b>.</p>

        <p><b>Data Barang Pembelian:</b></p>

        <div class="table-container">
            <table>
                <tr style="text-align: center">
                    <th class="align-center tabel">No.</th>
                    <th class="align-center tabel">Nama Barang</th>
                    <th class="align-center tabel">Kuantitas<br>Dipesan</th>
                    <th class="align-center tabel">Kuantitas<br>Diterima</th>
                    <th class="align-center tabel">Kategori</th>
                    <th class="align-center tabel">Tanggal<br>Beli</th>
                    <th class="align-center tabel">Tanggal<br>Terima</th>
                </tr>
                @foreach ($babp->details as $index => $item)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_barang ?? '-' }}</td>
                        <td style="text-align: center">{{ $item->kuantitas_dipesan }}</td>
                        <td style="text-align: center">{{ $item->kuantitas_diterima }}</td>
                        <td style="text-align: center">{{ $item->kategori }}</td>
                        <td>{{ $item->tanggal_beli ?? '-' }}</td>
                        <td>{{ $item->tanggal_terima ?? '-' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <p><b>Catatan Pengecekan:</b></p>

        <ol style="font-size:12px; line-height:1.2; margin-left: 15px; font-family: 'DejaVu Sans', sans-serif;">
            <small><i>Pengecekan Oleh Finance</i></small>
            <li><b>Jumlah Barang Sesuai:</b>
                <ul style="list-style-type: none; padding-left: 15px;">
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->jumlah_barang_sesuai == true ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Ya</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->jumlah_barang_sesuai == false && !is_null($babp->jumlah_barang_sesuai) ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Tidak</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="vertical-align: middle;">Jika tidak, rincian perbedaannya:</span>
                        @if ($babp->jumlah_barang_sesuai == false && !is_null($babp->jumlah_barang_sesuai) && $babp->rincian_perbedaan_jumlah)
                            <span
                                style="vertical-align: middle; margin-left: 5px;">{{ $babp->rincian_perbedaan_jumlah }}</span>
                        @else
                            <span
                                style="border-bottom: 1px solid black; display:inline-block; width: 250px; margin-left: 5px; vertical-align: middle;">&nbsp;</span>
                        @endif
                    </li>
                </ul>
            </li>
            <small><i>Pengecekan Oleh TIM IT</i></small>
            <li><b>Kondisi Barang:</b>
                <ul style="list-style-type: none; padding-left: 15px;">
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->kondisi_barang === 'baik' ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Baik</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->kondisi_barang === 'rusak' ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Rusak</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="vertical-align: middle;">Jika rusak, rincian kerusakannya:</span>
                        @if ($babp->kondisi_barang === 'rusak' && $babp->rincian_kerusakan)
                            <span
                                style="vertical-align: middle; margin-left: 5px;">{{ $babp->rincian_kerusakan }}</span>
                        @else
                            <span
                                style="border-bottom: 1px solid black; display:inline-block; width: 250px; margin-left: 5px; vertical-align: middle;">&nbsp;</span>
                        @endif
                    </li>
                </ul>
            </li>

            <li><b>Spesifikasi Barang Sesuai:</b>
                <ul style="list-style-type: none; padding-left: 15px;">
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->spesifikasi_sesuai == true ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Ya</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->spesifikasi_sesuai == false && !is_null($babp->spesifikasi_sesuai) ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Tidak</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="vertical-align: middle;">Jika tidak, rincian perbedaannya:</span>
                        @if ($babp->spesifikasi_sesuai == false && !is_null($babp->spesifikasi_sesuai) && $babp->rincian_perbedaan_spesifikasi)
                            <span
                                style="vertical-align: middle; margin-left: 5px;">{{ $babp->rincian_perbedaan_spesifikasi }}</span>
                        @else
                            <span
                                style="border-bottom: 1px solid black; display:inline-block; width: 250px; margin-left: 5px; vertical-align: middle;">&nbsp;</span>
                        @endif
                    </li>
                </ul>
            </li>

            <li><b>Tindakan yang Diambil:</b>
                <ul style="list-style-type: none; padding-left: 15px;">
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->tindakan_diambil === 'Barang diterima dan disimpan di ruang tim IT' ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Barang diterima dan disimpan di ruang tim IT</span>
                    </li>
                    <li style="margin-bottom: 2px;">
                        <span style="display:inline-block; width:18px; vertical-align: middle; font-size: 14px;">
                            {{ $babp->tindakan_diambil === 'lain' ? '☑' : '☐' }}
                        </span>
                        <span style="vertical-align: middle;">Tindakan lain:</span>
                        @if ($babp->tindakan_diambil === 'lain' && $babp->tindakan_lain)
                            <span style="vertical-align: middle; margin-left: 5px;">{{ $babp->tindakan_lain }}</span>
                        @else
                            <span
                                style="border-bottom: 1px solid black; display:inline-block; width: 250px; margin-left: 5px; vertical-align: middle;">&nbsp;</span>
                        @endif
                    </li>
                </ul>
            </li>
        </ol>


        <p>Demikian berita acara pengecekan kesesuaian pembelian barang ini dibuat dengan sebenar-benarnya dan digunakan
            sebagaimana mestinya.</p>
        <div style="page-break-inside: avoid; margin-top: 0;">
            <table style="width: 100%; margin: 0 auto; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PENYEDIA BARANG</p>
                        @if ($babp->tanda_tangan_petugas)
                            <img src="{{ asset('storage/' . $babp->tanda_tangan_petugas) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $babp->petugas->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $babp->petugas->job_role ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">VERIFIKATOR</p>
                        @if ($babp->verifier_signature)
                            <img src="{{ asset('storage/' . $babp->verifier_signature) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $babp->verifier->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $babp->verifier->job_role ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">VALIDATOR</p>
                        @if ($babp->tanda_tangan_penerima)
                            <img src="{{ asset('storage/' . $babp->tanda_tangan_penerima) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $babp->penerima->name_karyawan ?? '-' }}</p>
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $babp->penerima->job_role ?? '-' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>


    </div>
</body>

</html>
