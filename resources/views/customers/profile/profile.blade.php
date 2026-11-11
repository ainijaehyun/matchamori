<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-profile.css') }}?v={{ time() }}">
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
            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
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


    <div class="profile-page">
        <div class="profile-card">

            {{-- LEFT: PROFILE --}}
            <div class="profile-left">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <h2>{{ Auth::user()->name }}</h2>
                <p class="profile-role">Matcha Mori Customer</p>

                <a href="{{ route('customer.profile.edit') }}" class="profile-edit-btn">
                    <i class="fas fa-pen"></i>
                    Edit Profile
                </a>
            </div>

            {{-- RIGHT: CUSTOMER DATA --}}
            <div class="profile-right">
                <h3>Personal Information</h3>
                <p class="profile-subtitle">
                    Your account information
                </p>

                <div class="profile-field">
                    <label>Full Name</label>
                    <div class="profile-value">
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <div class="profile-field">
                    <label>Email Address</label>
                    <div class="profile-value">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="profile-field">
                    <label>Phone Number</label>
                    <div class="profile-value">
                        {{ Auth::user()->phone ?: '-' }}
                    </div>
                </div>

                <div class="profile-field">
                    <label>Address</label>
                    <div class="profile-value">
                        {{ Auth::user()->address ?: '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-footer">
            <a href="{{ route('customer.dashboard') }}" class="profile-back-btn">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>


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
</script>

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

