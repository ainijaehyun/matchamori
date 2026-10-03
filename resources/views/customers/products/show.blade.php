@extends('layouts.customers')

@section('title', 'Product Detail')

@push('styles')
    <link href="{{ asset('css/customer-product.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="product-detail-page">
    <div class="product-detail-breadcrumb">

        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>

        <span>&gt;</span>

        <a href="{{ route('customer.products.index') }}">
            Product
        </a>

        <span>&gt;</span>

        <span>
            {{ $product->name }}
        </span>

    </div>


    <div class="product-detail-container">
        <div class="product-detail-left">
            <div class="product-detail-image">

                @if($product->image)
                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-leaf"></i>
                @endif

            </div>

            <div class="quantity-box">

                <button type="button" onclick="decreaseQuantity()">
                    −
                </button>

                <input type="text" id="quantity" name="quantity" value="1" readonly>

                <button type="button" onclick="increaseQuantity()">
                    +
                </button>

            </div>

        </div>


        <div class="product-detail-info">

            <h1 class="product-detail-name">
                {{ $product->name }}
            </h1>

            <div class="product-detail-rating">

                @php
                    $rating = $product->rating ?? 4.9;
                    $fullStars = floor($rating);
                @endphp

                @for($i = 1; $i <= 5; $i++)

                    @if($i <= $fullStars)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
                <span>
                    {{ number_format($rating, 1, ',', '.') }}
                </span>
            </div>

            <div class="product-detail-price">
                Rp. {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <div class="product-detail-stock">
                Stock :
                {{ $product->stock }}
            </div>

            <div class="product-detail-description">
                {{ $product->description }}
            </div>

            <div class="product-detail-buttons">

                <a href="{{ request('form') ?? route('customer.products.index') }}" class="back-button">
                    Back
                </a>
                <form action="{{ route('customer.cart.store') }}" method="POST">

                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <input type="hidden" name="quantity" id="cart-quantity" value="1">

                    <button type="submit" class="add-cart-button">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Added to Cart!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#087a00',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection


@push('scripts')
    <script>

        function increaseQuantity() {

            const quantityInput = document.getElementById('quantity');
            const cartQuantity = document.getElementById('cart-quantity');

            let quantity = parseInt(quantityInput.value);

            const stock = {{ $product->stock }};

            if (quantity < stock) {

                quantity++;

                quantityInput.value = quantity;

                cartQuantity.value = quantity;

            }

        }


        function decreaseQuantity() {

            const quantityInput = document.getElementById('quantity');
            const cartQuantity = document.getElementById('cart-quantity');

            let quantity = parseInt(quantityInput.value);

            if (quantity > 1) {

                quantity--;

                quantityInput.value = quantity;

                cartQuantity.value = quantity;

            }

        }

    </script>
@endpush

