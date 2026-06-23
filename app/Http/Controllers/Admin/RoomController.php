<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    // ĐÃ SỬA: Thêm Request $request vào hàm index
    public function index(Request $request)
    {
        $query = Room::query();

        // Xử lý tìm kiếm (Nếu có từ khóa thì lọc theo name hoặc address)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('address', 'like', '%' . $searchTerm . '%');
            });
        }

        // Lấy dữ liệu với phân trang (nên dùng paginate thay vì all để web mượt hơn)
        $rooms = $query->paginate(10)->withQueryString();

        if ($request->expectsJson()) {
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
                    throw new \RuntimeException('Unable to store thumbnail.');
                }

                $room->thumbnail_url = Storage::disk('gcs')->url($storedPath);
                $room->save();
            } catch (\Throwable $e) {
                $room->delete();
                return back()
                    ->withInput()
                    ->withErrors(['thumbnail' => 'Không thể tải ảnh: ' . $e->getMessage()]);
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
            // Xóa ảnh cũ nếu có trên GCS
            if ($room->thumbnail_url) {
                $oldPath = str_replace('booking-homstay/', '', parse_url($room->thumbnail_url, PHP_URL_PATH));
                $oldPath = ltrim($oldPath, '/');
                Storage::disk('gcs')->delete($oldPath);
            }

            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filename = uniqid('room_thumb_', true) . '.' . $extension;
            $folderPath = 'rooms/' . $room->id . '/thumbnail';
            
            // Upload ảnh mới lên GCS
            $request->file('thumbnail')->storeAs($folderPath, $filename, 'gcs');
            $room->thumbnail_url = Storage::disk('gcs')->url($folderPath . '/' . $filename);
            
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
        // Xóa ảnh cũ nếu có trên GCS
        if ($room->thumbnail_url) {
            $oldPath = str_replace('booking-homstay/', '', parse_url($room->thumbnail_url, PHP_URL_PATH));
            $oldPath = ltrim($oldPath, '/');
            Storage::disk('gcs')->delete($oldPath);
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
