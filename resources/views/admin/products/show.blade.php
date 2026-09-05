@extends('layouts.app')

@section('title', 'Show Product')

@section('content')

<div class="product-show-page">
    <h1 class="product-show-title">Product Detail</h1>
    <div class="product-detail-card">

        <div class="detail-row">
            <div class="detail-label">Product Name</div>
            <div class="detail-value">{{ $product->name }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Category</div>
            <div class="detail-value">{{ $product->category->name ?? '-' }}</div>
        </div>

        <div class="detail-row description-row">
            <div class="detail-label">Description</div>
            <div class="detail-value description-value">{{ $product->description ?? '-' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Price</div>
            <div class="detail-value">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Stock</div>
            <div class="detail-value">{{ $product->stock}}</div>
        </div>

        <div class="detail-row image-row">
            <div class="detail-label">Image</div>
            <div class="detail-value">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-detail-image">
                @else
                    <span>-</span>
                @endif
            </div>
        </div>

        <div class="detail-row date-row">
            <div class="detail-label">Create at</div>
            <div class="detail-value">
                {{ $product->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>
        <div class="detail-row date-row">
            <div class="detail-label">Update at</div>
            <div class="detail-value">
                {{ $product->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>
    </div>

    <div class="form-buttons">
        <a href="{{ route('admin.products.index') }}" class="btn-back">
            Back
        </a>
    </div>
</div>
@endsection

<style>
    .product-show-page {
        padding: 10px 30px 25px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .product-show-title {
        font-family: Georgia, serif;
        font-size: 22px;
        font-weight: normal;
        color: #111;
        margin: 15px 0 18px;
    }
    .product-detail-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 20px 24px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
        max-width: 65%;
    }
    .detail-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        column-gap: 10px;
        align-items: start;
        margin-bottom: 13px;
    }
    .detail-row:last-child {
        margin-bottom: 0;
    }
    .detail-label {
        font-family: Georgia, serif;
        font-size: 17px;
        color: #111;
        line-height: 1.35;
    }
    .detail-value {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #111;
        line-height: 1.35;
    }
    .description-row {
        margin-top: 2px;
        margin-bottom: 15px;
    }
    .description-value {
        max-width: 380px;
        text-align: left;
    }
    .image-row {
        margin-bottom: 15px;
    }
    .product-detail-image {
        display: block;
        width: 105px;
        height: 82px;
        object-fit: contain;
        background: #eeeeee;
        border-radius: 11px;
        padding: 5px;
        box-sizing: border-box;
        box-shadow: 0 2px 5px rgba(0,0,0,0.12);
    }
    .date-row {
        margin-top: 2px;
    }
    .form-buttons {
        display: flex;
        margin-top: 18px;
    }
    .btn-back {
        width: 15%;
        height: 40px;
        border-radius: 18px;
        background: #008000;
        color: white;
        font-family: Georgia, serif;
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 3px 6px rgba(0,0,0,0.18);
        box-sizing: border-box;
    }
    .btn-back:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .product-show-page {
            padding: 15px 15px 25px;
        }
        .product-show-title {
            font-size: 21px;
            margin-bottom: 17px;
        }
        .product-detail-card {
            border-radius: 20px;
            padding: 20px 18px;
            max-width: 100%;
        }
        .detail-row {
            grid-template-columns: 1fr;
            row-gap: 4px;
            margin-bottom: 16px;
        }
        .detail-label {
            font-size: 17px;
        }
        .detail-value {
            font-size: 14px;
        }
        .product-detail-image {
            width: 105px;
            height: 82px;
        }
        .btn-back {
            width: 100%;
            height: 42px;
        }

    }
</style>