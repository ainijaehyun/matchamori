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
        /* chekcout steps */
        .checkout-steps {
            width: 82%;
            margin: 0 auto 35px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            position: relative; 
        }
        /* garis abu-abu */
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
        /* garis hijau sampai payment */
        .checkout-steps::after {
            content: "";
            position: absolute;
            top: 23px;
            left: 0;
            width: 66.66%;
            height: 4px;
            background: #00a000;
            z-index: 1;
        }
        /* step */
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
        /* step yang sudah selesai */
        .checkout-step.completed,
        .checkout-step.active {
            color: #008000;
        }
        /* circle */
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
        /* circle shipping dan payment */
        .checkout-step.completed .step-icon,
        .checkout-step.active .step-icon {
            background: #69a84f;
            border-color: #69a84f;
            color: #fff;
        }
        .payment-content {
            width: 82%;
            margin: 0 auto;
        }
        /* title */
        .payment-title {
            margin: 0 0 50px;
            font-size: 24px;
            font-weight: normal;
        }
        .payment-card {
            width: 100%;
            margin-bottom: 70px;
        }
        /* cod card */
        .payment-option {
            width: 100%;
            min-height: 200px;
            padding: 30px 35px;
            display: flex;
            align-items: center;
            gap: 20px;
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 3px 7px rgba(0,0,0, .15);
            box-sizing: border-box;
            cursor: pointer;
        }
        .payment-radio {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 4px solid #713c8f;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-sizing: border-box;
        }
        .payment-radio span {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: transparent;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* check inside radio */
        .payment-radio span::after {
            content: "";
            display: none;
            width: 14px;
            height: 7px;
            border-left: 4px solid #713c8f;
            border-bottom: 4px solid #713c8f;
            transform: rotate(-45deg);
            position: absolute;
            top: 10px;
        }
        .payment-option.selected .payment-radio span {
            background: #55c94a;
        }
        .payment-option.selected .payment-radio span::after {
            display: block;
        }
        .payment-info {
            flex: 1;
        }
        .payment-info h3 {
            margin: 0 0 7px;
            font-size: 23px;
            font-weight: normal;
            color: #111;
        }
        .payment-info p {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
            color: #222;
        }
        .payment-icon {
            width: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 55px;
            color: #4fc33f;
            flex-shrink: 0;
        }
        .payment-summary {
            width: 100%;
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-sizing: border-box;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .10);
        }
        .payment-summary h2 {
            margin: 0 0 20px;
            font-size: 21px;
            font-weight: normal;
        }
        /* summary item */
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 16px;
        }
        /* product */
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
        /* total */
        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            font-size: 22px;
            font-weight: 700;
        }
        .confirm-order-button {
            width: 100%;
            display: block;
            padding: 14px;
            box-sizing: border-box;
            background: #008000;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-family: Georgia, serif;
            font-size: 17px;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .18);
            transition: .2s ease;
        }
        .confirm-order-button:hover {
            background: #006b00;
            color: #fff;
            transform: translateY(-2px);
        }


        @media (max-width: 700px) {
            .checkout-breadcrumb {
                margin-bottom: 35px;
                font-size: 17px;
            }
            .checkout-steps,
            .payment-content {
                width: 100%;
            }
            .checkout-step {
                font-size: 16px;
            }
            .payment-title {
                margin-bottom: 30px;
            }
            .payment-option {
                min-height: 220px;
                padding: 30px 25px;
                border-radius: 30px;
                gap: 15px;
            }
            .payment-radio {
                width: 50px;
                height: 50px;
                border-width: 4px;
            }
            .payment-radio span {
                width: 36px;
                height: 36px;
            }
            .payment-radio span::after {
                width: 14px;
                height: 8px;
                border-width: 4px;
                top: 10px;
            }
            .payment-info h3 {
                font-size: 21px;
            }
            .payment-info p {
                font-size: 15px;
            }
            .payment-icon {
                width: 70px;
                font-size: 50px;
            }
            .summary-item {
                gap: 15px;
            }
        }

    </style>

@endpush
