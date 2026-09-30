<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #172016;
            background: #fff;
        }

        .mm-navbar {
            background: #6ba056;
            min-height: 74px;
        }

        .mm-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff !important;
            text-decoration: none;
        }

        .mm-brand img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .mm-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .mm-brand-text strong {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 21px;
            font-weight: normal;
            letter-spacing: 1.5px;
        }

        .mm-brand-text span {
            margin-top: 5px;
            color: #eaf5e5;
            font-size: 8px;
            letter-spacing: 2px;
        }

        .mm-navbar .nav-link {
            color: rgba(255,255,255,.9) !important;
            margin-left: 8px;
        }

        .mm-navbar .nav-link:hover,
        .mm-navbar .nav-link.active {
            color: #fff !important;
        }

        .mm-login,
        .mm-register {
            border-radius: 5px;
            padding: 8px 17px !important;
            border: 1px solid rgba(255,255,255,.65);
            margin-left: 10px !important;
        }

        .mm-login:hover,
        .mm-register:hover {
            background: rgba(255,255,255,.14);
        }

        .mm-hero {
            height: 80vh;
            min-height: 520px;
            position: relative;
            background:
                linear-gradient(rgba(32,52,29,.48), rgba(32,52,29,.48)),
                url('{{ asset('img/matchapow.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .mm-hero-content {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .mm-hero-inner {
            width: min(850px, 90%);
            text-align: center;
        }

        .mm-hero-small {
            font-size: 14px;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 18px;
            color: #e7f3df;
        }

        .mm-hero h1 {
            margin: 0;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(48px, 7vw, 78px);
            font-weight: normal;
            letter-spacing: 2px;
        }

        .mm-hero h1 span {
            display: block;
            margin-top: 8px;
            font-family: Arial, sans-serif;
            font-size: clamp(15px, 2vw, 22px);
            letter-spacing: 5px;
        }

        .mm-hero p {
            max-width: 720px;
            margin: 25px auto 0;
            font-size: 16px;
            line-height: 1.8;
        }

        .mm-hero-button {
            display: inline-block;
            margin-top: 25px;
            padding: 11px 27px;
            border: 1px solid #fff;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            transition: .2s ease;
        }

        .mm-hero-button:hover {
            background: #fff;
            color: #4f7942;
        }

        .mm-section {
            padding: 70px 0;
        }

        .mm-section-title {
            margin-bottom: 45px;
            text-align: center;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 32px;
            font-weight: normal;
            color: #315b25;
        }

        .mm-accordion {
            max-width: 780px;
            margin: auto;
        }

        .mm-accordion .accordion-button {
            color: #315b25;
            background: #fff;
            box-shadow: none;
        }

        .mm-accordion .accordion-button:not(.collapsed) {
            color: #315b25;
            background: #dff0d7;
            box-shadow: none;
        }

        .mm-accordion .accordion-item {
            border-color: #d5e6ce;
        }

        .mm-accordion .accordion-body {
            line-height: 1.7;
            color: #555;
        }

        .mm-green-section {
            background: #6ba056;
            color: #fff;
        }

        .mm-green-section .mm-section-title {
            color: #fff;
        }

        .mm-carousel {
            max-width: 850px;
            margin: auto;
        }

        .mm-carousel img {
            width: 100%;
            height: 470px;
            object-fit: cover;
        }

        .mm-carousel .carousel-caption {
            left: 0;
            right: 0;
            bottom: 0;
            padding: 60px 35px 28px;
            background: linear-gradient(transparent, rgba(0,0,0,.72));
        }

        .mm-product-image {
            max-width: 650px;
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
            border: 5px solid #fff;
            box-shadow: 0 3px 12px rgba(0,0,0,.14);
        }

        .mm-product-text {
            max-width: 700px;
            margin: 28px auto 0;
            text-align: center;
        }

        .mm-product-text h3 {
            font-family: Georgia, 'Times New Roman', serif;
            color: #315b25;
            font-weight: normal;
        }

        .mm-testimonials {
            background: #202529;
            color: #fff;
        }

        .mm-testimonials .mm-section-title {
            color: #fff;
        }

        .mm-quote {
            max-width: 800px;
            margin: 0 auto 35px;
        }

        .mm-quote p {
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .mm-quote footer {
            color: #aab4aa;
            font-size: 14px;
        }

        .mm-footer {
            padding: 25px 20px;
            text-align: center;
            background: #fff;
            color: #6d786a;
            border-top: 1px solid #dff0d7;
            font-size: 13px;
        }

        .mm-footer strong {
            color: #4f7942;
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: normal;
        }

        @media (max-width: 768px) {
            .mm-brand-text strong { font-size: 18px; }
            .mm-brand-text span { font-size: 6px; letter-spacing: 1.5px; }
            .mm-carousel img { height: 330px; }
            .mm-hero { min-height: 500px; }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark mm-navbar">
    <div class="container-fluid px-4 px-lg-5">
        <a class="mm-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/leaf.png') }}" alt="Matcha Mori">
            <div class="mm-brand-text">
                <strong>MATCHA MORI</strong>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#matchaNavbar" aria-controls="matchaNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="matchaNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link mm-login" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mm-register" href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="mm-hero">
    <div class="container-fluid mm-hero-content">
        <div class="mm-hero-inner">
            <div class="mm-hero-small">Japanese Matcha &amp; Tea Store</div>
            <h1>
                MATCHA MORI
                <span>your little moment of calm.</span>
            </h1>
            <p>
                Discover matcha drinks, desserts, matcha powder, and accessories
                inspired by the simplicity and warmth of Japanese tea culture.
            </p>
            <a href="{{ route('login') }}" class="mm-hero-button">Start Shopping</a>
        </div>
    </div>
</section>

<section id="about" class="mm-section">
    <div class="container">
        <h2 class="mm-section-title">Why Matcha Mori?</h2>

        <div class="accordion mm-accordion" id="matchaAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#matchaOne" aria-expanded="true">
                        Matcha Quality
                    </button>
                </h2>
                <div id="matchaOne" class="accordion-collapse collapse show" data-bs-parent="#matchaAccordion">
                    <div class="accordion-body">
                        Matcha Mori brings together matcha-inspired products for customers who enjoy
                        the distinctive taste and calm atmosphere associated with Japanese tea culture.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaTwo">
                        Matcha Drinks
                    </button>
                </h2>
                <div id="matchaTwo" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                    <div class="accordion-body">
                        Explore refreshing matcha drink choices made for a simple and enjoyable tea moment.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaThree">
                        Matcha Desserts
                    </button>
                </h2>
                <div id="matchaThree" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                    <div class="accordion-body">
                        Enjoy sweet treats that combine dessert flavors with the characteristic taste of matcha.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#matchaFour">
                        Japanese Tea Experience
                    </button>
                </h2>
                <div id="matchaFour" class="accordion-collapse collapse" data-bs-parent="#matchaAccordion">
                    <div class="accordion-body">
                        Matcha Mori also provides matcha powder and accessories for creating your own tea ritual at home.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="collection" class="mm-section mm-green-section">
    <div class="container">
        <h2 class="mm-section-title">Our Matcha Collection</h2>

        <div id="matchaCarousel" class="carousel slide mm-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#matchaCarousel" data-bs-slide-to="3"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/categories/matcha-drink.jpg') }}" alt="Matcha Drink">
                    <div class="carousel-caption">
                        <h5>Matcha Drink</h5>
                        <p>Fresh and refreshing matcha-inspired drinks.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('img/categories/matcha-dessert.jpg') }}" alt="Matcha Dessert">
                    <div class="carousel-caption">
                        <h5>Matcha Dessert</h5>
                        <p>Sweet treats with a gentle matcha touch.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('img/categories/matcha-powder.jpg') }}" alt="Matcha Powder">
                    <div class="carousel-caption">
                        <h5>Matcha Powder</h5>
                        <p>Matcha powder for your own tea moments.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('img/categories/accessories.jpg') }}" alt="Accessories">
                    <div class="carousel-caption">
                        <h5>Accessories</h5>
                        <p>Matcha accessories for your daily tea ritual.</p>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#matchaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#matchaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="mm-section">
    <div class="container">
        <h2 class="mm-section-title">Best of Matcha</h2>

        <img src="{{ asset('img/matchapow.jpg') }}" class="mm-product-image" alt="Matcha Powder">

        <div class="mm-product-text">
            <h3>Matcha Powder</h3>
            <p>
                A simple choice for creating your own matcha drinks and tea moments at home.
            </p>
        </div>
    </div>
</section>

<section class="mm-section mm-testimonials">
    <div class="container">
        <h2 class="mm-section-title">What People Think About Matcha</h2>

        <figure class="mm-quote text-center text-md-start">
            <blockquote>
                <p>“A gentle matcha moment can make an ordinary day feel a little calmer.”</p>
            </blockquote>
            <figcaption class="mm-quote footer">— Matcha Mori Customer</figcaption>
        </figure>

        <figure class="mm-quote text-center text-md-end">
            <blockquote>
                <p>“The combination of matcha drinks and sweet treats makes the experience enjoyable.”</p>
            </blockquote>
            <figcaption class="mm-quote footer">— Matcha Mori Customer</figcaption>
        </figure>

        <figure class="mm-quote text-center text-md-start">
            <blockquote>
                <p>“Matcha Mori brings the feeling of a simple Japanese tea ritual into everyday life.”</p>
            </blockquote>
            <figcaption class="mm-quote footer">— Matcha Mori Customer</figcaption>
        </figure>
    </div>
</section>

<footer class="mm-footer">
    Copyright &copy; <strong>Matcha Mori</strong> {{ date('Y') }}
</footer>

<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
