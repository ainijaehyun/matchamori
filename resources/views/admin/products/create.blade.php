@extends('layouts.app')

@section('title', 'Create Product')

@push('styles')
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="product-create-page">
    <div class="product-create-card">
        <h1 class="product-create-title">Create Product</h1>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">

                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-cube"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name">
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <div class="input-wrapper">
                        <i class="fas fa-th-large"></i>
                        <select id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <span class="invalid-feedback d-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group description-group">
                <label for="description">Description</label>
                <div class="input-wrapper textarea-wrapper">
                    <i class="fas fa-file-alt"></i>
                    <textarea id="description" name="description" placeholder="Enter product description">{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <span class="invalid-feedback d-block" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-row price-stock-row">

                <div class="form-group">
                    <label for="price">Price</label>
                    <div class="input-wrapper">
                        <i class="fas fa-tag"></i>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="Enter price" min="0">
                    </div>
                    @error('price')
                        <span class="invalid-feedback d-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <div class="input-wrapper">
                        <i class="fas fa-box-open"></i>
                        <input type="number" id="stock" name="stock" value="{{ old('stock') }}" placeholder="Enter stock" min="0">
                    </div>
                    @error('stock')
                        <span class="invalid-feedback d-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group image-form-group">
                <label for="image">Image</label>
                <label for="image" class="image-upload-box" id="image-preview">
                    <i class="fas fa-plus"></i>
                    <span>Choose Image</span>
                </label>
                <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" hidden>
                @error('image')
                    <span class="invalid-feedback d-block" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-save">
                    Save
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(event) {

        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');

        if (file) {
            const imageUrl = URL.createObjectURL(file);

            preview.innerHTML = `
                <img src="${imageUrl}" alt="Preview Image">
            `;
        }
    });
</script>
@endsection



