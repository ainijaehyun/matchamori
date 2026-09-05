@extends('layouts.app')

@section('title', 'Edit Product')

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
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
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


<style>

    .product-edit-page {
        padding: 10px 20px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }

    .product-edit-card {
        width: 50%;
        max-width: 800px;
        background: #ffffff;
        border-radius: 12px;
        padding: 15px 22px 22px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.10);
        box-sizing: border-box;
    }
    .product-edit-title {
        font-family: Georgia, serif;
        font-size: 21px;
        color: #111;
        margin-bottom: 15px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .form-group label {
        display: block;
        font-family: Georgia, serif;
        font-size: 15px;
        color: #111;
        margin-bottom: 4px;
    }
    .input-wrapper {
        position: relative;
        width: 100%;
    }
    .input-wrapper i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #111;
        z-index: 1;
    }
    .input-wrapper input,
    .input-wrapper textarea,
    .input-wrapper select {
        width: 100%;
        box-sizing: border-box;
        border: none;
        outline: none;
        background: #eeeeee;
        border-radius: 6px;
        padding: 6px 10px 6px 40px;
        font-size: 12px;
        color: #111;
        box-shadow: 0 1px 4px rgba(0,0,0,0.12);
    }
    .input-wrapper input,
    .input-wrapper select {
        height: 31px;
    }
    .input-wrapper textarea {
        height: 42px;
        resize: vertical;
        padding-top: 13px;
    }
    .textarea-wrapper i {
        top: 14px;
        transform: none;
    }
    .input-wrapper input:focus,
    .input-wrapper textarea:focus,
    .input-wrapper select:focus {
        box-shadow: 0 0 0 2px #b9df9f;
    }
    .description-group {
        margin-top: 14px;
        margin-bottom: 14px;
    }
    .price-stock-row {
        gap: 18px;
    }
    .image-form-group {
        margin-top: 12px;
    }
    .image-upload-box {
        width: 190px;
        height: 130px;
        background: #eeeeee;
        border-radius: 13px;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .image-upload-box i {
        font-size: 32px;
        color: #70c477;
        margin-bottom: 4px;
    }
    .image-upload-box span {
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #666;
    }
    .image-upload-box:hover {
        background: #e7e7e7;
    }
    .image-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 13px;
    }
    .form-buttons {
        display: flex;
        gap: 25px;
        margin-top: 18px;
    }
    .btn-save,
    .btn-cancel {
        width: 180px;
        height: 34px;
        border-radius: 17px;
        font-size: 16px;
        font-family: Georgia, serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-sizing: border-box;
    }
    .btn-save {
        border: none;
        background: #008000;
        color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
    .btn-save:hover {
        background: #006b00;
        color: white;
    }
    .btn-cancel {
        background: #eeeeee;
        border: 1px solid #777;
        color: #008000;
    }
    .btn-cancel:hover {
        background: #dddddd;
        color: #006b00;
        text-decoration: none;
    }
    .invalid-feedback {
        font-size: 11px;
        margin-top: 3px;
    }

    @media(max-width:768px) {

        .product-edit-page {
            padding: 15px;
        }
        .product-edit-card {
            width: 100%;
            padding: 15px;
        }
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .image-upload-box {
            width: 100%;
            height: 180px;
        }
        .form-buttons {
            flex-direction: column;
            gap: 10px;
        }
        .btn-save,
        .btn-cancel {
            width: 100%;
        }

    }

</style>