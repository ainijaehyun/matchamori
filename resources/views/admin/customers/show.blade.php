@extends('layouts.app')

@section('title', 'Show Customer')

@section('content')
<div class="customer-show-page">
    <h1 class="customer-show-title">
        Customer Detail
    </h1>

    <div class="customer-detail-card">
        <div class="detail-row">
            <div class="detail-label">
                Name
            </div>
            <div class="detail-value">
                {{ $customer->name }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Email
            </div>
            <div class="detail-value">
                {{ $customer->email }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Phone
            </div>
            <div class="detail-value">
                {{ $customer->phone ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Address
            </div>
            <div class="detail-value">
                {{ $customer->address ?? '-' }}
            </div>
        </div>

        <div class="detail-row date-row">
            <div class="detail-label">
                Create at
            </div>
            <div class="detail-value">
                {{ $customer->created_at->format('d M Y H:i:s A') }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">
                Update at
            </div>
            <div class="detail-value">
                {{ $customer->updated_at->format('d M Y H:i:s A') }}
            </div>
        </div>
    </div>

    <div class="form-buttons">
        <a href="{{ route('admin.customers.index') }}" class="btn-back">
            Back
        </a>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .customer-show-page {
            padding: 12px 40px 30px;
            background: #f7f8fb;
            min-height: calc(100vh - 70px);
            box-sizing: border-box;
        }
        .customer-show-title {
            font-family: Georgia, serif;
            font-size: 24px;
            font-weight: normal;
            color: #111;
            margin: 18px 0 25px;
        }
        .customer-detail-card {
            background: #ffffff;
            border-radius: 32px;
            padding: 28px 30px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.10);
            max-width: 760px;
        }
        .detail-row {
            display: grid;
            grid-template-columns: 220px 1fr;
            column-gap: 12px;
            align-items: start;
            margin-bottom: 18px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            font-family: Georgia, serif;
            font-size: 19px;
            color: #111;
            line-height: 1.4;
        }
        .detail-value {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #111;
            line-height: 1.4;
        }
        .date-row {
            margin-top: 2px;
        }
        .form-buttons {
            display: flex;
            margin-top: 25px;
        }
        .btn-back {
            width: 180px;
            height: 48px;
            border-radius: 20px;
            background: #008000;
            color: white;
            font-family: Georgia, serif;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
            box-sizing: border-box;
        }
        .btn-back:hover {
            background: #006b00;
            color: white;
            text-decoration: none;
        }


        @media (max-width: 768px) {
            .customer-show-page {
                padding: 20px 15px 30px;
            }
            .customer-show-title {
                font-size: 23px;
                margin-bottom: 20px;
            }
            .customer-detail-card {
                border-radius: 24px;
                padding: 23px 20px;
            }
            .detail-row {
                grid-template-columns: 1fr;
                row-gap: 6px;
                margin-bottom: 20px
            }
            .detail-label {
                font-size: 18px;
            }
            .detail-value {
                font-size: 15px;
            }
            .btn-back {
                width: 100%;
                height: 48px;
            }
        }
    </style>
@endpush