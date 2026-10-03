@extends('layouts.customers')

@section('title', 'Cart')

@push('styles')
    <link href="{{ asset('css/customer-cart.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="cart-page">
    <div class="cart-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span> &gt; </span>
        Cart
    </div>

    <h1 class="cart-title">
        Your Cart
    </h1>

    @if($cart && $cart->cartDetails->count() > 0)

        <label class="select-all">
            <input type="checkbox" id="selectAll">
            <span>Select All</span>
        </label>

        <div class="cart-layout">
            <div class="cart-items">

                @foreach($cart->cartDetails as $detail)

                    <div class="cart-item" data-subtotal="{{ $detail->subtotal }}">
                        <input type="checkbox" class="cart-check" value="{{ $detail->id }}">

                        <div class="cart-product-image">

                            @if($detail->product->image)
                                <img src="{{ asset('img/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">
                            @else
                                <i class="fas fa-leaf"></i>
                            @endif
                        </div>

                        <div class="cart-product-info">
                            <div class="cart-product-name">
                                {{ $detail->product->name }}
                            </div>

                            <div class="cart-product-price">
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="cart-quantity">

                            <form action="{{ route('customer.cart.update', $detail->id) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PATCH')

                                <div class="quantity-control">
                                    <button type="button" onclick="changeQuantity(this, -1)">
                                        −
                                    </button>

                                    <input type="number" name="quantity" class="quantity-input" value="{{ $detail->quantity }}" min="1" readonly>

                                    <button type="button" onclick="changeQuantity(this, 1)">
                                        +
                                    </button>
                                </div>

                            </form>

                        </div>

                        <div class="cart-item-subtotal">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>


                        <form action="{{ route('customer.cart.destroy', $detail->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-button" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </div>

                @endforeach

            </div>


            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>

                    <span id="cart-subtotal">
                        Rp 0
                    </span>
                </div>

                <div class="summary-total">
                    <span>Total</span>

                    <span id="cart-total">
                        Rp 0
                    </span>
                </div>

                <form action="{{ route('customer.checkout.index') }}" method="GET" id="checkout-form">

                    <div id="selected-items-container"></div>

                    <button type="submit" class="checkout-button">
                        <i class="fas fa-shopping-bag"></i>
                        Checkout
                    </button>

                </form>

            </div>

        </div>

    @else

        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your Cart is Empty</h3>

            <p>You haven't added any products to your cart yet.</p>

            <a href="{{ route('customer.products.index') }}" class="shop-now-btn">
                Shop Now
            </a>
        </div>

    @endif

</div>


<script>

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }


    function calculateSelectedTotal() {

        const cartItems = document.querySelectorAll('.cart-item');

        let total = 0;

        cartItems.forEach(function (item) {

            const checkbox = item.querySelector('.cart-check');

            if (checkbox.checked) {

                const subtotal = parseFloat(
                    item.dataset.subtotal
                );

                total += subtotal;
            }

        });

        document.getElementById('cart-subtotal').textContent =
            formatRupiah(total);

        document.getElementById('cart-total').textContent =
            formatRupiah(total);
    }


    function changeQuantity(button, amount) {

        const form = button.closest('.quantity-form');

        const input = form.querySelector('.quantity-input');

        let quantity = parseInt(input.value);

        quantity += amount;

        if (quantity < 1) {
            quantity = 1;
        }

        input.value = quantity;

        form.submit();
    }


    const selectAll = document.getElementById('selectAll');

    if (selectAll) {

        const checkboxes =
            document.querySelectorAll('.cart-check');


        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = selectAll.checked;

            });

            calculateSelectedTotal();

        });


        checkboxes.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const allChecked = [...checkboxes].every(
                    checkbox => checkbox.checked
                );

                selectAll.checked = allChecked;

                calculateSelectedTotal();

            });

        });

    }


    // Hitung total saat halaman pertama kali dibuka
    calculateSelectedTotal();
    const checkoutForm = document.getElementById('checkout-form');

    if (checkoutForm) {

        checkoutForm.addEventListener('submit', function (event) {

            const checkedItems = document.querySelectorAll('.cart-check:checked');

            // Jangan lanjut kalau belum memilih produk
            if (checkedItems.length === 0) {
                event.preventDefault();

                alert('Please select at least one product to checkout.');

                return;
            }

            const container = document.getElementById('selected-items-container');

            // Bersihkan input sebelumnya
            container.innerHTML = '';

            // Masukkan ID produk yang dipilih
            checkedItems.forEach(function (checkbox) {

                const input = document.createElement('input');

                input.type = 'hidden';
                input.name = 'selected_items[]';
                input.value = checkbox.value;

                container.appendChild(input);
            });

        });

    }
</script>

@endsection

