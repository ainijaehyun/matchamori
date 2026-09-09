@extends('layouts.customers')

@section('title', 'View Category')

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

@push('styles')

<style>
    .category-page {
        width: 100%;
        min-height: calc(100vh - 100px);
        padding: 0 30px 50px;
    }
     .category-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 30px;
        background: #b9dda8;
        border-radius: 4px;
        font-family: Georgia, serif;
        font-size: 22px;
        box-shadow:
            0 2px 5px rgba(0, 0, 0, .18);
        box-sizing: border-box;
    }
    .category-breadcrumb a {
        color: #111;
        text-decoration: none;
    }
    .category-breadcrumb a:hover {
        color: #008000;
        text-decoration: underline;
    }
    .category-breadcrumb span {
        color: #111;
    }
    .category-heading {
        margin: 25px 0 40px;
        text-align: center;
        font-family: Georgia, serif;
        font-size: 25px;
        font-weight: normal;
        color: #111;
    }
    .view-category-grid {
        width: 560px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(2, 220px);
        column-gap: 100px;
        row-gap: 55px;
        justify-content: center;
    }
    .view-category-card {
        width: 180px;
        height: 200px;
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #fffed8;
        border: 1.5px solid #222;
        border-radius: 14px;
        color: #111;
        text-decoration: none;
        box-shadow:
            0 3px 5px rgba(0, 0, 0, .18);
        transition:
            .2s ease;
    }
    .view-category-card:hover {
        transform: translateY(-4px);
        box-shadow:
            0 6px 10px rgba(0, 0, 0, .22);
        text-decoration: none;
        color: #111;
    }
    .category-image-box {
        width: 160px;
        height: 135px;
        background: #b6dda4;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
        overflow: hidden;
        box-shadow:
            0 3px 5px rgba(0, 0, 0, .15);
    }
    .category-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }
    .category-fallback-icon {
        font-size: 65px;
        color: #000;
    }
    .category-card-name {
        font-family: Georgia, serif;
        font-size: 15px;
        text-align: center;
        margin-top: 2px;
        line-height: 1.3;
    }

    @media (max-width: 650px) {

        .category-page {
            padding: 0 15px 40px;
        }
        .category-breadcrumb {
            font-size: 18px;
        }
        .view-category-grid {
            width: 100%;
            grid-template-columns: 220px;
            row-gap: 30px;
        }

    }
</style>