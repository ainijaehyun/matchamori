@extends('layouts.auth')

@section('title', 'Register Customer - Matcha Mori')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 0 80px;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #dcebd2 !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #222;
        }

        /*TOP TITLE */

        .page-title {
            margin-top: 25px;
            margin-bottom: 30px;
            padding: 8px 30px;
            background: #dcebd4;
            border: 1px solid #8aaa7c;
            font-family: Georgia, serif;
            font-size: 32px;
            text-align: center;
        }

        /*REGISTER CARD*/

        .register-card {
            width: 480px;
            max-width: 92%;
            background: #eef5e8;
            border-radius: 24px;
            padding: 30px 55px 40px;
            box-shadow: 0 5px 20px rgba(60, 90, 40, 0.15);
        }

        /* LOGO */

        .brand {
            height: 85px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0px;
            margin-bottom: 20px;
            transform: translateX(-12px);
        }

        .brand img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            flex-shrink: 0;
            margin-right: -3px;
        }

        .brand-name {
            font-family: Georgia, serif;
            font-size: 32px;
            white-space: nowrap;
            margin: 0;
        }

        /*HEADING*/

        .register-heading {
            text-align: center;
            margin-bottom: 6px;
            font-family: Georgia, serif;
            font-size: 22px;
        }

        .register-description {
            text-align: center;
            margin-bottom: 30px;
            font-family: Georgia, serif;
            font-size: 14px;
        }

        /*FORM*/

        .form-group {
            position: relative;
            margin-bottom: 9px;
        }

        .input-icon {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #222;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 0 42px 0 55px;
            border: 1px solid #222;
            border-radius: 7px;
            background: #eeeeee;
            font-size: 13px;
            outline: none;
        }

        textarea.form-control {
            height: 42px;
            padding-top: 12px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #238000;
            box-shadow: 0 0 0 2px rgba(35, 128, 0, 0.15);
        }

        .form-control::placeholder {
            color: #222;
        }

        /* =========================
           PASSWORD EYE
        ========================= */

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: none;
            background: transparent;

            cursor: pointer;

            color: #222;

            z-index: 3;
            padding: 5px;
        }

        .password-toggle i {
            font-size: 16px;
            color: #222;
        }

        .password-toggle:hover {
            color: #315c32;
        }

        .password-toggle:hover i {
            color: #315c32;
        }

        /*ERROR */

        .invalid-feedback {
            display: block;
            color: #d00000;
            font-size: 12px;
            margin-top: 4px;
            margin-left: 5px;
        }

        .is-invalid {
            border-color: #d00000;
        }

        /*REGISTER BUTTON*/

        .btn-register {
            width: 100%;
            height: 42px;
            margin-top: 28px;
            border: 1px solid #111;
            border-radius: 7px;
            background: #008000;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #006b00;
        }

        /*LOGIN*/

        .login-text {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .login-text a {
            color: #008000;
            text-decoration: none;
            font-weight: bold;
            margin-left: 5px;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        /*RESPONSIVE */

        @media (max-width: 600px) {

            .page-title {
                font-size: 25px;
                margin-top: 20px;
            }

            .register-card {
                padding: 35px 30px 45px;
            }

            .brand-name {
                font-size: 30px;
            }

            .brand img {
                width: 65px;
                height: 65px;
            }
        }
    </style>


    <!-- Register Card -->
    <div class="register-card">

        <!-- Brand -->
        <div class="brand">

            <!--
                Simpan foto daun di:
                public/img/matcha-leaf.png
            -->
            <img src="{{ asset('img/leaf1.png') }}"
                 alt="Matcha Mori">

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

                <span
                    class="password-toggle"
                    onclick="togglePassword('password', this)"
                >
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

                <span
                    class="password-toggle"
                    onclick="togglePassword('password-confirm', this)"
                >
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