@extends('layouts.app')

@section('title', 'Customer Page')

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

@push('styles')
    <style>
        .customer-page {
            padding: 35px 40px;
            background: #f7f8fb;
            min-height: calc(100vh - 70px);
            box-sizing: border-box;
        }
        .customer-title {
            font-family: Georgia, serif;
            font-size: 34px;
            margin-bottom: 25px;
            color: #111;
        }
        .customer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .customer-table-wrapper {
            background: white;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
        }
        .customer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .customer-table th,
        .customer-table td {
            border: 1px solid #275a2f;
        }
        .customer-table th {
            background: #b9df9f;
            padding: 15px;
            text-align: center;
            font-size: 16px;
            color: #111;
        }
        .customer-table td {
            padding: 13px 15px;
            text-align: center;
            font-size: 15px;
            color: #111;
        }
        .customer-table tr:hover {
            background: #f5f5f5;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
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
            transition: 0.2s ease;
        }
        .btn-show:hover {
            background: #006b00;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }
        .btn-delete {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: none;
            background: #e74a3b;
            color: white;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .btn-delete:hover {
            background: #c9362a;
            color: white;
            transform: translateY(-1px);
        }
        .customer-table-wrapper .pagination {
            margin: 0;
            padding: 18px;
            display: flex;
            justify-content: center;
        }
        .customer-table-wrapper .page-link {
            color: #008000;
        }
        .customer-table-wrapper .page-item.active .page-link {
            background: #008000;
            border-color: #008000;
            color: white;
        }
        .customer-table-wrapper .page-link:hover {
            color: #006b00;
            background: #eef7e8;
        }

        @media (max-width: 768px) {
            .customer-page {
                padding: 25px 20px;
            }
            .customer-header {
                align-items: flex-start;
                gap: 15px;
            }
            .customer-table-wrapper {
                overflow-x: auto;
            }
            .customer-table {
                min-width: 900px;
            }
        }
    </style>
@endpush