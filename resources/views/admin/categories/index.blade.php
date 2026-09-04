@extends('layouts.app')

@section('title', 'Category Page')

@section('content')

<div class="container py-4">
    <div class="category-header">
        <div class="category-title">
            Category Page
        </div>
        @if (Session::has('success'))
            {{-- <div class="alert alert-success">
                {{ Session::get('success') }}
            </div> --}}
        @endif

        <a href="{{ route('admin.categories.create') }}" class="add-category">
            <i class="fas fa-plus">
                Add Category
            </i>
        </a>
    </div>
    
    <div class="category-table-wrapper">
        <table class="category-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                 @if(!$categories->count())
                    <tr>
                        <td colspan="5" class="text-center">
                            Data categories not found!
                        </td>
                    </tr>
                @endif

                @foreach($categories as $category)

                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn-show" title="Show">
                                <i class="fas fa-eye"></i>        
                            </a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>        
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
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

        {!! $categories->links() !!}
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.min.css" integrity="sha512-ZPf2qlHx4NNLIT743alQXPPNHXxDslbJ0vLl1zJo3Hufo/NZSuWYLwp5nDHmECy1SJnlPwNulnL/f71qRfHvxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js" integrity="sha512-YuCuk5nNmVIUfKROKeV3fpZZ5Vt9vsnq8nExr5JwEJc2r1YDVmDfujcq373eHIzjqdxwCzoKpxngIaAdRUyg3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.all.min.js" integrity="sha512-9S3+vn3rpxj9li6QMuzZn0uzL7wRzoDC0TNhc389WlriJIMcD1aZEZAIGBDjgUBTiVKREmrjki7jNupqIR29bw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    function actionDestroy(url) {
            Swal.fire({
                title: "Do you want to delete?",
                text: "You can't recover deleted data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete!",
                cancleButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-destroy').attr('action', url);
                    $('#form-destroy').submit();
                };
            });
        }    
</script>

@endsection

<style>
    .category-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .category-title {
        font-family: Georgia, serif;
        font-size: 34px;
        margin-bottom: 25px;
        color: #111;
    }
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .add-category {
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
    .add-category:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }
    .category-table-wrapper {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
    }
    .category-table {
        width: 100%;
        border-collapse: collapse;
    }
    .category-table th {
        background: #b9df9f;
        padding: 15px;
        text-align: center;
        font-size: 16px;
        color: #111;
    }
    .category-table td {
        padding: 13px 15px;
        text-align: center;
        border-top: 1px solid #ddd;
        font-size: 15px;
        color: #111;
    }
    .category-table tr:hover {
        background: #f5f5f5;
    }
    .category-image {
        width: 70px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
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
        .category-page {
            padding: 25px 20px;
        }
        .category-header {
            align-items: flex-start;
            gap: 15px;
        }
        .category-table-wrapper {
            overflow-x: auto;
        }
        .category-table {
            min-width: 750px;
        }
    }
</style>