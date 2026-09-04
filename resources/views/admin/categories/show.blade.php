@extends('layouts.app')

@section('title', 'Show Category')

@section('content')

<div class="category-show-page">

    <h1 class="category-show-title">Category Detail</h1>

    <div class="category-detail-card">

        {{-- Category Name --}}
        <div class="detail-row">
            <div class="detail-label">
                Category Name
            </div>

            <div class="detail-value">
                {{ $category->name }}
            </div>
        </div>


        {{-- Description --}}
        <div class="detail-row description-row">
            <div class="detail-label">
                Description
            </div>

            <div class="detail-value description-value">
                {{ $category->description ?? '-' }}
            </div>
        </div>


        {{-- Image --}}
        <div class="detail-row image-row">
            <div class="detail-label">
                Image
            </div>

            <div class="detail-value">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-detail-image">
                @else
                    <span>-</span>
                @endif
            </div>
        </div>


        {{-- Created At --}}
        <div class="detail-row date-row">
            <div class="detail-label">
                Create at
            </div>

            <div class="detail-value">
                {{ $category->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>


        {{-- Updated At --}}
        <div class="detail-row">
            <div class="detail-label">
                Update at
            </div>

            <div class="detail-value">
                {{ $category->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>

    </div>


    {{-- Back Button --}}
    <div class="form-buttons">
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            Back
        </a>
    </div>

</div>

@endsection


<style>

    .category-show-page {
        padding: 12px 40px 30px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .category-show-title {
        font-family: Georgia, serif;
        font-size: 24px;
        font-weight: normal;
        color: #111;
        margin: 18px 0 25px;
    }
    .category-detail-card {
        background: #ffffff;
        border-radius: 32px;
        padding: 28px 30px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
        max-width: 760px;
    }
    .detail-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        column-gap: 12px;
        align-items: start;
        margin-bottom: 18px;
    }
    .detail-row:last-child {
        margin-bottom: 0;
    }
    .detail-label {
        font-family: Georgia, serif;
        font-size: 19px;
        color: #111;
        line-height: 1.4;
    }
    .detail-value {
        font-family: Arial, sans-serif;
        font-size: 16px;
        color: #111;
        line-height: 1.4;
    }
    .description-row {
        margin-top: 5px;
        margin-bottom: 20px;
    }
    .description-value {
        max-width: 450px;
    }
    .image-row {
        margin-bottom: 20px;
    }
    .category-detail-image {
        display: block;
        width: 125px;
        height: 100px;
        object-fit: contain;
        background: #eeeeee;
        border-radius: 13px;
        padding: 6px;
        box-sizing: border-box;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.12);
    }
    .date-row {
        margin-top: 2px;
    }
    .form-buttons {
        display: flex;
        margin-top: 25px;
    }
    .btn-back {
        width: 180px;
        height: 48px;
        border-radius: 20px;
        background: #008000;
        color: white;
        font-family: Georgia, serif;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
        box-sizing: border-box;
    }
    .btn-back:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }


    @media (max-width: 768px) {

        .category-show-page {
            padding: 20px 15px 30px;
        }
        .category-show-title {
            font-size: 23px;
            margin-bottom: 20px;
        }
        .category-detail-card {
            border-radius: 24px;
            padding: 23px 20px;
        }
        .detail-row {
            grid-template-columns: 1fr;
            row-gap: 6px;
            margin-bottom: 20px;
        }
        .detail-label {
            font-size: 18px;
        }
        .detail-value {
            font-size: 15px;
        }
        .category-detail-image {
            width: 120px;
            height: 95px;
        }
        .btn-back {
            width: 100%;
            height: 48px;
        }
    }

</style>