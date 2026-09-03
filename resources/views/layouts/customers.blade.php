<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Matcha Mori')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    @stack('styles')

</head>
<body>
    <div class="customer-container">
        {{--navbar--}}
        <nav class="customer-navbar">
            {{--logo--}}
            <div class="customer-logo">
                <img src="{{ asset('img/leaf1.png') }}"alt="Matcha Mori">
                <span>Matcha Mori</span>
            </div>
            {{-- navigasi --}}
            <div class="customer-nav">
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    Home
                </a>

                <a href="#categories">
                    Category
                </a>

                <a href="{{ route('customer.products.index') }}">
                    Product
                </a>

                <a href="#orders">
                    Order
                </a>

            </div>

            {{-- icon --}}

            <div class="customer-icons">

                {{-- cari --}}
                <a href="#" title="Search">
                    <i class="fas fa-search"></i>
                </a>

                {{-- keranjang --}}
                <a href="{{ route('customer.cart.index') }}" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                </a>

                {{-- profile --}}
                <div class="profile-dropdown dropdown">
                    <button class="profile-button dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>

                    <div class="profile-menu dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a href="{{ route('customer.profile') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        
        @yield('content')

    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    

    @stack('scripts')

</body>
</html>

<style>

    /* GLOBAL */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100%;
        overflow-x: hidden;
        background: #e5ffcf;
        font-family: Georgia, serif;
        color: #111;
    }

    /* CUSTOMER CONTAINER */
    .customer-container {
        width: 100%;
        min-height: 100vh;
        padding: 0 24px 40px;
        background: #e5ffcf;
    }

    /* NAVBAR */
    .customer-navbar {
        width: 100%;
        height: 75px;
        display: flex;
        align-items: center;
        padding: 0 18px;
        background: #e5ffcf;
    }

    /* LOGO */
    .customer-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-right: auto;
    }

    .customer-logo img {
        width: 42px;
        height: 42px;
        object-fit: contain;
    }

    .customer-logo span {
        font-size: 25px;
    }

    /* NAVIGATION */
    .customer-nav {
        display: flex;
        align-items: center;
        gap: 32px;
    }

    .customer-nav a {
        color: #111;
        text-decoration: none;
        font-size: 21px;
    }

    .customer-nav a:hover {
        color: #008000;
    }

    .customer-nav a.active {
        color: #008000;
        text-decoration: underline;
        text-underline-offset: 5px;
    }

    /* ICON */
    .customer-icons {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-left: 50px;
    }

    .customer-icons > a {
        color: #111;
        text-decoration: none;
        font-size: 25px;
    }

    .customer-icons > a:hover {
        color: #008000;
    }

    /* HERO */
    .customer-hero {
        position: relative;
        width: 100%;
        height: 350px;
        background: #111;
        border-radius: 22px;
        overflow: hidden;
    }

    /* FOTO HERO*/
    .hero-picture {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .hero-picture img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: center;
        object-position: center;
    }

    .hero-picture::before {
        display: none !important;
    }

    /* HERO TEXT */
    .hero-text {
        position: absolute;
        top: 50%;
        left: 55px;
        transform: translateY(-50%);
        width: 43%;
        z-index: 3;
        color: white;
    }

    /* GREETING */
    .hero-greeting {
        font-size: 18px;
        line-height: 1.4;
        margin-bottom: 14px;
    }

    /* TITLE */
    .hero-title {
        margin: 0 0 15px;
        font-size: 44px;
        line-height: 1.1;
        font-weight: bold;
    }

    /* DESCRIPTION */
    .hero-description {
        margin: 0;
        font-size: 18px;
        line-height: 1.5;
    }

    /* CUSTOMER SECTION */
    .customer-section {
        margin-top: 32px;
    }
    .customer-section-title {
        margin: 0 0 25px 12px;
        font-size: 20px;
        font-weight: bold;
    }

    /* CATEGORY GRID */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 35px;
        padding: 0 10px;
    }

    /* CATEGORY CARD */
    .category-card {
        min-height: 100px;
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 12px;
        background: #b8dfa5;
        border-radius: 12px;
        box-shadow:
            0 3px 6px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: 0.2s ease;
    }

    .category-card:hover {
        transform: translateY(-3px);
        box-shadow:
            0 5px 10px rgba(0, 0, 0, 0.18);
    }

    /* CATEGORY ICON */
    .category-icon {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5ffcf;
        border-radius: 10px;
        font-size: 30px;
        color: #315b25;
    }

    /* CATEGORY NAME */
    .category-name {
        font-size: 17px;
        font-weight: 500;
    }

    /* BEST SELLER */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 35px;
        padding: 0 10px;
    }

    /* PRODUCT CARD */
    .product-card {
        background: white;
        border: 1.5px solid #111;
        border-radius: 15px;
        padding: 8px;
        overflow: hidden;
        box-shadow:
            2px 3px 5px rgba(0, 0, 0, 0.15);
        transition: 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow:
            3px 5px 10px rgba(0, 0, 0, 0.18);
    }

    /* PRODUCT IMAGE */
    .product-image {
        width: 100%;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #b8dfa5;
        border-radius: 11px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    /* PRODUCT FALLBACK ICON */
    .product-icon {
        font-size: 45px;
        color: #315b25;
    }

    /* PRODUCT INFO */
    .product-info {
        padding: 12px 3px 8px;
    }

    /* PRODUCT NAME */
    .product-name {
        font-size: 17px;
        margin-bottom: 10px;
    }

    /* PRODUCT BOTTOM */
    .product-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* PRICE */
    .product-price {
        font-size: 17px;
        font-weight: bold;
    }

    /* RATING */
    .product-rating {
        font-size: 16px;
    }

    .product-rating i {
        color: #f5a400;
        margin-right: 4px;
    }

    /* PROFILE DROPDOWN */
    .profile-dropdown {
        position: relative;
    }

    /* PROFILE BUTTON */
    .profile-button {
        width: 40px;
        height: 40px;
        padding: 0;
        border: none;
        background: transparent;
        color: #111;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .profile-button:hover {
        color: #008000;
    }

    /* DROPDOWN TERTUTUP */
    .profile-dropdown .profile-menu {
        display: none !important;
        position: absolute;
        top: 48px;
        right: 0;
        width: 180px;
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        padding: 6px 0;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        z-index: 99999;
    }

    /* DROPDOWN MUNCUL */
    .profile-dropdown.show .profile-menu {
        display: block !important;
    }

    /* ITEM MENU */
    .profile-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        font-size: 15px;
    }

    .profile-menu a:hover {
        background: #e5ffcf;
        color: #315b25;
        text-decoration: none;
    }

    .profile-menu a i {
        width: 18px;
        text-align: center;
        color: #527b5b;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .customer-nav {
            gap: 20px;
        }

        .customer-nav a {
            font-size: 18px;
        }

        .customer-icons {
            margin-left: 25px;
            gap: 18px;
        }

        .hero-text {
            left: 40px;
            width: 45%;
        }

        .hero-title {
            font-size: 39px;
        }

        .category-grid,
        .product-grid {
            gap: 20px;
        }
    }

    /* TABLET */
    @media (max-width: 850px) {
        .customer-navbar {
            height: auto;
            flex-wrap: wrap;
            padding: 15px;
        }

        .customer-logo {
            margin-right: auto;
        }

        .customer-nav {
            order: 3;
            width: 100%;
            justify-content: center;
            margin-top: 15px;
        }

        .customer-icons {
            margin-left: 20px;
        }

        .customer-hero {
            height: 380px;
        }

        .hero-picture {
            width: 75%;
        }

        .hero-text {
            width: 50%;
            left: 35px;
        }

        .category-grid,
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* MOBILE */
    @media (max-width: 600px) {
        .customer-container {
            padding: 0 12px 30px;
        }
        .customer-navbar {
            padding: 12px 5px;
        }
        .customer-logo {
            width: 100%;
        }
        .customer-nav {
            gap: 15px;
            justify-content: flex-start;
            overflow-x: auto;
        }
        .customer-nav a {
            font-size: 16px;
        }
        .customer-icons {
            position: absolute;
            right: 20px;
            top: 15px;
            margin: 0;
        }
        .customer-hero {
            height: 400px;
        }
        .hero-picture {
            width: 100%;
        }
        .hero-text {
            left: 25px;
            width: 70%;
        }
        .hero-title {
            font-size: 35px;
        }
        .hero-description {
            font-size: 16px;
        }
        .category-grid,
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>