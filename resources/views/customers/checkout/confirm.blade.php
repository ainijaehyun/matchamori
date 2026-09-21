@extends('layouts.customers')

@section('title', 'Confirmation')

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

@push('styles')
<style>
    .checkout-page {
        width: 100%;
        padding: 0 10px 50px;
        box-sizing: border-box;
    }
    .checkout-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 55px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        font-size: 20px;
        box-sizing: border-box;
    }
    .checkout-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .checkout-breadcrumb a:hover {
        color: #008000;
    }
    .checkout-breadcrumb span {
        color: #111;
    }
    .checkout-steps {
        width: 82%;
        margin: 0 auto 35px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        position: relative;
    }
    .checkout-steps::before {
        content: "";
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 2px;
        background: #999;
        z-index: 0;
    }
    .checkout-steps::after {
        content: "";
        position: absolute;
        top: 23px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #00a000;
        z-index: 1;
    }
    .checkout-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        position: relative;
        z-index: 2;
        font-size: 20px;
        color: #111;
    }
    .checkout-step.completed,
    .checkout-step.active {
        color: #008000;
    }
    .step-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #111;
        font-size: 14px;
        box-sizing: border-box;
    }
    .checkout-step.completed .step-icon,
    .checkout-step.active .step-icon {
        background: #69a84f;
        border-color: #69a84f;
        color: #fff;
    }
    .confirmation-content {
        width: 82%;
        margin: 0 auto;
    }
    .confirmation-content > h2 {
        margin: 0 0 32px;
        font-size: 24px;
        font-weight: normal;
    }
    .confirmation-section {
        margin-bottom: 28px;
    }
    .confirmation-section h3 {
        margin: 0 0 15px;
        font-size: 20px;
        font-weight: normal;
    }
    .shipping-info {
        width: 100%;
        padding: 20px 25px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 3px 7px rgba(0, 0 , 0, .15);
        box-sizing: border-box;
    }
    .info-row {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 20px;
        padding: 8px 0;
        font-size: 16px;
    }
    .info-label {
        color: #555;
    }
    .info-value {
        color: #111;
        word-break: break-word;
    }
    .payment-mthod-confirm {
        width: 100%;
        min-height: 100px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 3px 7px rgba(0, 0, 0, .15);
        box-sizing: border-box;
    }
    .payment-method-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e8f2df;
        color: #4fc33f;
        font-size: 25px;
        flex-shrink: 0;
    }
    .payment-method-name {
        margin-bottom: 5px;
        font-size: 18px;
    }
    .payment-method-description {
        font-size: 15px;
        color: #555;
    }
    .order-summary {
        width: 100%;
        padding: 20px 25px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 3px 7px rgba(0, 0, 0, .15);
        box-sizing: border-box;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 11px 0;
        border-bottom: 1px solid #e0e0e0;
        font-size: 16px;
    }
    .summary-product {
        display: flex;
        gap: 12px;
        min-width: 0;
    }
    .product-name {
        color: #111;
        word-break: break-word;
    }
    .product-quantity {
        color: #777;
        white-space: nowrap;
    }
    .product-subtotal {
        font-weight: 600;
        white-space: nowrap;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 18px;
        font-size: 21px;
        font-weight: bold;
    }
    .place-order-button {
        width: 100%;
        margin-top: 5px;
        padding: 14px;
        border: none;
        border-radius: 5px;
        background: #008000;
        color: #fff;
        font-family: Georgia, serif;
        font-size: 17px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .18);
        transition: .2s ease;
    }
    .place-order-button:hover {
        background: #006b00;
        transform: translateY(-2px);
    }

    /* responsive */
    @media (max-width: 700px) {
        .checkout.breadcrumb {
            margin-bottom: 35px;
            font-size: 17px;
        }
        .checkout-steps,
        .confirmation-content {
            width: 100%;
        }
        .checkout-step {
            font-size: 16px;
        }
        .info-row {
            grid-template-columns: 1fr;
            gap:  3px;
        }
        .shipping-info,
        .payment-method-confirm,
        .order-summary {
            padding: 18px;
        }
        .summary-item {
            align-items: flex-start;
        }
    }
</style>
@endpush