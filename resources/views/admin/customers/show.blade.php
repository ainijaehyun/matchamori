@extends('layouts.app')

@section('title', 'Show Customer')

@push('styles')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
@endpush

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

