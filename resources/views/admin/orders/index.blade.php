@extends('layouts.app')

@section('title', 'Order Page')

@section('content')

<div class="order-page">
    <div class="order-header">
        <div class="order-title">
            Order Page
        </div>
    </div>

    <div class="order-table-wrapper">
        <table class="order-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User_id</th>
                    <th>Invoice</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Payment status</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @if(!$orders->count())

                    <tr>
                        <td colspan="8" class="text-center">
                            Data orders not found!
                        </td>
                    </tr>

                @endif

                @foreach($orders as $order)

                    <tr>
                        <td>
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>

                        <td>
                            {{ $order->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $order->invoice }}
                        </td>

                        <td class="products-cell">
                            <div class="products-list">

                                @forelse($order->orderDetails as $detail)

                                    <div class="product-item">
                                        <span class="product-name">
                                            {{ $detail->product->name ?? '-' }}
                                        </span>

                                        <span class="product-quantity">
                                            × {{ $detail->quantity }}
                                        </span>
                                    </div>

                                @empty

                                    <span class="no-product">
                                        -
                                    </span>

                                @endforelse
                            </div>
                        </td>

                        <td class="total-cell">
                            Rp. {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="payment-status
                                {{ strtolower($order->payment_status) }}">
                                {{ $order->payment_status }}
                            </span>
                        </td>

                        <td>

                            <a href="{{ route('admin.orders.status', $order->id) }}"
                               class="order-status"
                               title="Update Order Status">

                                {{ $order->order_status }}

                                <i class="fas fa-arrow-right"></i>

                            </a>

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="btn-show"
                                   title="Show">

                                    <i class="fas fa-eye"></i>

                                </a>

                            </div>

                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

        <div class="pagination-area">
            {!! $orders->links() !!}
        </div>

    </div> 
</div>

@endsection

@push('styles')
    <style>

        .order-page {
            padding: 35px 40px;
            background: #f7f8fb;
            min-height: calc(100vh - 70px);
            box-sizing: border-box;
        }
        .order-title {
            font-family: Georgia, 'Times New Roman' serif;
            font-size: 34px;
            color: #111;
        }
        .order-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .order-table-wrapper {
            width: 100%;
            background: #ffffff;
            border-radius: 0;
            overflow-x: auto;
            overflow-y: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
        }
        .order-table {
            width: 100%;
            min-width: 1300px;
            border-collapse: collapse;
        }
        .order-table th,
        .order-table td {
            border: 1px solid #275a2f;
        }
        .order-table th {
            background: #6b8a5d;
            padding: 15px 14px;
            text-align: center;
            font-size: 16px;
            color: #f5f4e8;
            font-weight: normal;
            white-space: nowrap;
        }
        .order-table td {
            padding: 14px;
            text-align: center;
            vertical-align: middle;
            font-size: 15px;
            color: #111;
        }
        .order-table td:nth-child(2),
        .order-table th:nth-child(2) {
            min-width: 150px;
            white-space: nowrap;
        }
        .order-table tr:hover {
            background: #f5f5f5;

        }
        .products-cell {
            min-width: 260px;
            text-align: left !important;
            padding: 10px 14px !important;
        }

        .products-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .product-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 7px 10px;
            background: #f3f7ef;
            border: 1px solid #d4e2cc;
            border-radius: 5px;
        }
        .product-name {
            text-align: left;
            color: #111;
            line-height: 1.3;
        }
        .product-quantity {
            flex-shrink: 0;
            color: #577738;
            font-size: 14px;
            font-weight: bold;
        }
        .no-product {
            color: #777;
        }
        .total-cell {
            white-space: nowrap;
            font-weight: normal;
        }
        .payment-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 70px;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .payment-status.paid {
            background: #dff0d7;
            border: 1px solid #8fbc7d;
            color: #315b25;
        }

        .payment-status.unpaid {
            background: #fff1df;
            border: 1px solid #e3b56d;
            color: #8a5a16;
        }
        .order-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 7px 12px;
            background: #eef7e8;
            border: 1px solid #8fbc7d;
            border-radius: 6px;
            color: #315b25;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }
        .order-status:hover {
            background: #d8ebcc;
            border-color: #6fa45d;
            color: #315b25;
            text-decoration: none;
            transform: translateY(-1px);
        }
        .order-status i {
            font-size: 11px;
        }
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-show {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #008000;
            color: white;
            text-decoration: none;
        }
        .btn-show:hover {
            background: #006b00;
            color: white;
        }
        .pagination-area {
            padding: 18px;
            display: flex;
            justify-content: center;
        }
        .pagination-area svg {
            width: 20px !important;
            height: 20px !important;
            max-width: 20px !important;
            max-height: 20px !important;
        }
        .pagination-area nav {
            width: 100%;
        }
        .pagination-area nav a,
        .pagination-area nav span {
            display: inline-flex;
            align-items;
            justify-content: center;
        }
        .order-table-wrapper .page-link {
            color: #008000;
        }
        .order-table-wrapper .page-item.active .page-link {
            background: #008000;
            border-color: #008000;
            color: white;
        }
        .order-table-wrapper .page-link:hover {
            color: #006b00;
            background: #eef7e8;
        }


        @media (max-width: 768px) {
            .order-page {
                padding: 25px 20px;
            }
            .order-header {
                align-items: flex-start;
                gap: 15px;
            }
            .order-table-wrapper {
                overflow-x: auto;
            }
            .order-table {
                min-width: 1300px;
            }
        }

    </style>
@endpush