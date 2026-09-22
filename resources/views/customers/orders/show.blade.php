@extends('layouts.customers')

@section('title', 'Order Detail')

@section('content')
<div class="order-detail-page">
    <div class="order-detail-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span>&gt; </span>
        <a href="{{ route('customer.orders.index') }}">
            Order
        </a>
        <span>&gt;</span> Order Detail
    </div>

    <div class="order-detail-heading">
        <h1>Order Detail - {{ $order->invoice }}</h1>
    </div>

    @foreach($order->orderDetails as $detail)
        <div class="order-detail-card">
            <div class="detail-row">
                <span>Order ID</span>
                <span>=</span>
                <strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div class="detail-row">
                <span>Product ID</span>
                <span>=</span>
                <strong>{{ $detail->product_id }}</strong>
            </div>
            <div class="detail-row">
                <span>Product</span>
                <span>=</span>
                <strong>{{ $detail->product->name }}</strong>
            </div>
            <div class="detail-row">
                <span>Quantity</span>
                <span>=</span>
                <strong>{{ $detail->quantity }}</strong>
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
            <div class="detail-row">
                <span>Create At</span>
                <span>=</span>
                <strong>
                    {{ $order->created_at->format('d F Y H:i:s') }}
                </strong>
            </div>
        </div>
    @endforeach

    <div class="order-detail-actions">
        <a href="{{ route('customer.orders.index') }}" class="back-order">
            Back
        </a>
        <a href="{{ route('customer.orders.status', $order->id) }}" class="status-order">
            View Status
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .order-detail-page {
        width: 100%;
        padding: 0 30px 50px;
        box-sizing: border-box;
    }
    .order-detail-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 45px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        font-size: 20px;
    }
    .order-detail-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .order-detail-breadcrumb a:hover {
        color: #008000;
    }
    .order-detail-breadcrumb span {
        margin: 0 5px;
    }
    .order-detail-heading {
        width: 82%;
        margin: 0 auto 28px;
    }
    .order-detail-heading h1 {
        margin: 0;
        font-size: 31px;
        font-weight: normal;
    }
    .order-detail-card {
        width: 80%;
        min-width: 550px;
        margin-left: 7%;
        padding: 38px 55px;
        background: #fff;
        border-radius: 45px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, .16);
        box-sizing: border-box;
    }
    .detail-row {
        display: grid;
        grid-template-columns: 180px 30px 1fr;
        align-items: center;
        margin-bottom: 15px;
        font-size: 17px
    }
    .detail-row:last-child {
        margin-bottom: 0;
    }
    .detail-row strong {
        font-weight: normal;
    }
    .order-detail-actions {
        width: 82%;
        margin: 25px auto 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .back-order {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        padding: 11px 22px;
        border: 1px solid #008000;
        border-radius: 5px;
        background: #008000;
        color: #fff;
        font-family: Georgia, serif;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        transition: .2s ease;
        box-sizing: border-box;
    }
    .back-order:hover {
        background: #006b00;
        border-color: #006b00;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .status-order {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 125px;
        padding: 11px 22px;
        border: 1px solid #b7d6a8;
        border-radius: 5px;
        background: #eef7e8;
        color: #315b25;
        font-family: Georgia, serif;
        font-size: 16px;
        text-decoration: none;
        box-sizing: border-box;
        transition: .2s ease;
    }

    .status-order:hover {
        background: #d8ebcc;
        border-color: #9fc78e;
        color: #315b25;
        text-decoration: none;
        transform: translateY(-2px);
    }

    @media (max-width: 700px) {

        .order-detail-page {
            padding: 0 10px 40px;
        }
        .order-detail-breadcrumb {
            font-size: 17px;
            margin-bottom: 35px;
        }
        .order-detail-heading,
        .order-detail-actions {
            width: 100%;
        }
        .order-detail-heading h1 {
            font-size: 24px;
        }
        .order-detail-card {
            width: 100%;
            min-width: 0;
            margin-left: 0;
            padding: 30px 25px;
            border-radius: 30px;
        }
        .detail-row {
            grid-template-columns: 120px 20px 1fr;
            font-size: 14px;
        }

    }
</style>
@endpush