@extends('layouts.customers')

@section('title', 'Order Confirmation')

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

        <a href="{{ route('customer.dashboard') }}"
           class="back-home-button">
            Back to Home
        </a>

    </div>

</div>

@endsection


@push('styles')

<style>

.confirmation-page {
    width: 100%;
    padding: 0 10px 50px;
    box-sizing: border-box;
}


/* Breadcrumb */

.confirmation-breadcrumb {
    width: 100%;
    padding: 7px 20px;
    margin-bottom: 45px;
    background: #b8dfa5;
    border-radius: 5px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
    font-size: 20px;
    box-sizing: border-box;
}

.confirmation-breadcrumb a {
    color: #111;
    text-decoration: none;
}

.confirmation-breadcrumb a:hover {
    color: #008000;
}

.confirmation-breadcrumb span {
    color: #111;
}


/* Success */

.confirmation-success {
    text-align: center;
    margin-bottom: 40px;
}

.success-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 15px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #69a84f;
    color: #fff;

    font-size: 32px;

    box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
}

.confirmation-success h1 {
    margin: 0 0 8px;
    font-size: 30px;
    font-weight: normal;
}

.confirmation-success p {
    margin: 0;
    font-size: 17px;
    color: #555;
}


/* Content */

.confirmation-content {
    width: 82%;
    margin: 0 auto;
}


/* Card */

.confirmation-card {
    width: 100%;
    margin-bottom: 25px;

    padding: 25px;

    background: #fff;
    border-radius: 20px;

    box-shadow: 0 3px 8px rgba(0, 0, 0, .12);

    box-sizing: border-box;
}

.confirmation-card-title {
    margin-bottom: 20px;
}

.confirmation-card-title h2 {
    margin: 0;
    font-size: 21px;
    font-weight: normal;
}


/* Order Information */

.order-info {
    display: flex;
    flex-direction: column;
}

.order-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 12px 0;

    border-bottom: 1px solid #e3e3e3;

    font-size: 16px;
}

.order-info-row:last-child {
    border-bottom: none;
}

.order-info-row strong {
    font-weight: normal;
    color: #315b25;
}


/* Shipping */

.shipping-info {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
}

.shipping-info p {
    margin: 0 0 8px;
}


/* Products */

.confirmation-products {
    display: flex;
    flex-direction: column;
}

.confirmation-product {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 13px 0;

    border-bottom: 1px solid #e3e3e3;

    font-size: 16px;
}

.product-detail {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-name {
    color: #111;
}

.product-quantity {
    color: #777;
}

.product-price {
    white-space: nowrap;
    font-weight: 600;
}


/* Total */

.confirmation-total {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-top: 20px;

    font-size: 21px;
}

.confirmation-total strong {
    color: #008000;
}


/* Button */

.back-home-button {
    display: block;

    width: 100%;

    padding: 14px;

    background: #008000;
    color: #fff;

    border-radius: 5px;

    text-align: center;
    text-decoration: none;

    font-family: Georgia, serif;
    font-size: 17px;
    font-weight: bold;

    box-shadow: 0 3px 6px rgba(0, 0, 0, .18);

    transition: .2s ease;
}

.back-home-button:hover {
    background: #006b00;
    color: #fff;
    transform: translateY(-2px);
}


/* Responsive */

@media (max-width: 700px) {

    .confirmation-breadcrumb {
        margin-bottom: 35px;
        font-size: 17px;
    }

    .confirmation-content {
        width: 100%;
    }

    .confirmation-success h1 {
        font-size: 25px;
    }

    .confirmation-success p {
        font-size: 15px;
    }

    .confirmation-card {
        padding: 20px;
        border-radius: 15px;
    }

    .order-info-row {
        font-size: 14px;
        gap: 20px;
    }

    .confirmation-product {
        font-size: 14px;
        gap: 15px;
    }

    .product-detail {
        gap: 10px;
    }

    .confirmation-total {
        font-size: 19px;
    }

}

</style>

@endpush