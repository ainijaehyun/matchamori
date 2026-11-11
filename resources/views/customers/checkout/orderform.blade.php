<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OrderForm - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-checkout.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}?v={{ time() }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>

<body>

    @php
        $selectedAddress = $selectedAddress ?? $addresses->first();
    @endphp

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

            <a href="{{ route('products.index') }}"
            class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                Menu
            </a>
        </div>

        <div class="mm-nav-right">

            <form action="{{ route('products.index') }}" method="GET" class="mm-search-form">
                <input type="text" name="search" class="mm-search-input" placeholder="Search..." value="{{ request('search') }}">

                <button type="submit" class="mm-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            @if(Auth::check())

                @php
                    $cartCount = \App\Models\CartDetail::whereHas('cart', function ($query) {
                        $query->where('user_id', Auth::id());
                    })->sum('quantity');
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


    {{-- CHECKOUT --}}
    <div class="checkout-page">
        <div class="checkout-container">

            <form action="{{ route('customer.checkout.store') }}" method="POST" class="checkout-form">

                @csrf

                {{-- ALAMAT PENGIRIMAN --}}
                <section class="checkout-card shipping-address-card" id="shippingAddressSection">

                    <h2>
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat Pengiriman
                    </h2>

                    @if($selectedAddress)

                        <div class="shipping-address-content">

                            <div class="shipping-address-user">
                                <strong id="previewName">
                                    {{ $selectedAddress->name }}
                                </strong>

                                <span class="shipping-address-divider">|</span>

                                <span id="previewPhone">
                                    {{ $selectedAddress->phone }}
                                </span>
                            </div>

                            <div class="shipping-address-detail">
                                <i class="fas fa-location-dot"></i>

                                <span id="previewAddress">
                                    {{ $selectedAddress->address }}
                                </span>
                            </div>

                            <button type="button" class="shipping-address-edit" id="editShippingAddress">
                                Ubah
                            </button>

                        </div>

                        {{-- DAFTAR ALAMAT TERSIMPAN --}}
                        <div id="addressList" style="display:none; margin-top:20px;">

                            <h3>Pilih Alamat Pengiriman</h3>

                            @foreach($addresses as $address)

                                <div class="saved-address-option" style="padding:15px; border:1px solid #ddd; border-radius:10px; margin-bottom:12px;">

                                    <label style="display:block; cursor:pointer;">

                                        <input type="radio" name="selected_address_option" value="{{ $address->id }}"
                                            data-name="{{ $address->name }}"
                                            data-phone="{{ $address->phone }}"
                                            data-address="{{ $address->address }}"
                                            data-latitude="{{ $address->latitude }}"
                                            data-longitude="{{ $address->longitude }}" 
                                            {{ $selectedAddress->id == $address->id ? 'checked' : '' }}>
                                        

                                        <strong>{{ $address->name }}</strong>
                                        <span>| {{ $address->phone }}</span>

                                        <p style="margin:8px 0 0 22px;">
                                            {{ $address->address }}
                                        </p>

                                        @if($address->is_default)
                                            <small style="color:#6b8a5d;">
                                                Alamat Utama
                                            </small>
                                        @endif

                                    </label>

                                    <div style="display:flex; gap:15px; margin-top:12px; margin-left:22px;">

                                        {{-- EDIT ALAMAT --}}
                                        <button type="button" class="edit-address-button"
                                            data-id="{{ $address->id }}"
                                            data-name="{{ $address->name }}"
                                            data-phone="{{ $address->phone }}"
                                            data-address="{{ $address->address }}"
                                            data-latitude="{{ $address->latitude }}"
                                            data-longitude="{{ $address->longitude }}"
                                            data-postal-code="{{ $address->postal_code }}"
                                            data-is-default="{{ $address->is_default ? '1' : '0' }}"
                                            data-update-url="{{ route('customer.addresses.update', $address->id) }}"
                                            style="border:none; background:none; color:#6b8a5d; padding:0;">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        {{-- HAPUS ALAMAT --}}
                                        <button type="submit" form="delete-address-{{ $address->id }}" style="border:none; background:none; color:#dc3545; padding:0;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                            <button type="button" id="addNewAddress">
                                + Tambah Alamat Baru
                            </button>

                        </div>

                        {{-- DATA ALAMAT YANG DIKIRIM KE CHECKOUT --}}
                        <input type="hidden" name="address_id" id="address_id" value="{{ $selectedAddress->id }}">

                        <input  type="hidden" name="name" id="name" value="{{ $selectedAddress->name }}">

                        <input type="hidden" name="phone" id="phone" value="{{ $selectedAddress->phone }}">

                        <input type="hidden" name="address" id="address" value="{{ $selectedAddress->address }}">

                        <input type="hidden" name="latitude" id="latitude" value="{{ $selectedAddress->latitude }}">

                        <input type="hidden" name="longitude" id="longitude" value="{{ $selectedAddress->longitude }}">

                    @else

                        <p>Belum ada alamat tersimpan.</p>

                        <button type="button" id="addNewAddress">
                            + Tambah Alamat Baru
                        </button>

                    @endif

                </section>



                {{-- PRODUK DAN PEMBAYARAN --}}
                <div class="checkout-main">
                    {{-- KOLOM KIRI --}}
                    <div class="checkout-left">
                        {{-- PRODUK DIPESAN --}}
                        <section class="checkout-card checkout-products-card">

                            <div class="checkout-section-heading">
                                <h2>Produk Dipesan</h2>
                                <span>Matcha Mori</span>
                            </div>

                            <div class="checkout-product-header">
                                <span>Produk</span>
                                <span>Harga</span>
                                <span>Jumlah</span>
                                <span>Subtotal</span>
                            </div>

                            @forelse($selectedItems as $item)

                                <div class="checkout-product-row">

                                    <div class="checkout-product-info">

                                        <img class="checkout-product-image" src="{{ $item->product->image ? asset('img/' . $item->product->image) : asset('img/leaf1.png') }}" alt="{{ $item->product->name }}">

                                        <div class="checkout-product-text">
                                            <strong>{{ $item->product->name }}</strong>
                                            <small>Matcha Mori</small>
                                        </div>

                                    </div>

                                    <div class="checkout-product-price">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>

                                    <div class="checkout-product-quantity">
                                        {{ $item->quantity }}
                                    </div>

                                    <div class="checkout-product-subtotal">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>

                                </div>

                            @empty

                                <p class="checkout-empty">
                                    Tidak ada produk yang dipilih.
                                </p>

                            @endforelse

                        </section>


                        {{-- METODE PEMBAYARAN --}}
                        <section class="checkout-card payment-card">

                            <h2>Metode Pembayaran</h2>

                            <div class="checkout-payment-list">

                                {{-- COD --}}
                                <label class="checkout-payment-option">

                                    <input type="radio" name="payment_method" value="COD" {{ old('payment_method', 'COD') === 'COD' ? 'checked' : '' }} required>

                                    <span class="checkout-payment-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </span>

                                    <span class="checkout-payment-description">
                                        <strong>Cash on Delivery (COD)</strong>
                                        <small>Bayar tunai saat pesanan diterima.</small>
                                    </span>

                                </label>


                                {{-- DANA --}}
                                <label class="checkout-payment-option">

                                    <input type="radio" name="payment_method" value="DANA" {{ old('payment_method') === 'DANA' ? 'checked' : '' }}>

                                    <span class="checkout-payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </span>

                                    <span class="checkout-payment-description">
                                        <strong>DANA</strong>
                                        <small>Pembayaran melalui DANA.</small>
                                    </span>

                                </label>


                                {{-- GOPAY --}}
                                <label class="checkout-payment-option">

                                    <input type="radio" name="payment_method" value="GoPay" {{ old('payment_method') === 'GoPay' ? 'checked' : '' }}>

                                    <span class="checkout-payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </span>

                                    <span class="checkout-payment-description">
                                        <strong>GoPay</strong>
                                        <small>Pembayaran melalui GoPay.</small>
                                    </span>

                                </label>


                                {{-- OVO --}}
                                <label class="checkout-payment-option">

                                    <input type="radio" name="payment_method" value="OVO" {{ old('payment_method') === 'OVO' ? 'checked' : '' }}>

                                    <span class="checkout-payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </span>

                                    <span class="checkout-payment-description">
                                        <strong>OVO</strong>
                                        <small>Pembayaran melalui OVO.</small>
                                    </span>

                                </label>

                            </div>

                            @error('payment_method')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </section>

                        {{-- METODE PENERIMAAN PESANAN --}}
                        <section class="checkout-card">
                            <h2>
                                <i class="fas fa-store"></i>
                                Metode Penerimaan Pesanan
                            </h2>

                            <div class="checkout-payment-list">

                                {{-- PENGIRIMAN --}}
                                <label class="checkout-payment-option">
                                    <input type="radio" name="delivery_method" id="deliveryMethod" value="delivery" {{ old('delivery_method', 'delivery') === 'delivery' ? 'checked' : '' }}>

                                    <i class="fas fa-truck"></i>

                                    <div>
                                        <strong>Pengiriman ke Alamat</strong>
                                        <p>Pesanan dikirim ke alamat tujuan.</p>
                                    </div>
                                </label>

                                {{-- AMBIL DI TEMPAT --}}
                                <label class="checkout-payment-option">
                                    <input type="radio" name="delivery_method" id="pickupMethod" value="pickup" {{ old('delivery_method') === 'pickup' ? 'checked' : '' }}>

                                    <i class="fas fa-store"></i>

                                    <div>
                                        <strong>Ambil di Tempat</strong>
                                        <p>Ambil pesanan langsung di toko Matcha Mori.</p>
                                    </div>
                                </label>

                            </div>
                        </section>

                        {{-- LOKASI PENGAMBILAN --}}
                        <section class="checkout-card" id="pickupLocationSection" style="display: none;">
                            <h2>
                                <i class="fas fa-store"></i>
                                Lokasi Pengambilan
                            </h2>

                            <div class="pickup-location-content">
                                <div class="pickup-store-name">
                                    <strong>Matcha Mori Store</strong>
                                </div>

                                <div class="pickup-location-address">
                                    <i class="fas fa-location-dot"></i>
                                    <span>Palumbungan Wetan, Bobotsari, Purbalingga, Jawa Tengah</span>
                                </div>

                                <p class="pickup-location-note">
                                    Silakan ambil pesanan langsung di toko setelah admin
                                    mengonfirmasi bahwa pesanan sudah siap.
                                </p>
                            </div>
                        </section>


                    </div>


                    {{-- KOLOM KANAN --}}
                    <aside class="checkout-right">

                        <section class="checkout-card order-summary">

                            <div class="order-summary-heading">
                                <div>
                                    <span class="order-summary-label">MATCHA MORI</span>
                                    <h2>Ringkasan Pesanan</h2>
                                </div>

                                <i class="fas fa-receipt order-summary-icon"></i>
                            </div>

                            <div class="order-summary-items">
                                <div class="checkout-summary-line">
                                    <span>Total Produk</span>
                                    <strong>{{ $selectedItems->sum('quantity') }} item</strong>
                                </div>

                                <div class="checkout-summary-line">
                                    <span>Subtotal Produk</span>
                                    <strong>
                                        Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>

                            <div class="order-summary-total">
                                <span>Total Pembayaran</span>

                                <strong>
                                    Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                                </strong>
                            </div>

                            <button type="submit" class="checkout-submit-button" id="checkoutSubmitButton" @if($selectedItems->isEmpty()) disabled @endif>
                                <span>Lanjut Pembayaran</span>
                                <i class="fas fa-arrow-right"></i>

                                <a href="{{ route('customer.cart.index') }}" class="checkout-back-button">
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Cart
                                </a>
                            </button>

                            

                            <div class="order-summary-note">
                                <i class="fas fa-shield-alt"></i>
                                <span>Pastikan alamat dan detail pesanan sudah benar.</span>
                            </div>

                        </section>

                    </aside>

                </div>

            </form>


            {{-- FORM DELETE ALAMAT --}}
            {{-- Form ini sengaja berada di luar form checkout. --}}

            @foreach($addresses as $address)

                <form id="delete-address-{{ $address->id }}" action="{{ route('customer.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>

            @endforeach


            {{-- MODAL TAMBAH / EDIT ALAMAT  --}}
            <div id="newAddressModal" class="address-modal" style="display:none;">

                <div class="address-modal-content">

                    <div class="address-modal-header">
                        <h2 id="addressModalTitle">
                            Tambah Alamat Baru
                        </h2>

                        <button type="button" id="closeAddressModal">
                            &times;
                        </button>
                    </div>

                    <form action="{{ route('customer.addresses.store') }}" method="POST" id="newAddressForm">

                        @csrf

                        {{-- Untuk mode edit akan diaktifkan menjadi PATCH --}}
                        <input type="hidden" name="_method" id="addressMethod" value="PATCH" disabled>

                        {{-- NAMA PENERIMA --}}
                        <div class="checkout-field">
                            <label for="new_name">Nama Penerima</label>

                            <input type="text" id="new_name" name="name" value="{{ old('name', $user->name ?? Auth::user()->name) }}" maxlength="100" required>
                        </div>

                        {{-- NOMOR HP --}}
                        <div class="checkout-field">
                            <label for="new_phone">Nomor HP</label>

                            <input type="text" id="new_phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" maxlength="20" required>
                        </div>


                        {{-- PROVINSI --}}
                        <div class="checkout-field">
                            <label for="province">Provinsi</label>

                            <select id="province" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        {{-- KABUPATEN / KOTA --}}
                        <div class="checkout-field">
                            <label for="regency">Kabupaten / Kota</label>

                            <select id="regency" required disabled>
                                <option value="">Pilih Kabupaten / Kota</option>
                            </select>
                        </div>

                        {{-- KECAMATAN --}}
                        <div class="checkout-field">
                            <label for="district">Kecamatan</label>

                            <select id="district" required disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>

                        {{-- DESA / KELURAHAN --}}
                        <div class="checkout-field">
                            <label for="village">Desa / Kelurahan</label>

                            <select id="village" required disabled>
                                <option value="">Pilih Desa / Kelurahan</option>
                            </select>
                        </div>

                        {{-- ALAMAT JALAN --}}
                        <div class="checkout-field">
                            <label for="new_address">
                                Nama Jalan, Nomor Rumah, RT/RW, dan Detail Lainnya
                            </label>

                            <textarea id="new_address" name="address" rows="3" required placeholder="Contoh: Jalan Melati No. 10, RT 02/RW 03"></textarea>
                        </div>

                        {{-- KODE POS --}}
                        <div class="checkout-field">
                            <label for="postal_code">Kode Pos</label>

                            <input type="text" id="postal_code" name="postal_code" maxlength="20" placeholder="Masukkan kode pos">
                        </div>

                        {{-- PENCARIAN LOKASI --}}
                        <div class="checkout-field">
                            <label for="mapSearch">Cari Lokasi</label>

                            <div style="display:flex; gap:8px;">

                                <input type="text" id="mapSearch" placeholder="Cari nama jalan, desa, atau tempat...">

                                <button type="button" id="searchMapButton" class="shipping-save-button">
                                    <i class="fas fa-search"></i>
                                </button>

                            </div>

                        </div>

                        {{-- GOOGLE MAPS --}}
                        <div class="checkout-field">
                            <label>Pilih Titik Lokasi pada Peta</label>

                            <p style="font-size:13px; color:#777;">
                                Geser pin atau klik peta untuk menentukan lokasi rumah.
                            </p>

                            <div id="addressMap" style="width:100%; height:300px; border-radius:10px;"></div>
                        </div>

                        {{-- KOORDINAT --}}
                        <input type="hidden" name="latitude" id="new_latitude">

                        <input type="hidden" name="longitude" id="new_longitude">

                        {{-- ALAMAT UTAMA --}}
                        <div class="checkout-field">
                            <label style="display:flex; align-items:center; gap:8px;">
                                <input type="checkbox" name="is_default" id="new_is_default" value="1" style="width:auto;">
                                Jadikan sebagai alamat utama
                            </label>

                        </div>

                        <button type="submit" class="shipping-save-button">
                            Simpan Alamat
                        </button>
                    </form>
                </div>
            </div>
        </div>

    {{-- POPUP SIMULASI PEMBAYARAN --}}
    <div id="ewalletPaymentModal" class="ewallet-modal" style="display:none;">

        <div class="ewallet-modal-content">
            <button type="button" class="ewallet-close" id="closeEwalletModal">
                &times;
            </button>

            <div class="ewallet-brand" id="ewalletBrand">
                DANA
            </div>

            <p class="ewallet-store-name">MATCHA MORI</p>

            <h2>Konfirmasi Pembayaran</h2>

            <p class="ewallet-description">
                Periksa kembali detail transaksi sebelum melanjutkan.
            </p>

            <div class="ewallet-detail">
                <div>
                    <span>Nomor Transaksi</span>
                    <strong id="ewalletInvoice">-</strong>
                </div>

                <div>
                    <span>Metode Pembayaran</span>
                    <strong id="ewalletMethod">-</strong>
                </div>

                <div class="ewallet-total">
                    <span>Total Pembayaran</span>
                    <strong id="ewalletTotal">Rp 0</strong>
                </div>
            </div>

            <div class="ewallet-simulation-note">
                <i class="fas fa-info-circle"></i>
                Ini merupakan simulasi pembayaran untuk aplikasi Matcha Mori,
                bukan transaksi uang sungguhan.
            </div>

            <button type="button" id="payNowButton" class="ewallet-pay-button">
                Bayar Sekarang
            </button>

            <p id="ewalletError" class="ewallet-error"></p>
        </div>
    </div>
</div>


{{-- FOOTER --}}
@include('layouts.inc.footer')


{{-- ================= JAVASCRIPT ================= --}}
<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


{{-- NOTIFIKASI --}}
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


@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Periksa kembali data',
            text: @json($errors->first()),
            confirmButtonText: 'OK'
        });
    </script>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const profileButton = document.getElementById('profileDropdown');
        const profileDropdown = profileButton?.closest('.profile-dropdown');

        if (profileButton && profileDropdown) {

            profileButton.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                const isOpen = profileDropdown.classList.toggle('show');

                profileButton.setAttribute('aria-expanded', isOpen);

            });

            document.addEventListener('click', function (event) {

                if (!profileDropdown.contains(event.target)) {

                    profileDropdown.classList.remove('show');

                    profileButton.setAttribute('aria-expanded', 'false');

                }

            });

        }

        
        // METODE PENERIMAAN PESANAN

        const deliveryMethod = document.getElementById('deliveryMethod');
        const pickupMethod = document.getElementById('pickupMethod');

        const shippingSection = document.getElementById('shippingAddressSection');
        const pickupSection = document.getElementById('pickupLocationSection');

        const checkoutSubmitButton = document.getElementById('checkoutSubmitButton');

        const hasSelectedItems = @json(!$selectedItems->isEmpty());
        const hasSelectedAddress = @json((bool) $selectedAddress);

        function updateDeliveryMethod() {

            const isPickup = pickupMethod && pickupMethod.checked;

            // Sembunyikan atau tampilkan alamat
            if (shippingSection) {
                shippingSection.style.display = isPickup ? 'none' : '';
            }

            // Sembunyikan atau tampilkan lokasi pengambilan
            if (pickupSection) {
                pickupSection.style.display = isPickup ? '' : 'none';
            }

            // Atur tombol checkout
            if (checkoutSubmitButton) {
                checkoutSubmitButton.disabled =
                    !hasSelectedItems || (!isPickup && !hasSelectedAddress);
            }

        }

        // Dengarkan perubahan pilihan
        deliveryMethod?.addEventListener('change', updateDeliveryMethod);
        pickupMethod?.addEventListener('change', updateDeliveryMethod);

        // Jalankan ketika halaman dibuka
        updateDeliveryMethod();
            
        // ELEMENT ALAMAT

        const modal = document.getElementById('newAddressModal');
        const form = document.getElementById('newAddressForm');

        const addButton = document.getElementById('addNewAddress');
        const closeButton = document.getElementById('closeAddressModal');

        const addressList = document.getElementById('addressList');
        const editShippingButton = document.getElementById('editShippingAddress');

        const modalTitle = document.getElementById('addressModalTitle');
        const methodInput = document.getElementById('addressMethod');

        const nameInput = document.getElementById('new_name');
        const phoneInput = document.getElementById('new_phone');
        const addressInput = document.getElementById('new_address');
        const postalInput = document.getElementById('postal_code');
        const defaultInput = document.getElementById('new_is_default');

        const provinceSelect = document.getElementById('province');
        const regencySelect = document.getElementById('regency');
        const districtSelect = document.getElementById('district');
        const villageSelect = document.getElementById('village');

        const latitudeInput = document.getElementById('new_latitude');
        const longitudeInput = document.getElementById('new_longitude');

        const mapSearchInput = document.getElementById('mapSearch');
        const searchMapButton = document.getElementById('searchMapButton');

        const storeUrl = form.action;

        const regionApi = 'https://www.emsifa.com/api-wilayah-indonesia/api';


        // BUKA DAN TUTUP DAFTAR ALAMAT

        editShippingButton?.addEventListener('click', function () {

            addressList.style.display =
                addressList.style.display === 'none' ? 'block' : 'none';

        });


        // PILIH ALAMAT TERSIMPAN

        document.querySelectorAll('input[name="selected_address_option"]').forEach(radio => {

            radio.addEventListener('change', function () {

                document.getElementById('address_id').value = this.value;

                document.getElementById('name').value = this.dataset.name;
                document.getElementById('phone').value = this.dataset.phone;
                document.getElementById('address').value = this.dataset.address;

                document.getElementById('latitude').value = this.dataset.latitude || '';
                document.getElementById('longitude').value = this.dataset.longitude || '';

                document.getElementById('previewName').textContent = this.dataset.name;
                document.getElementById('previewPhone').textContent = this.dataset.phone;
                document.getElementById('previewAddress').textContent = this.dataset.address;

                addressList.style.display = 'none';

            });

        });


        // FUNGSI MODAL

        function openModal() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        closeButton?.addEventListener('click', closeModal);

        modal?.addEventListener('click', function (event) {

            if (event.target === modal) {
                closeModal();
            }

        });


        // FUNGSI DROPDOWN WILAYAH

        async function getRegions(url) {

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Gagal mengambil data wilayah Indonesia.');
            }

            const result = await response.json();

            return Array.isArray(result) ? result : result.data;

        }


        function fillSelect(select, regions, placeholder) {

            select.innerHTML = '';

            const firstOption = document.createElement('option');
            firstOption.value = '';
            firstOption.textContent = placeholder;

            select.appendChild(firstOption);

            regions.forEach(region => {

                const option = document.createElement('option');

                option.value = region.id;
                option.textContent = region.name;

                select.appendChild(option);

            });

            select.disabled = false;

        }


        function resetSelect(select, placeholder) {

            select.innerHTML = `<option value="">${placeholder}</option>`;
            select.disabled = true;

        }


        async function loadProvinces() {

            provinceSelect.innerHTML =
                '<option value="">Memuat provinsi...</option>';

            provinceSelect.disabled = true;

            try {

                const provinces = await getRegions(
                    `${regionApi}/provinces.json`
                );

                fillSelect(
                    provinceSelect,
                    provinces,
                    'Pilih Provinsi'
                );

            } catch (error) {

                console.error(error);

                provinceSelect.innerHTML =
                    '<option value="">Gagal memuat provinsi</option>';

            }

        }


        provinceSelect.addEventListener('change', async function () {

            resetSelect(regencySelect, 'Memuat Kabupaten / Kota...');
            resetSelect(districtSelect, 'Pilih Kecamatan');
            resetSelect(villageSelect, 'Pilih Desa / Kelurahan');

            if (!this.value) {

                resetSelect(regencySelect, 'Pilih Kabupaten / Kota');
                return;

            }

            try {

                const regencies = await getRegions(
                    `${regionApi}/regencies/${this.value}.json`
                );

                fillSelect(
                    regencySelect,
                    regencies,
                    'Pilih Kabupaten / Kota'
                );

            } catch (error) {

                console.error(error);

                resetSelect(regencySelect, 'Gagal memuat Kabupaten / Kota');

            }

        });


        regencySelect.addEventListener('change', async function () {

            resetSelect(districtSelect, 'Memuat Kecamatan...');
            resetSelect(villageSelect, 'Pilih Desa / Kelurahan');

            if (!this.value) {

                resetSelect(districtSelect, 'Pilih Kecamatan');
                return;

            }

            try {

                const districts = await getRegions(
                    `${regionApi}/districts/${this.value}.json`
                );

                fillSelect(
                    districtSelect,
                    districts,
                    'Pilih Kecamatan'
                );

            } catch (error) {

                console.error(error);

                resetSelect(districtSelect, 'Gagal memuat Kecamatan');

            }

        });


        districtSelect.addEventListener('change', async function () {

            resetSelect(villageSelect, 'Memuat Desa / Kelurahan...');

            if (!this.value) {

                resetSelect(villageSelect, 'Pilih Desa / Kelurahan');
                return;

            }

            try {

                const villages = await getRegions(
                    `${regionApi}/villages/${this.value}.json`
                );

                fillSelect(
                    villageSelect,
                    villages,
                    'Pilih Desa / Kelurahan'
                );

            } catch (error) {

                console.error(error);

                resetSelect(villageSelect, 'Gagal memuat Desa / Kelurahan');

            }

        });


        // PENCARIAN NAMA WILAYAH SAAT EDIT

        function normalizeName(value) {

            return value.toLowerCase()
                .replace(/^(kabupaten administrasi|kabupaten|kota administrasi|kota)\s+/i, '')
                .replace(/[^a-z0-9]/g, '');

        }


        function findRegion(regions, name) {

            const target = normalizeName(name);

            return regions.find(item => normalizeName(item.name) === target);

        }


        async function loadEditRegions(fullAddress) {

            const parts = fullAddress.split(',').map(item => item.trim());

            if (parts.length < 5) {

                addressInput.value = fullAddress;

                return;

            }

            const street = parts.slice(0, -4).join(', ');

            const villageName = parts[parts.length - 4];
            const districtName = parts[parts.length - 3];
            const regencyName = parts[parts.length - 2];
            const provinceName = parts[parts.length - 1];

            addressInput.value = street;

            // Ambil provinsi
            const provinces = await getRegions(
                `${regionApi}/provinces.json`
            );

            fillSelect(
                provinceSelect,
                provinces,
                'Pilih Provinsi'
            );

            const selectedProvince = findRegion(provinces, provinceName);

            if (!selectedProvince) return;

            provinceSelect.value = selectedProvince.id;


            // Ambil kabupaten
            const regencies = await getRegions(
                `${regionApi}/regencies/${selectedProvince.id}.json`
            );

            fillSelect(
                regencySelect,
                regencies,
                'Pilih Kabupaten / Kota'
            );

            const selectedRegency = findRegion(regencies, regencyName);

            if (!selectedRegency) return;

            regencySelect.value = selectedRegency.id;


            // Ambil kecamatan
            const districts = await getRegions(
                `${regionApi}/districts/${selectedRegency.id}.json`
            );

            fillSelect(
                districtSelect,
                districts,
                'Pilih Kecamatan'
            );

            const selectedDistrict = findRegion(districts, districtName);

            if (!selectedDistrict) return;

            districtSelect.value = selectedDistrict.id;


            // Ambil desa
            const villages = await getRegions(
                `${regionApi}/villages/${selectedDistrict.id}.json`
            );

            fillSelect(
                villageSelect,
                villages,
                'Pilih Desa / Kelurahan'
            );

            const selectedVillage = findRegion(villages, villageName);

            if (selectedVillage) {
                villageSelect.value = selectedVillage.id;
            }

        }


        // LEAFLET MAP

        let addressMap = null;
        let addressMarker = null;
        let placeLayer = null;
        let mapInitialized = false;


        // MENAMPILKAN TEMPAT DI SEKITAR LOKASI

        async function loadNearbyPlaces() {

            if (!addressMap) return;

            if (placeLayer) {
                addressMap.removeLayer(placeLayer);
            }

            placeLayer = L.layerGroup().addTo(addressMap);

            const center = addressMap.getCenter();

            const query = `
                [out:json][timeout:25];
                (
                    node(around:1000,${center.lat},${center.lng})["name"]["shop"];
                    way(around:1000,${center.lat},${center.lng})["name"]["shop"];

                    node(around:1000,${center.lat},${center.lng})["name"]["amenity"];
                    way(around:1000,${center.lat},${center.lng})["name"]["amenity"];

                    node(around:1000,${center.lat},${center.lng})["name"]["tourism"];
                    way(around:1000,${center.lat},${center.lng})["name"]["tourism"];
                );
                out center tags;
            `;

            try {

                const response = await fetch(
                    'https://overpass-api.de/api/interpreter',
                    {
                        method: 'POST',
                        body: new URLSearchParams({ data: query })
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal mengambil data tempat.');
                }

                const data = await response.json();

                data.elements.forEach(place => {

                    const lat = place.lat ?? place.center?.lat;
                    const lng = place.lon ?? place.center?.lon;

                    if (!lat || !lng) return;

                    const name = place.tags.name;
                    const category =
                        place.tags.shop ||
                        place.tags.amenity ||
                        place.tags.tourism ||
                        'Tempat umum';

                    L.marker([lat, lng])
                        .addTo(placeLayer)
                        .bindPopup(`
                            <strong>${name}</strong><br>
                            <small>${category}</small>
                        `);

                });

            } catch (error) {

                console.error('Gagal memuat tempat sekitar:', error);

            }
        }


        function initAddressMap() {
            const mapElement = document.getElementById('addressMap');

            if (!mapElement) return;

            const savedLat = parseFloat(latitudeInput.value);
            const savedLng = parseFloat(longitudeInput.value);

            const lat = Number.isFinite(savedLat) ? savedLat : -7.3881;
            const lng = Number.isFinite(savedLng) ? savedLng : 109.3636;

            if (!mapInitialized) {
                addressMap = L.map('addressMap').setView([lat, lng], 16);

                L.tileLayer(
                    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 19
                    }
                ).addTo(addressMap);

                addressMarker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(addressMap);

                addressMarker.on('dragend', function () {
                    const position = addressMarker.getLatLng();

                    latitudeInput.value = position.lat;
                    longitudeInput.value = position.lng;
                });

                addressMap.on('click', function (event) {
                    addressMarker.setLatLng(event.latlng);

                    latitudeInput.value = event.latlng.lat;
                    longitudeInput.value = event.latlng.lng;
                });

                mapInitialized = true;

                // Memuat patokan tempat di sekitar lokasi
                loadNearbyPlaces();
            } else {
                moveAddressMap(lat, lng);
            }

            setTimeout(function () {
                addressMap.invalidateSize();
            }, 300);
        }


        function moveAddressMap(lat, lng) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);

            if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                return;
            }

            if (addressMap && addressMarker) {
                addressMap.setView([lat, lng], 17);
                addressMarker.setLatLng([lat, lng]);

                setTimeout(function () {
                    addressMap.invalidateSize();
                }, 200);
            }

            latitudeInput.value = lat;
            longitudeInput.value = lng;

            // Muat ulang tempat di sekitar lokasi yang dipilih
            if (addressMap) {
                loadNearbyPlaces();
            }
        }


        // PENCARIAN LOKASI

        async function searchMapLocation() {
            const keyword = mapSearchInput.value.trim();

            if (!keyword) {
                alert('Masukkan nama lokasi terlebih dahulu.');
                return;
            }

            try {
                searchMapButton.disabled = true;
                searchMapButton.textContent = 'Mencari...';

                const response = await fetch(
                    'https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&countrycodes=id&q='
                    + encodeURIComponent(keyword)
                );

                if (!response.ok) {
                    throw new Error('Pencarian lokasi gagal.');
                }

                const results = await response.json();

                if (!results.length) {
                    alert('Lokasi tidak ditemukan.');
                    return;
                }

                const location = results[0];

                if (!mapInitialized) {
                    initAddressMap();
                }

                moveAddressMap(location.lat, location.lon);

            } catch (error) {
                console.error(error);
                alert('Pencarian lokasi gagal. Periksa koneksi internet.');
            } finally {
                searchMapButton.disabled = false;
                searchMapButton.innerHTML = '<i class="fas fa-search"></i>';
            }
        }

        searchMapButton?.addEventListener('click', searchMapLocation);

        mapSearchInput?.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchMapLocation();
            }
        });

    
        // MODE TAMBAH ALAMAT

        addButton?.addEventListener('click', async function () {

            form.reset();

            form.action = storeUrl;

            methodInput.disabled = true;

            modalTitle.textContent = 'Tambah Alamat Baru';

            provinceSelect.innerHTML =
                '<option value="">Pilih Provinsi</option>';

            resetSelect(regencySelect, 'Pilih Kabupaten / Kota');
            resetSelect(districtSelect, 'Pilih Kecamatan');
            resetSelect(villageSelect, 'Pilih Desa / Kelurahan');

            openModal();

                function openModal() {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';

                    setTimeout(function () {
                        initAddressMap();
                        addressMap.invalidateSize();
                    }, 300);
                }

            await loadProvinces();

            try {

                await initAddressMap();

            } catch (error) {

                console.error(error);

                alert('Peta gagal dimuat. Periksa API Key Google Maps.');

            }

        });


        // MODE EDIT ALAMAT

        document.querySelectorAll('.edit-address-button').forEach(button => {

            button.addEventListener('click', async function () {

                form.reset();

                modalTitle.textContent = 'Edit Alamat';

                form.action = this.dataset.updateUrl;

                methodInput.value = 'PATCH';
                methodInput.disabled = false;

                nameInput.value = this.dataset.name;
                phoneInput.value = this.dataset.phone;

                addressInput.value = this.dataset.address;

                postalInput.value = this.dataset.postalCode || '';

                defaultInput.checked =
                    this.dataset.isDefault === '1';

                latitudeInput.value = this.dataset.latitude || '';
                longitudeInput.value = this.dataset.longitude || '';

                mapSearchInput.value = '';

                openModal();

                try {

                    await loadEditRegions(this.dataset.address);

                    await initAddressMap();

                    moveAddressMap(
                        this.dataset.latitude,
                        this.dataset.longitude
                    );

                } catch (error) {

                    console.error(error);

                    alert('Data alamat gagal dimuat. Periksa koneksi internet.');

                }

            });

        });


        // GABUNGKAN ALAMAT SAAT DISIMPAN

        form.addEventListener('submit', function (event) {

            const provinceName =
                provinceSelect.selectedOptions[0]?.textContent;

            const regencyName =
                regencySelect.selectedOptions[0]?.textContent;

            const districtName =
                districtSelect.selectedOptions[0]?.textContent;

            const villageName =
                villageSelect.selectedOptions[0]?.textContent;

            const street = addressInput.value.trim();


            if (
                !provinceSelect.value ||
                !regencySelect.value ||
                !districtSelect.value ||
                !villageSelect.value
            ) {

                event.preventDefault();

                alert('Silakan pilih provinsi, kabupaten/kota, kecamatan, dan desa/kelurahan.');

                return;

            }


            if (!street) {

                event.preventDefault();

                alert('Nama jalan dan detail alamat harus diisi.');

                return;

            }


            addressInput.value =
                `${street}, ${villageName}, ${districtName}, ${regencyName}, ${provinceName}`;

        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const checkoutForm = document.querySelector('.checkout-form');
        const submitButton = document.getElementById('checkoutSubmitButton');

        if (!checkoutForm) return;

        checkoutForm.addEventListener('submit', async function (event) {

            const selectedPayment = document.querySelector(
                'input[name="payment_method"]:checked'
            );

            // Jika COD, biarkan proses seperti sebelumnya.
            if (!selectedPayment || selectedPayment.value === 'COD') {
                return;
            }

            // Cegah form berpindah halaman dan menampilkan JSON.
            event.preventDefault();

            const originalButton = submitButton.innerHTML;

            submitButton.disabled = true;
            submitButton.innerHTML = 'Memproses...';

            try {
                const response = await fetch(checkoutForm.action, {
                    method: 'POST',
                    body: new FormData(checkoutForm),
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message || 'Data pembayaran gagal diproses.'
                    );
                }

                // Tampilkan popup pembayaran.
            const walletLogos = {
                    DANA: "{{ asset('img/payment/dana.jpg') }}",
                    GoPay: "{{ asset('img/payment/gopay.png') }}",
                    OVO: "{{ asset('img/payment/ovo.jpg') }}"
                };

                const walletLogo = walletLogos[data.payment_method];

                const result = await Swal.fire({

                    html: `
                        <div style="text-align:center; padding:10px;">

                            <img src="${walletLogo}" alt="${data.payment_method}"
                                style="
                                    width:110px;
                                    height:65px;
                                    object-fit:contain;
                                    margin-bottom:15px
                            ">

                            <div style="
                                font-size:14px;
                                color:#777;
                                margin-bottom:5px;
                            ">
                                MATCHA MORI
                            </div>

                            <div style="font-size:13px;color:#777;">
                                Nomor Transaksi
                            </div>

                            <div style="font-weight:600;margin-bottom:20px;">
                                ${data.invoice}
                            </div>

                            <div style="font-size:13px;color:#777;">
                                Total Pembayaran
                            </div>

                            <div style="
                                font-size:27px;
                                font-weight:700;
                                color:#315b42;
                                margin-bottom:15px;
                            ">
                                ${data.formatted_total}
                            </div>

                            <div style="
                                background:#f0f6ef;
                                padding:12px;
                                border-radius:12px;
                                font-size:13px;
                                color:#49634e;
                            ">
                            </div>

                        </div>
                    `,

                    showCancelButton: true,
                    confirmButtonText: 'Bayar Sekarang',
                    cancelButtonText: 'Nanti',
                    confirmButtonColor: '#315b42',
                    cancelButtonColor: '#999',
                    reverseButtons: true
                });

                // Jika tombol Bayar Sekarang diklik.
                if (result.isConfirmed) {

                    const paymentResponse = await fetch(
                        @json(route('customer.checkout.simulate-payment')),
                        {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': checkoutForm.querySelector(
                                    'input[name="_token"]'
                                ).value,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({})
                        }
                    );

                    const paymentData = await paymentResponse.json();

                    if (!paymentResponse.ok || !paymentData.success) {
                        throw new Error(
                            paymentData.message || 'Pembayaran gagal diproses.'
                        );
                    }

                    window.location.href = paymentData.redirect;
                }

            } catch (error) {

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: error.message,
                    confirmButtonColor: '#315b42'
                });

            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButton;
            }

        });

    });
</script>


</body>
</html>