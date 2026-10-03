@extends('layouts.app')

@section('title', 'Category Page')

@push('styles')
    <link href="{{ asset('css/category.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="category-page">
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
            <i class="fas fa-plus"></i>
            Add Category
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
                        <img src="{{ asset('img/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
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

