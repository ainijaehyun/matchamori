@extends('layouts.app')

@section('title', 'Show Order')

@section('content')

<div class="order-show-page">
    <h1 class="order-show-title">
        Order Detail
    </h1>

    <div class="order-detail-card">
        <div class="detail-row">
            <div class="detail-label">
                User_id
            </div>

            <div class="detail-value">
                {{ $order->user->name ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Invoice
            </div>

            <div class="detail-value">
                {{ $order->invoice }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Total
            </div>

            <div class="detail-value">
                Rp. {{ number_format($order->total, 0, ',', '.') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Payment status
            </div>

            <div class="detail-value">
                {{ $order->payment_status }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Status
            </div>

            <div class="detail-value">
                <a href="{{ route('admin.orders.status', $order->id) }}"
                   class="order-status">
                    {{ $order->order_status }}
                </a>
            </div>
        </div>

        <div class="detail-row date-row">
            <div class="detail-label">
                Create at
            </div>

            <div class="detail-value">
                {{ $order->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Update at
            </div>

            <div class="detail-value">
                {{ $order->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>
    </div>

    <div class="form-buttons">
        <a href="{{ route('admin.orders.index') }}"
           class="btn-back">
            Back
        </a>
    </div>
</div>

@endsection

@push('styles')

<style>

    .order-show-page {
        padding: 12px 40px 30px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .order-show-title {
        font-family: Georgia, serif;
        font-size: 24px;
        font-weight: normal;
        color: #111;
        margin: 18px 0 25px;
    }
    .order-detail-card {
        background: #ffffff;
        border-radius: 32px;
        padding: 28px 30px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
        max-width: 760px;
    }
    .detail-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        column-gap: 12px;
        align-items: start;
        margin-bottom: 18px;
    }
    .detail-row:last-child {
        margin-bottom: 0;
    }
    .detail-label {
        font-family: Georgia, serif;
        font-size: 19px;
        color: #111;
        line-height: 1.4;
    }
    .detail-value {
        font-family: Arial, sans-serif;
        font-size: 16px;
        color: #111;
        line-height: 1.4;
    }
    .date-row {
        margin-top: 2px;
    }
    .order-status {
        color: #111;
        text-decoration: none;
        transition: .2s ease;
    }
    .order-status:hover {
        color: #008000;
        text-decoration: underline;
    }
    .form-buttons {
        display: flex;
        margin-top: 25px;
    }
    .btn-back {
        width: 180px;
        height: 48px;
        border-radius: 20px;
        background: #008000;
        color: white;
        font-family: Georgia, serif;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
        box-sizing: border-box;
    }
    .btn-back:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }


    @media (max-width: 768px) {

        .order-show-page {
            padding: 20px 15px 30px;
        }
        .order-show-title {
            font-size: 23px;
            margin-bottom: 20px;
        }
        .order-detail-card {
            border-radius: 24px;
            padding: 23px 20px;
        }
        .detail-row {
            grid-template-columns: 1fr;
            row-gap: 6px;
            margin-bottom: 20px;
        }
        .detail-label {
            font-size: 18px;
        }
        .detail-value {
            font-size: 15px;
        }
        .btn-back {
            width: 100%;
            height: 48px;
        }

    }

</style>

@endpush