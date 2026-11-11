<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About - Matcha Mori</title>

    {{-- Bootstrap --}}
    <link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">

    <style>

        .about-page {
            --about-cream: #f5f4e8;
            --about-sage: #aebd99;
            --about-green: #6b8a5d;
            --about-dark: #304a2f;
            --about-text: #6e7568;
            background: #fffefa;
            color: var(--about-dark);
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .about-page * {
            box-sizing: border-box;
        }

        .about-page a {
            text-decoration: none;
        }

        /* SHARED LABEL */

        .about-eyebrow {
            display: inline-block;
            color: var(--about-green);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            line-height: 1.6;
        }

        /* HERO */

        .about-hero {
            background: var(--about-cream);
            padding: 75px 6%;
        }

        .about-hero-inner {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            align-items: center;
            gap: 75px;
        }

        .about-hero-content {
            padding: 20px 0;
        }

        .about-hero-content h1 {
            margin: 22px 0;
            color: var(--about-dark);
            font-family: Georgia, serif;
            font-size: clamp(42px, 5vw, 62px);
            font-weight: 400;
            line-height: 1.12;
            letter-spacing: -1.5px;
        }

        .about-hero-content h1 span {
            display: block;
            color: var(--about-green);
            font-style: italic;
        }

        .about-hero-content > p {
            max-width: 480px;
            margin: 0 0 30px;
            color: var(--about-text);
            font-size: 14px;
            line-height: 1.95;
        }

        .about-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding: 15px 22px;
            background: var(--about-dark);
            border: 1px solid var(--about-dark);
            color: #fff !important;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.25s ease,
                        color 0.25s ease;
        }

        .about-cta:hover {
            background: transparent;
            color: var(--about-dark) !important;
        }

        .about-cta i {
            font-size: 11px;
            transition: transform 0.25s ease;
        }

        .about-cta:hover i {
            transform: translateX(4px);
        }

        .about-signature {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 35px;
            color: #838779;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .about-signature-line {
            width: 35px;
            height: 1px;
            background: var(--about-sage);
        }

        /* HERO IMAGE */

        .about-hero-visual {
            position: relative;
            max-width: 470px;
            width: 100%;
            margin-left: auto;
            padding: 0 16px 20px 0;
        }

        .about-image-frame {
            position: relative;
            height: 490px;
            overflow: hidden;
            background: #e6e8d9;
        }

        .about-image-frame img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .about-image-frame:hover img {
            transform: scale(1.035);
        }

        .about-image-note {
            position: absolute;
            left: -35px;
            bottom: 55px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 17px 20px;
            background: #fffefa;
            box-shadow: 0 8px 30px rgba(48, 74, 47, 0.09);
            color: var(--about-dark);
            font-size: 11px;
        }

        .about-image-note i {
            color: var(--about-green);
            font-size: 17px;
        }

        .about-deco {
            position: absolute;
            z-index: 0;
            pointer-events: none;
        }

        .about-deco-one {
            top: -18px;
            right: 0;
            width: 95px;
            height: 95px;
            border-top: 1px solid var(--about-green);
            border-right: 1px solid var(--about-green);
        }

        .about-deco-two {
            bottom: 0;
            left: -15px;
            width: 100px;
            height: 100px;
            border-bottom: 1px solid var(--about-sage);
            border-left: 1px solid var(--about-sage);
        }

        /* OUR STORY */

        .about-story {
            padding: 95px 6%;
            background: #fffefa;
        }

        .about-story-inner {
            max-width: 1050px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 100px;
            align-items: start;
        }

        .about-story-heading h2 {
            margin: 20px 0 0;
            color: var(--about-dark);
            font-family: Georgia, serif;
            font-size: clamp(32px, 4vw, 43px);
            font-weight: 400;
            line-height: 1.3;
        }

        .about-story-content {
            padding-top: 8px;
        }

        .about-story-content p {
            margin: 0 0 20px;
            color: var(--about-text);
            font-size: 14px;
            line-height: 2;
        }

        .about-story-content p:last-child {
            margin-bottom: 0;
        }

        /* VALUES */

        .about-values {
            padding: 85px 6% 100px;
            background: var(--about-cream);
        }

        .about-values-inner {
            max-width: 1120px;
            margin: 0 auto;
        }

        .about-values-heading {
            max-width: 650px;
            margin: 0 auto 48px;
            text-align: center;
        }

        .about-values-heading h2 {
            margin: 17px 0 13px;
            color: var(--about-dark);
            font-family: Georgia, serif;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 400;
        }

        .about-values-heading p {
            margin: 0;
            color: var(--about-text);
            font-size: 13px;
            line-height: 1.8;
        }

        .about-values-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .about-value {
            position: relative;
            min-width: 0;
            padding: 32px 27px 35px;
            background: #fffefa;
            border-top: 2px solid var(--about-sage);
            transition: transform 0.25s ease,
                        box-shadow 0.25s ease;
        }

        .about-value:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(48, 74, 47, 0.07);
        }

        .about-value-number {
            color: #aab59e;
            font-family: Georgia, serif;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .about-value-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 47px;
            height: 47px;
            margin: 24px 0 22px;
            background: #eaf0e2;
            color: var(--about-green);
            font-size: 19px;
        }

        .about-value h3 {
            margin: 0 0 13px;
            color: var(--about-dark);
            font-family: Georgia, serif;
            font-size: 21px;
            font-weight: 400;
        }

        .about-value p {
            margin: 0;
            color: var(--about-text);
            font-size: 13px;
            line-height: 1.9;
        }

        /* CONTACT */

        .about-contact {
            padding: 75px 6%;
            background: var(--about-dark);
            color: #fff;
        }

        .about-contact-inner {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 0.8fr 1.2fr;
            gap: 70px;
            align-items: center;
        }

        .about-contact .about-eyebrow {
            color: #c8d8b8;
        }

        .about-contact-heading h2 {
            margin: 20px 0;
            color: #fff;
            font-family: Georgia, serif;
            font-size: clamp(34px, 4vw, 46px);
            font-weight: 400;
            line-height: 1.25;
        }

        .about-contact-heading > p {
            max-width: 410px;
            margin: 0;
            color: #dce5d5;
            font-size: 13px;
            line-height: 1.9;
        }

        .about-contact-details {
            display: flex;
            flex-direction: column;
        }

        .about-contact-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        }

        .about-contact-item:first-child {
            border-top: 1px solid rgba(255, 255, 255, 0.16);
        }

        .about-contact-item > i {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 43px;
            height: 43px;
            background: rgba(255, 255, 255, 0.09);
            color: #d5e2c8;
            font-size: 16px;
        }

        .about-contact-item span {
            display: block;
            margin-bottom: 7px;
            color: #c8d8b8;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .about-contact-item p {
            margin: 0;
            color: #fff;
            font-size: 13px;
            overflow-wrap: anywhere;
        }
        .about-contact-item {
            align-items: flex-start;
        }

        .about-contact-item .about-contact-icon {
            font-size: 24px;
            width: 55px;
            height: 55px;
        }

        .about-contact-info span {
            font-size: 18px;
            font-weight: 600;
        }

        .about-contact-info p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 3px;
        }
        
        .about-contact-details {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .about-contact-item {
            display: flex;
            align-items: center;
            gap: 18px;
            width: 100%;
            padding: 22px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        }

        .about-contact-item:first-child {
            border-top: 1px solid rgba(255, 255, 255, 0.16);
        }

        .about-contact-item > i {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.09);
            color: #d5e2c8;
            font-size: 18px;
        }

        .about-contact-item span {
            display: block;
            margin-bottom: 8px;
            color: #c8d8b8;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .about-contact-item p {
            margin: 0 0 5px;
            color: #fff;
            font-size: 15px;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .about-contact-item p:last-child {
            margin-bottom: 0;
        }
        

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .about-hero-inner {
                gap: 40px;
            }

            .about-image-frame {
                height: 410px;
            }

            .about-story-inner {
                gap: 45px;
            }

            .about-contact-inner {
                gap: 45px;
            }

            .about-values-grid {
                gap: 15px;
            }

            .about-value {
                padding: 28px 20px;
            }
        }

        @media (max-width: 680px) {
            .about-hero {
                padding: 55px 23px 65px;
            }

            .about-hero-inner {
                grid-template-columns: 1fr;
                gap: 45px;
            }

            .about-hero-content {
                padding: 0;
            }

            .about-hero-content h1 {
                font-size: 44px;
            }

            .about-hero-content > p {
                font-size: 13px;
            }

            .about-hero-visual {
                max-width: 100%;
                padding-right: 10px;
            }

            .about-image-frame {
                height: 360px;
            }

            .about-image-note {
                left: -5px;
                bottom: 45px;
                padding: 14px;
            }

            .about-story {
                padding: 65px 24px;
            }

            .about-story-inner {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .about-story-heading h2 {
                font-size: 34px;
            }

            .about-values {
                padding: 65px 22px;
            }

            .about-values-heading {
                margin-bottom: 32px;
            }

            .about-values-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .about-value {
                padding: 27px;
            }

            .about-value-icon {
                margin: 18px 0;
            }

            .about-contact {
                padding: 60px 24px;
            }

            .about-contact-inner {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .about-contact-heading h2 {
                font-size: 38px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .about-page *,
            .about-page *::before,
            .about-page *::after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }

    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="mm-navbar">
        {{-- Logo --}}
        <a href="{{ Auth::check() ? route('customer.dashboard') : route('welcome') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        {{-- Menu --}}
        <div class="mm-nav-links">
            <a href="{{ Auth::check() ? route('customer.dashboard') : route('welcome') }}">
                Home
            </a>

            <a href="{{ route('about') }}" class="active">
                About Us
            </a>

            <a href="{{ route('products.index') }}">
                Menu
            </a>
        </div>

        {{-- Search dan menu akun --}}
        <div class="mm-nav-right">
            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search.." value="{{ request('search') }}">

                <button type="submit" class="mm-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            @auth
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
                    <button class="profile-button"type="button" id="profileDropdown" aria-haspopup="true" aria-expanded="false">
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
                <div class="auth-links">
                    <a href="{{ route('login', ['redirect_to' => request()->getRequestUri()]) }}" class="auth-btn login-btn">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="auth-btn register-btn">
                        Register
                    </a>
                </div>
            @endauth

        </div>
    </nav>


    {{-- ABOUT --}}
    <main class="about-page">
        {{-- ABOUT HERO --}}
        <section class="about-hero">
            <div class="about-hero-inner">
                <div class="about-hero-content">
                    <span class="about-eyebrow">GET TO KNOW US</span>
                    <h1>
                        A Little About
                        <span>Matcha Mori.</span>
                    </h1>
                    <p>
                        Selamat datang di Matcha Mori, 
                        Matcha Mori hadir untuk para pecinta matcha yang ingin
                        menikmati beragam kreasi rasa khas Jepang. Mulai dari
                        minuman, dessert, bubuk matcha, hingga berbagai aksesori,
                        semuanya dipilih untuk menemani momen istimewamu.
                    </p>
                    <a href="{{ route('products.index') }}" class="about-cta">
                        Explore Our Products
                        <i class="fas fa-arrow-right"></i>
                    </a>

                    <div class="about-signature">
                        <span class="about-signature-line"></span>
                        <span>Japanese matcha & tea store</span>
                    </div>
                </div>

                <div class="about-hero-visual">
                    <div class="about-image-frame">
                        <img src="{{ asset('img/matchapow.jpg') }}" alt="Matcha green tea prepared in a ceramic bowl">
                    </div>

                    <div class="about-image-note">
                        <i class="fas fa-leaf"></i>
                        <span>Inspired by the art of matcha</span>
                    </div>

                    <span class="about-deco about-deco-one"></span>
                    <span class="about-deco about-deco-two"></span>
                </div>
            </div>
        </section>

        {{-- OUR STORY --}}
        <section class="about-story" id="about-story">
            <div class="about-story-inner">
                <div class="about-story-heading">
                    <span class="about-eyebrow">OUR STORY</span>
                    <h2>A Store Made for<br>Matcha Lovers</h2>
                </div>

                <div class="about-story-content">
                    <p>
                         Matcha Mori terinspirasi dari keindahan budaya teh
                        Jepang yang menghadirkan ketenangan dalam setiap
                        sajian. Kami percaya bahwa matcha bukan sekadar
                        minuman, tetapi juga bagian dari momen sederhana
                        yang dapat memberikan kesan istimewa.
                    </p>
                    <p>
                        Dengan menghadirkan beragam pilihan produk matcha,
                        mulai dari minuman yang menyegarkan, dessert yang
                        menggugah selera, hingga bubuk matcha dan aksesori,
                        Matcha Mori ingin menjadi tempat bagi siapa saja
                        untuk menemukan dan menikmati hal-hal favorit
                        seputar matcha.
                    </p>
                </div>
            </div>
        </section>

        {{-- OUR VALUES --}}
        <section class="about-values" id="about-values">
            <div class="about-values-inner">
                <div class="about-values-heading">
                    <span class="about-eyebrow">WHAT MATTERS TO US</span>
                    <h2>What Makes Us Special</h2>
                    <p>
                        Setiap pilihan di Matcha Mori hadir untuk memberikan
                        pengalaman menikmati matcha yang lebih berkesan.
                    </p>
                </div>

                <div class="about-values-grid">
                    <article class="about-value">
                        <div class="about-value-number">01</div>
                        <div class="about-value-icon">
                            <i class="fas fa-mug-hot"></i>
                        </div>
                        <h3>Product Variety</h3>
                        <p>
                            Berbagai pilihan minuman dan dessert matcha
                            dengan cita rasa yang menarik untuk dinikmati
                            di setiap kesempatan.
                        </p>
                    </article>

                    <article class="about-value">
                        <div class="about-value-number">02</div>
                        <div class="about-value-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3>Japanese inspired</h3>
                        <p>
                            Menghadirkan inspirasi budaya teh Jepang melalui
                            pilihan produk dan suasana khas Matcha Mori.
                        </p>
                    </article>

                    <article class="about-value">
                        <div class="about-value-number">03</div>
                        <div class="about-value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Made for Matcha Lovers</h3>
                        <p>
                            Menjadi tempat untuk menemukan berbagai
                            pilihan favorit bagi siapa saja yang menyukai
                            keunikan rasa matcha.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        {{-- CONTACT --}}
        <section class="about-contact" id="about-contact">
            <div class="about-contact-inner">
                <div class="about-contact-heading">
                    <span class="about-eyebrow">LET'S CONNECT</span>
                    <h2>We'd Love to<br>Hear From You.</h2>
                    <p>
                         Ingin mengetahui lebih banyak tentang Matcha Mori?
                        Kami senang bisa terhubung dan berbagi cerita
                        seputar dunia matcha bersama kamu.
                    </p>
                </div>

                <div class="about-contact-details">
                    <div class="about-contact-item">
                        <div class="about-contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>

                        <div class="about-contact-info">
                            <span>Jam Operasional</span>
                            <p>Senin – Jumat: 08.00 – 17.00 WIB</p>
                            <p>Sabtu: 08.00 – 15.00 WIB</p>
                            <p>Minggu: Tutup</p>
                        </div>
                    </div>

                    <div class="about-contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span>Email Address</span>
                            <p>matchamori@email.com</p>
                        </div>
                    </div>

                    <div class="about-contact-item">
                        <i class="fab fa-instagram"></i>
                        <div>
                            <span>Instagram</span>
                            <p>@matchamori</p>
                        </div>
                    </div>

                    <div class="about-contact-item">
                        <i class="fas fa-location-dot"></i>
                        <div>
                            <span>Location</span>
                            <p>Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


@include('layouts.inc.footer')
<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>



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