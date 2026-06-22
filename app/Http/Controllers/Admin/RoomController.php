<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        if (request()->expectsJson()) {
            return response()->json($rooms);
        }
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

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
        $room->address = $data['location']; 
        $room->price = $data['price_per_night']; 
        $room->description = $data['description'];
        $room->capacity = $data['capacity'];
        $room->type = $data['type'];
        $room->status = 'available';

        $room->save();

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $extension = $thumbnail->getClientOriginalExtension();
            $filename = uniqid('room_thumb_', true) . '.' . $extension;
            $folderPath = 'rooms/' . $room->id . '/thumbnail';

            try {
                $storedPath = Storage::disk('gcs')->putFileAs(
                    $folderPath,
                    $thumbnail,
                    $filename,
                    ['visibility' => 'public']
                );

                if (!$storedPath) {
                    throw new \RuntimeException('Unable to store thumbnail on Google Cloud Storage.');
                }

                $room->thumbnail_url = $storedPath;
                $room->save();
            } catch (\Throwable $e) {
                $room->delete();

                return back()
                    ->withInput()
                    ->withErrors(['thumbnail' => 'Không thể tải ảnh lên Google Cloud Storage: ' . $e->getMessage()]);
            }

        } elseif ($request->filled('thumbnail_url')) {
            $room->thumbnail_url = $data['thumbnail_url'];
            $room->save();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully.',
                'data' => $room,
            ], 201);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

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
            // Xóa ảnh cũ trên GCS nếu có
            if ($room->thumbnail_url && !str_contains($room->thumbnail_url, 'http')) {
                Storage::disk('gcs')->delete($room->thumbnail_url);
            }

            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filename = uniqid('room_thumb_', true) . '.' . $extension;
            $folderPath = 'rooms/' . $room->id . '/thumbnail';
            
            // Upload ảnh mới
            $request->file('thumbnail')->storeAs($folderPath, $filename, 'gcs');
            $room->thumbnail_url = $folderPath . '/' . $filename;
            
        } elseif ($request->filled('thumbnail_url')) {
            $room->thumbnail_url = $data['thumbnail_url'];
        }

        $room->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully.',
                'data' => $room,
            ]);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Xóa ảnh trên GCS
        if ($room->thumbnail_url && !str_contains($room->thumbnail_url, 'http')) {
            Storage::disk('gcs')->delete($room->thumbnail_url);
        }

        $room->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room deleted successfully.',
            ]);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}