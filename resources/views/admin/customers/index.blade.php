@extends('layouts.app')

@section('title', 'Customer Page')

@push('styles')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="customer-page">
    <div class="customer-header">
        <div class="customer-title">
            Customer Page
        </div>
    </div>

    <div class="customer-table-wrapper">
        <table class="customer-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                 @if (!$customers->count())
                    <tr>
                        <td colspan="6" class="text-center">
                            Data customers not found!
                        </td>
                    </tr>
                 @endif

                 @foreach ($customers as $customer)
                    <tr>
                        <td>
                            {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            {{ $customer->name }}
                        </td>
                        <td>
                            {{ $customer->email }}
                        </td>
                        <td>
                            {{ $customer->phone ?? '-' }}
                        </td>
                        <td>
                            {{ $customer->address ?? '-' }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn-show" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete this customer?');">
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

        {!! $customers->links() !!}
    </div>
</div>
@endsection

