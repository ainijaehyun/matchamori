@extends('layouts.customers')

@section('title', 'View Product')

@push('styles')
    <link href="{{ asset('css/customer-product.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="product-page">
    <div class="product-breadcrumb">

        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>

        <span>
            &gt; Product
        </span>

    </div>


    <div class="product-toolbar">

        <form action="{{ route('customer.products.index') }}" method="GET" class="sort-box">

            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            <span>Sort By</span>
            <select name="sort" onchange="this.form.submit()">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                    Latest
                </option>

                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                    Price: Low to High
                </option>

                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                    Price: High to Low
                </option>

                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                    Name: A-Z
                </option>
            </select>
        </form>

        <form action="{{ route('customer.products.index') }}" method="GET" class="filter-box">

            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <span>Filter</span>
            <select name="category_id" onchange="this.form.submit()">

                <option value="">
                    All Category
                </option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>
        </form>
    </div>

    <div class="customer-product-grid">

        @forelse($products as $product)

            <a href="{{ route('customer.products.show', $product->id) }}" class="customer-product-card">

                <div class="customer-product-image">

                    @if($product->image)
                        <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-leaf"></i>
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

        @empty

            <div class="product-empty">
                Belum ada produk.
            </div>

        @endforelse

    </div>

    @if($products->hasPages())
        <div class="product-pagination">
            @if($products->onFirstPage())
                <span class="page-arrow disabled">
                    ‹
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="page-arrow">
                    ‹
                </a>
            @endif

            @for($page = 1; $page <= $products->lastPage();$page++)
 
                @if($page == $products->currentPage())

                    <span class="page-number active">
                        {{ $page }}
                    </span>

                @else

                    <a href="{{ $products->url($page) }}" class="page-number">
                        {{ $page }}
                    </a>

                @endif

            @endfor


            @if($products->hasMorePages())

                <a href="{{ $products->nextPageUrl() }}" class="page-arrow">
                    ›
                </a>

            @else

                <span class="page-arrow disabled">
                    ›
                </span>

            @endif

        </div>

    @endif

</div>

@endsection

