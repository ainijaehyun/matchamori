@extends('layouts.customers')

@section('title', 'Profile Customer')

@push('styles')
    <link href="{{ asset('css/customer-profile.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="profile-page">
    <div class="profile-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        &gt; Profile
    </div>

    {{-- profile card --}}
    <div class="profile-card">
        {{-- icon --}}
        <div class="profile-large-icon">
            <i class="far fa-user"></i>
        </div>

        {{-- name --}}
        <h1 class="profile-name">
            {{ Auth::user()->name }}
        </h1>

        {{-- email --}}
        <p class="profile-email">
            {{ Auth::user()->email }}
        </p>

        {{-- data --}}
        <div class="profile-data">
            <div class="label">Full Name</div>
            <div class="value">
                {{ Auth::user()->name }}
            </div>

            <div class="label">Email</div>
            <div class="value">
                {{ Auth::user()->email }}
            </div>

            <div class="label">Phone</div>
            <div class="value">
                {{ Auth::user()->phone ?? '-' }}
            </div>

            <div class="label">Address</div>
            <div class="value">
                {{ Auth::user()->address ?? '-' }}
            </div>
        </div>
    </div>

    {{-- button --}}
    <div class="profile-buttons">
        <a href="{{ route('customer.dashboard') }}">
            Back
        </a>

        <a href="{{ route('customer.profile.edit') }}">
            Update Profile
        </a>
    </div>
</div>

@endsection

