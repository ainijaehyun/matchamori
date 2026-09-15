@extends('layouts.auth')

@section('title', 'Customer Login')

@section('content')


<div class="login-container">

    {{-- Logo --}}
    <div class="login-brand">
        <img src="{{ asset('img/leaf.png') }}" alt="Matcha Mori">
        <span>Matcha Mori</span>
    </div>


    {{-- Judul --}}
    <div class="login-heading">
        <h2>Customer Login</h2>
        <p>Welcome back!</p>
    </div>


    {{-- Error --}}
    @if ($errors->any())
        <div class="login-error">
            {{ $errors->first() }}
        </div>
    @endif


    {{-- Form Login --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="login-input">
            <i class="fas fa-envelope"></i>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email"
                required
                autocomplete="email"
                autofocus
            >
        </div>


        {{-- Password --}}
        <div class="login-input password-input">

            <i class="fas fa-lock"></i>

            <input
                id="password"
                type="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="current-password"
            >

            <button
                type="button"
                class="password-toggle"
                onclick="togglePassword()"
            >
                <i class="fas fa-eye" id="eyeIcon"></i>
            </button>

        </div>


        {{-- Remember Me --}}
        <div style="font-size: 13px; margin-top: 5px;">
            <label>
                <input
                    type="checkbox"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                Remember Me
            </label>
        </div>


        {{-- Tombol Login --}}
        <button type="submit" class="login-button">
            LOGIN
        </button>

    </form>


    {{-- Register --}}
    @if (Route::has('register'))
        <div class="register-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Register</a>
        </div>
    @endif

</div>


<script>
    function togglePassword() {

        const password = document.getElementById('password');
        const eye = document.getElementById('eyeIcon');

        if (password.type === 'password') {

            password.type = 'text';

            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');

        } else {

            password.type = 'password';

            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');

        }
    }
</script>

@endsection
<style>
    /* Background halaman */
    body {
        background: #dcebd2 !important;
    }

    /* Kotak login */
    .login-container {
        width: 470px;
        max-width: 90%;
        min-height: 500px;
        margin: 20px auto 50px;

        padding: 30px 45px 40px;

        background: #eef5e8;
        border-radius: 25px;

        box-sizing: border-box;

        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    /* Logo Matcha Mori */
    .login-brand {
        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 25px;
        transform: translateX(-15px);
    }

    .login-brand img {
        width: 70px;
        height: 70px;

        object-fit: contain;
        margin-right: 8px;
    }

    .login-brand span {
        font-family: Georgia, serif;
        font-size: 34px;
        color: #111;

        white-space: nowrap;
        transform: translateX(-8px);
    }

    /* Judul */
    .login-heading {
        text-align: center;
        margin-bottom: 42px;
    }

    .login-heading h2 {
        margin: 0 0 5px;

        font-family: Georgia, serif;
        font-size: 25px;
        font-weight: normal;

        color: #111;
    }

    .login-heading p {
        margin: 0;

        font-family: Georgia, serif;
        font-size: 17px;

        color: #111;
    }

    /* Input */
    .login-input {
        width: 100%;
        height: 41px;

        display: flex;
        align-items: center;

        background: #eeeeee;

        border: 1px solid #111;
        border-radius: 6px;

        margin-bottom: 18px;

        box-sizing: border-box;
    }

    /* Ikon */
    .login-input > i:first-child {
        width: 55px;

        text-align: center;

        font-size: 18px;
        color: #111;
    }

    /* Input text */
    .login-input input {
        flex: 1;
        height: 100%;

        border: none;
        outline: none;

        background: transparent;

        font-size: 14px;

        padding: 0 10px 0 0;

        color: #111;
    }

    .login-input input::placeholder {
        color: #222;
    }

    /* Password */
    .password-input {
        position: relative;
    }

    .password-input input {
        padding-right: 45px;
    }

    /* Tombol mata */
    .password-toggle {
        position: absolute;

        right: 10px;
        top: 50%;

        transform: translateY(-50%);

        width: 30px;
        height: 30px;

        border: none;
        background: transparent;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 0;
    }

    .password-toggle i {
        font-size: 18px;
        color: #111;
    }

    /* Tombol Login */
    .login-button {
        width: 100%;
        height: 41px;

        margin-top: 21px;

        border: 1px solid #111;
        border-radius: 6px;

        background: #008000;

        color: white;

        font-size: 14px;
        font-weight: bold;

        cursor: pointer;
    }

    .login-button:hover {
        background: #006b00;
    }

    /* Error */
    .login-error {
        display: block;

        margin-top: -10px;
        margin-bottom: 12px;

        color: #d00000;

        font-size: 13px;
    }

    /* Register */
    .register-link {
        margin-top: 20px;

        text-align: center;

        font-size: 14px;
        color: #111;
    }

    .register-link a {
        color: #315c32;
        font-weight: bold;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>