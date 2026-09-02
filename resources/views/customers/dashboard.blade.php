@extends('layouts.customers')

@section('title', 'Dashboard Customer')

@section('content')

    <div class="customer-hero">

        {{-- foto navbar --}}
        <div class="hero-picture">
            <img src="{{ asset('img/matcha1.jpg') }}" alt="Matcha Mori">
        </div>

        <div class="hero-text">
            <div class="hero-greeting">
                Hi, {{ Auth::user()->name }}!<br>
                Welcome to Matcha Mori
            </div>

            <h1 class="hero-title">
                Pure Matcha<br>
                Pure You.
            </h1>

            <p class="hero-description">
                Discover authentic Japanese<br>
                matcha for your daily wellness.
            </p>

        </div>

    </div>


    {{-- caetegory --}}

    <section class="customer-section" id="categories">

        <h2 class="customer-section-title">
            Shop by Category
        </h2>

        <div class="category-grid">

            <div class="category-card">

                <div class="category-icon">
                    <i class="fas fa-glass-martini-alt"></i>
                </div>

                <div class="category-name">
                    Matcha Drink
                </div>

            </div>


            <div class="category-card">

                <div class="category-icon">
                    <i class="fas fa-layer-group"></i>
                </div>

                <div class="category-name">
                    Matcha Dessert
                </div>

            </div>


            <div class="category-card">

                <div class="category-icon">
                    <i class="fas fa-prescription-bottle"></i>
                </div>

                <div class="category-name">
                    Matcha Powder
                </div>

            </div>


            <div class="category-card">

                <div class="category-icon">
                    <i class="fas fa-briefcase"></i>
                </div>

                <div class="category-name">
                    Accessories
                </div>

            </div>

        </div>

    </section>


    {{-- best seller --}}

    <section class="customer-section">

        <h2 class="customer-section-title">
            Best Seller
        </h2>

        <div class="product-grid">

            @forelse($bestSellers as $product)

                <div class="product-card">

                    <div class="product-image">

                        @if($product->image)

                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}">

                        @else

                            <i class="fas fa-leaf product-icon"></i>

                        @endif

                    </div>


                    <div class="product-info">

                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        <div class="product-bottom">

                            <div class="product-price">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <div class="product-rating">

                                <i class="fas fa-star"></i>

                                4,9

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div style="grid-column: 1 / -1; text-align: center;">
                    Belum ada produk best seller.
                </div>

            @endforelse

        </div>

    </section>

@endsection