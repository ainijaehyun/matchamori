@extends('layouts.app')

@section('title', 'Edit Category')

@push('styles')
    <link href="{{ asset('css/category.css') }}" rel="stylesheet">
@endpush

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
                        <img src="{{ asset('img/' . $category->image) }}" alt="{{ $category->name }}">
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


