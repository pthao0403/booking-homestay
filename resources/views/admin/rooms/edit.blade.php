@extends('layouts.app')

@section('title', 'Edit Room - Booking Homestay')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')
    
    <div class="admin-content">
        <h1>Edit Room</h1>
        
        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Room Name</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $room->name) }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required value="{{ old('location', $room->location) }}">
                @error('location')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required>{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price_per_night">Price Per Night</label>
                <input type="number" id="price_per_night" name="price_per_night" step="0.01" required value="{{ old('price_per_night', $room->price_per_night) }}">
                @error('price_per_night')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" required value="{{ old('capacity', $room->capacity) }}">
                @error('capacity')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="type">Room Type</label>
                <select id="type" name="type" required>
                    <option value="single" {{ old('type', $room->type) === 'single' ? 'selected' : '' }}>Single</option>
                    <option value="double" {{ old('type', $room->type) === 'double' ? 'selected' : '' }}>Double</option>
                    <option value="suite" {{ old('type', $room->type) === 'suite' ? 'selected' : '' }}>Suite</option>
                </select>
                @error('type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
