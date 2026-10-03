@extends('layouts.app')

@section('title', 'Product Page')

@push('styles')
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="product-page">
    <div class="product-header">
        <div class="product-title">
            Product Page
        </div>
        @if (Session::has('success'))
            {{-- <div class="alert alert-success">
                {{ Session::get('success') }}
            </div> --}}
        @endif

        <a href="{{ route('admin.products.create') }}" class="add-product">
            <i class="fas fa-plus"></i>
            Add Product
        </a>
    </div>

    <div class="product-table-wrapper">
        <table class="product-table">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @if(!$products->count())
                    <tr>
                        <td colspan="8" class="text-center">
                            Data products not found!
                        </td>
                    </tr>
                @endif
                
                @foreach($products as $product)

                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="product-description">{{ $product->description ?? '-' }}</td>
                    <td class="product-price"> Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn-show" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-area">
            {!! $products->links() !!}
        </div>
    </div>
</div>
@endsection

