@extends('layouts.customers')

@section('title', 'Product Detail')

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

@endsection


@push('styles')

<style>

.product-detail-page {
    width: 100%;
    min-height: calc(100vh - 100px);
    padding: 0 30px 50px;
}
.product-detail-breadcrumb {
    width: 100%;
    padding: 6px 20px;
    margin-bottom: 65px;
    background: #b9dda8;
    border-radius: 4px;
    font-size: 18px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .18);
}
.product-detail-breadcrumb a,
.product-detail-breadcrumb span {
    color: #111;
    text-decoration: none;
}
.product-detail-breadcrumb a:hover {
    color: #111;
    text-decoration: underline;
}
.product-detail-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 45px;
    max-width: 780px;
    margin: 0 auto;
}
.product-detail-left {
    width: 250px;
    flex-shrink: 0;
}
.product-detail-image {
    width: 250px;
    height: 400px;
    background: #b8dfa5;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 2px 4px 7px rgba(0, 0, 0, .20);
}
.product-detail-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
}
.product-detail-image i {
    font-size: 80px;
    color: #315b25;
}
.quantity-box {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: -98px;
    position: relative;
}
.quantity-box button,
.quantity-box input {
    width: 40px;
    height: 40px;
    border: 1px solid #111;
    background: white;
    font-family: Georgia, serif;
    font-size: 20px;
    text-align: center;
}
.quantity-box button {
    cursor: pointer;
}
.quantity-box button:hover {
    background: #eeeeee;
}
.quantity-box input {
    font-size: 17px;
    border-left: none;
    border-right: none;
}
.product-detail-info {
    width: 320px;
    padding-top: 20px;
}
.product-detail-name {
    margin: 0 0 15px;
    font-size: 31px;
    font-weight: normal;
    line-height: 1.2;
}
.product-detail-rating {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 20px;
    font-size: 16px;
}
.product-detail-rating i {
    color: #ffae00;
    font-size: 20px;
}
.product-detail-rating span {
    margin-left: 12px;
    color: #111;
}
.product-detail-price {
    margin-bottom: 20px;
    font-size: 21px;
    font-weight: bold;
}
.product-detail-stock {
    margin-bottom: 23px;
    font-size: 16px;
}
.product-detail-description {
    width: 100%;
    margin-bottom: 40px;
    font-size: 16px;
    line-height: 1.35;
}
.add-cart-button {
    width: 230px;
    height: 46px;
    border: none;
    border-radius: 5px;
    background: #008000;
    color: white;
    font-family: Georgia, serif;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 3px 6px rgba(0, 0, 0, .18);
    transition: .2s ease;
}
.add-cart-button:hover {
    background: #006b00;
    transform: translateY(-2px);
}

@media (max-width: 750px) {

    .product-detail-container {
        gap: 30px;
    }
    .product-detail-left {
        width: 220px;
    }
    .product-detail-image {
        width: 220px;
        height: 350px;
    }
    .product-detail-info {
        width: 280px;
    }

}

@media (max-width: 600px) {

    .product-detail-page {
        padding: 0 15px 40px;
    }
    .product-detail-breadcrumb {
        margin-bottom: 40px;
        font-size: 16px;
    }
    .product-detail-container {
        flex-direction: column;
        align-items: center;
        gap: 35px;
    }
    .product-detail-left {
        width: 100%;
    }
    .product-detail-image {
        width: 230px;
        height: 36%;
        margin: 0 auto;
    }
    .product-detail-info {
        width: 100%;
        max-width: 350px;
        padding-top: 0;
    }
    .product-detail-name {
        font-size: 28px;
    }
    .add-cart-button {
        width: 100%;
    }

}

</style>

@endpush


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