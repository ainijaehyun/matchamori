@extends('layouts.customers')

@section('title', 'View Category')

@push('styles')
    <link href="{{ asset('css/customer-category.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="category-page">
    <div class="category-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        <span>&gt;</span> Category
    </div>

    <h2 class="category-heading">
        All Category
    </h2>

    <div class="view-category-grid">
        @foreach($categories as $category)

            @php
                $categoryName = strtolower($category->name);

                if ($categoryName == 'matcha drink') {
                    $icon = 'fas fa-glass-martini-alt';
                } elseif ($categoryName == 'matcha dessert') {
                    $icon = 'fas fa-birthday-cake';
                } elseif ($categoryName == 'matcha powder') {
                    $icon = 'fas fa-prescription-bottle';
                } elseif ($categoryName == 'accessories') {
                    $icon = 'fas fa-gift';
                } else {
                    $icon = 'fas fa-leaf';
                }
            @endphp

            <a href="{{ route('customer.products.index', ['category_id' => $category->id]) }}" class="view-category-card">

                <div class="category-image-box">
                    @if($category->image)
                        <img src="{{ asset('img/' . $category->image) }}" alt="{{ $category->image }}" class="category-image">
                    @else
                        <i class="{{ $icon }} category-fallback-icon"></i>
                    @endif
                </div>

                <div class="category-card-name">
                    {{ $category->name }}
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

