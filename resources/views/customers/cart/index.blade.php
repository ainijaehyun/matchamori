@extends('layouts.customers')

@section('title', 'Cart')

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

@push('styles')
<style>

    .cart-page {
        width: 100%;
        padding: 5px 28px 50px;
        box-sizing: border-box;
    }
    .cart-breadcrumb {
        width: 100%;
        background: #b8dfa5;
        padding: 7px 22px;
        border-radius: 5px;
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.10);
        font-size: 18px;
        color: #111;
        margin-bottom: 35px;
        box-sizing: border-box;
    }
    .cart-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .cart-breadcrumb a:hover {
        text-decoration: underline;
    }
    .cart-title {
        margin: 0 0 25px 28px;
        font-size: 28px;
        font-weight: 500;
        color: #111;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.15);
    }
    .select-all {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-left: 28px;
        margin-bottom: 18px;
        font-size: 18px;
        color: #111;
        cursor: pointer;
    }
    .select-all input {
        width: 24px;
        height: 24px;
        margin: 0;
        cursor: pointer;
        accent-color: #4f8f3a;
    }
    .cart-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 34px;
        align-items: start;
    }
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .cart-item {
        width: 100%;
        min-height: 205px;
        background: #ffffff;
        border-radius: 16px;
        display: grid;
        grid-template-columns:
            28px
            145px
            minmax(170px, 1fr)
            130px
            130px
            35px;
        align-items: center;
        gap: 18px;
        padding: 24px;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .cart-check {
        width: 23px;
        height: 23px;
        margin: 0;
        cursor: pointer;
        accent-color: #4f8f3a;
    }
    .cart-product-image {
        width: 145px;
        height: 145px;
        border-radius: 12px;
        overflow: hidden;
        background: #edf7e8;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-product-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }
    .cart-product-image i {
        font-size: 40px;
        color: #75a966;
    }
    .cart-product-info {
        min-width: 0;
    }
    .cart-product-name {
        font-size: 23px;
        font-weight: 500;
        color: #111;
        margin-bottom: 13px;
        line-height: 1.2;
    }
    .cart-product-price {
        font-size: 19px;
        font-weight: 700;
        color: #111;
    }
    .cart-quantity {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quantity-form {
        margin: 0;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        width: fit-content;
        background: #ffffff;
        border: 1px solid #999;
        overflow: hidden;
    }
    .quantity-control button {
        width: 43px;
        height: 44px;
        padding: 0;
        border: none;
        background: #ffffff;
        font-size: 23px;
        line-height: 1;
        cursor: pointer;
        transition: 0.2s ease;
    }
    .quantity-control button:hover {
        background: #edf7e8;
    }
    .quantity-control input {
        width: 43px;
        height: 44px;
        padding: 0;
        border: none;
        border-left: 1px solid #999;
        border-right: 1px solid #999;
        outline: none;
        text-align: center;
        font-size: 17px;
        background: #ffffff;
    }
    .cart-item-subtotal {
        font-size: 19px;
        font-weight: 700;
        color: #111;
        text-align: center;
        white-space: nowrap;
    }
    .delete-form {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .delete-button {
        border: none;
        background: transparent;
        padding: 5px;
        font-size: 21px;
        color: #111;
        cursor: pointer;
        transition: 0.2s ease;
    }
    .delete-button:hover {
        color: #a00000;
        transform: scale(1.08);
    }
    .cart-summary {
        width: 100%;
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 25px;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 18px;
        border-bottom: 1px solid #c9d9c3;
        font-size: 18px;
        font-weight: 600;
        color: #111;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 21px 0 18px;
        border-bottom: 1px solid #c9d9c3;
        font-size: 25px;
        font-weight: 700;
        color: #111;
    }
    .checkout-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 26px;
        padding: 13px 20px;
        box-sizing: border-box;
        background: #087a00;
        color: #ffffff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 17px;
        font-weight: 600;
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.18);
        transition: 0.2s ease;
    }
    .checkout-button:hover {
        background: #066300;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .checkout-button i {
        font-size: 16px;
    }
    .empty-cart {
        background: #ffffff;
        border-radius: 16px;
        padding: 70px 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .empty-cart i {
        font-size: 55px;
        color: #6fa85e;
        margin-bottom: 18px;
    }
    .empty-cart h3 {
        margin: 0 0 10px;
        font-size: 24px;
    }
    .empty-cart p {
        margin: 0 0 20px;
        color: #666;
        font-size: 16px;
    }
    .shop-now-btn {
        display: inline-block;
        padding: 11px 24px;
        background: #087a00;
        color: #ffffff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 16px;
    }
    .shop-now-btn:hover {
        background: #066300;
        color: #ffffff;
    }
    @media (max-width: 1100px) {

        .cart-item {
            grid-template-columns:
                28px
                120px
                minmax(150px, 1fr)
                110px
                110px
                30px;
            gap: 12px;
            padding: 20px;
        }
        .cart-product-image {
            width: 120px;
            height: 120px;
        }
        .cart-product-name {
            font-size: 20px;
        }
        .cart-item-subtotal {
            font-size: 17px;
        }
    }

    @media (max-width: 900px) {

        .cart-layout {
            grid-template-columns: 1fr;
        }
        .cart-summary {
            margin-top: 5px;
        }
    }

    @media (max-width: 650px) {

        .cart-page {
            padding-left: 15px;
            padding-right: 15px;
        }
        .cart-title {
            margin-left: 10px;
        }
        .select-all {
            margin-left: 10px;
        }
        .cart-item {
            grid-template-columns: 28px 90px 1fr;
            padding: 18px;
            gap: 12px;
        }
        .cart-product-image {
            width: 90px;
            height: 90px;
        }
        .cart-product-name {
            font-size: 18px;
        }
        .cart-product-price {
            font-size: 16px;
        }
        .cart-quantity,
        .cart-item-subtotal,
        .delete-form {
            grid-column: 3;
            justify-content: flex-start;
        }
        .cart-item-subtotal {
            text-align: left;
        }
    }
</style>
@endpush