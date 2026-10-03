@extends('layouts.app')

@section('title', 'Show Category')

@push('styles')
    <link href="{{ asset('css/category.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="category-show-page">
    <h1 class="category-show-title">Category Detail</h1>
    <div class="category-detail-card">
    
        <div class="detail-row">
            <div class="detail-label">
                Category Name
            </div>

            <div class="detail-value">
                {{ $category->name }}
            </div>
        </div>


        <div class="detail-row description-row">
            <div class="detail-label">
                Description
            </div>

            <div class="detail-value description-value">
                {{ $category->description ?? '-' }}
            </div>
        </div>


        <div class="detail-row image-row">
            <div class="detail-label">
                Image
            </div>

            <div class="detail-value">
                @if($category->image)
                    <img src="{{ asset('img/' . $category->image) }}" alt="{{ $category->name }}" class="category-detail-image">
                @else
                    <span>-</span>
                @endif
            </div>
        </div>


        <div class="detail-row date-row">
            <div class="detail-label">
                Create at
            </div>

            <div class="detail-value">
                {{ $category->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Update at
            </div>

            <div class="detail-value">
                {{ $category->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>

    </div>



    <div class="form-buttons">
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            Back
        </a>
    </div>

</div>

@endsection

