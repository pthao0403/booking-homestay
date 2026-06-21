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
        $query = Room::query()->with('images');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
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
        $room->load('images');

        $similarRooms = Room::query()
            ->where('status', 'available')
            ->whereKeyNot($room->id)
            ->where(function ($query) use ($room) {
                $query->where('type', $room->type)
                    ->orWhere('address', 'like', '%' . $room->address . '%');
            })
            ->take(3)
            ->get();

        if (request()->expectsJson()) {
            return response()->json($room);
        }

        return view('rooms.show', compact('room', 'similarRooms'));
    }

    /**
     * Show the booking page for the room.
     */
    public function booking(Room $room)
    {
        return view('rooms.booking', compact('room'));
    }
}
