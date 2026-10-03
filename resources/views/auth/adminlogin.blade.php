@extends('layouts.auth')

@section('title', 'Login Admin - Matcha Mori')

@section('content')

    <div class="login-container admin-login-container">
        <!--Logo-->
        <div class="login-brand">
            <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori">
            <span>Matcha Mori</span>
        </div>

        <!--Judul-->
        <div class="login-heading">
            <h2>Admin Login</h2>
            <p>Sign in to your admin account</p>
        </div>

        <!--Form Login-->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!--email-->
            <div class="login-input">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email" requiredautocomplete="email">
            </div>

            @error('email')
                <span class="login-error">
                    {{ $message }}
                </span>
            @enderror

             <!--password-->
            <div class="login-input password-input">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="adminPassword" placeholder="Password" requiredautocomplete="current-password">

                <button type="button" class="password-toggle" onclick="toggleAdminPassword()">
                    <i class="fas fa-eye" id="adminEyeIcon"></i>
                </button>
            </div>

            @error('password')
                <span class="login-error">
                    {{ $message }}
                </span>
            @enderror

            <!--tombol login-->
            <button type="submit" class="login-button">
                Login
            </button>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    function toggleAdminPassword() {
        const password = document.getElementById('adminPassword');
        const icon = document.getElementById('adminEyeIcon');

        if (password.type === 'password') {
            password.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else{
            password.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush