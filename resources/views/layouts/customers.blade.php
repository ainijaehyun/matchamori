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
                <img src="{{ asset('img/leaf.png') }}"alt="Matcha Mori">
                <span>Matcha Mori</span>
            </div>
            {{-- navigasi --}}
            <div class="customer-nav">
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('customer.categories.index') }}" class="{{ request()->routeIs('customer.categories.index') ? 'active' : '' }}">
                    Category
                </a>

                <a href="{{ route('customer.products.index') }}" class="{{ request()->routeIs('customer.products.index') ? 'active' : '' }}">
                    Product
                </a>

                <a href="#orders">
                    Order
                </a>

            </div>

            {{-- icon --}}

            <div class="customer-icons">

                {{-- cari --}}
                <form action="{{ route('customer.products.index') }}" method="GET" class="customer-search">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">

                    <button type="submit" title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

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

        <footer class="custom-footer">
            <span>
                Copyright &copy; Matcha Mori {{ date('Y') }}
            </span>
        </footer>

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

    .customer-container {
        width: 100%;
        min-height: 100vh;
        padding: 0 24px 40px;
        background: #e5ffcf;
    }

    .custom-footer {
        width: 100%;
        margin-top: 50px;
        padding: 20px 0;
        text-align: center;
        background: #e5ffcf;
        border-radius: 12px 12px 0 0;
    }
    .custom-footer span {
        color: #315b25;
        font-size: 14px;
    }

    .customer-navbar {
        width: calc(100% + 48px);
        height: 82px;
        display: flex;
        align-items: center;
        margin-left: -24px;
        padding: 0 46px;
        background: #d1f7ba;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);   
        margin-bottom: 25px;
    }

    .customer-logo {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-right: auto;
    }

    .customer-logo img {
        width: 65px;
        height: 65px;
        object-fit: contain;
    }

    .customer-logo span {
        font-family: 'Cormorant Garamond', serif;
        font-size: 25px;
        font-weight: 600;
        transform: translateY(6px);
        color: #2b500a;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.25);
    }

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
    .customer-hero {
        position: relative;
        width: 100%;
        height: 350px;
        background: #111;
        border-radius: 22px;
        overflow: hidden;
    }

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

    .hero-text {
        position: absolute;
        top: 50%;
        left: 55px;
        transform: translateY(-50%);
        width: 70%;
        z-index: 3;
        color: #e1ffc6;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.25);
    }

    .hero-greeting {
        font-size: 25px;
        line-height: 1.4;
        margin-bottom: 20px;
    }

    .hero-title {
        margin: 0 0 15px;
        font-size: 44px;
        line-height: 1.1;
        font-weight: bold;
    }
    .hero-description {
        margin: 0;
        font-size: 18px;
        line-height: 1.5;
    }
    .customer-section {
        margin-top: 32px;
    }
    .customer-section-title {
        margin: 0 0 25px 12px;
        font-size: 20px;
        font-weight: bold;
    }
    .customer-section-heading {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }
    .customer-section-heading .customer-section-title {
        margin: 0;
    }
    .see-all-link {
        width: 78px;
        color: #008000;
        font-family: Georgia, serif;
        font-size: 20px;
        text-decoration: none;
    }
    .see-all-link:hover {
        color: #006b00;
        text-decoration: underline;
    }
    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 35px;
        padding: 0 10px;
    }

    .category-card {
        width: 290px;
        height: 90px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px;
        background: #b8dfa5;
        border-radius: 12px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: 0.2s ease;
        text-decoration: none;
        color: #111;
    }
    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.18);
        text-decoration: none;
        color: #111;
    }
    .category-image {
        width: 120px;
        height: 75px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        background: #e5ffcf;
    }
    .category-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }
    .category-image i {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #315b25;
    }
    .category-name {
        font-size: 15px;
        font-weight: 500;
    }
    .best-seller-section {
        margin-top: 32px;
    }
    .best-seller-section .customer-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .customer-section-title {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #244b2a;
    }
    .customer-section-title i {
        font-size: 23px;
        margin-right: 8px;
        color: #668d58;
    }
    .best-seller-subtitle {
        margin: 0;
        color: #008000;
        font-size: 20px;
    }
    .best-seller-subtitle i {
        margin-left: 6px;
    }
    .best-seller-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 32px;
        width: 100%;
    }
    .best-seller-card {
        display: flex;
        align-items: stretch;
        width: 100%;
        min-height: 225px;
        background: #f9fcf5;
        border: 1px solid #dce8d6;
        border-radius: 18px;
        padding: 14px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 5px 15px rgba(65, 91, 55, 0.10);
        transition: all 0.25s ease;
    }
    .best-seller-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 20px rgba(65, 91, 55, 0.16);
    }
    .best-seller-image {
        width: 245px;
        min-width: 245px;
        height: 195px;
        border-radius: 14px;
        overflow: hidden;
        background: #eef4e9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .best-seller-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .best-seller-image i {
        font-size: 45px;
        color: #8ba47e;
    }
    .best-seller-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 8px 12px 6px 20px;
        min-width: 0;
    }
    .best-seller-name {
        margin: 0 0 10px;
        color: #294a31;
        font-size: 21px;
        line-height: 1.25;
        font-weight: 700;
    }
    .best-seller-description {
        margin: 0;
        color: #71806f;
        font-size: 14px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .best-seller-bottom {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: auto;
    }
    .best-seller-price {
        margin-bottom: 10px;
        color: #396b3d;
        font-size: 19px;
        font-weight: 700;
    }
    .best-seller-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }
    .stock {
        background: #c4ff93;
        color: #52734e;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
    }


    /* RESPONSIVE */

    @media (max-width: 1000px) {

        .best-seller-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 600px) {

        .best-seller-section .customer-section-heading {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .best-seller-card {
            flex-direction: column;
        }

        .best-seller-image {
            width: 100%;
            min-width: 100%;
            height: 200px;
        }

        .best-seller-info {
            padding: 15px 5px 5px;
        }

    }
            /* SEARCH */
    .customer-search {
        display: flex;
        align-items: center;
        margin: 0;
    }

    .customer-search input {
        width: 180px;
        height: 36px;
        padding: 8px 14px;
        border: 1px solid #b8d6a8;
        outline: none;
        background: #ffffff;
        border-radius: 20px;
        font-family: Georgia, serif;
        font-size: 14px;
    }

    .customer-search input::placeholder {
        color: #777;
    }

    .customer-search input:focus {
        border-color: #7ca66b;
    }

    .customer-search button {
        margin-left: -38px;
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        color: #315b25;
        font-size: 16px;
        cursor: pointer;
    }

    .customer-search button:hover {
        color: #008000;
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