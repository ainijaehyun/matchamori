@extends('layouts.app')

@section('title', 'Show Order')

@push('styles')
    <link href="{{ asset('css/order.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="order-show-page">
    <h1 class="order-show-title">
        Order Detail
    </h1>

    <div class="order-detail-card">
        <div class="detail-row">
            <div class="detail-label">
                User_id
            </div>

            <div class="detail-value">
                {{ $order->user->name ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Invoice
            </div>

            <div class="detail-value">
                {{ $order->invoice }}
            </div>
        </div>
       
        @php
            $shippingInfo = $order->shipping ?? '';

            // Deteksi metode penerimaan
            $isPickup = str_contains(
                $shippingInfo,
                'Method: Pickup at Matcha Mori Store'
            );

            // Mengambil nama penerima sampai sebelum Phone
            preg_match(
                '/(?:^|,\s*)Name:\s*(.*?)(?=,\s*Phone:|$)/i',
                $shippingInfo,
                $nameMatch
            );

            // Mengambil nomor telepon sampai sebelum Address
            preg_match(
                '/(?:^|,\s*)Phone:\s*(.*?)(?=,\s*Address:|,\s*Method:|$)/i',
                $shippingInfo,
                $phoneMatch
            );

            // Mengambil alamat sampai sebelum Method
            preg_match(
                '/(?:^|,\s*)Address:\s*(.*?)(?=,\s*Method:|$)/i',
                $shippingInfo,
                $addressMatch
            );

            // Hasil data
            $recipientName = trim($nameMatch[1] ?? '');
            $recipientPhone = trim($phoneMatch[1] ?? '');
            $recipientAddress = trim($addressMatch[1] ?? '');

            // Fallback jika data tidak ditemukan
            $recipientName = $recipientName ?: ($order->user->name ?? '-');
            $recipientPhone = $recipientPhone ?: ($order->user->phone ?? '-');
            $recipientAddress = $recipientAddress ?: ($order->user->address ?? '-');
        @endphp


        <div class="detail-row">
            <div class="detail-label">
                Metode Penerimaan
            </div>

            <div class="detail-value">
                @if($isPickup)
                    <span class="reception-status pickup">
                        Ambil di Tempat
                    </span>
                @else
                    <span class="reception-status delivery">
                        Pengiriman ke Alamat
                    </span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Nama Penerima
            </div>

            <div class="detail-value">
                {{ $recipientName }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Nomor Telepon
            </div>

            <div class="detail-value">
                {{ $recipientPhone }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                {{ $isPickup ? 'Lokasi Pengambilan' : 'Alamat Pengiriman' }}
            </div>

            <div class="detail-value">
                @if($isPickup)
                    Matcha Mori Store
                    <br>
                    Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah
                    <br>
                    <small>Customer mengambil pesanan langsung di toko.</small>
                @else
                    {{ $recipientAddress }}
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Total
            </div>

            <div class="detail-value">
                Rp. {{ number_format($order->total, 0, ',', '.') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Payment status
            </div>

            <div class="detail-value">
                {{ $order->payment_status }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Status
            </div>

            <div class="detail-value">
                <a href="{{ route('admin.orders.status', $order->id) }}"
                   class="order-status">
                    {{ $order->order_status }}
                </a>
            </div>
        </div>

        <div class="detail-row date-row">
            <div class="detail-label">
                Create at
            </div>

            <div class="detail-value">
                {{ $order->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Update at
            </div>

            <div class="detail-value">
                {{ $order->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>
    </div>
    
    {{-- Produk Order --}}
    <div class="order-items-card">
        <div class="order-items-header">
            <div>
                <h2 class="order-items-title">Order Items</h2>
                <p class="order-items-subtitle">
                    Daftar produk dalam pesanan ini
                </p>
            </div>

            <span class="order-items-count">
                {{ $order->orderDetails->count() }}
                {{ $order->orderDetails->count() == 1 ? 'Product' : 'Products' }}
            </span>
        </div>

        <div class="order-items-wrapper">
            <table class="order-items-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($order->orderDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <div class="order-product-info">
                                    <div class="order-product-image">
                                        @if ($detail->product && $detail->product->image)
                                            <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">
                                        @else
                                            <div class="order-product-placeholder">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="order-product-text">
                                        <span class="order-product-name">
                                            {{ $detail->product->name ?? 'Product unavailable' }}
                                        </span>
                                        <small>Matcha Mori</small>
                                    </div>
                                </div>
                            </td>

                            <td class="order-item-price">
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="order-item-quantity">
                                    {{ $detail->quantity }}
                                </span>
                            </td>

                            <td class="order-item-subtotal">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="order-items-empty">
                                Belum ada produk dalam pesanan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="order-items-total">
            <span>Total Pesanan</span>
            <strong>
                Rp {{ number_format($order->total, 0, ',', '.') }}
            </strong>
        </div>
    </div>


    <div class="form-buttons">
        <a href="{{ route('admin.orders.index') }}" class="btn-back">
            Back
        </a>
    </div>
</div>

@endsection
