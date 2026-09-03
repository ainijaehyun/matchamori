@extends('layouts.customers')

@section('title', 'Profile Customer')

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

<style>

    /* profile psge */

    .profile-page {
        width: 100%;
        padding: 0 10px 50px;
    }
    /* breadcrumb */

    .profile-breadcrumb {
        width: 100%;
        padding: 7px 20px;
        margin-bottom: 80px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0,0,0,.15);
        font-size: 20px;
    }

    /* profile card */
    .profile-card {
        width: 460px;
        max-width: 90%;
        margin: 30px auto 0;
        margin-top: 30px;
        padding: 35px 45px 30px;
        background: #ffffff;
        border-radius: 55px;
        box-shadow: 0 3px 8px rgba(0,0,0,.18);
        text-align: center;
    }

    /* icon profile */
    .profile-large-icon {
        font-size: 105px;
        color: #42a5e5;
        margin-bottom: 5px;
    }

    /* name */
    .profile-name {
        margin: 0;
        font-size: 28px;
        font-weight: normal;
    }

    /* email */
    .profile-email {
        margin: 0 0 30px;
        font-size: 16px;
    }

    /* data profile */
    .profile-data {
        width: 100%;
        display: grid;
        grid-template-columns: 140px 1fr;
        row-gap: 15px;
        text-align: left;
        font-size: 17px;
    }
    .profile-data .label {
        font-weight: normal;
    }
    .profile-data .value {
        word-break: break-word;
    }

    /* button */
    .profile-buttons {
        display: flex;
        justify-content: center;
        gap: 55px;
        margin-top: 30px;
    }
    .profile-buttons a {
        width: 145px;
        padding: 14px 10px;
        background: #008000;
        color: #ffffff;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 3px 6px rgba(0,0,0,.18);
        transition: .2s;
    }
    .profile-buttons a:last-child {
        width: 220px;
    }
    .profile-buttons a:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* responsive */
    @media (max-width: 600px) {
        .profile-breadcrumb {
            margin-bottom: 40px;
            font-size: 17px;
        }
        .profile-card {
            width: 100%;
            max-width: 100%;
            padding: 40px 25px;
            border-radius: 40px;
        }
        .profile-large-icon {
            font-size: 100px;
        }
        .profile-name {
            font-size: 27px;
        }
        .profile-email {
            font-size: 16px;
        }
        .profile-data {
            grid-template-columns: 110px 1fr;
            font-size: 16px;
            row-gap: 15px;
        }
        .profile-buttons {
            gap: 15px;
        }
        .profile-buttons a,
        .profile-buttons a:last-child {
            width: 50%;
        }
    }

</style>