@extends('layouts.app')

@section('title', 'Update Profile Admin')

@section('content')

<style>
    .profile-edit-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }

    .profile-edit-title {
        font-family: Georgia, serif;
        font-size: 34px;
        color: #111;
        margin-bottom: 30px;
    }

    .profile-edit-card {
        width: 650px;
        max-width: 100%;
        background: white;
        border-radius: 30px;
        padding: 35px 45px 40px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.10);
        box-sizing: border-box;
    }

    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-label-custom {
        display: block;
        font-size: 17px;
        color: #111;
        margin-bottom: 7px;
    }

    .form-control-custom {
        width: 100%;
        height: 42px;
        padding: 8px 12px;
        background: #e8e8e8;
        border: none;
        border-radius: 6px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
        font-size: 16px;
        box-sizing: border-box;
        outline: none;
    }

    .form-control-custom:focus {
        box-shadow: 0 0 0 2px #b9df9f;
    }

    .form-row-custom {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control-custom {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 17px;
        color: #111;
    }

    .save-button {
        width: 100%;
        height: 53px;
        margin-top: 15px;
        background: #007500;
        color: white;
        border: none;
        border-radius: 5px;
        font-family: Georgia, serif;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);
    }

    .save-button:hover {
        background: #005c00;
    }

    .error-message {
        color: #d00000;
        font-size: 13px;
        margin-top: 5px;
    }
    .profile-buttons {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-top: 25px;
    }

    .back-button,
    .save-button {
        height: 55px;
        border-radius: 5px;
        font-family: Georgia, serif;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);
        box-sizing: border-box;
    }

    .back-button {
        width: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #007500;
        color: white;
        text-decoration: none;
    }

    .back-button:hover {
        background: #005c00;
        color: white;
        text-decoration: none;
    }

    .save-button {
        width: 350px;
        margin-top: 0;
        background: #007500;
        color: white;
        border: none;
    }

    .save-button:hover {
        background: #005c00;
    }

    @media (max-width: 700px) {
        .profile-edit-page {
            padding: 25px 20px;
        }

        .profile-edit-card {
            padding: 25px 20px;
        }

        .form-row-custom {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>


<div class="profile-edit-page">

    <div class="profile-edit-title">
        Update Your Profile
    </div>


    <div class="profile-edit-card">

        <form action="{{ route('admin.profile.update') }}" method="POST">

            @csrf
            @method('PATCH')


            {{-- NAME --}}
            <div class="form-group-custom">

                <label class="form-label-custom">
                    <i class="fas fa-user mr-2"></i>
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control-custom"
                    value="{{ old('name', $user->name) }}"
                    required
                >

                @error('name')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- EMAIL & PHONE --}}
            <div class="form-row-custom">

                {{-- EMAIL --}}
                <div class="form-group-custom">

                    <label class="form-label-custom">
                        <i class="fas fa-envelope mr-2"></i>
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control-custom"
                        value="{{ old('email', $user->email) }}"
                        required
                    >

                    @error('email')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PHONE --}}
                <div class="form-group-custom">

                    <label class="form-label-custom">
                        <i class="fas fa-phone mr-2"></i>
                        Phone Number
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control-custom"
                        value="{{ old('phone', $user->phone) }}"
                    >

                    @error('phone')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>
            
             {{-- ADDRESS --}}
            <div class="form-group-custom">

                <label class="form-label-custom">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Address
                </label>

                <textarea
                    name="address"
                    class="form-control-custom"
                    rows="3"
                    style="height: 80px; resize: none;"
                >{{ old('address', $user->address) }}</textarea>

                @error('address')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- PASSWORD & CONFIRM PASSWORD --}}
            <div class="form-row-custom">

                {{-- PASSWORD --}}
                <div class="form-group-custom">

                    <label class="form-label-custom">
                        <i class="fas fa-lock mr-2"></i>
                        Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control-custom"
                            placeholder="Leave blank if unchanged"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>

                    </div>

                    @error('password')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- CONFIRM PASSWORD --}}
                <div class="form-group-custom">

                    <label class="form-label-custom">
                        <i class="fas fa-lock mr-2"></i>
                        Confirm Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control-custom"
                            placeholder="Confirm new password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>

                    </div>

                </div>

            </div>


            {{-- SAVE --}}
            <div class="profile-buttons">

            {{-- BACK --}}
            <a href="{{ route('admin.profile') }}" class="back-button">
                Back
            </a>

            {{-- SAVE --}}
            <button type="submit" class="save-button">
                Save Change
            </button>

        </div>

        </form>

    </div>

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