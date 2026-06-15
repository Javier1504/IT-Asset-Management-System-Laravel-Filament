<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$asetpribadi->id}}. Formulir Pencabutan Penggunaan Aset Pribadi</title>
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
            padding: 95px 20px 60px 20px;
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
            padding: 5px;
        }
        .tabel {
            background-color: #ffcc9c;
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
        <p style="position: fixed; right: 80px; bottom: 96.5%; margin: 0; text-align: right; font-size: 10px; line-height: 1.2;">
            033/TMP.RO.FRM/TIS/SVM <br>
            Klasifikasi: <strong style="color: #ff9900 !important;">RESTRICTED</strong>
        </p>
        <img src="{{ asset('assets/images/footer.png') }}" style="width: 100%;">
    </footer>


    <table>
        <tbody>
            <tr>
                <td class="align-center" rowspan="4">
                    <h2>FORMULIR PENCABUTAN <br>
                        PENGGUNAAN ASET PRIBADI</h2>
                </td>
                <td><strong>Klasifikasi:</strong></td>
                <td ><strong style="color: #ff9900 !important;">RESTRICTED</strong></td>
            </tr>
            <tr>
                <td><strong>Template:</strong></td>
                <td>033/TMP.RO.FRM/TIS/SVM</td>
            </tr>
            <tr>
                <td><strong>Versi:</strong></td>
                <td>1.0 - 2025.08.29</td>
            </tr>
            <tr>
                <td><strong>No. Form:</strong></td>
                <td>{{ $asetpribadi->id }}/FRM.CPAP.1/TIS/SVM/{{ date('Y') }}</td>
            </tr>
        </tbody>
    </table>


    <h1><strong>I. IDENTITAS PIHAK</strong></h1>
    <h2><strong>1. PIHAK PERTAMA</strong></h2>
    <table>
        <tbody>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Nama Karyawan</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->admin->name_karyawan ?? 'Belum ditentukan'}}</strong></td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Unit Kerja</strong></td>
                <td colspan="3"><strong>Divisi IT Support</strong></td>
            </tr>
        </tbody>
    </table>
    <h2><strong>2. PIHAK KEDUA</strong></h2>
    <table>
        <tbody>
            <tr>
                <td class="align-left tabel"  style="width: 30%;"><strong>Nama Personel</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->user->name_karyawan }}</strong></td>
            </tr>
            <tr>
                <td class="tabel"  style="width: 30%;"><strong>Jabatan</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->user->job_role }}</strong></td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Divisi</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->user->team}}</strong></td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Jenis Pemohon</strong></td>
                <td class="align-center"><input type="checkbox" {{ $asetpribadi->is_manager ? '' : 'checked' }}></input><strong>(Non-Manager)</strong></td>
                <td class="align-center" colspan="2"><input type="checkbox" {{ $asetpribadi->is_manager ? 'checked' : '' }}></input><strong>Manager Divisi</strong></td>
            </tr>
        </tbody>
    </table>

    <h1><strong>II. Data Aset Pribadi yang Diajukan</strong></h1>
    <table>
        <thead>
            <tr>
                <th class="align-center tabel"><strong>No</strong></th>
                <th class="align-center tabel"><strong>Jenis Perangkat</strong></th>
                <th class="align-center tabel"><strong>Merk dan Spesifikasi Aset</strong></th>
                <th class="align-center tabel"><strong>No. Seri</strong></th>
                <th class="align-center tabel"><strong>Sistem Operasi</strong></th>
                <th class="align-center tabel"><strong>MAC Address</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td class="" style="text-align: center">1</td>
            <td class="">{{ $asetpribadi->nama_aset }}</td>
            <td class="">{{ $asetpribadi->merk }} - {{ $asetpribadi->tipe }}</td>
            <td class="">{{ $asetpribadi->no_seri }}</td>
            <td class="">{{ $asetpribadi->sistem_os }}</td>
            <td class="">{{ $asetpribadi->mac_address }}</td>
            </tr>
        </tbody>
    </table>

    <h1><strong>III. Alasan Pencabutan</strong></h1>
    <table>
        <tbody>
            <tr>
                <td class="align-left tabel"  style="width: 30%; padding: 15px;"><strong>Alasan Pencabutan Aset Pribadi</strong></td>
                <td class="align-left" colspan="3"><strong>{{ $asetpribadi->alasan_pencabutan_user ?? "Personel belum mengisi" }}</strong></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table style="border: none;">
        <tbody>
            <tr>
                <td colspan="3" class="header" style="border: none;">
                    <h1><strong>
                    IV. Pernyataan Pihak Kedua (Pemohon)
                    <br>
                    </strong></h1>
                </td>
                <td style="border: none;"></td>
                <td colspan="3" class="header" style="border: none;">
                    <h1><strong>
                    V. Verifikasi Backup Data (Oleh Manager/ Penanggung Jawab Data)
                    </h1></strong>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td colspan="3" style="vertical-align: top; width: 500px;">Saya selaku PIHAK KEDUA menyatakan bahwa seluruh data perusahaan yang tersimpan pada perangkat pribadi saya telah dilakukan backup/penyerahan oleh penanggung jawab/manager terkait sesuai dengan ketentuan.</td>
                <td style="border: none; background: none;"></td>
                <td  style="vertical-align: top; width: 200px;">Saya selaku Manager/Penanggung Jawab Data menyatakan bahwa data dari perangkat pribadi milik PIHAK KEDUA:</td>
                <td colspan="2" class="input-space">
                    <strong>Status Backup Data:</strong>
                    <div class="note"></div>
                    <input type="checkbox" {{ $asetpribadi->status_backup == 'sudah_backup' ? 'checked' : '' }}>
                    </input>Sudah dilakukan backup penuh
                    <div class="note"></div>
                    <input type="checkbox" {{ $asetpribadi->status_backup == 'tidak_perlu' ? 'checked' : '' }}>
                    </input>Tidak ada data perusahaan pada perangkat
                    <div class="note"></div>
                </td>
            </tr>
            <tr>
                <td class="label tabel">Nama Personel</td>
                <td colspan="2" class="input-space">{{ $asetpribadi->user->name_karyawan ?? 'Belum diisi' }}</td>
                <td style="border: none; background: none;"></td>
                <td class="label tabel">Nama Karyawan</td>
                <td colspan="2" class="input-space">{{ $asetpribadi->manager->name_karyawan ?? 'Belum diisi' }}</td>
            </tr>
        </tbody>
    </table>
    <h1><strong>VI. Tindakan Pihak Pertama (Divisi IT Support)</strong></h1>
    <table>
        <tbody>
            <tr>
                <td colspan="4" style="padding: 15px;"><strong>Pihak Pertama</strong> telah melakukan pengecekan perangkat milik <strong>Pihak Kedua</strong> dan memastikan:</td>
            </tr>
            <tr>
                <td class="tabel"  style="width: 30%;"><strong>Status Reset Sistem Operasi</strong></td>

                <td colspan="3" class="input-space">
                    <input type="checkbox" {{ $asetpribadi->status_reset_os == 'sudah_reset' ? 'checked' : '' }}>
                    </input>Sudah dilakukan reset sistem operasi
                    <div class="note"></div>
                    <input type="checkbox" {{ $asetpribadi->status_reset_os == 'belum_reset' ? 'checked' : '' }}>
                    </input>Reset tidak bisa dilakukan, sehingga dilakukan install ulang
                    <div class="note"></div>
                </td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Catatan IT Support</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->catatan_admin ?? 'Belum ada catatan' }}</strong></td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Nama Personal IT Support</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->admin->name_karyawan ?? 'Belum ditentukan' }}</strong></td>
            </tr>
            <tr>
                <td class="tabel" style="width: 30%;"><strong>Tanda Tangan Pelaksana</strong></td>
                <td colspan="3"><strong>{{ $asetpribadi->tanda_tangan_admin ? 'Sudah ditandatangani' : 'Belum ditandatangani' }}</strong></td>
            </tr>
        </tbody>
    </table>
    <h1><strong>VII. Pernyataan Penyelesaian</strong></h1>

    <p>Pada hari ini, <strong>{{ $asetpribadi->lampiran['hari'] ?? \Carbon\Carbon::now()->locale('id')->translatedFormat('l') }}</strong> tanggal <strong>{{ $asetpribadi->lampiran['tanggal'] ?? \Carbon\Carbon::now()->format('d') }}</strong> bulan <strong>{{  $asetpribadi->lampiran['bulan'] ?? \Carbon\Carbon::now()->locale('id')->translatedFormat('F') }}</strong> tahun <strong>{{ $asetpribadi->lampiran['tahun'] ?? \Carbon\Carbon::now()->format('Y') }}</strong>, bertempat di PT Sentra Vidya Utama, <strong>dilakukan pencabutan penggunaan aset pribadi milik Pihak Kedua oleh Pihak Pertama dengan hasil bahwa seluruh data perusahaan telah dibackup/diverifikasi oleh Penanggung Jawab Data serta perangkat telah direset sistem operasinya oleh Pihak Pertama.</strong></p>

    <p>Dengan ini kedua belah pihak menyatakan setuju bahwa perangkat pribadi tersebut telah resmi dilepaskan dari sistem perusahaan sesuai ketentuan yang berlaku.</p>

    <table style="width: 100%; margin: 0 auto; text-align: center; border: none;">
        <tbody>
            <tr>
                <td style="width: 33%; border: none; vertical-align: top;">
                    <p class="bold" style="margin-bottom: 4px;">PIHAK PERTAMA</p>
                    @if ($asetpribadi->tanda_tangan_admin)
                        <img src="{{ asset('storage/' . $asetpribadi->tanda_tangan_admin) }}"
                            alt="Tanda Tangan Admin" style="max-height: 80px; border: none;">
                    @else
                        <div style="height: 80px;"></div>
                    @endif
                    <p class="bold" style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                        {{ $asetpribadi->admin->name_karyawan ?? 'menunggu persetujuan' }}
                    </p>
                    <p class="bold" style="margin: 0; line-height: 1;">
                        {{ $asetpribadi->admin->job_role ?? 'menunggu persetujuan' }}
                    </p>
                </td>
                <td style="width: 33%; border: none; vertical-align: top;">
                    <p class="bold" style="margin-bottom: 4px;">VERIFIKASI MANAGER / PJ DATA</p>
                    @if ($asetpribadi->tanda_tangan_manager)
                        <img src="{{ asset('storage/' . $asetpribadi->tanda_tangan_manager) }}"
                            alt="Tanda Tangan Manager" style="max-height: 80px; border: none;">
                    @else
                        <div style="height: 80px;"></div>
                    @endif
                    <p class="bold" style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                        {{ $asetpribadi->manager->name_karyawan ?? '-' }}
                    </p>
                    <p class="bold" style="margin: 0; line-height: 1;">
                        {{ $asetpribadi->manager->job_role ?? '-' }}
                    </p>
                </td>
                <td style="width: 33%; border: none; vertical-align: top;">
                    <p class="bold" style="margin-bottom: 4px;">PIHAK KEDUA</p>
                    @if ($asetpribadi->tanda_tangan_user)
                        <img src="{{ asset('storage/' . $asetpribadi->tanda_tangan_user) }}"
                            alt="Tanda Tangan Pemohon" style="max-height: 80px; border: none;">
                    @else
                        <div style="height: 80px;"></div>
                    @endif
                    <p class="bold" style="text-decoration: underline; margin: 0; line-height: 1.2; padding-top: 10px;">
                        {{ $asetpribadi->user->name_karyawan ?? '-' }}
                    </p>
                    <p class="bold" style="margin: 0; line-height: 1;">
                        {{ $asetpribadi->user->job_role ?? '-' }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
