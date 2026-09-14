@extends('layouts.customers')

@section('title', 'Dashboard Customer')

@section('content')

    <div class="customer-hero">

        {{-- foto navbar --}}
        <div class="hero-picture">
            <img src="{{ asset('img/matchaaaaaaa.png') }}" alt="Matcha Mori">
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
<section class="customer-section" >

    <div class="customer-section-heading">

        <h2 class="customer-section-title">Shop by Category</h2>

        <a href="{{ route('customer.categories.index') }}" class="see-all-link">
            See All
        </a>
    </div>
    
    <div class="category-grid">

        @foreach($categories as $category)

            <a href="{{ route('customer.products.index', ['category_id' => $category->id]) }}"
               class="category-card">

                <div class="category-image">
                    @if($category->image)
                        <img src="{{ asset('img/' . $category->image) }}" alt="{{ $category->name }}">
                    @else
                        <i class="fas fa-leaf"></i>
                    @endif
                </div>

                <div class="category-name">
                    {{ $category->name }}
                </div>

            </a>

        @endforeach

        </div>

    </section>


    {{-- best seller --}}

    <section class="customer-section best-seller-section">
        <div class="customer-section-heading">
            <div>
                <h2 class="customer-section-title">
                    Best Seller
                </h2>
            </div>
            <p class="best-seller-subtitle">
                Best Seller at Matcha Mori
            </p>
        </div>
        
        <div class="best-seller-grid">

            @forelse($bestSellers as $product)

                <a href="{{ route('customer.products.show', $product->id) }}" class="best-seller-card">

                    <div class="best-seller-image">

                        @if($product->image)

                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">

                        @else

                            <i class="fas fa-leaf product-icon"></i>

                        @endif

                    </div>


                    <div class="best-seller-info">

                        <h3 class="best-seller-name">
                            {{ $product->name }}
                        </h3>
                        <p class="best-seller-description">
                            {{ $product->description }}
                        </p>

                        <div class="best-seller-bottom">
                            <div>
                                <div class="best-seller-price">
                                    Rp. {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <div class="best-seller-meta">
                                    <span class="stock">
                                        Stock {{ $product->stock }}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </a>

            @empty
                <p class="empty-best-seller">
                    Belum ada produk pilihan
                </p>
            @endforelse
        </div>
    </section>

@endsection
