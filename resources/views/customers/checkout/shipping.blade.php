@extends('layouts.customers')

@section('title', 'Shipping')

@push('styles')
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="checkout-page">

    <div class="checkout-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">Home</a>
        <span>&gt; Shipping</span>
    </div>

    <div class="checkout-steps">

        <div class="checkout-step active">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Shipping</span>
        </div>

        <div class="checkout-step">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Payment</span>
        </div>

        <div class="checkout-step">
            <span class="step-icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Confirmation</span>
        </div>

    </div>

    <div class="shipping-content">

        <h2>Shipping Information</h2>

        <form action="{{ route('customer.checkout.store') }}" method="POST">
            @csrf

            <div class="shipping-form-grid">

                <div class="form-group">
                    <label for="name">Full Name</label>

                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>

                    <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                </div>

                <div class="form-group full-width">
                    <label for="address">Address</label>

                    <textarea id="address" name="address" required >{{ old('address', Auth::user()->address ?? '') }}</textarea>
                </div>

              
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>

                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
                </div>

            </div>

            
            <div class="shipping-summary">

                <div class="quantity-title">
                    Quantity
                </div>

                @foreach($selectedItems as $item)

                    <div class="quantity-item">

                        <span>
                            {{ $item->product->name }}
                        </span>

                        <span>
                            {{ $item->quantity }}
                        </span>

                    </div>

                @endforeach

            </div>

            
            <button type="submit" class="continue-button">
                Continue to Payment
            </button>

        </form>

    </div>

</div>

@endsection


