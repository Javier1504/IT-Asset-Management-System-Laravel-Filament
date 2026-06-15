<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background-color: #0061f2;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .content h2 {
            margin-top: 0;
            color: #0061f2;
        }

        .info-box {
            margin-top: 20px;
            background-color: #f1f5ff;
            border-left: 5px solid #0061f2;
            padding: 15px 20px;
            border-radius: 4px;
        }

        .info-box p {
            margin: 10px 0;
        }

        .footer {
            background-color: #f0f2f5;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .note {
            background-color: #fff8dc;
            border-left: 4px solid #ffc107;
            padding: 10px 15px;
            margin-top: 15px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Status Permintaan Aset</h1>
        </div>

        <div class="content">
            <h2>Halo,</h2>
            <p>
                Permintaan aset berjudul <strong>"{{ $judulPermintaan }}"</strong> yang diajukan oleh
                <strong>{{ $namaPengaju }}</strong> untuk <strong>{{ $namaTarget }}</strong> telah
                <strong style="color: {{ $status === 'diterima' ? '#28a745' : '#dc3545' }};">
                    {{ strtoupper($status) }}
                </strong> oleh Admin IT.
            </p>

            <div class="info-box">
                <p>📌 <strong>Status:</strong>
                    <span style="color: {{ $status == 'diterima' ? '#28a745' : '#dc3545' }};">
                        {{ $status === 'diterima' ? 'Diterima' : 'Ditolak' }}
                    </span>
                </p>
                <p>🕒 <strong>Tanggal {{ $status === 'ditolak' ? 'Penolakan' : 'Persetujuan' }}:</strong>
                    {{ $tglApproval }}
                </p>
                <p class="note">🗒️ <strong>Catatan Admin:</strong> {{ $catatan }}</p>
            </div>

            @if($status === 'ditolak')
                <p>Silakan tinjau kembali di aplikasi atau hubungi Admin IT jika diperlukan. Terima kasih.</p>
            @else
                <p>Silakan lihat detail lengkapnya melalui aplikasi. Terima kasih.</p>
            @endif
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} IT Asset Management System. All rights reserved.
        </div>
    </div>
</body>

</html>
