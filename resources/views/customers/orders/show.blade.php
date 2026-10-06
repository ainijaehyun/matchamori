@extends('layouts.customers')

@section('title', 'Order Detail')

@push('styles')
    <link href="{{ asset('css/customer-order.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="order-detail-page">

    {{-- BREADCRUMB --}}
    <div class="order-detail-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>

        <span>&gt;</span>

        <a href="{{ route('customer.orders.index') }}">
            Order
        </a>

        <span>&gt;</span>

        Order Detail
    </div>


    {{-- HEADING --}}
    <div class="order-detail-heading">
        <h1>Order Detail - {{ $order->invoice }}</h1>
    </div>


    {{-- ONE CARD --}}
    <div class="order-detail-card">

        {{-- =========================
             ORDER INFORMATION
        ========================== --}}

        <div class="detail-row">
            <span>Order ID</span>
            <span>=</span>
            <strong>
                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Invoice</span>
            <span>=</span>
            <strong>
                {{ $order->invoice }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Payment</span>
            <span>=</span>
            <strong>
                {{ $order->payment_method }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Courier</span>
            <span>=</span>
            <strong>
                {{ $order->courier }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Delivery Service</span>
            <span>=</span>
            <strong>
                {{ $order->delivery_service }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Status</span>
            <span>=</span>

            <a href="{{ route('customer.orders.status', $order->id) }}"
               class="detail-status">
                {{ $order->order_status }}
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="detail-row">
            <span>Payment Status</span>
            <span>=</span>
            <strong>
                {{ $order->payment_status }}
            </strong>
        </div>

        <div class="detail-row">
            <span>Create At</span>
            <span>=</span>
            <strong>
                {{ $order->created_at->format('d F Y H:i:s') }}
            </strong>
        </div>


        {{-- PEMISAH --}}
        <div class="order-detail-divider"></div>


        {{-- =========================
             ORDER DETAILS
        ========================== --}}

        <div class="order-products-title">
            <h2>Order Details</h2>
        </div>


        {{-- PRODUCT --}}
        @foreach($order->orderDetails as $detail)

            <div class="product-detail-item">

                <div class="detail-row">
                    <span>Product ID</span>
                    <span>=</span>
                    <strong>
                        {{ $detail->product_id }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Product</span>
                    <span>=</span>
                    <strong>
                        {{ $detail->product->name }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Quantity</span>
                    <span>=</span>
                    <strong>
                        {{ $detail->quantity }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Price</span>
                    <span>=</span>
                    <strong>
                        Rp. {{ number_format($detail->price, 0, ',', '.') }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Subtotal</span>
                    <span>=</span>
                    <strong>
                        Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </strong>
                </div>

            </div>

        @endforeach


        {{-- PEMISAH SEBELUM TOTAL --}}
        <div class="order-detail-divider"></div>


        {{-- TOTAL --}}
        <div class="detail-row order-total-row">
            <span>Total</span>
            <span>=</span>
            <strong>
                Rp. {{ number_format($order->total, 0, ',', '.') }}
            </strong>
        </div>


        {{-- =========================
             ORDER RECEIVED
        ========================== --}}

        @if($order->order_status === 'On Delivery')

            <div class="confirm-order-section">

                <p>
                    Pesanan sedang dalam perjalanan.
                    Jika pesanan sudah sampai, silakan konfirmasi.
                </p>

                <form
                    action="{{ route('customer.orders.confirmReceived', $order->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="confirm-received-button">
                        <i class="fas fa-check"></i>
                        Pesanan Sudah Diterima
                    </button>
                </form>

            </div>

        @elseif($order->order_status === 'Delivered')

            <div class="order-delivered-message">
                <i class="fas fa-check-circle"></i>
                <span>Pesanan sudah diterima</span>
            </div>

        @endif

    </div>


    {{-- BACK BUTTON --}}
    <div class="order-detail-actions">

        <a href="{{ route('customer.orders.index') }}"
           class="back-order">
            Back
        </a>

    </div>

</div>

@endsection