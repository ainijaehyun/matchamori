@extends('layouts.app')

@section('title', 'Show Product')

@push('styles')
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
@endpush 

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
                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="product-detail-image">
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


