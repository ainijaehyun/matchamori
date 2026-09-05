@extends('layouts.app')

@section('title', 'Profile Admin')

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

<style>
    .profile-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
    }

    .profile-title {
        font-family: Georgia, serif;
        font-size: 34px;
        color: #111;
        margin-bottom: 30px;
    }

    .profile-card {
        width: 450px;
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.10);
        text-align: center;
    }

    .profile-icon {
        font-size: 90px;
        color: #4da3df;
        margin-bottom: 15px;
    }

    .profile-name {
        font-family: Georgia, serif;
        font-size: 28px;
        color: #111;
        margin-bottom: 8px;
    }

    .profile-info {
        font-family: Georgia, serif;
        font-size: 17px;
        color: #333;
        margin-bottom: 5px;
    }

    .profile-buttons {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-top: 35px;
    }

    .profile-button {
        background: #007500;
        color: white;
        padding: 11px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-family: Georgia, serif;
        font-size: 15px;
        box-shadow: 0 3px 5px rgba(0,0,0,0.15);
    }

    .profile-button:hover {
        background: #005c00;
        color: white;
        text-decoration: none;
    }
</style>  