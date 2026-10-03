@extends('layouts.customers')

@section('title', 'Order Detail')

@push('styles')
    <link href="{{ asset('css/customer-order.css') }}" rel="stylesheet">
@endpush

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
    <div class="order-detail-card">
        @foreach($order->orderDetails as $detail)
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
                <span>Status</span>
                <span>=</span>
                <a href="{{ route('customer.orders.status', $order->id) }}" class="detail-status">
                    {{ $order->order_status }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="detail-row">
                <span>Create At</span>
                <span>=</span>
                <strong>
                    {{ $order->created_at->format('d F Y H:i:s') }}
                </strong>
            </div>
        
        @endforeach
    </div>

    <div class="order-detail-actions">
        <a href="{{ route('customer.orders.index') }}" class="back-order">
            Back
        </a>
    </div>
</div>
@endsection

