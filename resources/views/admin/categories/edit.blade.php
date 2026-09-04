@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

<div class="category-edit-page">
    <div class="category-edit-card">

        <h1 class="category-edit-title">Edit Category</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Category Name --}}
            <div class="form-group">
                <label for="name">Category Name</label>

                <div class="input-wrapper">
                    <i class="fas fa-th-large"></i>

                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter category name">
                </div>

                @error('name')
                    <span class="invalid-feedback d-block" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            {{-- Description --}}
            <div class="form-group description-group">
                <label for="description">Description</label>

                <div class="input-wrapper textarea-wrapper">
                    <i class="fas fa-file-alt"></i>

                    <textarea id="description" name="description" placeholder="Enter category description" >{{ old('description', $category->description) }}</textarea>
                </div>

                @error('description')
                    <span class="invalid-feedback d-block" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            {{-- Image --}}
            <div class="form-group image-form-group">
                <label for="image">Image</label>

                <label for="image" class="image-upload-box" id="image-preview">

                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                    @else
                        <i class="fas fa-plus"></i>
                        <span>Choose Image</span>
                    @endif

                </label>

                <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" hidden>

                @error('image')
                    <span class="invalid-feedback d-block" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            {{-- Buttons --}}
            <div class="form-buttons">

                <button type="submit" class="btn-save">
                    Save
                </button>

                <a href="{{ route('admin.categories.index') }}" class="btn-cancel">
                    Cancel
                </a>

            </div>

        </form>
    </div>
</div>


{{-- Image Preview --}}
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
    .category-edit-page {
        padding: 15px 25px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .category-edit-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 30px 35px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
    }
    .category-edit-title {
        font-family: Georgia, serif;
        font-size: 24px;
        color: #111;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 14px;
    }
    .form-group label {
        display: block;
        font-family: Georgia, serif;
        font-size: 17px;
        color: #111;
        margin-bottom: 5px;
    }
    .input-wrapper {
        position: relative;
        width: 100%;
    }
    .input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #111;
        z-index: 1;
    }
    .input-wrapper input,
    .input-wrapper textarea {
        width: 100%;
        box-sizing: border-box;
        border: none;
        outline: none;
        background: #eeeeee;
        border-radius: 7px;
        padding: 8px 12px 8px 48px;
        font-size: 13px;
        color: #111;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
    .input-wrapper input {
        height: 35px;
    }
    .input-wrapper textarea {
        height: 48px;
        resize: vertical;
        padding-top: 14px;
    }
    .textarea-wrapper i {
        top: 18px;
        transform: none;
    }
    .input-wrapper input:focus,
    .input-wrapper textarea:focus {
        box-shadow: 0 0 0 2px #b9df9f;
    }
    .description-group {
        margin-top: 22px;
        margin-bottom: 20px;
    }
    .image-form-group {
        margin-top: 16px;
    }
    .image-upload-box {
        width: 240px;
        height: 175px;
        background: #eeeeee;
        border-radius: 17px;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.12);
    }
    .image-upload-box i {
        font-size: 42px;
        color: #70c477;
        margin-bottom: 5px;
    }
    .image-upload-box span {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #666;
    }
    .image-upload-box:hover {
        background: #e7e7e7;
    }
    .image-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 18px;
    }
    .form-buttons {
        display: flex;
        gap: 35px;
        margin-top: 25px;
    }
    .btn-save,
    .btn-cancel {
        width: 220px;
        height: 40px;
        border-radius: 20px;
        font-size: 19px;
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
        box-shadow: 0 3px 6px rgba(0,0,0,0.18);
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
        display: block;
        margin-top: 4px;
        font-size: 12px;
    }
    

    @media (max-width: 768px) {
        .category-edit-page {
            padding: 20px 15px;
        }
        .category-edit-card {
            padding: 20px 15px 25px;
        }
        .category-edit-title {
            font-size: 24px;
        }
        .image-upload-box {
            width: 100%;
            height: 250px;
        }
        .form-buttons {
            flex-direction: column;
            gap: 15px;
        }
        .btn-save,
        .btn-cancel {
            width: 100%;
        }
    }

</style>