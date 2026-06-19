@extends('layouts.app')

@section('title', $room->name . ' - Booking Homestay')

@section('content')
<div class="room-detail-container">
    <div class="room-detail-header">
        <h1>{{ $room->name }}</h1>
        <p class="location">{{ $room->location }}</p>
    </div>
    
    <div class="room-detail-content">
        <div class="room-images">
            {{-- Room images carousel will be displayed here --}}
        </div>
        
        <div class="room-details">
            <h2>Room Information</h2>
            <p class="description">{{ $room->description }}</p>
            
            <div class="details-info">
                <p><strong>Price:</strong> ${{ $room->price_per_night }} per night</p>
                <p><strong>Capacity:</strong> {{ $room->capacity }} guests</p>
                <p><strong>Type:</strong> {{ $room->type }}</p>
            </div>
            
            <div class="amenities">
                <h3>Amenities</h3>
                <ul>
                    {{-- Amenities will be listed here --}}
                </ul>
            </div>
            
            <div class="booking-section">
                <a href="{{ route('rooms.booking', $room) }}" class="btn btn-primary btn-lg">Book Now</a>
            </div>
        </div>
    </div>
</div>
@endsection
