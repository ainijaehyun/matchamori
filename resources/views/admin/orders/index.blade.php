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
                    <th>Total</th>
                    <th>Payment status</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @if(!$orders->count())

                    <tr>
                        <td colspan="7" class="text-center">
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

                        <td>
                            Rp. {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $order->payment_status }}
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

        {!! $orders->links() !!}

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
        font-family: Georgia, serif;
        font-size: 34px;
        margin-bottom: 25px;
        color: #111;
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .order-table-wrapper {
        background: white;
        border-radius: 0;
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
    }
    .order-table {
        width: 100%;
        border-collapse: collapse;
    }
    .order-table th,
    .order-table td {
        border: 1px solid #275a2f;
    }
    .order-table th {
        background: #b9df9f;
        padding: 15px;
        text-align: center;
        font-size: 16px;
        color: #111;
    }
    .order-table td {
        padding: 13px 15px;
        text-align: center;
        font-size: 15px;
        color: #111;
    }
    .order-table tr:hover {
        background: #f5f5f5;

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
    .order-table-wrapper .pagination {
        margin: 0;
        padding: 18px;
        display: flex;
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
            min-width: 900px;
        }
    }

</style>

@endpush