@extends('layouts.customers')

@section('title', 'Checkout')

@push('styles')
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="checkout-page">

    <div class="checkout-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">Home</a>
        <span> &gt; </span>
        <a href="{{ route('customer.cart.index') }}">Cart</a>
        <span> &gt; </span>
        Checkout
    </div>

    <h1 class="checkout-title">Checkout</h1>

    <form action="{{ route('customer.checkout.store') }}" method="POST" class="checkout-form">

        @csrf

        <div class="checkout-main">
            <div class="checkout-left">
                {{-- ALAMAT --}}
                <div class="checkout-card">

                    <h2>Alamat Pengiriman</h2>

                    <div class="shipping-fields">
                        <div class="checkout-field">
                            <label for="name">Full Name</label>

                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="checkout-field">
                            <label for="phone">Phone Number</label>

                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>

                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="checkout-field full">
                            <label for="address">Address</label>

                            <textarea id="address" name="address" rows="3" required>{{ old('address')}}</textarea>

                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="checkout-field">
                            <label for="postal_code">Postal Code</label>

                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>

                            @error('postal_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                </div>


                {{-- COURIER --}}
                <div class="checkout-card">

                    <h2>Courier</h2>

                    <div class="custom-select" id="courier-select">

                        <div class="custom-select-selected">
                            <div class="selected-courier">
                                <i class="fas fa-motorcycle"></i>
                                <span>Select Courier</span>
                            </div>

                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="custom-select-options">

                            <div class="custom-select-option" data-value="GrabExpress">
                                <img src="{{ asset('img/grab.png') }}" alt="GrabExpress">
                                <span>GrabExpress</span>

                            </div>

                            <div class="custom-select-option" data-value="GoSend">
                                <img src="{{ asset('img/gosend.png') }}" alt="GoSend">
                                <span>GoSend</span>

                            </div>

                        </div>

                        <input type="hidden" name="courier" id="courier">

                    </div>

                    @error('courier')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>


                {{-- DELIVERY SERVICE --}}
                <div class="checkout-card">

                    <h2>Delivery Service</h2>

                    <div class="custom-select" id="delivery-select">

                        <div class="custom-select-selected">

                            <div class="selected-courier">
                                <i class="fas fa-truck"></i>
                                <span>Select Delivery Service</span>
                            </div>

                            <i class="fas fa-chevron-down"></i>

                        </div>

                        <div class="custom-select-options">

                            <div class="custom-select-option"
                                data-value="Instant">

                                <img src="{{ asset('img/instant.png') }}" alt="Instant">

                                <span>Instant</span>

                            </div>

                            <div class="custom-select-option"
                                data-value="Same Day">

                                <img src="{{ asset('img/sameday.webp') }}" alt="sameday">

                                <span>Same Day</span>

                            </div>

                        </div>

                        <input type="hidden" name="delivery_service" id="delivery_service">

                    </div>

                    @error('delivery_service')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="checkout-card payment-card">

                    <h2>Metode Pembayaran</h2>

                    <label class="checkout-payment-option">

                        <input type="radio" name="payment_method" value="COD" checked required>

                        <div>

                            <strong>Cash on Delivery (COD)</strong>

                            <span>
                                Bayar di tempat saat pesanan diterima
                            </span>

                        </div>

                    </label>

                </div>

            </div>


            <div class="checkout-right">
                <div class="checkout-card order-summary">

                    <h2>Ringkasan Pesanan</h2>

                    @foreach($selectedItems as $item)

                        <div class="checkout-summary-item">

                            <div class="summary-product-name">
                                {{ $item->product->name }}
                            </div>

                            <div class="summary-product-quantity">
                                x{{ $item->quantity }}
                            </div>

                            <div class="summary-product-price">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>

                        </div>

                    @endforeach


                    <div class="checkout-summary-subtotal">
                        <span>Subtotal</span>

                        <span>
                            Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                        </span>
                    </div>


                    <div class="checkout-summary-total">
                        <span>Total</span>

                        <span>
                            Rp {{ number_format($checkoutTotal, 0, ',', '.') }}
                        </span>
                    </div>

                </div>


                {{-- BUTTON --}}
                <button type="submit" class="checkout-submit-button">
                    Continue to Confirmation
                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const dropdowns = document.querySelectorAll('.custom-select');

        dropdowns.forEach(function (dropdown) {

            const selected = dropdown.querySelector('.custom-select-selected');
            const options = dropdown.querySelectorAll('.custom-select-option');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            const selectedText = selected.querySelector('span');

            selected.addEventListener('click', function (event) {

                event.stopPropagation();

                dropdowns.forEach(function (otherDropdown) {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove('open');
                    }
                });

                dropdown.classList.toggle('open');
            });


            options.forEach(function (option) {

                option.addEventListener('click', function (event) {

                    event.stopPropagation();

                    const value = option.dataset.value;
                    const text = option.querySelector('span').textContent.trim();

                    // Isi hidden input
                    hiddenInput.value = value;

                    // Ubah tulisan pilihan
                    selectedText.textContent = text;

                    // Ambil gambar dari pilihan
                    const optionImage = option.querySelector('img');

                    // Cari gambar/icon di bagian selected
                    const selectedImage = selected.querySelector('.selected-courier img');
                    const selectedIcon = selected.querySelector('.selected-courier i');

                    if (optionImage) {

                        // Kalau pilihan menggunakan gambar
                        if (selectedImage) {
                            selectedImage.src = optionImage.src;
                            selectedImage.alt = optionImage.alt;
                        } 
                        
                        // Kalau bagian selected masih menggunakan icon
                        else if (selectedIcon) {
                            const newImage = document.createElement('img');

                            newImage.src = optionImage.src;
                            newImage.alt = optionImage.alt;
                            newImage.style.width = '22px';
                            newImage.style.height = '22px';
                            newImage.style.objectFit = 'contain';

                            selectedIcon.replaceWith(newImage);
                        }

                    }

                    dropdown.classList.remove('open');
                });

            });

        });


        // Klik di luar dropdown → tutup
        document.addEventListener('click', function () {

            dropdowns.forEach(function (dropdown) {
                dropdown.classList.remove('open');
            });

        });


        // Pastikan sebelum submit nilainya ada
        const checkoutForm = document.querySelector('.checkout-form');

        checkoutForm.addEventListener('submit', function (event) {

            const courier = document.querySelector('#courier').value;
            const deliveryService = document.querySelector('#delivery_service').value;

            if (!courier) {
                event.preventDefault();
                alert('Please select a Courier.');
                return;
            }

            if (!deliveryService) {
                event.preventDefault();
                alert('Please select a Delivery Service.');
                return;
            }

        });

    });
</script>

@endpush