<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms.
     */
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('address', 'like', '%' . $location . '%');
        }

        // Only show available rooms for booking by default
        $rooms = $query->where('status', 'available')
                      ->paginate(9)
                      ->withQueryString();

        if ($request->expectsJson()) {
            return response()->json($rooms);
        }

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        if (request()->expectsJson()) {
            return response()->json($room);
        }
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the booking page for the room.
     */
    public function booking(Room $room)
    {
        return view('rooms.booking', compact('room'));
    }
}
