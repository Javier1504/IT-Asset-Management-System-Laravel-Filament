<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $documentTitle }}</title>

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
            font-family: 'Inter', DejaVu Sans, sans-serif;
            font-size: 11px;
            text-align: justify;
            margin: 0;
            padding: 118px 24px 88px 24px;
            box-sizing: border-box;
            line-height: 1.25;
            color: #000;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 92px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            z-index: -1;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 66px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            z-index: -1;
        }

        .container {
            width: 100%;
            padding: 0;
            box-sizing: border-box;
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
            vertical-align: top;
        }

        .align-center {
            text-align: center;
        }

        .align-left {
            text-align: left;
        }

        .align-right {
            text-align: right;
        }

        .bold {
            font-weight: 600;
        }

        .tabel {
            background-color: #ffcc9c;
            font-weight: 600;
        }

        .section-title {
            background-color: #ffcc9c;
            font-weight: 600;
            text-align: left;
        }

        .no-border,
        .no-border td,
        .no-border th {
            border: none !important;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        .mb-16 {
            margin-bottom: 16px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        .mt-16 {
            margin-top: 16px;
        }

        .small {
            font-size: 9px;
        }

        .title-document {
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            line-height: 1.35;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 5px;
            border: 1px solid #000;
            font-size: 9px;
            font-weight: 600;
        }

        .signature-table,
        .signature-table td {
            border: none !important;
        }

        .signature-space {
            height: 55px;
        }

        .signature-name {
            display: inline-block;
            min-width: 170px;
            border-top: 1px solid #000;
            padding-top: 4px;
            font-weight: 600;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
<header>
    <img src="{{ public_path('assets/images/header.png') }}" style="width: 100%;">
</header>

<footer>
    <img src="{{ public_path('assets/images/footer.png') }}" style="width: 100%;">
</footer>

<div class="container">
    <table class="mb-16">
        <tbody>
            <tr>
                <td class="align-center" rowspan="4" style="width: 58%;">
                    <div class="title-document">
                        {{ strtoupper($documentTitle) }}
                    </div>
                </td>
                <td class="bold" style="width: 18%;">No. Dokumen</td>
                <td style="width: 24%;">{{ $assetOfferRequest->request_number ?: '-' }}</td>
            </tr>
            <tr>
                <td class="bold">Tanggal Cetak</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="bold">Status</td>
                <td>{{ $assetOfferRequest->status_label }}</td>
            </tr>
            <tr>
                <td class="bold">Klasifikasi</td>
                <td>RESTRICTED</td>
            </tr>
        </tbody>
    </table>

    <table class="mb-12">
        <tbody>
            <tr>
                <td class="section-title" colspan="4">A. INFORMASI KEBUTUHAN ASET</td>
            </tr>

            <tr>
                <td class="bold" style="width: 22%;">Nomor Kebutuhan</td>
                <td style="width: 28%;">{{ $assetOfferRequest->request_number ?: '-' }}</td>
                <td class="bold" style="width: 22%;">Tanggal Dibutuhkan</td>
                <td style="width: 28%;">
                    {{ $assetOfferRequest->needed_date ? $assetOfferRequest->needed_date->format('d/m/Y') : '-' }}
                </td>
            </tr>

            <tr>
                <td class="bold">Nama Barang / Aset</td>
                <td>{{ $assetOfferRequest->item_name ?: '-' }}</td>
                <td class="bold">Kategori</td>
                <td>{{ $assetOfferRequest->category_label ?? '-' }}</td>
            </tr>

            <tr>
                <td class="bold">Jumlah Kebutuhan</td>
                <td>{{ $assetOfferRequest->quantity }}</td>
                <td class="bold">PIC Internal</td>
                <td>
                    {{ $assetOfferRequest->pic_name ?: '-' }}
                    @if($assetOfferRequest->pic_email)
                        <br>
                        <span class="small">{{ $assetOfferRequest->pic_email }}</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td class="bold">Estimasi Budget / Unit</td>
                <td>
                    {{ $assetOfferRequest->estimated_unit_budget
                        ? 'Rp ' . number_format((float) $assetOfferRequest->estimated_unit_budget, 0, ',', '.')
                        : '-' }}
                </td>
                <td class="bold">Estimasi Total Budget</td>
                <td>
                    {{ $assetOfferRequest->estimated_total_budget
                        ? 'Rp ' . number_format((float) $assetOfferRequest->estimated_total_budget, 0, ',', '.')
                        : '-' }}
                </td>
            </tr>

            <tr>
                <td class="bold">Spesifikasi Kebutuhan</td>
                <td colspan="3">{!! nl2br(e($assetOfferRequest->required_specification ?: '-')) !!}</td>
            </tr>

            <tr>
                <td class="bold">Catatan</td>
                <td colspan="3">{!! nl2br(e($assetOfferRequest->notes ?: '-')) !!}</td>
            </tr>
        </tbody>
    </table>

    <table class="mb-12">
        <thead>
            <tr>
                <th class="section-title" colspan="9">B. PERBANDINGAN PENAWARAN VENDOR</th>
            </tr>
            <tr class="tabel">
                <th style="width: 4%;">No</th>
                <th style="width: 17%;">Vendor</th>
                <th style="width: 13%;">No. Penawaran</th>
                <th style="width: 11%;">Tanggal</th>
                <th style="width: 12%;">Harga Unit</th>
                <th style="width: 12%;">Total Harga</th>
                <th style="width: 10%;">Garansi</th>
                <th style="width: 12%;">Estimasi Kirim</th>
                <th style="width: 9%;">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($assetOfferRequest->vendorOffers as $index => $offer)
                <tr>
                    <td class="align-center">{{ $index + 1 }}</td>

                    <td>
                        <span class="bold">
                            {{ $offer->vendor_name ?: ($offer->vendor->vendor_name ?? '-') }}
                        </span>

                        @if($offer->vendor_pic_name)
                            <br>
                            <span class="small">PIC: {{ $offer->vendor_pic_name }}</span>
                        @endif

                        @if($offer->vendor_email)
                            <br>
                            <span class="small">{{ $offer->vendor_email }}</span>
                        @endif

                        @if($offer->vendor_phone)
                            <br>
                            <span class="small">{{ $offer->vendor_phone }}</span>
                        @endif
                    </td>

                    <td>
                        {{ $offer->offer_number ?: '-' }}

                        @if($offer->valid_until)
                            <br>
                            <span class="small">
                                Berlaku s/d {{ $offer->valid_until->format('d/m/Y') }}
                            </span>
                        @endif
                    </td>

                    <td class="align-center">
                        {{ $offer->offer_date ? $offer->offer_date->format('d/m/Y') : '-' }}
                    </td>

                    <td class="align-right">
                        Rp {{ number_format((float) $offer->unit_price, 0, ',', '.') }}
                    </td>

                    <td class="align-right bold">
                        Rp {{ number_format((float) $offer->total_price, 0, ',', '.') }}
                    </td>

                    <td>{{ $offer->warranty ?: '-' }}</td>

                    <td>{{ $offer->delivery_estimation ?: '-' }}</td>

                    <td class="align-center">
                        <span class="status-badge">
                            {{ $offer->status_label }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="align-center">
                        Belum ada penawaran vendor.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="mb-12">
        <tbody>
            <tr>
                <td class="section-title" colspan="4">C. RINGKASAN HASIL PERBANDINGAN</td>
            </tr>

            <tr>
                <td class="bold" style="width: 25%;">Jumlah Vendor Pembanding</td>
                <td style="width: 25%;">{{ $assetOfferRequest->vendorOffers->count() }} vendor</td>
                <td class="bold" style="width: 25%;">Status Kebutuhan</td>
                <td style="width: 25%;">{{ $assetOfferRequest->status_label }}</td>
            </tr>

            <tr>
                <td class="bold">Penawaran Terendah</td>
                <td colspan="3">
                    @if($lowestOffer)
                        {{ $lowestOffer->vendor_name ?: ($lowestOffer->vendor->vendor_name ?? '-') }}
                        —
                        <span class="bold">
                            Rp {{ number_format((float) $lowestOffer->total_price, 0, ',', '.') }}
                        </span>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td class="bold">Vendor Terpilih</td>
                <td colspan="3">
                    @if($selectedOffer)
                        {{ $selectedOffer->vendor_name ?: ($selectedOffer->vendor->vendor_name ?? '-') }}
                        —
                        <span class="bold">
                            Rp {{ number_format((float) $selectedOffer->total_price, 0, ',', '.') }}
                        </span>
                    @else
                        Belum ada vendor yang dipilih.
                    @endif
                </td>
            </tr>

            <tr>
                <td class="bold">Catatan Rekomendasi</td>
                <td colspan="3">
                    @if($selectedOffer)
                        Vendor terpilih berdasarkan hasil perbandingan penawaran, harga, garansi,
                        estimasi pengiriman, dan kebutuhan aset internal.
                    @else
                        Dokumen ini masih berupa ringkasan perbandingan. Vendor belum ditetapkan.
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    @if($documentType === 'selected' && $selectedOffer)
        <table class="mb-12">
            <tbody>
                <tr>
                    <td class="section-title" colspan="4">D. DETAIL VENDOR TERPILIH</td>
                </tr>

                <tr>
                    <td class="bold" style="width: 25%;">Nama Vendor</td>
                    <td style="width: 25%;">
                        {{ $selectedOffer->vendor_name ?: ($selectedOffer->vendor->vendor_name ?? '-') }}
                    </td>
                    <td class="bold" style="width: 25%;">No. Penawaran</td>
                    <td style="width: 25%;">{{ $selectedOffer->offer_number ?: '-' }}</td>
                </tr>

                <tr>
                    <td class="bold">Harga Unit</td>
                    <td>Rp {{ number_format((float) $selectedOffer->unit_price, 0, ',', '.') }}</td>
                    <td class="bold">Total Harga</td>
                    <td class="bold">Rp {{ number_format((float) $selectedOffer->total_price, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <td class="bold">Garansi</td>
                    <td>{{ $selectedOffer->warranty ?: '-' }}</td>
                    <td class="bold">Estimasi Pengiriman</td>
                    <td>{{ $selectedOffer->delivery_estimation ?: '-' }}</td>
                </tr>

                <tr>
                    <td class="bold">Email Vendor</td>
                    <td>{{ $selectedOffer->vendor_email ?: '-' }}</td>
                    <td class="bold">Telepon Vendor</td>
                    <td>{{ $selectedOffer->vendor_phone ?: '-' }}</td>
                </tr>
            </tbody>
        </table>

        <table class="signature-table mt-16">
            <tbody>
                <tr>
                    <td class="align-center">
                        Dibuat oleh,
                        <div class="signature-space"></div>
                        <span class="signature-name">
                            {{ $assetOfferRequest->createdByUser->name_karyawan
                                ?? $assetOfferRequest->createdByUser->username
                                ?? $assetOfferRequest->createdByUser->corporate_email
                                ?? '-' }}
                        </span>
                    </td>

                    <td class="align-center">
                        Mengetahui,
                        <div class="signature-space"></div>
                        <span class="signature-name">
                            {{ $assetOfferRequest->pic_name ?: 'PIC Internal' }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
</body>
</html>