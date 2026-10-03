@extends('layouts.app')

@section('title', 'Show Order')

@push('styles')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endpush

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

    {{-- produk order --}}
    <div class="order-items-card">
        <h2 class="order-items-title">
            Product
        </h2>

        <table class="order-items-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse($order->orderDetails as $index => $detail)
                    <tr>
                        <td>
                            {{ $index + 1 }}.
                        </td>

                        <td>
                            {{ $detail->product->name ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->quantity }}
                        </td>

                        <td>
                            Rp. {{ number_format($detail->price, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            Belum ada produk dalam order ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-buttons">
        <a href="{{ route('admin.orders.index') }}"
           class="btn-back">
            Back
        </a>
    </div>
</div>

@endsection
