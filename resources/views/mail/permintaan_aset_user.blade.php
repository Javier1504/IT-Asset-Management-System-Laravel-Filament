<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f9fc;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .header {
      background-color: #0061f2;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .content {
      padding: 30px;
      color: #333;
    }

    .content h2 {
      margin-top: 0;
      color: #0061f2;
    }

    .info {
      margin: 20px 0;
      padding: 15px;
      background-color: #f1f5ff;
      border-left: 5px solid #0061f2;
      border-radius: 4px;
      line-height: 1.6;
    }

    .info p {
      margin: 8px 0;
    }

    .footer {
      background-color: #f0f2f5;
      padding: 15px;
      text-align: center;
      font-size: 13px;
      color: #666;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>Permintaan Aset Diajukan</h1>
    </div>

    <div class="content">
      <h2>Halo,</h2>
      <p>
        Permintaan aset dengan judul <strong>"{{ $judulPermintaan }}"</strong> telah berhasil diajukan oleh <strong>{{ $namaPengaju }}</strong> untuk <strong>{{ $namaTarget }}</strong>.
        Permintaan ini saat ini <strong>menunggu persetujuan</strong> dari Admin IT.
      </p>

      <div class="info">
        <p>📌 <strong>Status saat ini:</strong> <span style="color: orange;">Pending</span></p>
        <p>🕒 <strong>Tanggal pengajuan:</strong> {{ $tglPengajuan }}</p>
      </div>

      <p>
        Anda akan menerima notifikasi melalui email setelah permintaan ini diterima atau ditolak.
        Status juga dapat dipantau secara <strong>real-time</strong> melalui aplikasi.
      </p>

      <p>Terima kasih atas perhatian dan kerjasamanya.</p>
    </div>

    <div class="footer">
      &copy; {{ date('Y') }} Mail IT Asset Management. All rights reserved.<br>
    </div>
  </div>

</body>
</html>
