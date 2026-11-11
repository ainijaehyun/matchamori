<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet"  href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-payment.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">
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
            <a href="{{ route('about') }}">
                About Us
            </a>
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

                <a href="{{ route('login') }}" class="mm-auth-link">
                    Login
                </a>

                <span class="mm-auth-divider">|</span>

                <a href="{{ route('register') }}" class="mm-auth-link">
                    Register
                </a>

            @endif

        </div>
    </nav>

    @php
        $orderForm = $orderForm ?? session('checkout.order_form', []);
        $isWalletPayment = $isWalletPayment ?? false;
    @endphp

    <main class="payment-page">
        <div class="payment-container">

            {{-- LEFT COLUMN --}}
            <div class="payment-left-column">
                
                {{-- PAYMENT INSTRUCTIONS --}}
                <section class="payment-card">
                    <h2 class="payment-section-title">
                        <span class="payment-step">1</span>
                        <span>
                            Payment Instructions
                            <small>Ikuti petunjuk pembayaran berikut.</small>
                        </span>
                    </h2>

                    <div class="payment-detail-box">
                        @if ($isWalletPayment)

                            <div style="text-align:center; padding:15px 10px;">

                                <div style="
                                    width:65px;
                                    height:65px;
                                    margin:0 auto 15px;
                                    border-radius:50%;
                                    background:#e8f5e9;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#315b42;
                                    font-size:30px;
                                ">
                                    <i class="fas fa-check"></i>
                                </div>

                                <h3 style="color:#315b42;">
                                    Pembayaran Berhasil!
                                </h3>

                                <p>
                                    Pembayaran melalui {{ $paymentMethod }} berhasil.
                                </p>

                                <div class="payment-account">
                                    <span>Nomor Transaksi</span>
                                    <strong>{{ $order->invoice }}</strong>

                                    <span style="margin-top:12px;">Status Pembayaran</span>
                                    <strong style="color:#27834b;">
                                        {{ $order->payment_status }}
                                    </strong>
                                </div>

                                <div class="payment-info-note">
                                    <i class="fas fa-circle-info"></i>
                                    Ini merupakan simulasi pembayaran. Tidak ada uang yang benar-benar ditransfer.
                                </div>

                            </div>

                        @elseif ($paymentMethod === 'COD')

                            <h3>Transfer {{ $paymentMethod }}</h3>

                            <p>Transfer sesuai total pembayaran ke nomor admin berikut.</p>

                            <div class="payment-account">
                                <span>Nomor admin {{ $paymentMethod }}</span>

                                <strong>
                                    {{ config('payment.accounts.' . strtolower($paymentMethod), 'Nomor tujuan belum diatur') }}
                                </strong>

                                <small>Pastikan nomor tujuan dan nominal pembayaran benar.</small>
                            </div>

                        @endif
                    </div>
                </section>

                {{-- METODE PENERIMAAN PESANAN --}}
                <section class="payment-card">
                    <h2 class="payment-section-title">
                        <span class="payment-step">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <span>
                            Metode Penerimaan Pesanan
                            <small>Informasi pengambilan atau pengiriman pesanan.</small>
                        </span>
                    </h2>

                    @if (($orderForm['delivery_method'] ?? 'delivery') === 'pickup')

                        <div class="payment-detail-box">

                            <h3>
                                <i class="fas fa-store"></i>
                                Ambil di Tempat
                            </h3>

                            <div class="pickup-payment-location">
                                <strong>Matcha Mori Store</strong>
                                <p>
                                    <i class="fas fa-map-marker-alt"></i>
                                    Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah
                                </p>
                                <div class="pickup-payment-map">
                                    <iframe
                                        src="https://www.google.com/maps?q=Palumbungan%20Wetan%2C%20Bobotsari%2C%20Purbalingga%2C%20Jawa%20Tengah&output=embed"
                                        width="100%"
                                        height="300"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>

                                <a href="https://www.google.com/maps/search/?api=1&query=Palumbungan%20Wetan%2C%20Bobotsari%2C%20Purbalingga%2C%20Jawa%20Tengah"
                                    target="_blank" class="pickup-map-link">

                                    <i class="fas fa-directions"></i>
                                    Lihat Petunjuk Arah
                                </a>

                                <div class="payment-info-note">
                                    <i class="fas fa-info-circle"></i>
                                    Silakan ambil pesanan langsung di toko setelah admin
                                    mengonfirmasi bahwa pesanan sudah siap.
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="payment-detail-box">
                            <h3>
                                <i class="fas fa-truck"></i>
                                Pengiriman ke Alamat
                            </h3>

                            <p>{{ $orderForm['address'] ?? '-' }}</p>
                        </div>

                    @endif
                </section>

                
                {{-- PAYMENT PROOF --}}
                <section class="payment-card payment-proof-card">
                    <h2 class="payment-section-title">
                        <span class="payment-step">2</span>
                        <span>
                            Payment Confirmation
                            <small>Unggah bukti transfer untuk menyelesaikan pesanan.</small>
                        </span>
                    </h2>

                    <form id="paymentConfirmationForm" action="{{ route('customer.checkout.payment.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        @if ($isWalletPayment)

                            <h2 class="payment-section-title">
                                <span class="payment-step">
                                    <i class="fas fa-check"></i>
                                </span>

                                <span>
                                    Payment Confirmation
                                    <small>Pembayaran e-wallet berhasil diselesaikan.</small>
                                </span>
                            </h2>

                            <div class="payment-info-note">
                                <i class="fas fa-check-circle"></i>
                                Pembayaran {{ $paymentMethod }} sudah berhasil.
                                Kamu bisa melanjutkan ke halaman konfirmasi pesanan.
                            </div>

                        @else

                            <div class="payment-info-note">
                                <i class="fas fa-circle-info"></i>
                                Pembayaran COD dilakukan saat pesanan diterima.
                                Bukti transfer tidak diperlukan.
                            </div>

                        @endif
                    </form>
                </section>
            </div>

            {{-- RIGHT COLUMN: ORDER SUMMARY --}}
            <aside class="payment-card payment-summary">
                <h2 class="payment-summary-heading">
                    <i class="fas fa-shopping-cart"></i>
                    Order Summary
                </h2>

                {{-- PRODUCT LIST --}}
                <div class="payment-product-list">

                    @foreach ($selectedItems as $item)

                        @if ($item->product)

                            <div class="payment-product">
                                <div class="payment-product-image">
                                    @if ($item->product->image)
                                        <img src="{{ asset('img/' . $item->product->image) }}" alt="{{ $item->product->name }}"> 
                                    @else
                                        <i class="fas fa-leaf"></i>
                                    @endif
                                </div>

                                <div class="payment-product-info">
                                    <strong>{{ $item->product->name }}</strong>
                                    <span>
                                        {{ $item->quantity }} x
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <strong class="payment-product-subtotal">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </strong>
                            </div>

                        @endif

                    @endforeach

                </div>

                <div class="payment-summary-divider"></div>

                <div class="payment-summary-line">
                    <span>Total Produk</span>
                    <span>{{ $selectedItems->sum('quantity') }} item</span>
                </div>

                <div class="payment-summary-line">
                    <span>Subtotal</span>
                    <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="payment-summary-total">
                    <span>Total Pembayaran</span>
                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
                @if ($isWalletPayment)

                    <a href="{{ route('customer.checkout.confirmation', $order->id) }}" class="payment-confirm-button" style="display:block; text-align:center; text-decoration:none;">
                        Lanjutkan ke Confirmation
                        <i class="fas fa-arrow-right"></i>
                    </a>

                @else

                    <button type="submit" form="paymentConfirmationForm" class="payment-confirm-button">
                        Konfirmasi Pesanan
                        <i class="fas fa-arrow-right"></i>
                    </button>

                @endif
                    
                <a href="{{ route('customer.checkout.index') }}" class="payment-back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Checkout
                </a>

            </aside>

        </div>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('bukti_pembayaran');
        const previewContainer = document.getElementById('payment-preview-container');
        const previewImage = document.getElementById('payment-preview-image');
        const previewFilename = document.getElementById('payment-preview-filename');
        const removeButton = document.getElementById('remove-payment-preview');

        if (!fileInput || !previewContainer || !previewImage || !removeButton) {
            return;
        }

        let previewUrl = null;

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];

            if (!file) {
                return;
            }

            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                alert('Pilih gambar berformat JPG, JPEG, atau PNG.');
                fileInput.value = '';
                previewContainer.hidden = true;
                return;
            }

            // Maksimal 2 MB
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 2 MB.');
                fileInput.value = '';
                previewContainer.hidden = true;
                return;
            }

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
            }

            previewUrl = URL.createObjectURL(file);
            previewImage.src = previewUrl;
            previewFilename.textContent = file.name;
            previewContainer.hidden = false;
        });

        removeButton.addEventListener('click', function () {
            fileInput.value = '';
            previewImage.removeAttribute('src');
            previewFilename.textContent = '';
            previewContainer.hidden = true;

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }
        });
    });
</script>


<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

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
