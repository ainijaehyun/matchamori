@extends('layouts.customers')

@section('title', 'Order Status')

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

@push('styles')
<style>
    .order-status-page {
        width: 100%;
        padding: 0 30px 40px;
        box-sizing: border-box;
    }
    .order-status-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 45px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        font-size: 20px;
        box-sizing: border-box;
    }
    .order-status-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .order-status-breadcrumb a:hover {
        color: #008000;
    }
    .order-status-breadcrumb span {
        margin: 0 5px;
    }
    .order-status-heading {
        width: 75%;
        margin: 0 auto 22px;
    }
    .order-status-heading h1 {
        margin: 0 0 4px;
        font-size: 28px;
        font-weight: normal;
    }
    .order-status-heading p {
        margin: 0;
        color: #666;
        font-size: 16px;
    }
    .status-card {
        width: 72%;
        margin-left: 10%;
        padding: 28px 40px;
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 3px 7px rgba(0, 0, 0, .14);
        box-sizing: border-box;
    }
    .status-timeline {
        position: relative;
    }
    .status-item {
        position: relative;
        display: flex;
        align-items: flex-start;
        min-height: 78px;
    }
    .status-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 39px;
        left: 19px;
        width: 2px;
        height: 55px;
        background: #d9e8d1;
    }
    .status-item.completed:not(:last-child)::after {
        background: #9fc78e;
    }
    .status-icon {
        position: relative;
        z-index: 2;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #cbdcc2;
        border-radius: 50%;
        backgrond: #f4f8f1;
        color: #9aaa91;
        font-size: 15px;
        box-sizing: border-box;
        transition: .2s ease;
    }
    .status-item.active .status-icon,
    .status-item.completed .status-icon {
        border-color: #8fbc7d;
        background: #dff0d7;
        color: #438034;
    }
    .status-content {
        padding: 2px 0 0 20px;
    }
    .status-content h3 {
        margin: 0 0 5px;
        color: #555;
        font-size: 18px;
        font-weight: normal;
    }
    .status-item.active .status-content h3,
    .status-item.completed .status-content h3 {
        color: #315b25;
        font-weight: bold;
    }
    .status-content p {
        margin: 0;
        color: #999;
        font-size: 14px;
    }
    .current-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 15px;
        padding: 15px 20px;
        border-top: 1px solid #e4e4e4;
        background: #f7faf5;
        font-size: 15px;
    }
    .current-status span {
        color: #666;
    }
    .current-status strong {
        padding: 7px 14px;
        border: 1px solid #b7d6a8;
        border-radius: 5px;
        background: #eef7e8;
        color: #315b25;
        font-weight: normal;
    }
    .order-status-actions {
        width: 82%;
        margin: 22px auto 0;
    }
    .back-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 160px;
        padding: 11px 22px;
        border: 1px solid #008000;
        border-radius: 5px;
        background: #008000;
        color: #fff;
        font-family: Georgia, serif;
        font-size: 16px;
        text-decoration: none;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        transition: .2s ease;
        box-sizing: border-box;
    }
    .back-detail:hover {
        background: #006b00;
        border-color: #006b00;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }


    
    @media (max-width: 700px) {

        .order-status-page {
            padding: 0 10px 40px;
        }
        .order-status-breadcrumb {
            margin-bottom: 35px;
            font-size: 17px;
        }
        .order-status-heading,
        .order-status-actions {
            width: 100%;
        }
        .order-status-heading h1 {
            font-size: 25px;
        }
        .status-card {
            width: 100%;
            margin-left: 0;
            padding: 30px 25px;
            border-radius: 30px;
        }
        .status-item {
            min-height: 90px;
        }
        .status-item:not(:last-child)::after {
            left: 21px;
            height: 65px;
        }
        .status-icon {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }
        .status-content {
            padding-left: 15px;
        }
        .status-content h3 {
            font-size: 16px;
        }
        .status-content p {
            font-size: 13px;
        }
        .current-status {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }
        .back-detail {
            width: 100%;
        }

    }

</style>
@endpush