@extends('layouts.customers')

@section('title', 'Update Profile Customer')

@section('content')

<div class="update-profile-page">
    <div class="update-breadcrumb">
        <a href="{{ route('customer.dashboard') }}">
            Home
        </a>
        &gt; Profile
    </div>

    {{-- title --}}
    <h1 class="update-title">Update Your Profile</h1>

    {{-- form --}}
    <form action="{{ route('customer.profile.update') }}" method="POST">
        @csrf

        @method('PATCH')

        <div class="update-card">
            {{-- name --}}
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i>
                    Name
                </label>

                <input type="text" name="name" class="profile-input" value="{{ old('name', Auth::user()->name) }}" required>

                @error('name')

                <div class="profile-error">
                    {{ $message }}
                </div>

                @enderror
            </div>

            {{-- email --}}
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </label>

                <input type="email" name="email" class="profile-input" value="{{ old('email', Auth::user()->email) }}" required>

                @error('email')

                <div class="profile-error">
                    {{ $message }}
                </div>

                @enderror
            </div>

            {{-- phone + address --}}
            <div class="form-row-custom">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i>
                        Phone Number
                    </label>

                    <input type="text" name="phone" class="profile-input" value="{{ old('phone', Auth::user()->phone) }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Address
                    </label>

                    <input type="text" name="address" class="profile-input" value="{{ old('address', Auth::user()->address) }}" required>

                </div>
            </div>

            {{-- password --}}
            <div class="password-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>

                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="profile-input">
                        <button type="button" class="password-eye" onclick="togglePassword('password', this)">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- confirm password --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Confirm Password
                    </label>

                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="profile-input">
                        <button type="button" class="password-eye" onclick="togglePassword('password_confirmation', this)">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- button --}}
        <div class="profile-button-area">
            {{-- back --}}
            <a href="{{ route('customer.profile') }}" class="back-profile">
                Back
            </a>
            {{-- save --}}
            <button type="submit" class="save-profile">
                Save Change
            </button>
        </div>
    </form>

</div>

<script>
    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }
    }
</script>

@endsection

<style>
    /* update profile */
    .update-profile-page {
        width: 100%;
        padding: 0 10px 40px;
    }
    /* breadcrumb */
    .update-breadcrumb {
        width: 100%;
        height: 36px;
        display: flex;
        align-items: center;
        padding: 0px 20px;
        margin-bottom: 25px;
        background: #b8dfa5;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0,0,0,.15);
        font-size: 18px;
    }
    .update-breadcrumb a {
        color: #111;
        text-decoration: none;
    }

    .update-breadcrumb a:hover {
        color: #008000;
    }
    /* title */
    .update-title {
        width: 780px;
        max-width: calc(100% - 20px);
        margin: 0 auto 8px;
        font-size: 28px;
        font-weight: normal;
        line-height: 1.2;
    }
    /* form card */
    .update-card {
        width: 780px;
        max-width: calc(100% - 20px);
        margin: 0 auto;
        padding: 25px 38px 28px;
        background: #ffffff;
        border-radius: 45px;
        box-shadow: 0 3px 8px rgba(0,0,0,.18);
    }
    /* form group */
    .form-group {
        margin: 0 0 12px;
    }
    .form-label {
        display: block;
        margin-bottom: 5px;
        font-size: 15px;
    }
    .form-label i {
        width: 20px;
        margin-right: 5px;
    }
    /* input */
    .profile-input {
        width: 100%;
        height: 42px;
        display: block;
        padding: 8px 13px;
        border: none;
        border-radius: 6px;
        background: #e5e5e5;
        box-shadow: 0 3px 5px rgba(0,0,0,.15);
        font-family: Georgia, serif;
        font-size: 14px;
        outline: none;
    }
    .profile-input:focus {
        background: #eeeeee;
    }


    /* phone & address */
    .form-row-custom {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 10px;
    }
    /* password */
    .password-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper .profile-input {
        padding-right: 45px;
    }

    .password-eye {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        padding: 0;
        border: none;
        background: transparent;
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
    }

    .password-eye:hover {
        color: #008000;
    }
    /* button area */
    .profile-button-area {
        width: 780px;
        max-width: calc(100% - 20px);
        margin: 25px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }
    /* back button */
    .back-profile {
        width: 145px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        background: #008000;
        color: white;
        border: none;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.20);
        text-decoration: none;
        font-family: Georgia, serif;
        font-size: 15px;
        font-weight: bold;
    }
    .back-profile:hover {
        background: #006b00;
        color: white;
        text-decoration: none;
    }
    /* save bottom */
    .save-profile {
        width: 300px;
        height: 43px;
        padding: 0;
        border: none;
        border-radius: 5px;
        background: #008000;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.20);
        font-family: Georgia, serif;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
    }
    .save-profile:hover {
        background: #006b00;
    }
    /* RESPONSIVE */

    @media (max-width: 800px) {
        .update-title,
        .update-card,
        .profile-button-area {
            width: 90%;
        }

        .form-row-custom,
        .password-row {
            grid-template-columns: 1fr;
        }

        .profile-button-area {
            gap: 20px;
        }
    }


    @media (max-width: 500px) {

        .update-title {
            font-size: 24px;
        }

        .update-card {
            padding: 22px;
            border-radius: 30px;
        }

        .profile-button-area {
            flex-direction: column;
        }

        .back-profile,
        .save-profile {
            width: 100%;
        }
    }

</style>