<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $incrementNumber }}. Formulir Pemeliharaan Aset IT_SEVIMA</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
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
            {{ $nomorTemplate ?? '036/TMP.RO.BRT/TIS/' . ($asetMaintenances->company->code ?? '-') }}<br>
            Klasifikasi: <strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ $footerPath }}" style="width: 100%;">
    </footer>

    <!-- CONTENT -->
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="judul-form" rowspan="3">
                        <span>FORMULIR PEMELIHARAAN ASET IT</span>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td>{{ $nomorTemplate ?? '036/TMP.RO.BRT/TIS/' . ($asetMaintenances->company->code ?? '-') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td>{{ $nomorVersion ?? '1.0 - 2025.07.10' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="table-container">
            <table>
                <tbody>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">No. Form</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->nomor_formulir }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Tanggal Pemeliharaan</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->tanggal_surat }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Nama Petugas</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->petugas->name_karyawan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Nama Pemegang Aset</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->pemegang->name_karyawan }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">1. Jenis Pemeliharaan</span>
        <div class="table-container">
            @php
                $jenisPemeliharaan = is_array($jenisPemeliharaan) ? $jenisPemeliharaan : [];

                function checkboxSymbol($value, $selectedArray)
                {
                    return in_array($value, $selectedArray) ? '☑' : '☐';
                }
            @endphp
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
                            <span style="font-family: 'DejaVu Sans', sans-serif;">
                                {{ checkboxSymbol('perawatan', $jenisPemeliharaan) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-center">2</td>
                        <td class="align-left">Perbaikan</td>
                        <td class="align-center">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">
                                {{ checkboxSymbol('perbaikan', $jenisPemeliharaan) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-center">3</td>
                        <td class="align-left">Pergantian Sparepart</td>
                        <td class="align-center">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">
                                {{ checkboxSymbol('pergantian_sparepart', $jenisPemeliharaan) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="judul-form">2. Pengecekan Data Pada Aset</span>
        <div class="table-container">
            @php
                $isMissing = (bool) ($asetMaintenances->missing_data ?? false);
                $ya = $isMissing ? '☑' : '☐';
                $tidak = $isMissing ? '☐' : '☑';
            @endphp

            <table>
                <tbody>
                    <tr>
                        <th class="tabel align-left" style="width: 50%;">Potensi Kehilangan Data?</th>

                        <td class="align-center" style="width: 25%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $ya }}</span> YA
                        </td>

                        <td class="align-center" style="width: 25%; border-left: 1px solid black;">
                            <span style="font-family: 'DejaVu Sans', sans-serif;">{{ $tidak }}</span> TIDAK
                        </td>
                    </tr>

                    <tr>
                        <th class="tabel align-left" style="width: 50%;">Tindak Lanjut Backup<br>(Jika Jawaban “Ya”)
                        </th>

                        <td class="align-left" colspan="2" style="border-left: 1px solid black;">
                            @if ($isMissing && !empty($asetMaintenances->backup_data))
                                {{ $asetMaintenances->backup_data }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <span class="judul-form">3. Detail Pemeliharaan Aset TI</span>
        <div class="table-container">
            <table>
                <thead>
                    <tr style="text-align: center">
                        <th class="align-center tabel">Jenis Aset</th>
                        <th class="align-center tabel">Detail Aset</th>
                        <th class="align-center tabel">Nomor Aset</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-center">{{ $asetMaintenances->jenis_perangkat ?? '-' }}</td>
                        <td class="align-center">{{ $asetMaintenances->aset->merk_aset ?? '-' }}</td>
                        <td class="align-center">{{ $asetMaintenances->aset->nomor_aset ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <table>
                <tbody>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Deskripsi Permasalahan</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->deskripsi_permasalahan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Solusi Yang Dilakukan</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->solusi }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Keterangan Tambahan</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->keterangan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 25%;" class="tabel align-left">Catatan</th>
                        <td style="width: 75%;" class="align-left">{{ $asetMaintenances->catatan }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="page-break-inside: avoid; margin-top: 0;">

            <table style="width: 100%; margin: 0 auto; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK PERTAMA</p>
                        @if ($asetMaintenances->tanda_tangan_petugas)
                            <img src="{{ asset('storage/' . $asetMaintenances->tanda_tangan_petugas) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetMaintenances->petugas->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetMaintenances->petugas->job_role }}
                        </p>
                    </td>
                    <td style="width: 50%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PIHAK KEDUA</p>
                        @if ($asetMaintenances->tanda_tangan_pemegang)
                            <img src="{{ asset('storage/' . $asetMaintenances->tanda_tangan_pemegang) }}"
                                style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetMaintenances->pemegang->name_karyawan }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetMaintenances->pemegang->job_role }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
