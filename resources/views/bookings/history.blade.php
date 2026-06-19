@extends('layouts.app')

@section('title', 'My Bookings - Booking Homestay')

@section('content')
<div class="bookings-container">
    <h1>My Bookings</h1>
    
    <div class="bookings-filter">
        <a href="?status=all" class="filter-btn">All</a>
        <a href="?status=upcoming" class="filter-btn">Upcoming</a>
        <a href="?status=completed" class="filter-btn">Completed</a>
        <a href="?status=cancelled" class="filter-btn">Cancelled</a>
    </div>
    
    <div class="bookings-list">
        @forelse($bookings as $booking)
            <div class="booking-card">
                <div class="booking-header">
                    <h3>{{ $booking->room->name }}</h3>
                    <span class="status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span>
                </div>
                
                <div class="booking-details">
                    <p><strong>Check In:</strong> {{ $booking->check_in->format('M d, Y') }}</p>
                    <p><strong>Check Out:</strong> {{ $booking->check_out->format('M d, Y') }}</p>
                    <p><strong>Guests:</strong> {{ $booking->guests }}</p>
                    <p><strong>Total Price:</strong> ${{ $booking->total_price }}</p>
                </div>
                
                <div class="booking-actions">
                    @if($booking->status === 'pending')
                        <a href="{{ route('bookings.cancel', $booking) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel Booking</a>
                    @endif
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-secondary">View Details</a>
                </div>
            </div>
        @empty
            <p>No bookings found.</p>
        @endforelse
    </div>
</div>
@endsection
