@extends('layouts.app')

@section('title', 'Register - Booking Homestay')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Create Account</h1>
        
        <form action="{{ route('register') }}" method="POST" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
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
            
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        
        <p class="auth-link">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>
@endsection
