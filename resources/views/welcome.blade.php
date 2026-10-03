<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matcha Mori</title>

    <link rel="stylesheet"
        href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --cream: #f5f4e8;
            --cream-light: #faf9f1;

            --sage: #aebd99;
            --sage-light: #dce5d3;

            --green: #6b8a5d;
            --green-dark: #4f6945;
            --deep-green: #304a2f;

            --text: #344330;
            --muted: #65705f;

            --line: rgba(48, 74, 47, .18);
        }

        * {
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background: var(--cream);
        }
        a {
            text-decoration: none;
        }
        .mm-navbar {
            min-height: 72px;
            padding: 8px 0;
            background: #6b8a5d;
            position: relative;
            z-index: 1000;
        }
        .mm-navbar .container-fluid {
            padding-left: 45px;
            padding-right: 45px;
        }
        .mm-brand {
            display: flex; 
            align-items: center; 
            gap: 10px; 
            color: #fff; 
            text-decoration: none;
        } 
        .mm-brand:hover {
            color: #fff;
        } 
        .mm-brand img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        } 
        .mm-brand-title {
            font-size: 20px; 
            letter-spacing: 3px; 
            font-weight: normal; 
            line-height: 1;
        } 
        .mm-navbar .nav-link {
            position: relative; 
            color: rgba(255, 255, 255, .92) !important;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            margin-left: 10px;
            padding: 9px 5px !important;
            transition: .2s ease;
        }
        .mm-navbar .nav-link:hover {
            color: #fff !important;
        }
        .mm-navbar .nav-link:not(.mm-nav-button)::after {
            content: "";
            position: absolute;
            left: 5px;
            right: 5px;
            bottom: 2px;
            width: 0;
            height: 1px;
            background: #fff;
            transition: .2s ease;
        }
        .mm-navbar .nav-link:not(.mm-nav-button):hover::after {
            width: calc(100% - 10px);
        }
        .mm-nav-button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 40px;
            padding: 0 20px !important;
            margin-left: 10px !important;
            border-radius: 4px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 15px !important;
            text-decoration: none;
            transition: all .2s ease;
        }
        .mm-login {
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, .8);
            background: transparent;
        }
        .mm-login:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .12);
            border-color: #fff;
        }
        .mm-register {
            color: #4f6945 !important;
            border: 1px solid #253b24;
            background: #253b24;
        }
        .mm-register:hover {
            color: #3d5637 !important;
            background: #304a2f;
            border-color: #304a2f;
        }
        .mm-hero {
            min-height: 590px;
            position: relative;
            background-image:
                linear-gradient(
                    90deg,
                    rgba(245, 244, 232, .94) 0%,
                    rgba(245, 244, 232, .78) 35%,
                    rgba(245, 244, 232, .30) 65%,
                    rgba(245, 244, 232, .04) 100%
                ),
                url('{{ asset('img/matchaaaaaaa.png') }}');

            background-size: cover;
            background-position: center;
        }
        .mm-hero-content {
            min-height: 590px;
            display: flex;
            align-items: center;
        }
        .mm-hero-inner {
            max-width: 570px;
            margin-left: 7%;
            padding: 60px 0;
        }
        .mm-hero-small {
            margin-bottom: 15px;
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 4px;
            color: #607157;
            text-transform: uppercase;
        }
        .mm-hero h1 {
            margin: 0;
            color: #344a31;
            font-size: clamp(50px, 6vw, 76px);
            font-weight: normal;
            line-height: .95;
            letter-spacing: 3px;
        }
        .mm-hero-tagline {
            margin-top: 14px;
            color: #52644d;
            font-size: 23px;
            letter-spacing: 2px;
        }
        .mm-hero-line {
            width: 48px;
            height: 1px;
            margin: 25px 0 20px;
            background: #687c5e;
        }
        .mm-hero p {
            max-width: 480px;
            margin-bottom: 25px;
            color: #52604d;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.8;
        }
        .mm-hero-button {
            display: inline-flex;
            align-items: center;
            gap: 13px;
            padding: 11px 24px;
            border: 1px solid #68815d;
            border-radius: 4px;
            background: #68815d;
            color: #fff;
            font-family: Arial, sans-serif;
            font-size: 13px;
            transition: .2s ease;
        }
        .mm-hero-button:hover {
            background: #4f6945;
            border-color: #4f6945;
            color: #fff;
        }
        .mm-section {
            position: relative;
            padding: 85px 0;
            overflow: hidden;
        }
        .mm-section-title-small {
            margin-bottom: 10px;
            color: #6b7c62;
            font-family: Arial, sans-serif;
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .mm-section-title {
            margin: 0;
            color: #3b5137;
            font-size: 37px;
            font-weight: normal;
            line-height: 1.2;
        }
        .mm-title-line {
            width: 45px;
            height: 1px;
            margin: 20px 0;
            background: #708463;
        }

        .mm-about {
            background: var(--cream);
        }
        .mm-about-text {
            padding-left: 8%;
        }
        .mm-about-text p {
            max-width: 430px;
            margin-bottom: 0;
            color: #596452;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.9;
        }

        .mm-accordion {
            margin-top: 10px;
        }
        .mm-accordion .accordion-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--line);
            border-radius: 0;
        }

        .mm-accordion .accordion-item:first-child {
            border-top: 1px solid var(--line);
        }
        .mm-accordion .accordion-button {
            padding: 18px 5px;
            background: transparent;
            color: #4d6048;
            box-shadow: none !important;
            font-size: 15px;
            font-weight: normal;
        }
        .mm-accordion .accordion-button:not(.collapsed) {
            background: transparent;
            color: #344b30;
        }
        .mm-accordion .accordion-button::after {
            background-size: 12px;
        }
        .mm-accordion .accordion-body {
            padding: 0 5px 20px;
            color: #697267;
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.8;
        }
        .mm-collection {
            background: var(--sage); 
            padding-top: 85px; 
            padding-bottom: 90px;
        } 
        .mm-collection-heading {
            margin-bottom: 40px; 
            text-align: center;
        } 
        .mm-collection-heading .mm-section-title-small {
            color: #53664d;
        } 
        .mm-collection-heading .mm-section-title {
            color: #354b32;
        } 
        .mm-collection-heading .mm-title-line {
            margin: 18px auto;
        } 
        .mm-collection-description {
            margin: 0; 
            color: #596953;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .mm-carousel {
            position: relative;
            max-width: 1120px;
            margin: auto;
        }
        .mm-carousel .carousel-item {
            padding: 0;
        }
        .mm-collection-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        .mm-collection-item {
            position: relative;
            height: 300px;
            overflow: hidden;
            background: #879b78;
            border-radius: 3px;
        }
        .mm-collection-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .45s ease;
        }
        .mm-collection-item:hover img {
            transform: scale(1.035);
        }

        .mm-collection-overlay {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 65px 20px 20px;
            background:
                linear-gradient(
                    transparent,
                    rgba(35, 52, 32, .80)
                );
        }
        .mm-collection-overlay h3 {
            margin: 0;
            color: #fff;
            font-size: 19px;
            font-weight: normal;
        }
        .mm-collection-overlay span {
            display: inline-block;
            margin-top: 7px;
            color: #edf1e7;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .mm-carousel-control {
            position: absolute;
            top: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            border: none;
            border-radius: 4px;
            background: rgba(246, 245, 233, .9);
            color: #4f6945;
            z-index: 5;
            transition: .2s ease;
        }
        .mm-carousel-control:hover {
            background: #fff;
            color: #304a2f;
        }
        .mm-carousel-prev {
            left: -18px;
        }
        .mm-carousel-next {
            right: -18px;
        }

        .mm-carousel .carousel-indicators {
            bottom: -35px;
            margin-bottom: 0;
        }
        .mm-carousel .carousel-indicators button {
            width: 8px;
            height: 8px;
            margin: 0 4px;
            border: none;
            border-radius: 50%;
            background: #63775b;
        }
        .mm-carousel .carousel-indicators .active {
            background: #f4f3e8;
        }

        .mm-best {
            background: var(--cream);
        }
        .mm-best-image {
            display: block;
            width: 100%;
            height: 390px;
            object-fit: cover;
            border-radius: 3px;
        }
        .mm-best-content {
            padding: 30px 8% 30px 12%;
        }
        .mm-best-content p {
            max-width: 430px;
            color: #626b5e;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.9;
        }
        .mm-product-button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
            padding: 10px 21px;
            border: 1px solid #b4c4a8;
            border-radius: 4px;
            background: #c8d3bb;
            color: #42553c;
            font-family: Arial, sans-serif;
            font-size: 12px;
            transition: .2s ease;
        }
        .mm-product-button:hover {
            background: #afbea0;
            border-color: #9eaf91;
            color: #34482f;
        }

        .mm-testimonials {
            background:
                linear-gradient(
                    rgba(38, 61, 36, .93),
                    rgba(38, 61, 36, .93)
                ),
                url('{{ asset('img/matchapow.jpg') }}');

            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .mm-testimonial-heading {
            margin-bottom: 50px;
            text-align: center;
        }
        .mm-testimonial-heading .mm-section-title-small {
            color: #c8d4c1;
        }
        .mm-testimonial-heading .mm-section-title {
            color: #fff;
        }
        .mm-testimonial-heading .mm-title-line {
            margin: 18px auto;
            background: #c4d1bc;
        }


        .mm-quote {
            min-height: 150px;
            padding: 0 35px;
            text-align: center;
        }
        .mm-quote + .mm-quote {
            border-left: 1px solid rgba(255,255,255,.30);
        }
        .mm-quote-icon {
            margin-bottom: 12px;
            color: #cbd8c4;
            font-size: 30px;
            line-height: 1;
        }
        .mm-quote p {
            margin-bottom: 15px;
            color: #f0f2ec;
            font-size: 15px;
            line-height: 1.8;
        }
        .mm-quote-author {
            color: #c2cebb;
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .mm-footer {
            padding: 35px 20px 28px;
            background: var(--cream);
            color: #74806e;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: .5px;
        }
        .mm-footer-leaf {
            margin-bottom: 8px;
            color: #718568;
            font-size: 15px;
        }
        .mm-footer strong {
            color: #506547;
            font-family: Georgia, "Times New Roman", serif;
            font-weight: normal;
        }


        
        @media (max-width: 992px) {

            .mm-navbar .container-fluid {
                padding-left: 25px;
                padding-right: 25px;
            }
            .mm-hero-inner {
                margin-left: 5%;
            }
            .mm-collection-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .mm-quote {
                padding: 0 20px;
            }

        }


        @media (max-width: 768px) {

            .mm-navbar {
                min-height: 65px;
            }
            .mm-navbar .container-fluid {
                padding-left: 20px;
                padding-right: 20px;
            }
            .mm-brand img {
                width: 36px;
                height: 36px;
            }
            .mm-brand-title {
                font-size: 18px;
                letter-spacing: 2px;
            }


            /* NAV MOBILE */

            .mm-navbar .nav-link {
                margin: 3px 0;
            }
            .mm-nav-button {
                width: 120px;
                height: 40px;
                margin: 5px 0 !important;
            }

            /* HERO */
            .mm-hero,
            .mm-hero-content {
                min-height: 560px;
            }
            .mm-hero {
                background-image:
                    linear-gradient(
                        rgba(245, 244, 232, .88),
                        rgba(245, 244, 232, .60)
                    ),
                    url('{{ asset('img/matchapow.jpg') }}');

                background-position: center;
            }
            .mm-hero-inner {
                max-width: 100%;
                margin-left: 0;
                padding: 40px 25px;
                text-align: center;
            }
            .mm-hero-line {
                margin: 20px auto;
            }
            .mm-hero p {
                margin-right: auto;
                margin-left: auto;
            }


            /* SECTION */
            .mm-section {
                padding: 70px 20px;
            }

            /* ABOUT */
            .mm-about-text {
                padding-left: 0;
                margin-bottom: 35px;
            }
            .mm-section-title {
                font-size: 31px;
            }


            /* COLLECTION */
            .mm-collection-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 5px;
            }
            .mm-collection-item {
                height: 220px;
            }
            .mm-carousel-prev {
                left: -5px;
            }
            .mm-carousel-next {
                right: -5px;
            }


            /* BEST */
            .mm-best-image {
                height: 300px;
            }
            .mm-best-content {
                padding: 35px 10px 0;
            }


            /* TESTIMONIAL */
            .mm-quote {
                padding: 25px 10px;
            }
            .mm-quote + .mm-quote {
                border-top: 1px solid rgba(255,255,255,.30);
                border-left: none;
            }

        }


        @media (max-width: 480px) {

            .mm-navbar .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
            .mm-brand img {
                width: 34px;
                height: 34px;
            }
            .mm-brand-title {
                font-size: 16px;
                letter-spacing: 1.8px;
            }
            .mm-nav-button {
                width: 110px;
                height: 38px;
                font-size: 14px !important;
            }
            .mm-collection-grid {
                grid-template-columns: 1fr;
            }
            .mm-collection-item {
                height: 250px;
            }
            .mm-hero h1 {
                font-size: 45px;
            }
            .mm-hero-tagline {
                font-size: 19px;
            }

        }

    </style>

</head>


<body>
<nav class="navbar navbar-expand-lg navbar-dark mm-navbar">
    <div class="container-fluid">
        {{-- BRAND --}}
        <a class="mm-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">

            <span class="mm-brand-title">
                MATCHA MORI
            </span>
        </a>


        {{-- MOBILE TOGGLE --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#matchaNavbar" aria-controls="matchaNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        {{-- NAVIGATION --}}
        <div class="collapse navbar-collapse" id="matchaNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="#home">
                        Home
                    </a> 
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about" >
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#collection">
                        Collection
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#best">
                        Best of Matcha
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#testimonial">
                        Testimonial
                    </a> 
                </li>

                <li class="nav-item">
                    <a class="nav-link mm-nav-button mm-login" href="{{ route('login') }}">
                        Login
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link mm-nav-button mm-register" href="{{ route('register') }}">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<section id="home" class="mm-hero">
    <div class="container-fluid mm-hero-content">
        <div class="mm-hero-inner">
            <div class="mm-hero-small">
                Japanese Matcha & Tea Store
            </div>

            <h1>
                MATCHA MORI
            </h1>

            <div class="mm-hero-tagline">
                your little moment of calm.
            </div>

            <div class="mm-hero-line"></div>

            <p>
                Discover matcha drinks, desserts, matcha powder,
                and accessories inspired by the simplicity and
                warmth of Japanese tea culture.
            </p>

            <a href="{{ route('login') }}" class="mm-hero-button">
                Start Shopping
            </a>
        </div>
    </div>
</section>

<section id="about" class="mm-section mm-about">
    <div class="container">
        <div class="row align-items-center">

            {{-- LEFT --}}
            <div class="col-lg-5">
                <div class="mm-about-text">
                    <div class="mm-section-title-small">
                        Why Matcha Mori?
                    </div>
                    <h2 class="mm-section-title">
                        Why Matcha Mori?
                    </h2>
                    <div class="mm-title-line"></div>
                    <p>
                        Lebih dari sekadar minuman, Matcha Mori
                        adalah pengalaman sederhana untuk menikmati
                        hal-hal baik dalam hidup.
                    </p>
                </div>
            </div>


            {{-- RIGHT --}}
            <div class="col-lg-6 offset-lg-1">
                <div class="accordion mm-accordion" id="matchaAccordion">

                    {{-- ITEM 1 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#matchaOne" aria-expanded="true">
                                Matcha Quality
                            </button>
                        </h2>

                        <div id="matchaOne" class="accordion-collapse collapse show" data-bs-parent="#matchaAccordion">
                            <div class="accordion-body">
                                Matcha Mori menghadirkan pilihan
                                produk matcha yang terinspirasi
                                dari karakter dan budaya teh Jepang.
                            </div>
                        </div>
                    </div>


                    {{-- ITEM 2 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaTwo">
                                Matcha Drinks
                            </button>
                        </h2>

                        <div id="matchaTwo" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                            <div class="accordion-body">
                                Nikmati berbagai pilihan minuman
                                matcha yang cocok untuk menemani
                                waktu santai sehari-hari.
                            </div>
                        </div>
                    </div>


                    {{-- ITEM 3 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaThree">
                                Matcha Desserts
                            </button>
                        </h2>

                        <div id="matchaThree" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                            <div class="accordion-body">
                                Temukan dessert dengan perpaduan
                                rasa manis dan karakter khas matcha.
                            </div>
                        </div>
                    </div>


                    {{-- ITEM 4 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaFour">
                                Japanese Tea Experience
                            </button>
                        </h2>

                        <div id="matchaFour" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                            <div class="accordion-body">
                                Lengkapi pengalaman minum matcha
                                dengan powder dan accessories
                                untuk ritual teh sederhana di rumah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="collection" class="mm-section mm-collection">
    <div class="container">
        <div class="mm-collection-heading">
            <div class="mm-section-title-small">
                Our Matcha Collection
            </div>
            <h2 class="mm-section-title">
                Temukan Favoritmu
            </h2>
            <div class="mm-title-line"></div>
            <p class="mm-collection-description">
                Empat kategori pilihan untuk menemani setiap
                momen matchamu.
            </p>
        </div>

        <div id="matchaCarousel" class="carousel slide mm-carousel" data-bs-ride="carousel">

            {{-- INDICATORS --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>

                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="1"></button>
            </div>

            <div class="carousel-inner">

                {{-- SLIDE 1 --}}
                <div class="carousel-item active">
                    <div class="mm-collection-grid">
                        {{-- MATCHA DRINK --}}
                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-drink.jpg') }}" alt="Matcha Drink">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Drink
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        {{-- MATCHA DESSERT --}}
                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-dessert.jpg') }}" alt="Matcha Dessert">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Dessert
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        {{-- MATCHA POWDER --}}
                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-powder.jpg') }}" alt="Matcha Powder">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Powder
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        {{-- ACCESSORIES --}}
                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/accessories.jpg') }}" alt="Accessories">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Accessories
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- SLIDE 2 --}}
                <div class="carousel-item">
                    <div class="mm-collection-grid">
                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-powder.jpg') }}" alt="Matcha Powder">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Powder
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/accessories.jpg') }}" alt="Accessories">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Accessories
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-drink.jpg') }}" alt="Matcha Drink">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Drink
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>

                        <a href="{{ route('login') }}" class="mm-collection-item">
                            <img src="{{ asset('img/categories/matcha-dessert.jpg') }}" alt="Matcha Dessert">
                            <div class="mm-collection-overlay">
                                <h3>
                                    Matcha Dessert
                                </h3>

                                <span>
                                    Explore collection →
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


            {{-- PREVIOUS --}}
            <button class="mm-carousel-control mm-carousel-prev" type="button" data-bs-target="#matchaCarousel" data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </button>

            {{-- NEXT --}}
            <button class="mm-carousel-control mm-carousel-next" type="button" data-bs-target="#matchaCarousel" data-bs-slide="next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>


<section id="best" class="mm-section mm-best">
    <div class="container">
        <div class="row align-items-center g-0">

            {{-- IMAGE --}}
            <div class="col-lg-6">
                <img src="{{ asset('img/matchapow.jpg') }}" alt="Matcha Powder" class="mm-best-image">
            </div>

            {{-- CONTENT --}}
            <div class="col-lg-6">
                <div class="mm-best-content">
                    <div class="mm-section-title-small">
                        Best of Matcha
                    </div>
                    <h2 class="mm-section-title">
                        Matcha Powder
                    </h2>
                    <div class="mm-title-line"></div>
                    <p>
                        Pilihan sederhana untuk menciptakan
                        minuman matcha dan momen teh versimu
                        sendiri di rumah.
                    </p>
                    <p>
                        Rasakan cita rasa khas matcha dalam
                        setiap tegukan.
                    </p>
                    <a href="{{ route('login') }}" class="mm-product-button">
                        View product
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="testimonial" class="mm-section mm-testimonials">
    <div class="container">
        <div class="mm-testimonial-heading">
            <div class="mm-section-title-small">
                What People Think About Matcha
            </div>
            <h2 class="mm-section-title">
                Kata Mereka Tentang Matcha
            </h2>
            <div class="mm-title-line"></div>
        </div>

        <div class="row g-0">

            {{-- TESTIMONIAL 1 --}}
            <div class="col-lg-4">
                <div class="mm-quote">
                    <div class="mm-quote-icon">
                        “
                    </div>
                    <p>
                        Secangkir matcha bisa membuat
                        hari biasa terasa sedikit lebih tenang.
                    </p>

                    <div class="mm-quote-author">
                        — Matcha Mori Customer
                    </div>
                </div>
            </div>

            {{-- TESTIMONIAL 2 --}}
            <div class="col-lg-4">
                <div class="mm-quote">
                    <div class="mm-quote-icon">
                        “
                    </div>
                    <p>
                        Perpaduan minuman matcha dan
                        dessert-nya benar-benar menyenangkan.
                    </p>
                    <div class="mm-quote-author">
                        — Matcha Mori Customer
                    </div>
                </div>
            </div>

            {{-- TESTIMONIAL 3 --}}
            <div class="col-lg-4">
                <div class="mm-quote">
                    <div class="mm-quote-icon">
                        “
                    </div>
                    <p>
                        Matcha Mori menghadirkan sensasi
                        ritual teh Jepang yang sederhana
                        dalam kehidupan sehari-hari.
                    </p>
                    <div class="mm-quote-author">
                        — Matcha Mori Customer
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<footer class="mm-footer">
    Copyright &copy;
    <strong>
        Matcha Mori
    </strong>
    {{ date('Y') }}
</footer>

{{-- Bootstrap JS --}}
<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>