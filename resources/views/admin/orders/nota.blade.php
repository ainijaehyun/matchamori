
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - Matcha Mori</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            background: #f5f4e8;
            color: #222;
            font-family: "Courier New", monospace;
        }

        .nota {
            width: 100%;
            max-width: 380px;
            margin: auto;
            padding: 24px 20px;
            background: #fff;
            border: 1px solid #304a2f;
            border-radius: 4px;
            box-shadow: 0 3px 15px rgba(48, 74, 47, 0.10);
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin: 0 0 5px;
            color: #304a2f;
            font-size: 22px;
            letter-spacing: 2px;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
        }

        .garis {
            margin: 15px 0;
            border: 0;
            border-top: 1px dashed #777;
        }

        .info p {
            display: grid;
            grid-template-columns: 105px 10px minmax(0, 1fr);
            gap: 2px;
            margin: 7px 0;
            font-size: 12px;
            line-height: 1.5;
        }

        .info .nilai {
            overflow-wrap: anywhere;
        }

        .judul-bagian {
            margin: 12px 0;
            font-size: 12px;
            font-weight: bold;
        }

        .produk {
            margin: 14px 0;
            font-size: 12px;
        }

        .nama-produk {
            margin-bottom: 5px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .rincian-produk {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            line-height: 1.6;
        }

        .rincian-produk .harga {
            text-align: right;
            white-space: nowrap;
        }

        .ringkasan p {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 9px 0;
            font-size: 12px;
        }

        .ringkasan .angka {
            text-align: right;
            white-space: nowrap;
        }

        .total {
            font-size: 14px !important;
            font-weight: bold;
        }

        .ucapan {
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
        }

        .ucapan p {
            margin: 5px 0;
        }

        .tombol {
            display: block;
            margin: 22px auto 0;
            padding: 10px 20px;
            background: #6b8a5d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        @media print {
            @page {
                size: 80mm 200mm;
                margin: 0;
            }
            
            html,
            body {
                width: 80mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }

            .nota {
                width: 72mm !important;
                max-width: 72mm !important;
                margin: 0 auto !important;
                padding: 4mm 2mm !important;
                border: 1px solid #304a2f !important;
                border-radius: 2mm !important;
                box-shadow: none !important;
            }

            .tombol {
                display: none !important;
            }

            .info p {
                grid-template-columns: 25mm 3mm minmax(0, 1fr);
                font-size: 9pt;
            }

            .produk,
            .ringkasan p {
                font-size: 9pt;
            }

            .header h1 {
                font-size: 15pt;
            }

            .header p,
            .ucapan {
                font-size: 9pt;
            }

            table,
            .nota,
            .produk,
            .ringkasan,
            .ucapan {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        @media screen and (max-width: 420px) {
            body {
                padding: 10px;
            }

            .nota {
                padding: 18px 12px;
            }
        }
    </style>
</head>

<body>
    
    @php
        $shippingInfo = $order->shipping ?? '';

        // Deteksi metode penerimaan
        $isPickup = str_contains(
            $shippingInfo,
            'Method: Pickup at Matcha Mori Store'
        );

        // Ambil nama pelanggan sebelum bagian Phone
        preg_match(
            '/^\s*(?:Name:\s*)?(.*?)(?=,\s*Phone:|$)/i',
            $shippingInfo,
            $nameMatch
        );

        // Ambil nomor telepon sampai Address atau Method
        preg_match(
            '/Phone:\s*(.*?)(?=,\s*(?:Address|Method):|$)/i',
            $shippingInfo,
            $phoneMatch
        );

        // Ambil alamat sampai Method atau akhir teks
        preg_match(
            '/Address:\s*(.*?)(?=,\s*Method:|$)/i',
            $shippingInfo,
            $addressMatch
        );

        $namaPelanggan = trim($nameMatch[1] ?? '');
        $nomorTelepon = trim($phoneMatch[1] ?? '');
        $alamatPelanggan = trim($addressMatch[1] ?? '');

        // Fallback jika data tidak ditemukan
        $namaPelanggan = $namaPelanggan ?: ($order->user->name ?? '-');
        $nomorTelepon = $nomorTelepon ?: ($order->user->phone ?? '-');
        $alamatPelanggan = $alamatPelanggan ?: ($order->user->address ?? '-');

        $lokasiToko = 'Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah';
    @endphp


    <div class="nota">
        <div class="header">
            <h1>MATCHA MORI</h1>
            <p>Japanese Matcha &amp; Tea Store</p>
            <p>STRUK PESANAN</p>
        </div>

        <hr class="garis">
        
        <div class="info">

            <p>
                <span>No. Invoice</span>
                <span>:</span>
                <span class="nilai">{{ $order->invoice ?? $order->id }}</span>
            </p>

            <p>
                <span>Pelanggan</span>
                <span>:</span>
                <span class="nilai">{{ $namaPelanggan }}</span>
            </p>

            <p>
                <span>No. Telepon</span>
                <span>:</span>
                <span class="nilai">{{ $nomorTelepon }}</span>
            </p>

            <p>
                <span>Penerimaan</span>
                <span>:</span>
                <span class="nilai">
                    {{ $isPickup ? 'Ambil di Tempat' : 'Pengiriman ke Alamat' }}
                </span>
            </p>

            <p>
                <span>{{ $isPickup ? 'Lokasi Toko' : 'Alamat' }}</span>
                <span>:</span>
                <span class="nilai">
                    {{ $isPickup ? $lokasiToko : $alamatPelanggan }}
                </span>
            </p>

            <p>
                <span>Waktu</span>
                <span>:</span>
                <span class="nilai">
                    {{ $order->created_at?->format('d-m-Y H:i') ?? '-' }}
                </span>
            </p>

            <p>
                <span>Pembayaran</span>
                <span>:</span>
                <span class="nilai">{{ $order->payment_method ?? '-' }}</span>
            </p>

        </div>

        <hr class="garis">

        <div class="judul-bagian">RINCIAN PESANAN</div>

        @foreach ($order->orderDetails as $detail)
            <div class="produk">
                <div class="nama-produk">
                    {{ $loop->iteration }}. {{ $detail->product->name ?? 'Produk tidak tersedia' }}
                </div>

                <div class="rincian-produk">
                    <span>
                        {{ $detail->quantity }} x
                        Rp{{ number_format((float) $detail->price, 0, ',', '.') }}
                    </span>

                    <span class="harga">
                        Rp{{ number_format((float) $detail->subtotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endforeach

        <hr class="garis">

        <div class="ringkasan">
            <p>
                <span>Total QTY</span>
                <span class="angka">
                    {{ $order->orderDetails->sum('quantity') }}
                </span>
            </p>
        </div>

        <hr class="garis">

        <div class="ringkasan">
            <p>
                <span>Subtotal</span>
                <span class="angka">
                    Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                </span>
            </p>

            <p class="total">
                <span>TOTAL</span>
                <span class="angka">
                    Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <hr class="garis">

        <div class="ucapan">
            <p><strong>Terima kasih telah berbelanja di</strong></p>
            <p><strong>MATCHA MORI</strong></p>
            <p>Semoga harimu seindah secangkir matcha!</p>
        </div>

        <button class="tombol" onclick="window.print()">
            Cetak Nota
        </button>

    </div>
</body>
</html>
