@extends('layouts.customers')

@section('title', 'View Order')

@section('content')
    <div class="orders-page">
        <div class="orders-breadcrumb">
            <a href="{{ route('customer.dashboard') }}">
                Home
            </a>
            <span>&gt;</span> Order
        </div>

        <div class="orders-heading">
            <h1>My Orders</h1>
        </div>

        <div class="orders-table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $order->invoice }}
                            </td>
                            <td>
                                Rp. {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td>
                                COD
                            </td>
                            <td>
                                <a href="{{ route('customer.orders.status', $order->id) }}" class="order-status-link">
                                    <span class="order-status
                                        {{ strtolower(str_replace(' ', '-', $order->order_status)) }}">
                                        {{ $order->order_status }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <div class="order-actions">
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="order-action" title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-order">
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .orders-page {
        width: 100%;
        padding: 0 30px 50px;
        box-sizing: border-box;
    }
    .orders-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 55px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
        font-size: 20px;
        box-sizing: border-box;
    }
    .orders-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .orders-breadcrumb a:hover {
        color: #008000;
    }
    .orders-breadcrumb span {
        margin: 0 5px;
    }
    .orders-heading {
        width: 88%;
        margin: 0 auto 35px;
    }
    .orders-heading h1 {
        margin: 0;
        font-size: 32px;
        font-weight: normal;
    }
    .orders-table-wrapper {
        width: 88%;
        margin: 0 auto;
        overflow-x: auto;
    }
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
        font-size: 18px;
    }
    .orders-table th,
    .orders-table td {
        border: 1px solid #111;
        padding: 13px 12px;
        text-align: center;
        white-space: nowrap;
    }
    .orders-table th {
        font-weight: normal;
        font-size: 20px;
    }
    .orders-table td {
        height: 35px;
    }
    .orders-table th:nth-child(1) {
        width: 7%;
    }
    .orders-table th:nth-child(2) {
        width: 20%;
    }
    .orders-table th:nth-child(3) {
        width: 19%;
    }
    .orders-table th:nth-child(4) {
        width: 18%;
    }
    .orders-table th:nth-child(5) {
        width: 18%;
    }
    .orders-table th:nth-child(6) {
        width: 18%;
    }
    .order-status-link {
        display: inline-block;
        text-decoration: none;
        color: inherit;
    }
    .order-status {
        display: inline-block;
        padding: 6px 12px;
        border: 1px solid #b7d6a8;
        background: #eef7e8;
        color: #315b25;
        font-size: 16px;
        transition: .2s ease;
        cursor: pointer;
    }
    .order-status-link:hover .order-status {
        background: #d8ebcc;
        border-color: #8fbc7d;
        color: #315b25;
        transform: translateY(-1px);
    }
    .order-status.processing {
        border-color: #00a000;
        background: #dff5d8;
    }
    .order-status.on-delivery {
        border-color: #ff9c00;
        background: #fff1df;
    }
    .order-status.delivered {
        border-color: #b7d6a8;
        background: #eef7e8;
    }
    .order-actions {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .order-action {
        color: #000;
        font-size: 34px;
        text-decoration: none;
        transition: .2s ease;
    }
    .order-action:hover {
        color: #008000;
    
        transform: scale(1.08);
    }
    .empty-order {
        padding: 30px !important;
        font-size: 17px;
    }

    /* Responsive */

    @media (max-width: 700px) {

        .orders-page {
            padding: 0 10px 40px;
        }
        .orders-breadcrumb {
            margin-bottom: 35px;
            font-size: 17px;
        }
        .orders-heading,
        .orders-table-wrapper {
            width: 100%;
        }
        .orders-heading h1 {
            font-size: 26px;
        }
        .orders-table {
            font-size: 14px;
        }
        .orders-table th {
            font-size: 15px;
        }
        .orders-table th,
        .orders-table td {
            padding: 10px 8px;
        }
        .order-action {
            font-size: 26px;
        }
    }
</style>
@endpush