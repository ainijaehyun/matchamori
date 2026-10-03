@extends('layouts.auth')

@section('title', 'Register Customer - Matcha Mori')

@section('content')
    <!-- Register Card -->
    <div class="register-card">

        <!-- Brand -->
        <div class="brand">

            <!--
                Simpan foto daun di:
                public/img/matcha-leaf.png
            -->
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <div class="brand-name">
                Matcha Mori
            </div>
        </div>


        <!-- Heading -->
        <h2 class="register-heading">
            Create Your Account
        </h2>

        <div class="register-description">
            Join us and enjoy authentic matcha products.
        </div>


        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">

            @csrf

            <!-- Name -->
            <div class="form-group">
                <i class="fas fa-user input-icon"></i>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Name"
                    required
                    autofocus
                >

                @error('name')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- Email -->
            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email"
                    required
                >

                @error('email')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- Phone -->
            <div class="form-group">
                <i class="fas fa-phone-alt input-icon"></i>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="Phone Number"
                    required
                >

                @error('phone')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- Address -->
            <div class="form-group">
                <i class="fas fa-map-marker-alt input-icon"></i>
                <input
                    type="text"
                    name="address"
                    id="address"
                    value="{{ old('address') }}"
                    class="form-control @error('address') is-invalid @enderror"
                    placeholder="Address"
                    required
                >

                @error('address')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- Password -->
            <div class="form-group password-group">
                <i class="fas fa-lock input-icon"></i>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password"
                    required
                >

                <span class="password-toggle" onclick="togglePassword('password', this)">
                    <i class="fas fa-eye"></i>
                </span>

                @error('password')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- Confirm Password -->
            <div class="form-group password-group">
                <i class="fas fa-lock input-icon"></i>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password-confirm"
                    class="form-control"
                    placeholder="Confirm Password"
                    required
                >

                <span class="password-toggle" onclick="togglePassword('password-confirm', this)">
                    <i class="fas fa-eye"></i>
                </span>

            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-register">
                Register
            </button>

            <!-- Login -->
            <div class="login-text">
                Already have an account?
                <a href="{{ route('login') }}">
                    Login
                </a>
            </div>
        </form>
    </div>

    <!-- Password Toggle -->
    <script>

        function togglePassword(inputId, element) {

            const input = document.getElementById(inputId);
            const icon = element.querySelector('i');

            if (input.type === "password") {

                input.type = "text";

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

            } else {

                input.type = "password";

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            }
        }

    </script>
    @endsection