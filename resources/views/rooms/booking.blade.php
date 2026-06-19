@extends('layouts.app')

@section('title', 'Book ' . $room->name . ' - Booking Homestay')

@section('content')
<div class="booking-container">
    <h1>Book {{ $room->name }}</h1>
    
    <div class="booking-content">
        <div class="room-summary">
            <h3>{{ $room->name }}</h3>
            <p>{{ $room->location }}</p>
            <p class="price">${{ $room->price_per_night }} per night</p>
        </div>
        
        <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            
            <div class="form-group">
                <label for="check_in">Check In Date</label>
                <input type="date" id="check_in" name="check_in" required>
                @error('check_in')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="check_out">Check Out Date</label>
                <input type="date" id="check_out" name="check_out" required>
                @error('check_out')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="guests">Number of Guests</label>
                <input type="number" id="guests" name="guests" min="1" max="{{ $room->capacity }}" required>
                @error('guests')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="booking-summary">
                <p><strong>Total Price:</strong> $<span id="total-price">0</span></p>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg">Confirm Booking</button>
            <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
