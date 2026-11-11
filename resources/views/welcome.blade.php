<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link href="{{ asset('css/customer-layout.css') }}?v={{ time() }}" rel="stylesheet">    
    <link href="{{ asset('css/customer-product.css') }}?v={{ time() }}" rel="stylesheet">   

</head>

<body>

    {{-- NAVBAR --}}
    <nav class="mm-navbar">
        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        {{-- Menu --}}
        <div class="mm-nav-links">
            <a href="{{ route('welcome') }}" class="active">
                Home
            </a>

            <a href="{{ route('about') }}">
                About Us
            </a>

            <a href="{{ route('products.index') }}">
                Menu
            </a>
        </div>

        {{-- Search + Login + Register --}}
        <div class="mm-nav-right">
            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">

                <button type="submit" class="mm-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-btn login-btn">
                    Login
                </a>

                <a href="{{ route('register') }}" class="auth-btn register-btn">
                    Register
                </a>
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

                <a href="{{ route('products.index') }}" class="mm-hero-button">
                    Start Shopping
                </a>
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
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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
                        
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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
                            
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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
                            
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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
                            
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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

                            
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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

                            
                            <a href="{{ route('products.index') }}" class="mm-collection-item">
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

    <section id="best-seller" class="mm-section mm-best">
        <div class="container">

            {{-- HEADING --}}
            <div class="mm-testimonial-heading">
                <div class="mm-section-title-small">
                    Best of Matcha
                </div>

                <h2 class="mm-section-title">
                    Most Loved Products
                </h2>

                <div class="mm-title-line"></div>

                <p>
                    Empat produk matcha yang paling banyak terjual
                    dan menjadi favorit pelanggan Matcha Mori.
                </p>
            </div>


            {{-- BEST SELLING PRODUCTS --}}
            <div class="row g-4 mt-4">

                @forelse($bestProducts as $product)

                    <div class="col-lg-3 col-md-6">
                        <div class="mm-best-card">

                            {{-- IMAGE --}}
                            <div class="mm-best-card-image">
                                <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>

                            {{-- CONTENT --}}
                            <div class="mm-best-card-content">
                                <div class="mm-best-category">
                                    {{ $product->category->name ?? 'Matcha' }}
                                </div>

                                <h3>
                                    {{ $product->name }}
                                </h3>

                                <p>
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <div class="mm-best-sold">
                                    {{ $product->total_sold }} sold
                                </div>

                                <button type="button" class="mm-best-button" data-bs-toggle="modal" data-bs-target="#welcomeProductModal{{ $product->id }}">
                                    View Product
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        {{-- PRODUCT DETAIL MODAL --}}
                        <div class="modal fade product-modal" id="welcomeProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="welcomeProductLabel{{ $product->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <button type="button" class="product-modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        &times;
                                    </button>

                                    <div class="product-modal-body">

                                        {{-- PRODUCT IMAGE --}}
                                        <div class="product-modal-image">

                                            @if($product->image)
                                                <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <i class="fas fa-leaf"></i>
                                            @endif

                                            {{-- QUANTITY --}}
                                            @if($product->stock > 0)
                                                <div class="modal-quantity-box">
                                                    <button type="button" class="quantity-btn" data-product-id="{{ $product->id }}" data-stock="{{ $product->stock }}" data-change="-1">
                                                        −
                                                    </button>

                                                    <input type="text" id="modal-quantity-{{ $product->id }}" value="1" readonly>

                                                    <button type="button" class="quantity-btn" data-product-id="{{ $product->id }}" data-stock="{{ $product->stock }}" data-change="1">
                                                        +
                                                    </button>
                                                </div>
                                            @endif

                                        </div>

                                        {{-- PRODUCT INFORMATION --}}
                                        <div class="product-modal-info">
                                            <div class="product-modal-category">
                                                {{ $product->category->name ?? 'Matcha' }}
                                            </div>

                                            <h2 id="welcomeProductLabel{{ $product->id }}">
                                                {{ $product->name }}
                                            </h2>

                                            <div class="product-modal-price">
                                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                                            </div>

                                            @if($product->stock > 0)
                                                <div class="product-modal-stock">
                                                    Stock {{ $product->stock }}
                                                </div>
                                            @else
                                                <div class="product-modal-sold">
                                                    Sold Out
                                                </div>
                                            @endif

                                            <p class="product-modal-description">
                                                {{ $product->description ?? 'Nikmati pilihan produk Matcha Mori.' }}
                                            </p>

                                            {{-- CUSTOMER REVIEWS --}}
                                            <div class="product-modal-reviews">

                                                @php
                                                    $reviews = $product->reviews;
                                                    $reviewCount = $reviews->count();
                                                    $averageRating = $reviews->avg('rating') ?? 0;
                                                @endphp

                                                <h3>Ulasan Customer</h3>

                                                <div class="product-modal-review-summary">

                                                    <strong>
                                                        {{ number_format($averageRating, 1, ',', '.') }}
                                                    </strong>

                                                    <span class="product-modal-review-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= round($averageRating))
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>

                                                    <span>{{ $reviewCount }} ulasan</span>

                                                </div>

                                                @forelse($reviews->sortByDesc('created_at')->take(3) as $review)

                                                    <div class="product-modal-review-item">

                                                        <div class="product-modal-review-user">

                                                            <strong>
                                                                {{ $review->user->name ?? 'Customer' }}
                                                            </strong>

                                                            <span class="product-modal-review-stars">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= $review->rating)
                                                                        <i class="fas fa-star"></i>
                                                                    @else
                                                                        <i class="far fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </span>

                                                        </div>

                                                        @if($review->comment)
                                                            <p>{{ $review->comment }}</p>
                                                        @endif

                                                        <small>
                                                            {{ $review->created_at->format('d M Y') }}
                                                        </small>

                                                    </div>

                                                @empty

                                                    <p class="product-modal-review-empty">
                                                        Belum ada ulasan untuk produk ini.
                                                    </p>

                                                @endforelse

                                            </div>

                                            {{-- ADD TO CART / LOGIN TO ORDER --}}
                                            @if(Auth::check() && $product->stock > 0)

                                                <form action="{{ route('customer.cart.store') }}" method="POST">

                                                    @csrf

                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" id="cart-quantity-{{ $product->id }}" value="1">
                                                    <button type="submit" class="modal-add-cart">
                                                        Add to Cart
                                                    </button>
                                                </form>

                                            @elseif(!Auth::check() && $product->stock > 0)

                                                <a href="{{ route('login') }}" class="modal-add-cart">
                                                    Login to Order
                                                </a>

                                            @else

                                                <button type="button" class="modal-add-cart modal-disabled" disabled>
                                                    Sold Out
                                                </button>

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="col-12 text-center">
                        <p>
                            Belum ada produk terlaris.
                        </p>
                    </div>

                @endforelse

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

@include('layouts.inc.footer')

{{-- Bootstrap JS --}}
<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (event) {

        const button = event.target.closest('.quantity-btn');

        if (!button) return;

        const productId = button.dataset.productId;
        const stock = parseInt(button.dataset.stock);
        const change = parseInt(button.dataset.change);

        const quantityInput = document.getElementById(
            'modal-quantity-' + productId
        );

        const cartQuantity = document.getElementById(
            'cart-quantity-' + productId
        );

        if (!quantityInput) return;

        let quantity = parseInt(quantityInput.value) || 1;

        quantity += change;

        quantity = Math.max(1, Math.min(quantity, stock));

        quantityInput.value = quantity;

        if (cartQuantity) {
            cartQuantity.value = quantity;
        }
        

    });

});
</script>
</body>
</html>