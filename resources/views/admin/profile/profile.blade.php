@extends('layouts.app')

@section('title', 'Profile Admin')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="profile-page">
    <div class="profile-title">
        Profile Admin
    </div>

    <div class="profile-card">
        <div class="profile-icon">
            <i class="far fa-user"></i>
        </div>

        <div class="profile-name">
            {{ $user->name }}
        </div>

        <div class="profile-info">
            {{ $user->email }}
        </div>

        <div class="profile-info">
            {{ $user->phone ?? '-' }}
        </div>

        <div class="profile-info">
            {{ $user->address ?? '-' }}
        </div>

        <div class="profile-buttons">
            <a href="{{ route('admin.dashboard') }}" class="profile-button">
                Back
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="profile-button">
                Update Profile
            </a>
        </div>
    </div>
</div>


@endsection


 