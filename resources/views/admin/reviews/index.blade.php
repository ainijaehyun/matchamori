
@extends('layouts.app')

@section('title', 'Manage Ulasan')

@push('styles')
    <link href="{{ asset('css/review.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="review-page">
    <div class="review-header">
        <div class="review-title">
            Manage Ulasan
        </div>

        @if (Session::has('success'))
            {{-- <div class="alert alert-success">
                {{ Session::get('success') }}
            </div> --}}
        @endif
    </div>

    <div class="review-table-wrapper">
        <table class="review-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>
                            {{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                        </td>

                        <td>
                            {{ $review->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $review->product->name ?? '-' }}
                        </td>

                        <td>
                            <span class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span>{{ $review->rating }}/5</span>
                            </span>
                        </td>

                        <td class="review-comment">
                            {{ $review->comment ?: '-' }}
                        </td>

                        <td>
                            {{ $review->created_at->format('d M Y') }}
                        </td>

                        <td>
                            <div class="review-action">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="review-delete-button" title="Hapus Ulasan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada ulasan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-area">
            {!! $reviews->links() !!}
        </div>
    </div>
</div>

@endsection
