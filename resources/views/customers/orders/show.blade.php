
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Detail - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-order.css') }}?v={{ time() }}">
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="mm-navbar">
        <a href="{{ route('welcome') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        <div class="mm-nav-links">
            <a href="{{ Auth::check() ? route('customer.dashboard') : route('welcome') }}">
                Home
            </a>

            <a href="{{ route('about') }}">About Us</a>

            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                Menu
            </a>
        </div>

        <div class="mm-nav-right">

            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">

                <button type="submit" class="mm-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            @if(Auth::check())

                @php
                    $cartCount = \App\Models\CartDetail::whereHas(
                        'cart',
                        function ($query) {
                            $query->where('user_id', Auth::id());
                        }
                    )->sum('quantity');
                @endphp

                <a class="mm-auth-link mm-cart-link" href="{{ route('customer.cart.index') }}" title="Cart">
                    <i class="fas fa-shopping-cart"></i>

                    @if($cartCount > 0)
                        <span class="mm-cart-count">{{ $cartCount }}</span>
                    @endif
                </a>

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

                <a href="{{ route('login') }}" class="mm-auth-link">Login</a>
                <span class="mm-auth-divider">|</span>
                <a href="{{ route('register') }}" class="mm-auth-link">Register</a>

            @endif
        </div>
    </nav>

    @php
        $shippingInfo = $order->shipping ?? '';

        $isPickup = str_contains(
            $shippingInfo,
            'Method: Pickup at Matcha Mori Store'
        );

        preg_match('/Name:\s*(.*?)(?=,\s*Phone:|$)/i', $shippingInfo, $nameMatch);

        preg_match('/Phone:\s*(.*?)(?=,\s*(?:Address|Method):|$)/i', $shippingInfo, $phoneMatch);

        preg_match('/Address:\s*(.*?)(?=,\s*Method:|$)/i', $shippingInfo, $addressMatch);

        $recipientName = trim($nameMatch[1] ?? ($order->user->name ?? '-'));
        $recipientPhone = trim($phoneMatch[1] ?? ($order->user->phone ?? '-'));
        $recipientAddress = trim($addressMatch[1] ?? ($order->user->address ?? '-'));

        $storeAddress = 'Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah';

        $orderSteps = [
            'Order Placed' => [
                'title' => 'Pesanan dibuat',
                'description' => 'Pesanan berhasil dicatat.',
                'icon' => 'fa-clipboard-check',
            ],

            'Processing' => [
                'title' => 'Pesanan diproses',
                'description' => 'Pesanan sedang disiapkan oleh Matcha Mori.',
                'icon' => 'fa-box-open',
            ],

            'On Delivery' => [
                'title' => $isPickup ? 'Pesanan siap diambil' : 'Dalam perjalanan',
                'description' => $isPickup
                    ? 'Pesanan sudah siap. Silakan ambil di toko Matcha Mori.'
                    : 'Pesanan sedang dikirim ke alamat tujuan.',
                'icon' => $isPickup ? 'fa-store' : 'fa-truck',
            ],

            'Delivered' => [
                'title' => $isPickup ? 'Pesanan sudah diambil' : 'Pesanan diterima',
                'description' => $isPickup
                    ? 'Pesanan telah diambil oleh customer.'
                    : 'Pesanan telah diterima oleh customer.',
                'icon' => 'fa-circle-check',
            ],
        ];

        $statusOrder = array_keys($orderSteps);

        $currentStatusIndex = array_search(
            $order->order_status,
            $statusOrder
        );

        if ($currentStatusIndex === false) {
            $currentStatusIndex = -1;
        }

        $currentStatusLabel = match ($order->order_status) {
            'Order Placed' => 'Pesanan Dibuat',
            'Processing' => 'Diproses',
            'On Delivery' => $isPickup ? 'Siap Diambil' : 'Dalam Pengiriman',
            'Delivered' => $isPickup ? 'Sudah Diambil' : 'Sudah Diterima',
            default => $order->order_status,
        };
    @endphp

    <main class="order-detail-page">
        {{-- PAGE HEADER --}}
        <section class="order-detail-hero">
            <div class="order-hero-brand">
                <div class="order-hero-leaf">
                    <i class="fas fa-leaf"></i>
                </div>

                <div>
                    <span>MATCHA MORI</span>
                    <small>YOUR LITTLE MOMENT OF CALM</small>
                </div>
            </div>

            <div class="order-hero-content">
                <span class="order-eyebrow">MY ORDERS / ORDER DETAIL</span>
                <h1>Pesanan saya<span>.</span></h1>
            </div>

            <div class="order-hero-decoration">
                <i class="fas fa-seedling"></i>
            </div>
        </section>

        {{-- ORDER SUMMARY --}}
        <section class="order-summary-card">
            <div class="order-summary-top">
                <div>
                    <span class="order-label">NOMOR INVOICE</span>

                    <h2>{{ $order->invoice }}</h2>

                    <p>
                        <i class="far fa-calendar"></i>
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                <a href="#" class="order-current-status">
                    <span class="status-dot"></span>
                    {{ $currentStatusLabel }}
                    <i class="fas fa-arrow-up-right-from-square"></i>
                </a>
            </div>

            <div class="order-summary-bottom">
                <div class="summary-item">
                    <span>Order ID</span>
                    <strong>
                        #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </strong>
                </div>

                <div class="summary-item">
                    <span>Metode pembayaran</span>
                    <strong>
                        <i class="fas fa-money-bill-wave"></i>
                        {{ $order->payment_method }}
                    </strong>
                </div>

                <div class="summary-item">
                    <span>Status pembayaran</span>
                    <strong>{{ $order->payment_status }}</strong>
                </div>
            </div>
        </section>

        {{-- ORDER TIMELINE --}}
        <section class="order-section-card">
            <div class="order-section-heading">
                <div>
                    <span class="order-section-eyebrow">ORDER PROGRESS</span>
                    <h2>Perjalanan pesanan</h2>
                </div>

                <div class="order-section-icon">
                    <i class="fas fa-route"></i>
                </div>
            </div>

            <div class="order-timeline">

                @foreach($orderSteps as $status => $step)

                    @php
                        $stepIndex = array_search($status, $statusOrder);

                        $isCompleted = $currentStatusIndex >= 0
                            && $stepIndex < $currentStatusIndex;

                        $isActive = $currentStatusIndex >= 0
                            && $stepIndex === $currentStatusIndex;
                    @endphp

                    <div class="timeline-step
                        {{ $isCompleted ? 'completed' : '' }}
                        {{ $isActive ? 'active' : '' }}">

                        <div class="timeline-marker">
                            <i class="fas {{ $isCompleted ? 'fa-check' : $step['icon'] }}"></i>
                        </div>

                        <div class="timeline-copy">
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['description'] }}</p>

                            @if($isActive)
                                <span class="timeline-current">
                                    Status saat ini
                                </span>
                            @endif
                        </div>
                    </div>

                @endforeach

            </div>

            @if($currentStatusIndex === -1)
                <p class="order-status-note">
                    Status pesanan saat ini:
                    <strong>{{ $order->order_status }}</strong>
                </p>
            @endif

        </section>

        {{-- PRODUCTS --}}
        <section class="order-section-card">
            <div class="order-section-heading">
                <div>
                    <span class="order-section-eyebrow">YOUR PURCHASE</span>
                    <h2>Produk yang dipesan</h2>
                </div>

                <div class="order-section-icon">
                    <i class="fas fa-bag-shopping"></i>
                </div>
            </div>

            <div class="ordered-products">

                @forelse($order->orderDetails as $detail)

                    <article class="ordered-product">
                        <div class="ordered-product-image">

                            @if($detail->product && $detail->product->image)
                                <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" onerror="this.style.display='none';">
                            @else
                                <div class="ordered-product-placeholder">
                                    <i class="fas fa-leaf"></i>
                                </div>
                            @endif

                        </div>

                        <div class="ordered-product-info">
                            <span class="ordered-product-category">
                                MATCHA MORI
                            </span>

                            <h3>
                                {{ $detail->product->name ?? 'Produk tidak tersedia' }}
                            </h3>

                            <p>
                                {{ $detail->quantity }} produk
                                <span>×</span>
                                Rp{{ number_format($detail->price, 0, ',', '.') }}
                            </p>

                            <small>
                                Product ID: {{ $detail->product_id }}
                            </small>
                        </div>

                        <div class="ordered-product-price">
                            <span>Subtotal</span>
                            <strong>
                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                            </strong>
                        </div>
                    </article>

                @empty

                    <div class="order-products-empty">
                        Belum ada detail produk untuk pesanan ini.
                    </div>

                @endforelse

            </div>

            {{-- TOTAL --}}
            <div class="order-total-panel">
                <div>
                    <span>Total pembayaran</span>
                    <small>
                        {{ $order->orderDetails->sum('quantity') }} produk
                    </small>
                </div>

                <strong>
                    Rp{{ number_format($order->total, 0, ',', '.') }}
                </strong>
            </div>
        </section>

        {{-- BACK --}}
        <div class="order-detail-footer">
            <a href="{{ route('customer.orders.index') }}" class="order-back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke My Orders
            </a>

            <span class="order-footer-note">
                Made with <i class="fas fa-heart"></i> by Matcha Mori
            </span>
        </div>
    </main>

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
