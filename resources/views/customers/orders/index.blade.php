
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Orders - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-order.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="mm-navbar">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="mm-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>MATCHA MORI</span>
        </a>

        {{-- Menu --}}
        <div class="mm-nav-links">
            <a href="{{ route('welcome') }}" class="active">Home</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('products.index') }}">Menu</a>
        </div>

        {{-- Search + Customer --}}
        <div class="mm-nav-right">

            <form action="{{ route('search') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">
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
            @endauth
        </div>
    </nav>

    <div class="orders-page">

        {{-- PAGE HEADING --}}
        <section class="orders-heading">
            <div>
                <span class="orders-eyebrow">MATCHA MORI</span>
                <h1>My Orders</h1>
                <p>Pantau dan kelola pesanan matcha favoritmu.</p>
            </div>
        </section>
        
        {{-- STATUS TABS --}}
        <div class="orders-tabs">

            <a href="{{ route('customer.orders.index') }}" class="orders-tab {{ empty($status) ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('customer.orders.index', ['status' => 'placed']) }}" class="orders-tab {{ $status === 'placed' ? 'active' : '' }}">
                Pesanan Dibuat
            </a>

            <a href="{{ route('customer.orders.index', ['status' => 'processing']) }}" class="orders-tab {{ $status === 'processing' ? 'active' : '' }}">
                Diproses
            </a>

            <a href="{{ route('customer.orders.index', ['status' => 'delivery']) }}" class="orders-tab {{ $status === 'delivery' ? 'active' : '' }}">
                Dikirim
            </a>

            <a href="{{ route('customer.orders.index', ['status' => 'delivered']) }}" class="orders-tab {{ $status === 'delivered' ? 'active' : '' }}">
                Selesai
            </a>

        </div>

        {{-- ORDER LIST --}}
        <section class="orders-list">

            @forelse($orders as $order)

                @php
                    $isPickup = str_contains(
                        $order->shipping ?? '',
                        'Method: Pickup at Matcha Mori Store'
                    );

                    $status = strtolower(str_replace(
                        [' ', '_'],
                        '-',
                        $order->order_status ?? ''
                    ));

                    $statusLabel = match ($order->order_status) {
                        'Order Placed' => 'Pesanan Dibuat',
                        'Processing' => 'Diproses',
                        'On Delivery' => $isPickup ? 'Siap Diambil' : 'Dalam Pengiriman',
                        'Delivered' => $isPickup ? 'Sudah Diambil' : 'Pesanan Selesai',
                        default => $order->order_status ?? 'Menunggu Konfirmasi',
                    };

                    $statusIcon = match ($order->order_status) {
                        'Order Placed' => 'fa-clock',
                        'Processing' => 'fa-box',
                        'On Delivery' => $isPickup ? 'fa-store' : 'fa-truck',
                        'Delivered' => 'fa-circle-check',
                        default => 'fa-leaf',
                    };
                @endphp

                <article class="order-card">

                    {{-- CARD HEADER --}}
                    <div class="order-card-header">
                        <div class="order-store">
                            <div>
                                <strong>Matcha Mori</strong>
                                <small>Pesanan #{{ $order->invoice }}</small>
                            </div>
                        </div>

                        <span class="order-status-badge status-{{ $status }}">
                            <i class="fas {{ $statusIcon }}"></i>
                            {{ $statusLabel }}
                        </span>
                    </div>

                    {{-- CARD BODY --}}                
                    <div class="order-card-body">
                        @foreach($order->orderDetails as $detail)
                            <div class="order-product-row">
                                <div class="order-product-image">
                                    @if($detail->product && $detail->product->image)
                                        <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="order-product-placeholder"
                                            style="display:none;">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                    @else
                                        <div class="order-product-placeholder">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="order-product-info">
                                    <h3>
                                        {{ $detail->product->name ?? 'Produk tidak tersedia' }}
                                    </h3>

                                    <p>
                                        Rp{{ number_format($detail->price, 0, ',', '.') }}
                                        × {{ $detail->quantity }}
                                    </p>
                                </div>

                                <div class="order-product-subtotal">
                                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach

                        <div class="order-reception-info">
                            <div class="reception-info-item">
                                <i class="fas {{ $isPickup ? 'fa-store' : 'fa-truck' }}"></i>

                                <div>
                                    <small>Metode Penerimaan</small>

                                    <strong>
                                        {{ $isPickup ? 'Ambil di Tempat' : 'Pengiriman ke Alamat' }}
                                    </strong>
                                </div>
                            </div>

                            @if($isPickup)

                                <div class="reception-info-item">
                                    <i class="fas fa-location-dot"></i>

                                    <div>
                                        <small>Lokasi Pengambilan</small>
                                        <strong>Matcha Mori Store</strong>
                                        <p>Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah</p>
                                    </div>
                                </div>

                            @else

                                @php
                                    preg_match('/Address:\s*(.*?)(?=,\s*Method:|$)/i',
                                        $order->shipping ?? '', $addressMatch);

                                    $customerAddress = trim(
                                        $addressMatch[1] ?? ($order->user->address ?? '-')
                                    );
                                @endphp

                                <div class="reception-info-item">
                                    <i class="fas fa-location-dot"></i>

                                    <div>
                                        <small>Alamat Pengiriman</small>
                                        <strong>{{ $customerAddress }}</strong>
                                    </div>
                                </div>

                            @endif

                        </div>

                        <div class="order-total">
                            <small>Total pesanan</small>
                            <strong>
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>
                    
                    {{-- CARD FOOTER --}}
                    <div class="order-card-footer">
                        <span class="order-payment-note">
                            <i class="fas fa-shield-heart"></i>
                            Terima kasih telah berbelanja!
                        </span>

                        <div class="order-card-actions">

                            {{-- KONFIRMASI PESANAN: HANYA ON DELIVERY --}}
                            @if(trim($order->order_status ?? '') === 'On Delivery')

                                <section class="order-confirm-card">
                                    <div class="order-confirm-icon">
                                        <i class="fas {{ $isPickup ? 'fa-store' : 'fa-box-open' }}"></i>
                                    </div>

                                    <div class="order-confirm-copy">
                                        <h2>
                                            {{ $isPickup ? 'Pesanan siap diambil?' : 'Pesanan sudah sampai?' }}
                                        </h2>
                                        <p>
                                            {{ $isPickup
                                                ? 'Jika pesanan sudah kamu ambil di toko, silakan konfirmasi pesanan.'
                                                : 'Jika pesanan sudah kamu terima, silakan konfirmasi pesanan.' }}
                                        </p>
                                    </div>
                                </section>

                            @endif


                            {{-- PESANAN SUDAH SELESAI --}}
                            @if(trim($order->order_status ?? '') === 'Delivered')

                                <div class="order-delivered-banner">
                                    <i class="fas fa-circle-check"></i>
                                    <div>
                                        <strong>
                                            {{ $isPickup ? 'Pesanan berhasil diambil!' : 'Pesanan berhasil diterima!' }}
                                        </strong>

                                        <p>Terima kasih sudah memilih Matcha Mori.</p>
                                    </div>
                                </div>

                                <div class="order-review-actions">
                                    <span class="order-received-badge">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $isPickup ? 'Pesanan Sudah Diambil' : 'Pesanan Sudah Diterima' }}
                                    </span>

                                    {{-- ULASAN PRODUK --}}
                                    @foreach($order->orderDetails as $detail)

                                        @if($detail->product)

                                            @php
                                                $reviewExists = $order->reviews()
                                                    ->where('product_id', $detail->product_id)
                                                    ->exists();

                                                $modalId = 'reviewModal-' . $order->id
                                                    . '-' . $detail->product_id;
                                            @endphp

                                            @if(!$reviewExists)

                                                <button type="button" class="order-review-button" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                                    <i class="fas fa-star"></i>
                                                    Ulas {{ $detail->product->name }}
                                                </button>

                                                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="{{ route('customer.reviews.store', $order->id) }}" method="POST">

                                                                @csrf

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        Berikan Ulasan
                                                                    </h5>

                                                                    <button type="button"
                                                                            class="btn-close"
                                                                            data-bs-dismiss="modal">
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">

                                                                    <p>{{ $detail->product->name }}</p>

                                                                    <input type="hidden" name="product_id" value="{{ $detail->product_id }}">

                                                                    <label class="form-label">Rating</label>

                                                                    <select name="rating" class="form-select" required>
                                                                        <option value="">Pilih rating</option>
                                                                        <option value="5">★★★★★ - Sangat Baik</option>
                                                                        <option value="4">★★★★ - Baik</option>
                                                                        <option value="3">★★★ - Cukup</option>
                                                                        <option value="2">★★ - Kurang</option>
                                                                        <option value="1">★ - Buruk</option>
                                                                    </select>

                                                                    <label class="form-label mt-3">
                                                                        Komentar
                                                                    </label>

                                                                    <textarea name="comment" class="form-control" rows="4" maxlength="1000" placeholder="Ceritakan pengalamanmu..."></textarea>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        Batal
                                                                    </button>

                                                                    <button type="submit" class="btn btn-success">
                                                                        Kirim Ulasan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <span class="order-review-submitted">
                                                    <i class="fas fa-check"></i>
                                                    Sudah Diulas
                                                </span>

                                            @endif

                                        @endif

                                    @endforeach

                                </div>

                            @endif


                            {{-- TOMBOL AKSI --}}
                            <div class="order-action-buttons">

                                {{-- TOMBOL KONFIRMASI: HANYA ON DELIVERY --}}
                                @if(trim($order->order_status ?? '') === 'On Delivery')

                                    <form action="{{ route('customer.orders.confirmReceived', $order->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin mengonfirmasi pesanan ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="order-confirm-button">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $isPickup ? 'Pesanan Sudah Diambil' : 'Pesanan Sudah Diterima' }}
                                        </button>

                                    </form>

                                @endif

                                {{-- TOMBOL DETAIL SELALU MUNCUL --}}
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="order-detail-button">
                                    Lihat Detail
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

            @empty

                <div class="orders-empty">
                    <div class="orders-empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>

                    <h3>Belum ada pesanan</h3>

                    <p>
                        Pesananmu akan muncul di sini setelah kamu melakukan checkout.
                    </p>

                    <a href="{{ route('products.index') }}" class="order-detail-button">
                        <i class="fas fa-leaf"></i>
                        Mulai Belanja
                    </a>
                </div>

            @endforelse

        </section>
    </div>


{{-- FOOTER --}}
@include('layouts.inc.footer')


<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
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
</body>
</html>
