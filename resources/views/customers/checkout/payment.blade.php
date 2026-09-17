@extends('layouts.customers')

@section('title', 'Payment')

@section('content')
<div class="checkout-page">
    <div class="checkout-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span>&gt; </span>
        <a href="{{ route('customer.checkout.index', ['selected_items' => session('checkout.selected_items')]) }}">
            Shipping
        </a>
        <span>&gt;</span> Payment
    </div>

    <div class="checkout-steps">
        <div class="checkout-step completed">
            <span class="step-icon">
                <i class="fas fa-check"></i>
            </span>
            <span>Shipping</span>
        </div>

        <div class="checkout-step active">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Payment</span>
        </div>

        <div class="checkout-step">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Confirmation</span>
        </div>
    </div>

    <div class="payment-content">
        <h2 class="payment-title">
            Payment Method
        </h2>

        <div class="payment-card">
            <div class="payment-option" id="cod-option">
                <div class="payment-radio">
                    <span></span>
                </div>

                <div class="payment-info">
                    <h3>Bayar di tempat (COD)</h3>
                    <p>Pay when your order arrives<br>
                        at your addres
                    </p>
                </div>

                <div class="payment-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="payment-summary">
            <h2>Order Summary</h2>

            @foreach ($selectedItems as $item)

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

        <a href="{{ route('customer.checkout.confirm') }}" class="confirm-order-button">
            Confirm Order
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const codOption = document.getElementById('cod-option');

    codOption.addEventListener('click', function () {
        this.classList.toggle('selected');
    });
</script>
@endpush
