@extends('layouts.app')

@section('title', 'Manage Bookings - Booking Homestay')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')
    
    <div class="admin-content">
        <h1>Manage Bookings</h1>
        
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room->name }}</td>
                        <td>{{ $booking->check_in->format('M d, Y') }}</td>
                        <td>{{ $booking->check_out->format('M d, Y') }}</td>
                        <td>${{ $booking->total_price }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($booking->status) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-secondary">View</a>
                            @if($booking->status === 'pending')
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        {{ $bookings->links() }}
    </div>
</div>
@endsection
