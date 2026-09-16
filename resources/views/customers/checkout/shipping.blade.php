@extends('layouts.customers')

@section('title', 'Shipping')

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


@push('styles')

<style>

    .checkout-page {
        width: 100%;
        padding: 0 10px 50px;
    }

    /* Breadcrumb */
    .checkout-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 55px;

        background: #b8dfa5;
        border-radius: 5px;

        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);

        font-size: 20px;
    }

    .checkout-breadcrumb a {
        color: #111;
        text-decoration: none;
    }

    .checkout-breadcrumb a:hover {
        color: #008000;
    }


    /* Checkout Steps */
    .checkout-steps {
        width: 82%;
        margin: 0 auto 35px;

        display: grid;
        grid-template-columns: repeat(3, 1fr);

        position: relative;
    }

    .checkout-steps::before {
        content: "";

        position: absolute;

        top: 24px;
        left: 0;
        right: 0;

        height: 2px;

        background: #999;

        z-index: 0;
    }

    .checkout-steps::after {
        content: "";

        position: absolute;

        top: 24px;
        left: 0;

        width: 33.33%;
        height: 4px;

        background: #00a000;

        z-index: 1;
    }

    .checkout-step {
        display: flex;
        flex-direction: column;
        align-items: center;

        gap: 6px;

        position: relative;
        z-index: 2;

        font-size: 20px;
    }

    .checkout-step.active {
        color: #008000;
    }

    .step-icon {
        width: 32px;
        height: 32px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #fff;
        border: 2px solid #111;

        font-size: 15px;
    }

    .checkout-step.active .step-icon {
        background: #69a84f;
        border-color: #69a84f;
        color: #fff;
    }


    /* Shipping Content */
    .shipping-content {
        width: 82%;
        margin: 0 auto;
    }

    .shipping-content h2 {
        margin: 0 0 32px;

        font-size: 24px;
        font-weight: normal;
    }


    /* Form */
    .shipping-form-grid {
        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 25px 40px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 10px;

        font-size: 20px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;

        border: none;
        outline: none;

        background: #fff;

        border-radius: 9px;

        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);

        font-family: Georgia, serif;
        font-size: 17px;

        padding: 12px 15px;
    }

    .form-group input {
        height: 50px;
    }

    .form-group textarea {
        height: 95px;

        resize: none;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        box-shadow: 0 0 0 2px #8fbd7d;
    }


    /* Quantity */
    .shipping-summary {
        margin-top: 28px;

        width: 100%;
    }

    .quantity-title {
        font-size: 20px;

        margin-bottom: 10px;
    }

    .quantity-item {
        display: flex;

        justify-content: space-between;

        padding: 8px 15px;

        font-size: 16px;
    }


    /* Button */
    .continue-button {
        width: 100%;

        margin-top: 30px;

        padding: 14px;

        border: none;
        border-radius: 5px;

        background: #008000;

        color: #fff;

        font-family: Georgia, serif;
        font-size: 17px;
        font-weight: bold;

        cursor: pointer;

        box-shadow: 0 3px 6px rgba(0, 0, 0, .18);

        transition: .2s ease;
    }

    .continue-button:hover {
        background: #006b00;

        transform: translateY(-2px);
    }


    /* Responsive */
    @media (max-width: 700px) {

        .checkout-breadcrumb {
            margin-bottom: 35px;
            font-size: 17px;
        }

        .checkout-steps,
        .shipping-content {
            width: 100%;
        }

        .checkout-step {
            font-size: 16px;
        }

        .shipping-form-grid {
            grid-template-columns: 1fr;

            gap: 20px;
        }

        .form-group.full-width {
            grid-column: auto;
        }

        .form-group label {
            font-size: 17px;
        }

    }

</style>

@endpush