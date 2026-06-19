@extends('layouts.app')

@section('title', 'Browse Rooms - Booking Homestay')

@section('content')
<div class="rooms-container">
    <h1>Available Rooms</h1>
    
    <div class="filters">
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Search rooms..." value="{{ request('search') }}">
            <input type="date" name="check_in" placeholder="Check In" value="{{ request('check_in') }}">
            <input type="date" name="check_out" placeholder="Check Out" value="{{ request('check_out') }}">
            <button type="submit" class="btn btn-filter">Filter</button>
        </form>
    </div>
    
    <div class="rooms-grid">
        @forelse($rooms as $room)
            <div class="room-card">
                <div class="room-image">
                    {{-- Room image will be displayed here --}}
                </div>
                <div class="room-info">
                    <h3>{{ $room->name }}</h3>
                    <p class="location">{{ $room->location }}</p>
                    <p class="description">{{ Str::limit($room->description, 100) }}</p>
                    <div class="room-footer">
                        <span class="price">${{ $room->price_per_night }}/night</span>
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No rooms available.</p>
        @endforelse
    </div>
    
    {{ $rooms->links() }}
</div>
@endsection
