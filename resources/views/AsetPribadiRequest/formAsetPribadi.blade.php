<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $incrementNumber }}. Formulir Permintaan Aset Pribadi_SEVIMA</title>
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
        <img src="{{ asset('assets/images/header.png') }}" alt="Header" style="width: 100%;">
    </header>

    <!-- FOOTER -->
    <footer>
        <p
            style="position: fixed; right: 80px; bottom: 96.5%; margin: 0; text-align: right; font-size: 10px; line-height: 1.2;">
            034/TMP.RO.BRT/TIS/SVM <br>
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
                        <h2>FORMULIR PERMINTAAN PENGGUNAAN <br>
                            ASET PRIBADI</h2>
                    </td>
                    <td><strong>Klasifikasi:</strong></td>
                    <td><strong class="restricted-text" style="color: #ff9900 !important;">RESTRICTED</strong></td>
                </tr>
                <tr>
                    <td><strong>Template:</strong></td>
                    <td><strong>034/TMP.RO.FRM/TIS/SVM</strong></td>
                </tr>
                <tr>
                    <td><strong>Versi:</strong></td>
                    <td><strong>1.0 - 2025.08.29</strong></td>
                </tr>
                <tr>
                    <td><strong>No. Form:</strong></td>
                    <td><strong>{{ $asetpribadiRequest->nomor_surat ?? $asetpribadiRequest->id . '/FRM.MPAP.1/TIS/SVM/' . date('Y') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2><strong>I. Data Pemohon</strong></h2>
        {{-- @dd($asetpribadiRequest) --}}

        <table>
            <tbody>
                <tr>
                    <td class="align-left tabel"><strong>Nama Personel</strong></td>
                    <td colspan="3"><strong>{{ $asetpribadiRequest->user->name_karyawan }}</strong></td>
                </tr>
                <tr>
                    <td class="tabel"><strong>Jabatan</strong></td>
                    <td colspan="3"><strong>{{ $asetpribadiRequest->jabatan_user }}</strong></td>
                </tr>
                <tr>
                    <td class="tabel"><strong>Divisi</strong></td>
                    <td colspan="3"><strong>{{ $asetpribadiRequest->divisi }}</strong></td>
                </tr>
                <tr>
                    <td class="tabel"><strong>Jenis Pemohon</strong></td>
                    <td class="align-center"><input type="checkbox"
                            {{ $asetpribadiRequest->is_manager ? '' : 'checked' }}></input><strong>(Non-Manager)</strong>
                    </td>
                    <td class="align-center" colspan="2"><input type="checkbox"
                            {{ $asetpribadiRequest->is_manager ? 'checked' : '' }}></input><strong>Manager
                            Divisi</strong></td>
                </tr>
                <tr>
                    <td class="tabel"><strong>Tanggal Diajukan Permohonan</strong></td>
                    <td colspan="3"><strong>{{ $asetpribadiRequest->created_at }}</strong></td>
                </tr>
            </tbody>
        </table>
        <h2><strong>II. Data Aset Pribadi yang Diajukan</strong></h2>

        <table>
            <thead>
                <tr>
                    <th class="align-center tabel"><strong>No</strong></th>
                    <th class="align-center tabel"><strong>Jenis Perangkat</strong></th>
                    <th class="align-center tabel"><strong>Merk dan Spesifikasi Aset</strong></th>
                    <th class="align-center tabel"><strong>Sistem Operasi</strong></th>
                    <th class="align-center tabel"><strong>Alasan Penggunaan</strong></th>
                </tr>
            </thead>
            <tbody>

                @php
                    $asetPribadi = is_array($asetpribadiRequest->aset_pribadi)
                        ? $asetpribadiRequest->aset_pribadi
                        : json_decode($asetpribadiRequest->aset_pribadi, true) ?? [];
                @endphp
                @foreach ($asetPribadi as $index => $aset)
                    <tr>
                        <td class="" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="">{{ $aset['nama'] ?? '-' }}</td>
                        <td class="">{{ $aset['tipe'] ?? '-' }} {{ $aset['merk'] ?? '-' }}
                            {{ $aset['no_seri'] ?? '-' }}</td>
                        <td class="">{{ $aset['sistem_os'] ?? '-' }}</td>
                        @if ($index === 0)
                            <td class="align-center" rowspan="{{ count($asetPribadi) }}">
                                {{ $asetpribadiRequest->catatan_user ?? '-' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <table style="border: none;">
            <tbody>
                <tr>
                    <td colspan="3" class="header" style="border: none;">
                        <h2><strong>
                                III. Persetujuan Manager Divisi
                                <br>
                                <span style="font-size: 14px; font-weight: normal;">(Khusus Personel-Non Manager)</span>
                            </strong></h2>
                    </td>
                    <td style="border: none;"></td>
                    <td colspan="3" class="header" style="border: none;">
                        <h2><strong>
                                IV. Evaluasi Divisi IT Support
                        </h2></strong>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td class="label tabel">Nama Manager</td>
                    <td colspan="2" class="input-space">{{ $asetpribadiRequest->manager->name_karyawan ?? ' ' }}
                    </td>
                    <td style="border: none; background: none;"></td>
                    <td class="label tabel">Nama Admin IT</td>
                    <td colspan="2" class="input-space">
                        @if ($asetpribadiRequest->keputusan_manager == 'ditolak')
                            Ditolak oleh manager
                        @elseif ($asetpribadiRequest->keputusan_admin == 'ditolak')
                            {{ $asetpribadiRequest->admin->name_karyawan ?? 'Ditolak oleh admin IT' }}
                        @else
                            {{ $asetpribadiRequest->admin->name_karyawan ?? 'Menunggu persetujuan' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label tabel">Alasan Persetujuan/Penolakan</td>
                    <td colspan="2" class="input-space">{{ $asetpribadiRequest->catatan_manager }}</td>
                    <td style="border: none; background: none;"></td>
                    <td class="label tabel">Catatan Evaluasi</td>
                    <td colspan="2" class="input-space">{{ $asetpribadiRequest->catatan_admin }}</td>
                </tr>
                <tr>
                    <td class="label tabel">Keputusan</td>
                    <td class="align-center"><input type="checkbox"
                            {{ $asetpribadiRequest->keputusan_manager == 'disetujui' ? 'checked' : '' }}></input><strong>Disetujui</strong>
                    </td>
                    <td class="align-center"><input type="checkbox"
                            {{ $asetpribadiRequest->keputusan_manager == 'ditolak' ? 'checked' : '' }}></input><strong>Ditolak</strong>
                    </td>
                    <td style="border: none; background: none;"></td>
                    <td class="label tabel">Keputusan IT</td>
                    <td>
                        <input
                            type="checkbox"{{ $asetpribadiRequest->keputusan_admin == 'disetujui' ? 'checked' : '' }}></input><strong>Layak</strong>
                        <div class="note"></div>
                    </td>
                    <td>
                        <input type="checkbox"
                            {{ $asetpribadiRequest->keputusan_admin == 'ditolak' ? 'checked' : '' }}></input><strong>Tidak
                            Layak</strong>
                        <div class="note"></div>
                    </td>
                </tr>
                <tr>
                    <td class="label tabel">Tanggal Persetujuan</td>
                    <td colspan="2" class="input-space">{{ $asetpribadiRequest->tanda_tangan_manager_at ?? '' }}
                    </td>
                    <td style="border: none; background: none;"></td>
                    <td class="label tabel">Tanggal Evaluasi</td>
                    <td colspan="2" class="input-space">{{ $asetpribadiRequest->tanda_tangan_admin_at ?? '' }}</td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%; margin: 0 auto; text-align: center; border: none;">
            <tbody>
                <tr>
                    <td style="width: 33%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">PEMOHON</p>
                        @if ($asetpribadiRequest->tanda_tangan_user)
                            <img src="{{ asset('storage/' . $asetpribadiRequest->tanda_tangan_user) }}"
                                alt="Tanda Tangan Pemohon" style="max-height: 80px; border: none;">
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetpribadiRequest->user->name_karyawan ?? '-' }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetpribadiRequest->jabatan_user ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 33%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">MANAGER</p>
                        @if ($asetpribadiRequest->tanda_tangan_manager && $asetpribadiRequest->keputusan_manager == 'disetujui')
                            <img src="{{ asset('storage/' . $asetpribadiRequest->tanda_tangan_manager) }}"
                                alt="Tanda Tangan Manager" style="max-height: 80px; border: none;">
                        @elseif ($asetpribadiRequest->keputusan_manager == 'ditolak')
                            <div>
                                <strong>
                                    <p>Proses telah ditolak <br> oleh manager</p>
                                </strong>
                            </div>
                        @else
                            @if ($asetpribadiRequest->is_manager)
                                <div style="height: 80px;"><strong>
                                        <p>Pemohon adalah <br>manager divisi</p>
                                    </strong></div>
                            @else
                                <div style="height: 80px;"></div>
                            @endif
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            {{ $asetpribadiRequest->manager->name_karyawan ?? '-' }}
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            {{ $asetpribadiRequest->jabatan_manager ?? '-' }}
                        </p>
                    </td>
                    <td style="width: 33%; border: none; vertical-align: top;">
                        <p class="bold" style="margin-bottom: 4px;">ADMIN</p>
                        @if ($asetpribadiRequest->tanda_tangan_admin && $asetpribadiRequest->keputusan_admin == 'disetujui')
                            <img src="{{ asset('storage/' . $asetpribadiRequest->tanda_tangan_admin) }}"
                                alt="Tanda Tangan Admin" style="max-height: 80px; border: none;">
                        @elseif ($asetpribadiRequest->keputusan_admin == 'ditolak')
                            <div>
                                <strong>
                                    <p>Proses telah ditolak <br> oleh admin IT</p>
                                </strong>
                            </div>
                        @elseif ($asetpribadiRequest->keputusan_manager == 'ditolak')
                            <div>
                                <strong>
                                    <p>Proses telah ditolak <br> oleh manager</p>
                                </strong>
                            </div>
                        @else
                            <div style="height: 80px;"></div>
                        @endif
                        <p class="bold"
                            style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                            @if ($asetpribadiRequest->keputusan_manager == 'ditolak')
                                Ditolak oleh manager
                            @elseif ($asetpribadiRequest->keputusan_admin == 'ditolak')
                                {{$asetpribadiRequest->admin->name_karyawan ?? 'ditolak oleh admin IT' }}
                            @else
                                {{ $asetpribadiRequest->admin->name_karyawan ?? 'menunggu persetujuan' }}
                            @endif
                        </p>
                        <p class="bold" style="margin: 0; line-height: 1;">
                            Admin IT
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
