
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sales Report - Matcha Mori</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #304a2f;
            font-size: 10px;
            background: #ffffff;
        }

        .page {
            position: relative;
            padding-bottom: 35px;
            page-break-after: auto;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .brand {
            border-bottom: 1px solid #dce6d2;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .brand-name {
            font-family: Georgia, serif;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #78866e;
            font-size: 9px;
        }

        .report-heading {
            background: #edf2e5;
            border-left: 5px solid #6b8a5d;
            padding: 15px;
            margin-bottom: 16px;
        }

        .report-heading h1 {
            margin: 0 0 7px;
            font-family: Georgia, serif;
            font-size: 23px;
            color: #304a2f;
        }

        .report-heading p {
            margin: 4px 0;
            color: #64745c;
        }

        .section-title {
            margin: 20px 0 10px;
            font-family: Georgia, serif;
            font-size: 15px;
            color: #304a2f;
        }

        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            margin: 0 -6px 15px;
        }

        .summary td {
            width: 33.33%;
            padding: 13px 10px;
            background: #f1f5eb;
            border: 1px solid #dce6d2;
            vertical-align: top;
        }

        .summary-label {
            margin-bottom: 8px;
            color: #718168;
            font-size: 9px;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #304a2f;
            overflow-wrap: break-word;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .data-table th {
            padding: 9px 6px;
            background: #dfe8d5;
            border: 1px solid #d2dfc7;
            color: #304a2f;
            text-align: left;
            font-size: 8px;
        }

        .data-table td {
            padding: 8px 6px;
            border: 1px solid #e1e7db;
            color: #45513f;
            font-size: 8px;
            vertical-align: top;
            overflow-wrap: break-word;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f7f9f4;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            background: #e8efdf;
            color: #304a2f;
            font-weight: bold;
        }

        .empty {
            padding: 18px !important;
            text-align: center;
            color: #78866e;
        }

        .page-note {
            margin-top: 10px;
            color: #78866e;
            font-size: 8px;
        }

        .recap-table th,
        .recap-table td {
            padding: 10px 8px;
        }

        .conclusion {
            margin-top: 20px;
            padding: 12px 15px;
            background: #eef3e6;
            border-left: 4px solid #6b8a5d;
            border-radius: 2px;
            font-size: 10px;
            line-height: 1.6;
            color: #304a2f;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .conclusion h3 {
            margin: 0 0 8px;
            font-size: 12px;
            color: #304a2f;
        }

        .conclusion p {
            margin: 0;
        }

        /* Footer di akhir laporan */
        .footer {
            position: static;
            width: 100%;
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #d8dfd0;
            text-align: center;
            font-size: 9px;
            line-height: 1.5;
            color: #777;
        }

        .print-button {
            margin-bottom: 18px;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #4f7942;
            color: white;
            font-size: 12px;
            cursor: pointer;
        }

        @media screen {
            body {
                max-width: 850px;
                margin: 25px auto;
                padding: 20px;
            }

            .page {
                min-height: 267mm;
                margin-bottom: 25px;
                padding: 22px 18px 45px;
                border: 1px solid #e1e7db;
                box-shadow: 0 3px 12px rgba(48, 74, 47, 0.08);
            }
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page {
                min-height: 0;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }

             .data-table thead {
                display: table-header-group;
            }

            .data-table tr {
                page-break-inside: avoid;
            }

             .conclusion,
            .footer {
                position: static;
            }
        }
    </style>
</head>

<body>

    <button class="print-button" onclick="window.print()">
        Cetak / Simpan sebagai PDF
    </button>

    {{-- HALAMAN 1 RINGKASAN DAN DAFTAR PESANAN --}}
    <section class="page">

        <div class="brand">
            <div class="brand-name">MATCHA MORI</div>
            <div class="brand-subtitle">
                Japanese Matcha &amp; Tea Store
            </div>
        </div>

        <div class="report-heading">
            <h1>Laporan Penjualan</h1>
            <p>Sales Report — Matcha Mori</p>
            <p>
                Periode:
                <strong>{{ $monthName }} {{ $year }}</strong>
            </p>
            <p>
                Tanggal dibuat:
                {{ now()->format('d-m-Y H:i') }}
            </p>
        </div>

        <div class="section-title">Ringkasan Penjualan</div>

        <table class="summary">
            <tr>
                <td>
                    <div class="summary-label">Total Sales</div>
                    <div class="summary-value">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </div>
                </td>

                <td>
                    <div class="summary-label">Total Order</div>
                    <div class="summary-value">
                        {{ $totalOrders }} Pesanan
                    </div>
                </td>

                <td>
                    <div class="summary-label">Rata-rata per Order</div>
                    <div class="summary-value">
                        Rp {{ number_format($averageOrder, 0, ',', '.') }}
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">Daftar Pesanan</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 18%;">Invoice</th>
                    <th style="width: 21%;">Customer</th>
                    <th style="width: 14%;">Tanggal</th>
                    <th style="width: 13%;">Metode</th>
                    <th style="width: 15%;" class="text-right">Total</th>
                    <th style="width: 14%;">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $order->invoice ?? 'ORD-' . $order->id }}
                        </td>

                        <td>
                            {{ $order->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $order->created_at->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $order->payment_method ?? '-' }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $order->payment_status }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Tidak ada transaksi Paid pada periode ini.
                        </td>
                    </tr>
                @endforelse

                <tr class="total-row">
                    <td colspan="5" class="text-right">
                        TOTAL PENJUALAN
                    </td>

                    <td colspan="2" class="text-right">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="page-note">
            Data transaksi yang ditampilkan merupakan pesanan berstatus Paid
            pada periode yang dipilih.
        </div>

        <div class="section-title">Rekap Penjualan per Bulan</div>

        <table class="data-table recap-table">
            <thead>
                <tr>
                    <th style="width: 10%;">No.</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th class="text-center">Jumlah Order</th>
                    <th class="text-right">Total Sales</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($recapPerMonth as $recap)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::createFromDate( (int) $recap->year, (int) $recap->month, 1 )->translatedFormat('F') }}
                        </td>

                        <td>{{ $recap->year }}</td>

                        <td class="text-center">
                            {{ $recap->total_order }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($recap->total_sales, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada data penjualan berstatus Paid.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="section-title">Kesimpulan</div>

        <div class="conclusion">
            <div class="conclusion-title">
                Ringkasan Penjualan {{ $monthName }} {{ $year }}
            </div>

            Pada periode <strong>{{ $monthName }} {{ $year }}</strong>,
            Matcha Mori mencatat total penjualan sebesar
            <strong>
                Rp {{ number_format($totalSales, 0, ',', '.') }}
            </strong>
            dari <strong>{{ $totalOrders }} transaksi</strong>
            yang telah berstatus Paid.

            @if ($totalOrders > 0)
                Rata-rata nilai setiap transaksi adalah
                <strong>
                    Rp {{ number_format($averageOrder, 0, ',', '.') }}
                </strong>.
            @else
                Belum terdapat transaksi Paid pada periode ini.
            @endif

            Rekap bulanan di atas digunakan untuk melihat perkembangan
            penjualan berdasarkan transaksi yang tercatat dalam sistem.
        </div>

        <div class="footer">
            Matcha Mori — Japanese Matcha &amp; Tea Store<br>
            Laporan dibuat secara otomatis oleh sistem.<br>
        </div>

    </section>

</body>
</html>
