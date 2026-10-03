@extends('layouts.customers')

@section('title', 'Order Confirmation')

@push('styles')
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="confirmation-page">
    <div class="confirmation-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">Home</a>
        <span>&gt;</span> Confirmation
    </div>

    <div class="confirmation-success">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Order Confirmed!</h1>

        <p>
            Your order has been successfully placed.
        </p>
    </div>

    <div class="confirmation-content">
        <div class="confirmation-card">
            <div class="confirmation-card-title">
                <h2>Order Information</h2>
            </div>

            <div class="order-info">
                <div class="order-info-row">
                    <span>Invoice</span>
                    <strong>{{ $order->invoice }}</strong>
                </div>

                <div class="order-info-row">
                    <span>Order Status</span>
                    <strong>{{ $order->order_status }}</strong>
                </div>

                <div class="order-info-row">
                    <span>Payment</span>
                    <strong>Bayar di tempat (COD)</strong>
                </div>

                <div class="order-info-row">
                    <span>Payment Status</span>
                    <strong>{{ $order->payment_status }}</strong>
                </div>

            </div>

        </div>

        <div class="confirmation-card">
            <div class="confirmation-card-title">
                <h2>Shipping Information</h2>
            </div>

            <div class="shipping-info">
                <p>
                    {{ $order->shipping }}
                </p>

                <p>
                    Postal Code: {{ $order->postal_code }}
                </p>
            </div>

        </div>

        <div class="confirmation-card">
            <div class="confirmation-card-title">
                <h2>Order Details</h2>
            </div>

            <div class="confirmation-products">

                @foreach($order->orderDetails as $detail)

                    <div class="confirmation-product">
                        <div class="product-detail">

                            <div class="product-name">
                                {{ $detail->product->name }}
                            </div>

                            <div class="product-quantity">
                                x{{ $detail->quantity }}
                            </div>
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="confirmation-total">
                <span>Total</span>

                <strong>
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="confirmation-buttons">
            <a href="{{ route('customer.orders.show', $order->id) }}" 
                class="view-order-button">
                View Order
            </a>
            <a href="{{ route('customer.dashboard') }}"
                class="back-home-button">
                Back to Home
            </a>
        </div>

    </div>

</div>

@endsection


