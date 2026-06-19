@extends('layouts.app')

@section('title', 'Login - Booking Homestay')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Login</h1>
        
        <form action="{{ route('login') }}" method="POST" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        
        <p class="auth-link">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        <p class="auth-link"><a href="#">Forgot your password?</a></p>
    </div>
</div>
@endsection
