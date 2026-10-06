@extends('layouts.customers')

@section('title', 'Confirmation')

@push('styles')
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="checkout-page">

    {{-- Breadcrumb --}}
    <div class="checkout-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>

        <span>&gt;</span>

        <span>Confirmation</span>
    </div>


    {{-- Title --}}
    <h1 class="checkout-title">
        Order Confirmation
    </h1>


    {{-- Confirmation Layout --}}
    <div class="confirmation-content">

        {{-- LEFT COLUMN --}}
        <div class="confirmation-left">

            {{-- Shipping Information --}}
            <div class="confirmation-section">

                <h3>Shipping Information</h3>

                <div class="shipping-info">

                    <div class="info-row">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">
                            {{ $orderForm['name'] }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value">
                            {{ $orderForm['phone'] }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Address</span>
                        <span class="info-value">
                            {{ $orderForm['address'] }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Postal Code</span>
                        <span class="info-value">
                            {{ $orderForm['postal_code'] }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Delivery Information --}}
            <div class="confirmation-section">

                <h3>Delivery Information</h3>

                <div class="shipping-info">

                    <div class="info-row">
                        <span class="info-label">Courier</span>

                        <span class="info-value">
                            {{ $orderForm['courier'] }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Delivery Service</span>

                        <span class="info-value">
                            {{ $orderForm['delivery_service'] }}
                        </span>
                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT COLUMN --}}
        <div class="confirmation-right">

            {{-- Order Summary --}}
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

                        <strong>
                            Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Payment Method --}}
            <div class="confirmation-section">

                <h3>Payment Method</h3>

                <div class="payment-method-confirm">

                    <div class="payment-method-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>

                    <div>

                        <div class="payment-method-name">
                            Cash on Delivery (COD)
                        </div>

                        <div class="payment-method-description">
                            Pay when your order arrives at your address.
                        </div>

                    </div>

                </div>

            </div>


            {{-- Place Order --}}
            <form
                action="{{ route('customer.checkout.placeOrder') }}"
                method="POST"
                class="place-order-form"
            >

                @csrf

                <button
                    type="submit"
                    class="place-order-button"
                >
                    Place Order
                </button>

            </form>

        </div>

    </div>

</div>

@endsection