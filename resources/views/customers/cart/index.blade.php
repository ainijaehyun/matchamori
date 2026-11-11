<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet"
          href="{{ asset('css/welcome.css') }}?v={{ time() }}">

    <link rel="stylesheet"
          href="{{ asset('css/customer-cart.css') }}?v={{ time() }}">
          <link rel="stylesheet"
          href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">
</head>

<body>

    <nav class="mm-navbar">

        <a href="{{ route('welcome') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        <div class="mm-nav-links">

            <a href="{{ Auth::check() ? route('customer.dashboard') : route('welcome') }}">
                Home
            </a>

            <a href="{{ route('about') }}">
                About Us
            </a>

            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                Menu
            </a>

        </div>

        <div class="mm-nav-right">

            <form action="{{ route('products.index') }}" method="GET" class="mm-search-form">

                <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">

                <button type="submit" class="mm-search-button">
                    <i class="fas fa-search"></i>
                </button>

            </form>

            @if(Auth::check())

                {{-- Cart --}}
                @php
                    $cartCount = \App\Models\CartDetail::whereHas('cart', function ($query) {
                        $query->where('user_id', Auth::id());
                    })->sum('quantity');
                @endphp

                <a class="mm-auth-link mm-cart-link" href="{{ route('customer.cart.index') }}" title="Cart">
                    <i class="fas fa-shopping-cart"></i>

                    @if ($cartCount > 0)
                        <span class="mm-cart-count">{{ $cartCount }}</span>
                    @endif
                </a>


            {{-- Customer Name --}}
            <div class="profile-dropdown">
                <button class="profile-button" type="button" id="profileDropdown" aria-haspopup="true" aria-expanded="false">

                    <i class="fas fa-user-circle mm-customer-icon"></i>
                    <span>{{ Auth::user()->name }}</span>

                </button>

                <div class="profile-menu">

                    <a href="{{ route('customer.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>

                    <a href="{{ route('customer.orders.index') }}">
                        <i class="fas fa-shopping-bag"></i>
                        <span>My Orders</span>
                    </a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>

                </div>
            </div>

            @else

                <a href="{{ route('login') }}" class="mm-auth-link">
                    Login
                </a>

                <span class="mm-auth-divider">|</span>

                <a href="{{ route('register') }}" class="mm-auth-link">
                    Register
                </a>

            @endif

        </div>

    </nav>


    <div class="cart-page">
        <h1 class="cart-title">
            Pesanan Saya
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

                            <div class="cart-checkbox">
                                <input type="checkbox" name="selected_items[]" value="{{ $detail->id }}" class="product-checkbox" data-subtotal="{{ $detail->subtotal }}">
                            </div>

                            <div class="cart-product-image">
                                @if($detail->product->image)

                                    <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">

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

                                <form action="{{ route('customer.cart.update', $detail->id) }}" method="POST" class="quantity-form">

                                    @csrf
                                    @method('PATCH')

                                    <div class="quantity-control">

                                        <button type="button" onclick="changeQuantity(this, -1)">
                                            −
                                        </button>

                                        <input type="number" name="quantity" class="quantity-input" value="{{ $detail->quantity }}" min="1" readonly>

                                        <button type="button" onclick="changeQuantity(this, 1)">
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
                            <form action="{{ route('customer.cart.destroy', $detail->id) }}" method="POST" class="delete-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="delete-button" title="Delete">
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

                    <form action="{{ route('customer.checkout.index') }}" method="GET" id="checkout-form">

                        <button type="submit" class="checkout-button" id="checkout-button" disabled>
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
                <a href="{{ route('products.index') }}" class="shop-now-btn">
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

@include('layouts.inc.footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Produk ini akan dihapus dari keranjang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6b8a5d',
                cancelButtonColor: '#9e9e9e',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: @json(session('success')),
        confirmButtonText: 'OK',
        scrollbarPadding: false
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('profileDropdown');
        const dropdown = button?.closest('.profile-dropdown');

        if (!button || !dropdown) return;

        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const isOpen = dropdown.classList.toggle('show');

            button.setAttribute('aria-expanded', isOpen);

        });

        document.addEventListener('click', function (event) {

            if (!dropdown.contains(event.target)) {

                dropdown.classList.remove('show');

                button.setAttribute('aria-expanded', 'false');

            }

        });

    });
</script>


</body>
</html>