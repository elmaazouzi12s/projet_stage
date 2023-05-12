@extends('layouts.auth-master')

@section('title', 'register')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-5 col-md-8 m-5">
            <form class="bg-white rounded-5 shadow-5-strong p-5" method="POST" action="{{ route('register.perform') }}"
                required autofocus>
                @csrf
                <div class="form-group mb-4">
                    <p class="mb-3 fw-bold text-center fs-3 text-warning" style="letter-spacing: 3px">Register</p>
                    <p class="fw-bold fs-4 text-center">Sign Up Free Account</p>
                </div>

                @include('layouts.partials.frontend.auth.messages')

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="form1Example1" class="form-control" name="email" value="{{ old('email') }}" />
                    <label class="form-label" for="form1Example1">Email address</label>
                </div>
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input type="text" id="form1Example1" class="form-control" name="username"
                        value="{{ old('username') }}" />
                    <label class="form-label" for="form1Example1">Username</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="form1Example2" class="form-control" name="password"
                        value="{{ old('password') }}" required />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>
                <!-- Password confirmation input -->
                <div class="form-outline mb-4">
                    <input type="password" id="form1Example2" class="form-control" name="password_confirmation"
                        value="{{ old('password_confirmation') }}" required />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>

                <!-- 1 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col text-center">
                        <!-- Simple link -->
                        <a href="{{ route('login.show') }}">Already Have Account?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                @include('layouts.partials.frontend.auth.copy')
            </form>
        </div>
    </div>
@endsection
