<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekomendasi Vendor Terpilih</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
    <h2 style="margin-bottom: 6px;">Rekomendasi Vendor Terpilih</h2>

    <p>
        Berikut ringkasan hasil penawaran aset yang sudah memiliki vendor terpilih.
    </p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; border-color: #d1d5db;">
        <tr>
            <td style="background: #f3f4f6; width: 220px;"><strong>Nomor Kebutuhan</strong></td>
            <td>{{ $assetOfferRequest->request_number ?: '-' }}</td>
        </tr>
        <tr>
            <td style="background: #f3f4f6;"><strong>Nama Barang / Aset</strong></td>
            <td>{{ $assetOfferRequest->item_name ?: '-' }}</td>
        </tr>
        <tr>
            <td style="background: #f3f4f6;"><strong>Kategori</strong></td>
            <td>{{ $assetOfferRequest->category_label ?? '-' }}</td>
        </tr>
        <tr>
            <td style="background: #f3f4f6;"><strong>Jumlah</strong></td>
            <td>{{ $assetOfferRequest->quantity }}</td>
        </tr>
        <tr>
            <td style="background: #f3f4f6;"><strong>PIC Internal</strong></td>
            <td>
                {{ $assetOfferRequest->pic_name ?: '-' }}
                @if($assetOfferRequest->pic_email)
                    <br>{{ $assetOfferRequest->pic_email }}
                @endif
            </td>
        </tr>
        <tr>
            <td style="background: #f3f4f6;"><strong>Status Kebutuhan</strong></td>
            <td>{{ $assetOfferRequest->status_label }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 22px;">Vendor Terpilih</h3>

    @if($selectedOffer)
        <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; border-color: #d1d5db;">
            <tr>
                <td style="background: #f3f4f6; width: 220px;"><strong>Vendor</strong></td>
                <td>{{ $selectedOffer->vendor_name ?: ($selectedOffer->vendor->vendor_name ?? '-') }}</td>
            </tr>
            <tr>
                <td style="background: #f3f4f6;"><strong>No. Penawaran</strong></td>
                <td>{{ $selectedOffer->offer_number ?: '-' }}</td>
            </tr>
            <tr>
                <td style="background: #f3f4f6;"><strong>Harga Satuan</strong></td>
                <td>Rp {{ number_format((float) $selectedOffer->unit_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="background: #f3f4f6;"><strong>Total Harga</strong></td>
                <td><strong>Rp {{ number_format((float) $selectedOffer->total_price, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="background: #f3f4f6;"><strong>Garansi</strong></td>
                <td>{{ $selectedOffer->warranty ?: '-' }}</td>
            </tr>
            <tr>
                <td style="background: #f3f4f6;"><strong>Estimasi Pengiriman</strong></td>
                <td>{{ $selectedOffer->delivery_estimation ?: '-' }}</td>
            </tr>
        </table>
    @else
        <p>Belum ada vendor yang dipilih.</p>
    @endif

    <h3 style="margin-top: 22px;">Spesifikasi Kebutuhan</h3>
    <div style="background: #f9fafb; border: 1px solid #d1d5db; padding: 12px;">
        {!! nl2br(e($assetOfferRequest->required_specification ?: '-')) !!}
    </div>

    <p style="margin-top: 22px;">
        Dokumen rekomendasi vendor terpilih terlampir dalam email ini.
    </p>

    <p style="color: #6b7280; font-size: 12px; margin-top: 28px;">
        Email ini dibuat otomatis oleh sistem IT Asset Management.
    </p>
</body>
</html>