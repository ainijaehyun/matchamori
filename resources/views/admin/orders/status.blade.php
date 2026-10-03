@extends('layouts.app')

@section('title', 'Update Order Status')

@push('styles')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="order-status-page">
    <h1 class="order-status-title">
        Update Order Status
    </h1>

    <div class="order-status-card">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="status-row">
                <div class="status-label">
                    User_id
                </div>

                <div class="status-value">
                    {{ $order->user->name ?? '-' }}
                </div>
            </div>

            <div class="status-row">
                <div class="status-label">
                    Invoice
                </div>

                <div class="status-value">
                    {{ $order->invoice }}
                </div>
            </div>

            <div class="status-row">
                <div class="status-label">
                    Current Status
                </div>

                <div class="status-value">
                    {{ $order->order_status }}
                </div>
            </div>

            <div class="status-row update-status-row">
                <div class="status-label">
                    Update Status
                </div>

                <div class="status-value">
                    <select name="order_status" class="status-select" required>

                        <option value="Order Placed"
                            {{ $order->order_status === 'Order Placed' ? 'selected' : '' }}>
                            Order Placed
                        </option>

                        <option value="Processing"
                            {{ $order->order_status === 'Processing' ? 'selected' : '' }}>
                            Processing
                        </option>

                        <option value="On Delivery"
                            {{ $order->order_status === 'On Delivery' ? 'selected' : '' }}>
                            On Delivery
                        </option>

                        <option value="Delivered"
                            {{ $order->order_status === 'Delivered' ? 'selected' : '' }}>
                            Delivered
                        </option>

                    </select>
                </div>
            </div>

            <div class="status-row">
                <div class="status-label">
                    Payment Status
                </div>

                <div class="status-value">
                    {{ $order->payment_status }}
                </div>
            </div>

            <div class="form-buttons">
                <a href="{{ route('admin.orders.index') }}" class="btn-back">
                    Back
                </a>

                <button type="submit" class="btn-update">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection


