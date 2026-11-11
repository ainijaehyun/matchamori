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


    {{-- OUR PRODUCTS --}}
    <div class="product-page">

        @php
            $availableProducts = $products->where('stock', '>', 0);
            $soldOutProducts = $products->where('stock', '<=', 0);
        @endphp

        <div class="products-heading" id="product-list">
            <h1>Our Products</h1>
            <h2>Explore Our Matcha</h2>
            <p>
                Temukan berbagai pilihan produk matcha untuk menemani setiap momenmu.
            </p>
        </div>
    
        <div class="product-toolbar">
        {{-- FILTER DI KIRI --}}
        <form action="{{ route('products.index') }}" method="GET" class="filter-box">

            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <span>Filter</span>

            <select name="category_id" onchange="this.form.submit()">

                <option value="">All Category</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </form>

        {{-- SORT DI KANAN --}}
        <form action="{{ route('products.index') }}" method="GET" class="sort-box">

            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif

            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <span>Sort By</span>

            <select name="sort" onchange="this.form.submit()">
                <option value="latest"
                    {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                    Latest
                </option>

                <option value="price_low"
                    {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                    Price: Low to High
                </option>

                <option value="price_high"
                    {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                    Price: High to Low
                </option>

                <option value="name"
                    {{ request('sort') == 'name' ? 'selected' : '' }}>
                    Name: A-Z
                </option>

                <option value="sold_out"
                    {{ request('sort') == 'sold_out' ? 'selected' : '' }}>
                    Sold Out
                </option>
            </select>
        </form>
    </div>


    {{-- PRODUCT LIST --}}
    @if(request('sort') !== 'sold_out')

    <div class="customer-product-grid">

        @forelse($availableProducts as $product)

            <div class="customer-product-card">
                <a href="{{ route('products.show', $product->id) }}" class="customer-product-link">
                    <div class="customer-product-image">

                        @if($product->image)

                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="{{ $product->stock <= 0 ? 'sold-out-image' : '' }}">

                        @else

                            <i class="fas fa-leaf"></i>

                        @endif

                        @if ($product->stock <= 0)
                            <div class="sold-out-label">
                                SOLD OUT
                            </div>
                        @endif

                    </div>

                    <div class="customer-product-info">
                        <div class="customer-product-name">
                            {{ $product->name }}
                        </div>

                        <div class="customer-product-bottom">
                            <div class="customer-product-price">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="customer-product-stock">
                                Stock {{ $product->stock }}
                            </div>
                        </div>
                    </div>
                </a>

                <button type="button" class="view-product-button {{ $product->stock <= 0 ? 'sold-out-button' : '' }}" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                    View Product
                </button>
            </div>

            <div class="modal fade product-modal" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" class="product-modal-close" data-bs-dismiss="modal">
                            &times;
                        </button>

                        <div class="product-modal-body">
                            <div class="product-modal-image">
                                @if($product->image)
                                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <i class="fas fa-leaf"></i>
                                @endif

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

                            <div class="product-modal-info">
                                <div class="product-modal-category">
                                    {{ $product->category->name }}
                                </div>

                                <h2>{{ $product->name }}</h2>

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
                                    {{ $product->description }}
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
                                        <strong>{{ number_format($averageRating, 1, ',', '.') }}</strong>
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
                                                <strong>{{ $review->user->name ?? 'Customer' }}</strong>
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

                                            <small>{{ $review->created_at->format('d M Y') }}</small>
                                        </div>
                                    @empty
                                        <p class="product-modal-review-empty">
                                            Belum ada ulasan untuk produk ini.
                                        </p>
                                    @endforelse

                                </div>

                                @if(Auth::check() && $product->stock > 0)

                                    <form action="{{ route('customer.cart.store') }}" method="POST">

                                        @csrf

                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <input type="hidden" name="quantity" id="cart-quantity-{{ $product->id }}" value="1">

                                        <button type="submit" class="modal-add-cart">
                                            Add to Cart
                                        </button>

                                    </form>

                                @elseif(!Auth::check())

                                    <a href="{{ route('login', ['redirect_to' => '/products?open_product='. $product->id]) }}" class="modal-add-cart">
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

        @empty

            <div class="product-empty">
                Belum ada produk.
            </div>

        @endforelse
    </div>
    @endif

    {{-- SOLD OUT --}}

    <div class="sold-out-section" id="sold-out">
        <div class="sold-out-heading">
            <h2>Sold Out</h2>
            <p>Produk yang sedang tidak tersedia.</p>
        </div>

        <div class="customer-product-grid">

            @forelse($soldOutProducts as $product)

                <div class="customer-product-card">
                    <div class="customer-product-link">
                        <div class="customer-product-image">

                            @if($product->image)

                                <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="sold-out-image">

                            @else

                                <i class="fas fa-leaf"></i>

                            @endif

                            <div class="sold-out-label">
                                SOLD OUT
                            </div>

                        </div>

                        <div class="customer-product-info">
                            <div class="customer-product-name">
                                {{ $product->name }}
                            </div>

                            <div class="customer-product-bottom">
                                <div class="customer-product-price">
                                    Rp. {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <div class="customer-product-sold">
                                    Sold Out
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="view-product-button sold-out-button" data-bs-toggle="modal" data-bs-target="#productModalSold{{ $product->id }}">
                        View Product
                    </button>
                </div>

            @empty

                <div class="product-empty">
                    Tidak ada produk yang sold out.
                </div>

            @endforelse

        </div>
    </div>
</div>


{{-- FOOTER --}}
@include('layouts.inc.footer')


<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('open_product');

        if (!productId) {
            return;
        }

        const modalElement = document.getElementById('productModal' + productId);

        if (modalElement) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        } else {
            console.error('Popup produk tidak ditemukan:', productId);
        }

    });
</script>
</body>
</html>