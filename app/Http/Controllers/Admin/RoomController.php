<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms.
     */
    public function index()
    {
        $rooms = Room::all();
        if (request()->expectsJson()) {
            return response()->json($rooms);
        }
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string|in:single,double,suite,vip,family_suite',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_url' => 'nullable|string|max:255',
        ]);

        $room = new Room();
        $room->name = $data['name'];
        $room->address = $data['location']; // maps to address
        $room->price = $data['price_per_night']; // maps to price
        $room->description = $data['description'];
        $room->capacity = $data['capacity'];
        $room->type = $data['type'];
        $room->status = 'available';

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('rooms', 'public');
            $room->thumbnail_url = asset('storage/' . $path);
        } elseif ($request->filled('thumbnail_url')) {
            $room->thumbnail_url = $data['thumbnail_url'];
        } else {
            // Default homestay placeholder image URL
            $room->thumbnail_url = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';
        }

        $room->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully.',
                'data' => $room
            ], 201);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string|in:single,double,suite,vip,family_suite',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_url' => 'nullable|string|max:255',
        ]);

        $room->name = $data['name'];
        $room->address = $data['location'];
        $room->price = $data['price_per_night'];
        $room->description = $data['description'];
        $room->capacity = $data['capacity'];
        $room->type = $data['type'];

        if ($request->hasFile('thumbnail')) {
            // Delete old file if exists
            if ($room->thumbnail_url && str_contains($room->thumbnail_url, '/storage/rooms/')) {
                $oldPath = str_replace(asset('storage/'), '', $room->thumbnail_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('thumbnail')->store('rooms', 'public');
            $room->thumbnail_url = asset('storage/' . $path);
        } elseif ($request->filled('thumbnail_url')) {
            $room->thumbnail_url = $data['thumbnail_url'];
        }

        $room->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully.',
                'data' => $room
            ]);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        // Delete image if exists
        if ($room->thumbnail_url && str_contains($room->thumbnail_url, '/storage/rooms/')) {
            $oldPath = str_replace(asset('storage/'), '', $room->thumbnail_url);
            Storage::disk('public')->delete($oldPath);
        }

        $room->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room deleted successfully.'
            ]);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
