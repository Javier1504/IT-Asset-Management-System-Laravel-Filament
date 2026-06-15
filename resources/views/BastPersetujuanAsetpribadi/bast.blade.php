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
$formattedDate = \Carbon\Carbon::parse($bast->tanggal)->locale('id')->isoFormat('DD-MM-YYYY');

// Convert day and year to words
$dayInWords = numberToWords(\Carbon\Carbon::parse($bast->tanggal)->day);
$yearInWords = numberToWords(\Carbon\Carbon::parse($bast->tanggal)->year);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAST Persetujuan Aset Pribadi - {{ $bast->nomor_surat }}</title>

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
            032/TMP.RO.BRT/TIS/SVM <br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ asset('assets/images/footer.png') }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="align-center" rowspan="4">
                        <h2>BERITA ACARA <br> PERSETUJUAN PENGGUNAAN ASET PRIBADI</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>032/TMP.RO.BRT/TIS/SVM</td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>1.0 - 2025.08.29</td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td>{{ $bast->nomor_surat }}</td>
                </tr>
            </tbody>
        </table>


        <p>Pada hari ini, <b>{{ \Carbon\Carbon::parse($bast->tanggal)->locale('id')->isoFormat('dddd') }} tanggal
                {{ $dayInWords }} bulan
                {{ \Carbon\Carbon::parse($bast->tanggal)->locale('id')->isoFormat('MMMM') }} tahun
                {{ $yearInWords }} ({{ $formattedDate }})</b>, telah dibuat dan ditandatangani <strong>Acara
                Persetujuan Penggunaan Aset Pribadi</strong> oleh dan antara yang bertanda tangan dibawah ini:</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">1.</td>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {{ $bast->pihakPertama->name_karyawan }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1.2; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Alamat</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {!! strlen($bast->pihakPertama->alamat) > 50
                        ? wordwrap($bast->pihakPertama->alamat, 80, '<br>')
                        : $bast->pihakPertama->alamat !!}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1.2; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {{ $bast->pihakPertama->job_role }}</td>
            </tr>
        </table>

        <p style="margin: 0 0 5px 15px;">Selanjutnya disebut sebagai <b>PIHAK PERTAMA (Perwakilan Divisi IT Support)
            </b>.</p>

        <table
            style="width: 100%; border-collapse: collapse; border: none; margin-left: 15px; margin-bottom: 5px; font-size: 12px;">
            <tr>
                <td style="width: 20px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">2.</td>
                <td style="width: 120px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">Nama Lengkap
                </td>
                <td style="width: 10px; vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {{ $bast->pihakKedua->name_karyawan }}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1.2; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Alamat</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {!! strlen($bast->pihakKedua->alamat) > 50
                        ? wordwrap($bast->pihakKedua->alamat, 80, '<br>')
                        : $bast->pihakKedua->alamat !!}</td>
            </tr>
            <tr>
                <td style="padding: 0; line-height: 1.2; border: none;"></td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">Jabatan</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">:</td>
                <td style="vertical-align: top; padding: 0; line-height: 1.2; border: none;">
                    {{ $bast->pihakKedua->job_role }}</td>
            </tr>
        </table>
        <p>Selanjutnya disebut sebagai <b>PIHAK KEDUA (Pemilik Laptop Pribadi)</b>.</p>

        <p><b>PIHAK KEDUA</b> menyatakan akan menggunakan laptop pribadi untuk menunjang aktivitas kerja dan bersedia
            mengikuti seluruh ketentuan keamanan informasi yang berlaku, sebagaimana diatur dalam SOP Pengelolaan Aset
            IT No.001/PO.SOP/TIS/SVM.</p>

        <p>Adapun perangkat yang digunakan adalah sebagai berikut:</p>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="align-center tabel"><strong>No</strong></th>
                        <th class="align-center tabel"><strong>Tipe Laptop</strong></th>
                        <th class="align-center tabel"><strong>Serial Number</strong></th>
                        <th class="align-center tabel"><strong>Mac Address</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bast->asetpribadiRequests as $index => $aset)
                        @php
                            $aset = is_array($aset->aset_pribadi)
                                ? $aset->aset_pribadi
                                : json_decode($aset->aset_pribadi, true) ?? [];
                        @endphp
                        <tr>
                            <td class="" style="text-align: center">{{ $index + 1 }}</td>
                            <td class="">{{ $aset[0]['nama'] ?? '-' }}</td>
                            <td class="">{{ $aset[0]['no_seri'] ?? '-' }} </td>
                            <td class="">{{ $aset[0]['mac_address'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p>Dengan ini, <strong>PIHAK PERTAMA</strong> menyatakan:</p>

        <ol style="margin-left: 30px;">
            <li>Mengizinkan <strong>PIHAK KEDUA</strong> untuk melakukan instalasi perangkat lunak penunjang kerja,
                backup data, pengecekan keamanan, dan penghapusan data kerja saat perpindahan tugas personel dan saat
                masa kerja berakhir.</li>
            <li>Bertanggung jawab penuh atas kondisi fisik perangkat pribadi dan tidak menuntut perusahaan atas
                kerusakan perangkat pribadi.</li>
            <li>Bersedia menjalani proses evaluasi perangkat secara berkala atau sewaktu-waktu jika diperlukan.</li>
            <li>Mengetahui bahwa masa berlaku persetujuan ini adalah 12 bulan dan dapat diperpanjang berdasarkan
                evaluasi.</li>
            <li>Menyetujui bahwa perusahaan dapat mencabut izin penggunaan laptop pribadi jika terjadi pelanggaran
                terhadap ketentuan yang berlaku atau jika terdapat perubahan kebijakan internal perusahaan.</li>
        </ol>

        <p>Demikian <strong>Acara Persetujuan Penggunaan Aset Pribadi</strong> ini dibuat dan ditandatangani oleh para
            pihak dengan sebenar-benarnya dan digunakan sebagaimana mestinya.</p>
        <div class="signature-section">
            <table style="width: 100%; margin: 30px auto 0; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK PERTAMA</p>
                        @if ($bast->tanda_tangan_pihak_pertama)
                            <img src="{{ asset('storage/' . $bast->tanda_tangan_pihak_pertama) }}"
                                style="max-height: 80px; border: none;">
                        @elseif ($bast->status == 'cancelled')
                            <Strong>
                                Proses dibatalkan<br>oleh PIHAK KEDUA
                            </Strong>
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $bast->pihakPertama->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $bast->pihakPertama->job_role }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK KEDUA</p>
                        @if ($bast->tanda_tangan_pihak_kedua)
                            <img src="{{ asset('storage/' . $bast->tanda_tangan_pihak_kedua) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $bast->pihakKedua->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $bast->pihakKedua->job_role }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
