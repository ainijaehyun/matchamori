@extends('layouts.app')

@section('title', 'Update Order Status')

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

@push('styles')

<style>

    .order-status-page {
        padding: 12px 40px 30px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .order-status-title {
        font-family: Georgia, serif;
        font-size: 24px;
        font-weight: normal;
        color: #111;
        margin: 18px 0 25px;
    }
    .order-status-card {
        background: #ffffff;
        border-radius: 32px;
        padding: 28px 30px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
        max-width: 760px;
    }
    .status-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        column-gap: 12px;
        align-items: center;
        margin-bottom: 18px;
    }
    .status-row:last-of-type {
        margin-bottom: 0;
    }
    .status-label {
        font-family: Georgia, serif;
        font-size: 19px;
        color: #111;
        line-height: 1.4;
    }
    .status-value {
        font-family: Arial, sans-serif;
        font-size: 16px;
        color: #111;
        line-height: 1.4;
    }
    .status-select {
        width: 100%;
        max-width: 360px;
        height: 42px;
        padding: 6px 12px;
        border: 1px solid #275a2f;
        border-radius: 6px;
        background: #ffffff;
        color: #111;
        font-family: Arial, sans-serif;
        font-size: 15px;
        outline: none;
        box-sizing: border-box;
    }
    .status-select:focus {
        border-color: #008000;
        box-shadow: 0 0 0 2px rgba(0, 128, 0, 0.12);
    }
    .form-buttons {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }
    .btn-back,
    .btn-update {
        width: 180px;
        height: 48px;
        border-radius: 20px;
        font-family: Georgia, serif;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
        transition: .2s ease;
    }
    .btn-back {
        background: #008000;
        color: white;
        text-decoration: none;
    }
    .btn-back:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }
    .btn-update {
        border: none;
        background: #dda900;
        color: white;
        cursor: pointer;
    }
    .btn-update:hover {
        background: #c89400;
        color: white;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {

        .order-status-page {
            padding: 20px 15px 30px;
        }
        .order-status-title {
            font-size: 23px;
            margin-bottom: 20px;
        }
        .order-status-card {
            border-radius: 24px;
            padding: 23px 20px;
        }
        .status-row {
            grid-template-columns: 1fr;
            row-gap: 6px;
            margin-bottom: 20px;
        }
        .status-label {
            font-size: 18px;
        }
        .status-value {
            font-size: 15px;
        }
        .status-select {
            max-width: 100%;
        }
        .form-buttons {
            flex-direction: column;
        }
        .btn-back,
        .btn-update {
            width: 100%;
            height: 48px;
        }

    }

</style>

@endpush