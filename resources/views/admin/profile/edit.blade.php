@extends('layouts.app')

@section('title', 'Update Profile Admin')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush

@section('content')

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

