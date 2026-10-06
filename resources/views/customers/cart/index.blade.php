@extends('layouts.customers')

@section('title', 'Cart')

@push('styles')
    <link href="{{ asset('css/customer-cart.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="cart-page">

    <div class="cart-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span> &gt; </span>
        Cart
    </div>

    <h1 class="cart-title">
        Your Cart
    </h1>

    @if($cart && $cart->cartDetails->count() > 0)

        {{-- SELECT ALL --}}
        <div class="cart-select-all">
            <label>
                <input type="checkbox" id="select-all">
                <span>Select All</span>
            </label>
        </div>

        <div class="cart-layout">

            <div class="cart-items">

                @foreach($cart->cartDetails as $detail)

                    <div class="cart-item">

                        {{-- CHECKBOX --}}
                        <div class="cart-checkbox">
                            <input
                                type="checkbox"
                                name="selected_items[]"
                                value="{{ $detail->id }}"
                                class="product-checkbox"
                                data-subtotal="{{ $detail->subtotal }}"
                            >
                        </div>

                        {{-- IMAGE --}}
                        <div class="cart-product-image">
                            @if($detail->product->image)

                                <img
                                    src="{{ asset('img/' . $detail->product->image) }}"
                                    alt="{{ $detail->product->name }}"
                                >

                            @else

                                <i class="fas fa-leaf"></i>

                            @endif
                        </div>

                        {{-- PRODUCT INFO --}}
                        <div class="cart-product-info">

                            <div class="cart-product-name">
                                {{ $detail->product->name }}
                            </div>

                            <div class="cart-product-price">
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </div>

                        </div>

                        {{-- QUANTITY --}}
                        <div class="cart-quantity">

                            <form
                                action="{{ route('customer.cart.update', $detail->id) }}"
                                method="POST"
                                class="quantity-form"
                            >

                                @csrf
                                @method('PATCH')

                                <div class="quantity-control">

                                    <button
                                        type="button"
                                        onclick="changeQuantity(this, -1)"
                                    >
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        name="quantity"
                                        class="quantity-input"
                                        value="{{ $detail->quantity }}"
                                        min="1"
                                        readonly
                                    >

                                    <button
                                        type="button"
                                        onclick="changeQuantity(this, 1)"
                                    >
                                        +
                                    </button>

                                </div>

                            </form>

                        </div>

                        {{-- SUBTOTAL --}}
                        <div class="cart-item-subtotal">

                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}

                        </div>

                        {{-- DELETE --}}
                        <form
                            action="{{ route('customer.cart.destroy', $detail->id) }}"
                            method="POST"
                            class="delete-form"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="delete-button"
                                title="Delete"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </div>

                @endforeach

            </div>


            {{-- CART SUMMARY --}}
            <div class="cart-summary">

                <div class="summary-row">

                    <span>Selected</span>

                    <span id="selected-count">
                        0 Product
                    </span>

                </div>

                <div class="summary-row">

                    <span>Subtotal</span>

                    <span id="cart-subtotal">
                        Rp 0
                    </span>

                </div>

                <div class="summary-total">

                    <span>Total</span>

                    <span id="cart-total">
                        Rp 0
                    </span>

                </div>

                <form
                    action="{{ route('customer.checkout.index') }}"
                    method="GET"
                    id="checkout-form"
                >

                    <button
                        type="submit"
                        class="checkout-button"
                        id="checkout-button"
                        disabled
                    >
                        <i class="fas fa-shopping-bag"></i>
                        Checkout
                    </button>

                </form>

            </div>

        </div>

    @else

        <div class="empty-cart">

            <i class="fas fa-shopping-cart"></i>

            <h3>Your Cart is Empty</h3>

            <p>
                You haven't added any products to your cart yet.
            </p>

            <a
                href="{{ route('customer.products.index') }}"
                class="shop-now-btn"
            >
                Shop Now
            </a>

        </div>

    @endif

</div>


<script>

function changeQuantity(button, amount)
{
    const form = button.closest('.quantity-form');

    const input = form.querySelector('.quantity-input');

    let quantity = parseInt(input.value);

    quantity += amount;

    if (quantity < 1) {
        quantity = 1;
    }

    input.value = quantity;

    form.submit();
}


/*
|--------------------------------------------------------------------------
| SELECT PRODUCT
|--------------------------------------------------------------------------
*/

const selectAll = document.getElementById('select-all');

const productCheckboxes = document.querySelectorAll('.product-checkbox');

const selectedCount = document.getElementById('selected-count');

const cartSubtotal = document.getElementById('cart-subtotal');

const cartTotal = document.getElementById('cart-total');

const checkoutButton = document.getElementById('checkout-button');


function updateCartSummary()
{
    let total = 0;

    let count = 0;

    productCheckboxes.forEach(function(checkbox) {

        if (checkbox.checked) {

            total += parseInt(checkbox.dataset.subtotal);

            count++;

        }

    });

    selectedCount.textContent = count + ' Product';

    cartSubtotal.textContent =
        'Rp ' + total.toLocaleString('id-ID');

    cartTotal.textContent =
        'Rp ' + total.toLocaleString('id-ID');

    checkoutButton.disabled = count === 0;

    if (count === 0) {

        checkoutButton.classList.add('disabled');

    } else {

        checkoutButton.classList.remove('disabled');

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SELECT ALL
    |--------------------------------------------------------------------------
    */

    if (productCheckboxes.length > 0) {

        selectAll.checked =
            count === productCheckboxes.length;

    }

}


/*
|--------------------------------------------------------------------------
| CHECKBOX PRODUCT
|--------------------------------------------------------------------------
*/

productCheckboxes.forEach(function(checkbox) {

    checkbox.addEventListener('change', function() {

        updateCartSummary();

    });

});


/*
|--------------------------------------------------------------------------
| SELECT ALL
|--------------------------------------------------------------------------
*/

selectAll.addEventListener('change', function() {

    productCheckboxes.forEach(function(checkbox) {

        checkbox.checked = selectAll.checked;

    });

    updateCartSummary();

});


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

checkoutButton.addEventListener('click', function(event) {

    event.preventDefault();

    const selected = [];

    productCheckboxes.forEach(function(checkbox) {

        if (checkbox.checked) {

            selected.push(checkbox.value);

        }

    });

    if (selected.length === 0) {

        return;

    }

    const url =
        "{{ route('customer.checkout.index') }}" +
        "?selected_items=" +
        selected.join(',');

    window.location.href = url;

});


updateCartSummary();

</script>

@endsection