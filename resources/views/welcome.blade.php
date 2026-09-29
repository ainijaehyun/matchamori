<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Matcha Mori</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Georgia, 'Times New Roman', serif;
            background: #f4f9f0;
            color: #24351f;
        }


        /* =========================
        NAVBAR
        ========================= */

        .welcome-navbar {
            width: 100%;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 65px;
            background: #ffffff;
            border-bottom: 1px solid #dcebd4;
            position: relative;
            z-index: 10;
        }

        .welcome-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #4f7942;
            text-decoration: none;
        }

        /* LOGO FOTO */
        .welcome-logo-image {
            width: 36px;
            height: 36px;
            object-fit: contain;
            display: block;
        }

        .welcome-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .welcome-logo-text strong {
            font-size: 21px;
            letter-spacing: 1.5px;
            font-weight: normal;
            color: #4f7942;
        }

        .welcome-logo-text span {
            margin-top: 5px;
            font-family: Arial, sans-serif;
            font-size: 8px;
            letter-spacing: 1.8px;
            color: #8a9d83;
        }

        .welcome-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-login,
        .nav-register {
            min-width: 95px;
            padding: 9px 20px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-family: Georgia, serif;
            font-size: 14px;
            transition: .2s ease;
        }

        .nav-login {
            color: #4f7942;
            border: 1px solid #b8d8aa;
            background: #ffffff;
        }

        .nav-login:hover {
            background: #eef7e9;
            color: #4f7942;
        }

        .nav-register {
            color: #315b25;
            border: 1px solid #b8dfa5;
            background: #b8dfa5;
            box-shadow: 0 3px 6px rgba(70, 110, 55, .10);
        }

        .nav-register:hover {
            background: #a8d294;
            border-color: #a8d294;
            color: #315b25;
            transform: translateY(-1px);
        }


        /* =========================
        HERO
        ========================= */

        .welcome-hero {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            padding: 55px 70px 65px;

            background:
                linear-gradient(
                    135deg,
                    #f8fbf5 0%,
                    #eef7e8 50%,
                    #dff0d7 100%
                );

            position: relative;
            overflow: hidden;
        }

        .hero-content {
            width: 50%;
            max-width: 600px;
            padding-left: 30px;
            position: relative;
            z-index: 2;
        }

        .hero-small-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #6f9563;
            font-family: Arial, sans-serif;
            font-size: 13px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .hero-small-title::before {
            content: '';
            width: 35px;
            height: 1px;
            background: #a8c99a;
        }

        .hero-content h1 {
            font-size: clamp(50px, 6vw, 78px);
            line-height: .95;
            font-weight: normal;
            color: #4f7942;
            letter-spacing: 1px;
        }

        .hero-content h1 span {
            display: block;
            color: #45643b;
            font-size: .55em;
            letter-spacing: 4px;
            margin-top: 15px;
        }

        .hero-description {
            max-width: 460px;
            margin: 28px 0 32px;
            color: #687663;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .hero-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 155px;
            padding: 13px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            transition: .2s ease;
        }

        .hero-button-primary {
            background: #b8dfa5;
            color: #315b25;
            border: 1px solid #a8d294;
            box-shadow: 0 4px 8px rgba(70, 110, 55, .12);
        }

        .hero-button-primary:hover {
            background: #a8d294;
            border-color: #a8d294;
            color: #315b25;
            transform: translateY(-2px);
        }

        .hero-button-secondary {
            background: #ffffff;
            color: #4f7942;
            border: 1px solid #b8d8aa;
        }

        .hero-button-secondary:hover {
            background: #eef7e8;
            color: #4f7942;
        }


        /* =========================
        HERO IMAGE
        ========================= */

        .hero-image-wrapper {
            position: absolute;
            right: 0;
            top: 0;
            width: 52%;
            height: 100%;
            overflow: hidden;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .hero-image-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    #f4f9f0 0%,
                    rgba(244, 249, 240, .65) 10%,
                    rgba(244, 249, 240, 0) 35%
                );
        }


        /* =========================
        DECORATION
        ========================= */

        .leaf-decoration {
            position: absolute;
            color: rgba(95, 139, 76, .08);
            font-size: 145px;
            z-index: 1;
        }

        .leaf-one {
            right: 43%;
            bottom: 5%;
            transform: rotate(-25deg);
        }

        .leaf-two {
            right: 5%;
            top: 12%;
            font-size: 95px;
            transform: rotate(20deg);
        }


        /* =========================
        INFO
        ========================= */

        .welcome-info {
            width: 92%;
            max-width: 1250px;

            margin: -35px auto 70px;

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 16px;

            position: relative;
            z-index: 10;
        }

        .info-item {
            min-height: 165px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            text-align: center;

            padding: 18px 15px;

            background: #ffffff;

            border: 1px solid #b8dfa5;

            border-radius: 18px;

            box-shadow:
                0 4px 10px rgba(49, 91, 37, .10);

            transition: .25s ease;
        }
        .info-item:hover {
            transform: translateY(-4px);

            border-color: #8fbc7d;

            box-shadow:
                0 8px 18px rgba(49, 91, 37, .14);
        }

        .info-item:last-child {
            border-right: none;
        }

        .info-image {
            width: 82px;
            height: 82px;

            flex-shrink: 0;

            object-fit: cover;

            border-radius: 12px;

            background: #eef7e8;

            border: 3px solid #eef7e8;

            display: block;
            margin-bottom: 11px;
        }

        .info-item h3 {
            color: #4f7942;
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 7px;
        }

        .info-item p {
            color: #71806c;
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.5;
        }
        .welcome-footer {
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #dcebd4;
            background: #ffffff;
            color: #7c8978;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .welcome-footer strong {
            color: #4f7942;
            font-family: Georgia, serif;
            font-weight: normal;
        }


        /* =========================
        RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .welcome-navbar {
                padding: 0 25px;
            }

            .welcome-hero {
                min-height: auto;
                padding: 70px 30px 300px;
            }

            .hero-content {
                width: 100%;
                max-width: 600px;
                padding-left: 0;
            }

            .hero-image-wrapper {
                top: auto;
                bottom: 0;
                width: 100%;
                height: 300px;
            }

            .hero-image-overlay {
                background:
                    linear-gradient(
                        180deg,
                        #f4f9f0 0%,
                        rgba(244, 249, 240, 0) 45%
                    );
            }

            .leaf-one {
                display: none;
            }

            .welcome-info {
                width: 90%;
                margin-top: -20px;
            }
        }


        @media (max-width: 650px) {

            .welcome-navbar {
                height: auto;
                min-height: 75px;
                padding: 15px 20px;
            }

            .welcome-logo-image {
                width: 32px;
                height: 32px;
            }

            .welcome-logo-text strong {
                font-size: 18px;
            }

            .welcome-logo-text span {
                font-size: 7px;
            }

            .welcome-nav {
                gap: 6px;
            }

            .nav-login,
            .nav-register {
                min-width: auto;
                padding: 8px 12px;
                font-size: 13px;
            }

            .welcome-hero {
                padding: 55px 25px 260px;
            }

            .hero-content h1 {
                font-size: 55px;
            }

            .hero-content h1 span {
                font-size: 13px;
                letter-spacing: 3px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-button {
                width: 100%;
            }

            .hero-image-wrapper {
                height: 260px;
            }

            .welcome-info {
                width: 90%;
                grid-template-columns: 1fr;
                margin-top: -15px;
            }

            .info-item {
                border-right: none;
                border-bottom: 1px solid #dcebd4;
            }

            .info-item:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>

<body>
    <nav class="welcome-navbar">

        <a href="{{ url('/') }}" class="welcome-logo">

            <img src="{{ asset('img/leaf.png') }}" alt="Matcha Mori Logo" class="welcome-logo-image">

            <div class="welcome-logo-text">
                <strong>MATCHA MORI</strong>
            </div>

        </a>

        <div class="welcome-nav">

            <a href="{{ route('login') }}" class="nav-login">
                Login
            </a>

            <a href="{{ route('register') }}" class="nav-register">
                Register
            </a>

        </div>

    </nav>


    <main>

        <section class="welcome-hero">

            <div class="hero-content">

                <div class="hero-small-title">
                    Japanese Matcha & Tea Store
                </div>

                <h1>
                    Matcha
                    <span>your little moment of calm.</span>
                </h1>

                <p class="hero-description">
                    Discover a collection of matcha drinks, desserts,
                    matcha powder, and accessories inspired by the
                    simplicity and warmth of Japanese tea culture.
                </p>

                <div class="hero-buttons">

                    <a href="{{ route('login') }}"
                       class="hero-button hero-button-primary">
                        <i class="fas fa-leaf" style="margin-right:8px;"></i>
                        Start Shopping
                    </a>

                    <a href="{{ route('register') }}"
                       class="hero-button hero-button-secondary">
                        Create Account
                    </a>

                </div>

            </div>


            

            <div class="hero-image-wrapper">

                <img
                    src="{{ asset('img/matchapow.jpg') }}"
                    alt="Matcha Mori"
                    class="hero-image"
                >

                <div class="hero-image-overlay"></div>

            </div>


            

            <i class="fas fa-leaf leaf-decoration leaf-one"></i>
            <i class="fas fa-leaf leaf-decoration leaf-two"></i>

        </section>



        <section class="welcome-info">

            <!-- MATCHA DRINK -->
            <div class="info-item">

                <img
                    src="{{ asset('img/categories/matcha-drink.jpg') }}"
                    alt="Matcha Drink"
                    class="info-image"
                >

                <div class="info-content">

                    <h3>
                        Matcha Drink
                    </h3>

                    <p>
                        Fresh and refreshing matcha-inspired drinks.
                    </p>

                    <div class="info-line"></div>

                </div>

            </div>


            <!-- MATCHA DESSERT -->
            <div class="info-item">

                <img
                    src="{{ asset('img/categories/matcha-dessert.jpg') }}"
                    alt="Matcha Dessert"
                    class="info-image"
                >

                <div class="info-content">

                    <h3>
                        Matcha Dessert
                    </h3>

                    <p>
                        Sweet treats with a gentle matcha touch.
                    </p>

                    <div class="info-line"></div>

                </div>

            </div>


            <!-- MATCHA POWDER -->
            <div class="info-item">

                <img
                    src="{{ asset('img/categories/matcha-powder.jpg') }}"
                    alt="Matcha Powder"
                    class="info-image"
                >

                <div class="info-content">

                    <h3>
                        Matcha Powder
                    </h3>

                    <p>
                        Matcha powder for your own tea moments.
                    </p>

                    <div class="info-line"></div>

                </div>

            </div>


            <!-- ACCESSORIES -->
            <div class="info-item">

                <img
                    src="{{ asset('img/categories/accessories.jpg') }}"
                    alt="Accessories"
                    class="info-image"
                >

                <div class="info-content">

                    <h3>
                        Accessories
                    </h3>

                    <p>
                        Matcha accessories for your daily tea ritual.
                    </p>

                    <div class="info-line"></div>

                </div>

            </div>

        </section>

    </main>
    

    <footer class="welcome-footer">
        <span>Copyright &copy; Matcha Mori {{ date('Y') }}</span>
    </footer>

</body>

</html>
