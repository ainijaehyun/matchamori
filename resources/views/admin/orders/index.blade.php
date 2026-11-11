@extends('layouts.app')

@section('title', 'Order Page')

@push('styles')
    <link href="{{ asset('css/order.css') }}?v={{ time() }}" rel="stylesheet">
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
                    <th>Penerimaan</th>
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
                        <td colspan="9" class="text-center">
                            Data orders not found!
                        </td>
                    </tr>

                @endif

                @foreach($orders as $order)

                    @php
                        $isPickup = str_contains(
                            $order->shipping ?? '',
                            'Method: Pickup at Matcha Mori Store'
                        );

                        $statusLabel = match ($order->order_status) {
                            'Order Placed' => 'Order Placed',
                            'Processing' => 'Processing',
                            'On Delivery' => $isPickup ? 'Ready for Pick Up' : 'On Delivery',
                            'Delivered' => $isPickup ? 'Picked Up' : 'Delivered',
                            default => $order->order_status,
                        };
                    @endphp

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
                            @if(str_contains($order->shipping ?? '', 'Method: Pickup at Matcha Mori Store'))
                                <span class="reception-status pickup">
                                    Ambil di Tempat
                                </span>
                            @else
                                <span class="reception-status delivery">
                                    Pengiriman
                                </span>
                            @endif
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
                            <a href="{{ route('admin.orders.status', $order->id) }}" class="order-status status-{{ \Illuminate\Support\Str::slug($order->order_status ?? 'pending') }}" title="Update Order Status">

                                <span>{{ $statusLabel }}</span>
                                <i class="fas fa-arrow-right"></i>

                            </a>
                        </td>

                                                
                        <td>
                            <div class="action-buttons">

                                {{-- Tombol detail pesanan --}}
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-show" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol cetak nota --}}
                                <a href="{{ route('admin.orders.nota', $order->id) }}" class="btn-show" title="Cetak Nota" target="_blank">
                                    <i class="fas fa-print"></i>
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

