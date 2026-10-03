@extends('layouts.app')

@section('title', 'Order Page')

@push('styles')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endpush

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

