@extends('layouts.auth')

@section('title', 'Customer Login')

@section('content')


<div class="login-container">

    {{-- Logo --}}
    <div class="login-brand">
        <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
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

            <button type="button" class="password-toggle" onclick="togglePassword()">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
        </div>


        {{-- Remember Me --}}
        <div style="font-size: 13px; margin-top: 5px;">
            <label>
                <input type="checkbox" name="remember"
                    {{ old('remember') ? 'checked' : '' }}>
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


