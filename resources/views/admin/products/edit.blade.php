@extends('layouts.app')

@section('title', 'Edit Product')

@push('styles')
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="product-edit-page">
    <div class="product-edit-card">
        <h1 class="product-edit-title">Edit Product</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">

                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-cube"></i>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                    </div>

                    @error('name')
                        <span class="invalid-feedback d-block">
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
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    @error('category_id')
                        <span class="invalid-feedback d-block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

            </div>

            <div class="form-group description-group">
                <label for="description">Description</label>
                <div class="input-wrapper textarea-wrapper">
                    <i class="fas fa-file-alt"></i>
                    <textarea id="description" name="description" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                </div>

                @error('description')
                    <span class="invalid-feedback d-block">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-row price-stock-row">
                <div class="form-group">
                    <label for="price">Price</label>
                    <div class="input-wrapper">
                        <i class="fas fa-tag"></i>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="Enter price" min="0">
                    </div>

                    @error('price')
                        <span class="invalid-feedback d-block">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group">
                    <label for="stock">Stock</label>
                    <div class="input-wrapper">
                        <i class="fas fa-box-open"></i>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Enter stock" min="0">
                    </div>

                    @error('stock')
                        <span class="invalid-feedback d-block">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

            <div class="form-group image-form-group">
                <label for="image">Image</label>
                <label for="image" class="image-upload-box" id="image-preview">
                    @if($product->image)
                        <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-plus"></i>
                        <span>Choose Image</span>
                    @endif
                </label>

                <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" hidden>

                @error('image')
                    <span class="invalid-feedback d-block">
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

