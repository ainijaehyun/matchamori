@extends('layouts.customers')

@section('title', 'Confirmation')

@push('styles')
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="checkout-page">
    <div class="checkout-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span>&gt;</span>
        <a href="{{ route('customer.cart.index', ['selected_items' => session('checkout.selected_items')]) }}">
            Shipping
        </a>
        <span>&gt;</span>
        <a href="{{ route('customer.checkout.payment') }}">
            Payment
        </a>
        <span>&gt;</span> Confirmation
    </div>

    <div class="checkout-steps">
        <div class="checkout-step completed">
            <span class="step-icon">
                <i class="fas fa-check"></i>
            </span>
            <span>Shipping</span>
        </div>

        <div class="checkout-step completed">
            <span class="step-icon">
                <i class="fas fa-check"></i>
            </span>
            <span>Payment</span>
        </div>

        <div class="checkout-step active">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Confirmation</span>
        </div>
    </div>

    <div class="confirmation-content">
        <h2>Order Confirmation</h2>

        {{-- shipping information --}}
        <div class="confirmation-section">
            <h3>Shipping Information</h3>

            <div class="shipping-info">
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">
                        {{ $shipping['name'] }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone Number</span>
                    <span class="info-value">
                        {{ $shipping['phone'] }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address</span>
                    <span class="info-value">
                        {{ $shipping['address'] }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Postal Code</span>
                    <span class="info-value">
                        {{ $shipping['postal_code'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- payment method --}}
        <div class="confirmation-section">
            <h3>Payment Method</h3>
            <div class="payment-method-confirm">
                <div class="payment-method-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>

                <div>
                    <div class="payment-method-name">
                        Bayar di tempat (COD)
                    </div>
                    <div class="payment-method-description">
                        Pay when your order arrives at your address.
                    </div>
                </div>
            </div>
        </div>

        {{-- order summary --}}
        <div class="confirmation-section">
            <h3>Order Summary</h3>
            <div class="order-summary">
                @foreach($selectedItems as $item)
                    <div class="summary-item">
                        <div class="summary-product">
                            <span class="product-name">
                                {{ $item->product->name }}
                            </span>
                            <span class="product-quantity">
                                x{{ $item->quantity }}
                            </span>
                        </div>

                        <span class="product-subtotal">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <div class="summary-total">
                    <span>Total</span>
                    <span>
                        Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- place order --}}
        <form action="{{ route('customer.checkout.placeOrder') }}" method="POST">
            @csrf
            <button type="submit" class="place-order-button">
                Place Order
            </button>
        </form>
    </div>
</div>
@endsection

