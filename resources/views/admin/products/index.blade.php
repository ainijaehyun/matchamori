@extends('layouts.app')

@section('title', 'Product Page')

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
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
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

<style>
   .product-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .product-title {
        font-family: Georgia, serif;
        font-size: 34px;
        margin-bottom: 25px;
        color: #111;
    }
    .add-product {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #008000;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 15px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    }
    .add-product:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }
    .product-table-wrapper {
        background: white;
        border-radius: 20px;
        overflow-x: auto;
        overflow-y: hidden;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
    }
    .product-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }
    .product-table th,
    .product-table td {
        border: 1px solid #275a2f;
    }
    .product-table th {
        background: #b9df9f;
        padding: 15px;
        text-align: center;
        font-size: 16px;
        color: #111;
        white-space: nowrap;
    }
    .product-table td {
        padding: 13px 15px;
        text-align: center;
        border-top: 1px solid #ddd;
        font-size: 15px;
        color: #111;
        vertical-align: middle;
    }
    .product-table tr:hover {
        background: #f5f5f5;
    }
    .product-image {
        width: 70px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
    }
    .product-description {
        min-width: 300px;
        max-width: 350px;
        text-align: left !important;
        vertical-align: top;
        line-height: 1.4;
    }
    .product-price {
        min-width: 100px;
        white-space: nowrap;
        text-align: center !important;
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    .action-buttons form {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }
    .btn-show {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #008000;
        color: white;
        text-decoration: none;
    }

    .btn-show:hover {
        background: #006b00;
        color: white;
    }
    .btn-edit,
    .btn-delete {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-edit {
        background: #dda900;
        color: white;
        text-decoration: none;
    }
    .btn-delete {
        background: #e74a3b;
        color: white;
    }
    .btn-delete:hover {
        background: #c9362a;
    }
    .pagination-area {
        padding: 18px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .product-page {
            padding: 25px 20px;
        }
        .product-header {
            align-items: flex-start;
            gap: 15px;
        }
        .product-table-wrapper {
            overflow-x: auto;
        }
        .product-table {
            min-width: 950px;
        }
    }
</style>