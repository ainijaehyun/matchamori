<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Our Products - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-product.css') }}?v={{ time() }}">
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="mm-navbar">

        <a href="{{ route('welcome') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        <div class="mm-nav-links">
            <a href="{{ route('welcome') }}">
                Home
            </a>

            <a href="{{ route('about') }}">
                About Us
            </a>

            <a href="{{ route('products.index') }}" class="active">
                Menu
            </a>
        </div>

        <div class="mm-nav-right">
            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search.." value="{{ request('search') }}">

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
                <div class="auth-links">
                    <a href="{{ route('login', ['redirect_to' => request()->getRequestUri()]) }}" class="auth-btn login-btn">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="auth-btn register-btn">
                        Register
                    </a>
                </div>

            @endif

        </div>
    </nav>


    <div class="product-detail-page">
        <div class="product-detail-container">
            <div class="product-detail-left">
                <div class="product-detail-image">

                    @if($product->image)
                        <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-leaf"></i>
                    @endif

                    <div class="quantity-box">

                        <button type="button" onclick="decreaseQuantity()">
                            −
                        </button>

                        <input type="text" id="quantity" name="quantity" value="1" readonly>

                        <button type="button" onclick="increaseQuantity()">
                            +
                        </button>

                    </div>
                </div>
            </div>

            <div class="product-detail-info">
                <h1 class="product-detail-name">
                    {{ $product->name }}
                </h1>

                <div class="product-detail-rating">

                    @php
                        $rating = $product->rating ?? 4.9;
                        $fullStars = floor($rating);
                    @endphp

                    @for($i = 1; $i <= 5; $i++)

                        @if($i <= $fullStars)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span>
                        {{ number_format($rating, 1, ',', '.') }}
                    </span>
                </div>

                <div class="product-detail-price">
                    Rp. {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="product-detail-stock">
                    Stock :
                    {{ $product->stock }}
                </div>

                <div class="product-detail-description">
                    {{ $product->description }}
                </div>

                <div class="product-detail-buttons">
                    <a href="{{ route('products.index') }}" class="back-button">
                        Back
                    </a>

                    @if(Auth::check() && Auth::user()->role === 'customer')

                        <form action="{{ route('customer.cart.store') }}" method="POST">

                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="cart-quantity" value="1">
                            <button type="submit" class="add-cart-button">
                                Add to Cart
                            </button>
                        </form>

                    @else

                        <a href="{{ url('/login') }}?redirect_to={{ urlencode(request()->getRequestUri()) }}" class="add-cart-button">
                            Login to Order
                        </a>

                    @endif

                </div>
            </div>
        </div>


        {{-- CUSTOMER REVIEWS --}}
        <section class="product-reviews">
            <div class="product-reviews-heading">
                <h2>Ulasan Customer</h2>

                <div class="product-reviews-summary">
                    <span class="product-reviews-average">
                        {{ number_format($averageRating, 1, ',', '.') }}
                    </span>

                    <span class="product-reviews-stars">
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
            </div>

            @forelse($reviews as $review)
                <article class="product-review-card">
                    <div class="product-review-top">
                        <strong>{{ $review->user->name ?? 'Customer' }}</strong>

                        <span class="product-review-stars">
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
                        <p class="product-review-comment">{{ $review->comment }}</p>
                    @endif

                    <small class="product-review-date">
                        {{ $review->created_at->format('d M Y') }}
                    </small>
                </article>
            @empty
                <p class="product-reviews-empty">
                    Belum ada ulasan untuk produk ini.
                </p>
            @endforelse

        </section>
    </div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Added to Cart!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#087a00',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection


@push('scripts')
    <script>

        function increaseQuantity() {

            const quantityInput = document.getElementById('quantity');
            const cartQuantity = document.getElementById('cart-quantity');

            let quantity = parseInt(quantityInput.value);

            const stock = {{ $product->stock }};

            if (quantity < stock) {

                quantity++;

                quantityInput.value = quantity;

                cartQuantity.value = quantity;

            }

        }


        function decreaseQuantity() {

            const quantityInput = document.getElementById('quantity');
            const cartQuantity = document.getElementById('cart-quantity');

            let quantity = parseInt(quantityInput.value);

            if (quantity > 1) {

                quantity--;

                quantityInput.value = quantity;

                cartQuantity.value = quantity;

            }

        }

    </script>
@endpush
</body>
</html>
