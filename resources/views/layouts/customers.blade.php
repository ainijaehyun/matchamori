<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Matcha Mori')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/customer-layout.css') }}?v={{ time() }}" rel="stylesheet">

    @stack('styles')

</head>

<body>

    <div class="customer-container">

        {{-- Navbar --}}
        <nav class="customer-navbar">
            {{-- Logo --}}
            <div class="customer-logo">
                <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
                <span>MATCHA MORI</span>
            </div>

            {{-- Navigasi --}}
            <div class="customer-nav">
                <a href="{{ Auth::check() ? route('customer.dashboard') : route('welcome') }}"
                   class="{{ request()->routeIs('customer.dashboard') || request()->routeIs('welcome') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    About Us
                </a>

                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    Menu
                </a>
            </div>

            {{-- Bagian kanan --}}
            <div class="customer-icons">
                {{-- Global Search --}}
                <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                    <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">

                    <button type="submit" class="mm-search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                @if(Auth::check())
                                        
                    {{-- Keranjang --}}
                    @php
                        $cart = \App\Models\Cart::where('user_id', Auth::id())->first();

                        $cartCount = $cart
                            ? $cart->cartDetails()->sum('quantity')
                            : 0;
                    @endphp

                    <a href="{{ route('customer.cart.index') }}" title="Cart" class="mm-cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartCount > 0 && !request()->routeIs('customer.cart.*'))
                            <span class="mm-cart-count">{{ $cartCount }}</span>
                        @endif
                    </a>

                    {{-- Profile Customer --}}
                    <div class="profile-dropdown">
                        <button class="profile-button" type="button" id="profileDropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle mm-customer-icon"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </button>

                        <div class="profile-menu" aria-labelledby="profileDropdown">
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

                    {{-- Guest / Belum Login --}}
                    <a href="{{ route('login', ['redirect_to' => request()->getRequestUri()]) }}">
                        Login
                    </a>

                    <span class="guest-divider">|</span>

                    <a href="{{ route('register') }}" class="guest-auth-link">
                        Register
                    </a>

                @endif

            </div>

        </nav>


        @yield('content')


        @include('layouts.inc.footer')

    </div>


    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

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

    @stack('scripts')

        
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