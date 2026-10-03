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
    <link rel="stylesheet"
        href="{{ asset('css/welcome.css') }}">

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