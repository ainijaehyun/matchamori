@extends('layouts.customers')

@section('title', 'View Order')

@push('styles')
    <link href="{{ asset('css/customer-order.css') }}" rel="stylesheet">
@endpush

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

