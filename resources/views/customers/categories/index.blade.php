@extends('layouts.customers')

@section('title', 'Category')

@push('styles')
    <link href="{{ asset('css/customer-category.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="category-page">

    {{-- Breadcrumb --}}
    <div class="category-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">Home</a>
        <span>&gt;</span>
        Category
    </div>

    {{-- Heading --}}
    <div class="category-heading">
        <p class="category-small-title">MATCHA MORI</p>

        <h1>Our Categories</h1>

        <p class="category-description">
            Explore our selection of Japanese matcha and tea products.
        </p>
    </div>

    {{-- Category --}}
    <div class="category-grid">

        @forelse($categories as $category)

            @php
                $categoryImages = [
                    'Matcha Drink' => 'categories/matcha-drink.jpg',
                    'Matcha Dessert' => 'categories/matcha-dessert.jpg',
                    'Matcha Powder' => 'categories/matcha-powder.jpg',
                    'Accessories' => 'categories/accessories.jpg',
                ];

                $image = $categoryImages[$category->name] ?? null;
            @endphp

            <a href="{{ route('customer.products.index', ['category_id' => $category->id]) }}"
               class="category-card">

                <div class="category-image">

                    @if($image)
                        <img
                            src="{{ asset('img/' . $image) }}"
                            alt="{{ $category->name }}"
                        >
                    @else
                        <i class="fas fa-leaf category-fallback-icon"></i>
                    @endif

                </div>

                <div class="category-info">

                    <h2>{{ $category->name }}</h2>

                    <span>
                        Explore
                        <i class="fas fa-arrow-right"></i>
                    </span>

                </div>

            </a>

        @empty

            <div class="category-empty">

                <i class="fas fa-leaf"></i>

                <h2>No Category Available</h2>

                <p>
                    There are currently no categories available.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection