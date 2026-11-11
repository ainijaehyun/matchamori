<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Confirmation - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet"  href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-checkout.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">
</head>
<body>

    {{-- NAVBAR --}}
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

    {{-- Success Message --}}
    <div class="confirmation-success">

        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Order Confirmed!</h1>

        <p>
            Your order has been successfully placed.
        </p>

    </div>

    {{-- Notification --}}
    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    {{-- Confirmation Content --}}
    <div class="confirmation-content">

        {{-- ORDER INFORMATION --}}
        <div class="confirmation-card">

            <div class="confirmation-card-title">
                <h2>Order Information</h2>
            </div>

            <div class="order-info">

                <div class="order-info-row">
                    <span>Invoice</span>
                    <strong>{{ $order->invoice }}</strong>
                </div>

                <div class="order-info-row">
                    <span>Order Status</span>
                    <strong>{{ $order->order_status }}</strong>
                </div>

                <div class="order-info-row">
                    <span>Payment Method</span>
                    <strong>{{ $order->payment_method }}</strong>
                </div>

                <div class="order-info-row">
                    <span>Payment Status</span>

                    <strong>
                        @if($order->payment_method === 'COD')
                            @if($order->payment_status === 'Paid')
                                Paid
                            @else
                                Pay when order arrives
                            @endif
                        @elseif($order->payment_status === 'Paid')
                            Paid
                        @elseif($order->payment_status === 'Pending')
                            Waiting for payment
                        @elseif($order->payment_status === 'Unpaid')
                            Unpaid
                        @else
                            {{ $order->payment_status }}
                        @endif
                    </strong>
                </div>

            </div>

        </div>
        
        {{-- SHIPPING INFORMATION --}}
        <div class="confirmation-card shipping-confirmation-card">

            @php
                $shippingText = $order->shipping ?? '';

                preg_match('/Name:\s*(.*?),\s*Phone:/i', $shippingText, $nameMatch);
                preg_match('/Phone:\s*(.*?),\s*(Address|Method):/i', $shippingText, $phoneMatch);

                $recipientName = $nameMatch[1] ?? '';
                $recipientPhone = $phoneMatch[1] ?? '';

                $isPickup = str_contains($shippingText, 'Method: Pickup');
                
                if ($isPickup) {
                    $recipientAddress = 'Ambil di Tempat - Matcha Mori Store';
                } else {
                    preg_match('/Address:\s*(.*)$/i', $shippingText, $addressMatch);
                    $recipientAddress = $addressMatch[1] ?? '';
                }
            @endphp

            <div class="confirmation-card-title">
                <h2>
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $isPickup ? 'Pickup Information' : 'Shipping Information' }}
                </h2>
            </div>

            <div class="shipping-confirmation-details">

                <div class="shipping-info-item">
                    <span class="shipping-info-label">Full Name</span>
                    <p>{{ trim($recipientName) ?: '-' }}</p>
                </div>

                <div class="shipping-info-item">
                    <span class="shipping-info-label">Phone Number</span>
                    <p>{{ trim($recipientPhone) ?: '-' }}</p>
                </div>

                <div class="shipping-info-item">
                    <span class="shipping-info-label">
                        {{ $isPickup ? 'Pickup Location' : 'Shipping Address' }}
                    </span>
                    <p>{{ trim($recipientAddress) ?: '-' }}</p>
                </div>

            </div>

            <div class="shipping-confirmation-note">
                <i class="fas fa-info-circle"></i>
                <span>
                    {{ $isPickup
                        ? 'Silakan datang ke lokasi Matcha Mori untuk mengambil pesanan.'
                        : 'Please make sure your shipping information is correct.'
                    }}
                </span>
            </div>

        </div>


        {{-- ORDER DETAILS --}}
        <div class="confirmation-card order-details-card">

            <div class="confirmation-card-title">
                <h2>Order Details</h2>
            </div>

            <div class="confirmation-products">
                @foreach ($order->orderDetails as $detail)
                    <div class="confirmation-product">

                        <div class="confirmation-product-image">
                            @if ($detail->product && $detail->product->image)
                                <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">
                            @else
                                <i class="fas fa-leaf"></i>
                            @endif
                        </div>

                        <div class="confirmation-product-info">
                            <h3>
                                {{ $detail->product->name ?? 'Produk tidak tersedia' }}
                            </h3>

                            <p class="confirmation-product-price">
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                                <span>× {{ $detail->quantity }}</span>
                            </p>
                        </div>

                        <div class="confirmation-product-subtotal">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="confirmation-product-total">
                <span>Product Total</span>
                <strong>
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </strong>
            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="confirmation-buttons">

            <a href="{{ route('customer.orders.index', $order->id) }}" class="view-order-button">
                View Order
            </a>

            <a href="{{ route('customer.cart.index') }}" class="back-home-button">
                Back 
            </a>

        </div>

    </div>

</div>
<br><br>

{{-- FOOTER --}}
@include('layouts.inc.footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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
