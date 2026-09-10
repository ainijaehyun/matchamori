@extends('layouts.customers')

@section('title', 'View Product')

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

                        <div class="customer-product-rating">

                            <i class="fas fa-star"></i>
                            4,9

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

            @for(
                $page = 1;
                $page <= $products->lastPage();
                $page++
            )

                @if($page == $products->currentPage())

                    <span class="page-number active">
                        {{ $page }}
                    </span>

                @else

                    <ahref="{{ $products->url($page) }}" class="page-number">
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


@push('styles')

<style>
.product-page {
    width: 100%;
    min-height: calc(100vh - 100px);
    padding: 0 30px 50px;
}

.product-breadcrumb {
    width: 100%;
    padding: 7px 20px;
    margin-bottom: 45px;
    background: #b9dda8;
    border-radius: 4px;
    font-size: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .18);
}
.product-breadcrumb a {
    color: #111;
    text-decoration: none;
}
.product-breadcrumb a:hover {
    color: #111;
    text-decoration: underline;
}
.product-breadcrumb span {
    color: #111;
}
.product-toolbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 55px;
    margin-bottom: 45px;
}
.sort-box,
.filter-box {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}
.sort-box select,
.filter-box select {
    width: 190px;
    height: 34px;
    padding: 3px 10px;
    border: 1px solid #111;
    border-radius: 5px;
    background: white;
    font-family: Georgia, serif;
    font-size: 15px;
    cursor: pointer;
}
.customer-product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px 45px;
    padding: 0 10px;
    max-width: 1100px;
    margin: 0 auto;
}
.customer-product-card {
    width: 100%;
    background: white;
    border-radius: 13px;
    padding: 9px;
    color: #111;
    text-decoration: none;
    box-shadow: 2px 3px 6px rgba(0, 0, 0, .20);
    overflow: hidden;
    transition: .2s ease;
}
.customer-product-card:hover {
    transform: translateY(-4px);
    color: #111;
    text-decoration: none;
    box-shadow: 3px 6px 10px rgba(0, 0, 0, .23);
}
.customer-product-image {
    width: 100%;
    height: 220px;
    background: #b8dfa5;
    border-radius: 9px;
    overflow: hidden;
}
.customer-product-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
}
.customer-product-info {
    padding: 11px 3px 5px;
}
.customer-product-name {
    font-size: 16px;
    margin-bottom: 9px;
    min-height: 20px;
}
.customer-product-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.customer-product-price {
    font-size: 16px;
    font-weight: bold;
}
.customer-product-rating {
    font-size: 15px;
}
.customer-product-rating i {
    color: #f5a400;
    margin-right: 3px;
}
.product-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 50px;
}
.product-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 40px;
}
.page-number,
.page-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    color: #111;
    text-decoration: none;
    font-family: Georgia, serif;
    font-size: 15px;
    border-radius: 5px;
}
.page-number:hover,
.page-arrow:hover {
    background: #b8dfa5;
    color: #111;
    text-decoration: none;
}
.page-number.active {
    background: #008000;
    color: white;
}
.page-arrow {
    font-size: 24px;
}
.page-arrow.disabled {
    color: #aaa;
    cursor: default;
}
.page-arrow.disabled:hover {
    background: transparent;
}



@media (max-width: 1000px) {

    .customer-product-grid {
        gap: 40px 25px;
    }
    .product-toolbar {
        gap: 25px;
    }
    .sort-box select,
    .filter-box select {
        width: 160px;
    }

}


@media (max-width: 1000px) {

    .customer-product-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 35px 25px;
    }

}

@media (max-width: 750px) {

    .customer-product-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px 20px;
    }

}


@media (max-width: 500px) {

    .product-page {
        padding: 0 15px 40px;
    }
    .product-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }
    .customer-product-grid {
        grid-template-columns: 1fr;
    }

}

</style>

@endpush