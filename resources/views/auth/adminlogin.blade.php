@extends('layouts.auth')

@section('title', 'Login Admin - Matcha Mori')

@section('content')

<style>
    body {
        background: #dcebd2 !important;
    }
    /*Login Admin*/
    .login-container {
        width: 470px;
        max-width: 90%;
        min-height: 500px;
        margin: 20px auto 50px;

        padding:30px 45px 40px;

        background: #eef5e8;
        border-radius: 25px;

        box-sizing: border-box;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
     
    /*logo matcha mori*/
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

    /*judul*/
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

    /*input*/
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

    /*ikon*/
    .login-input > i:first-child {
        width: 55px;

        text-align: center;

        font-size: 18px;
        color: #111;
    }

    /*input text*/
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

    /*password*/
    .password-input {
        position: relative;
    }

    .password-input input {
        padding-right: 45px;
    }

    /*tombol mata*/
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

    /*tombol login*/
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

    /*error*/
    .login-error {
        display: block;

        margin-top: -10px;
        margin-bottom: 12px;

        color: #d00000;

        font-size: 13px;
    }



</style>
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