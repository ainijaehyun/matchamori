@extends('layouts.customers')

@section('title', 'Order Status')

@push('styles')
    <link href="{{ asset('css/customer-order.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="order-status-page">
    <div class="order-status-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span>&gt;</span>
        <a href="{{ route('customer.orders.index') }}">
            Order
        </a>
        <span>&gt;</span>
        <a href="{{ route('customer.orders.show', $order->id) }}">
            Order Detail
        </a>
        <span>&gt;</span> Order Status
    </div>

    <div class="order-status-heading">
        <h1>Order Status</h1>
        <p>
            {{ $order->invoice }}
        </p>
    </div>

    <div class="status-card">
        <div class="status-timeline">
            <div class="status-item 
                {{ $order->order_status === 'Order Placed' ? 'active' : '' }}
                {{ in_array($order->order_status, ['Processing', 'On Delivery', 'Delivered']) ? 'completed' : '' }}">

                <div class="status-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>

                <div class="status-content">
                    <h3>Order Placed</h3>
                    <p>Pesanan berhasil dibuat.</p>
                </div>
            </div>

            <div class="status-item 
                {{ $order->order_status === 'Processing' ? 'active' : '' }}
                {{ in_array($order->order_status, ['On Delivery', 'Delivered']) ? 'completed' : '' }}">

                <div class="status-icon">
                    <i class="fas fa-box"></i>
                </div>

                <div class="status-content">
                    <h3>Processing</h3>
                    <p>Pesanan sedang diproses.</p>
                </div>
            </div>

            <div class="status-item 
                {{ $order->order_status === 'On Delivery' ? 'active' : '' }}
                {{ $order->order_status === 'Delivered' ? 'completed' : '' }}">

                <div class="status-icon">
                    <i class="fas fa-truck"></i>
                </div>

                <div class="status-content">
                    <h3>On Delivery</h3>
                    <p>Pesanan sedang dalam perjalanan.</p>
                </div>
            </div>
            <div class="status-item 
                {{ $order->order_status === 'Delivered' ? 'active' : '' }}">

                <div class="status-icon">
                    <i class="fas fa-home"></i>
                </div>

                <div class="status-content">
                    <h3>Delivered</h3>
                    <p>Pesanan telah sampai.</p>
                </div>
            </div>
        </div>

        <div class="current-status">
            <span>Current Status</span>
            <strong>
                {{ $order->order_status }}
            </strong>
        </div>
    </div>

    <div class="order-status-actions">
        <a href="{{ route('customer.orders.index') }}" class="back-detail">
            Back
        </a>
    </div>
</div>
@endsection

