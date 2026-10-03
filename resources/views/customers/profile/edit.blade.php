@extends('layouts.customers')

@section('title', 'Update Profile Customer')

@push('styles')
    <link href="{{ asset('css/customer-profile.css') }}" rel="stylesheet">
@endpush

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

