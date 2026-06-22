<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImagesController extends Controller
{
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $disk = Storage::disk('gcs');

        foreach ($request->file('images') as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('room_', true) . '.' . $extension;
            $objectPath = 'rooms/' . $room->id . '/' . $filename;

            $disk->put($objectPath, file_get_contents($file->getRealPath()), [
                'visibility' => 'private',
                'contentType' => $file->getClientMimeType(),
            ]);

            RoomImage::create([
                'room_id' => $room->id,
                'image_url' => $objectPath,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Upload images successfully',
            ], 201);
        }

        return back()->with('success', 'Upload ảnh thành công.');
    }

    /**
     * DELETE /admin/rooms/{room}/images/{image}
     */
    public function destroy(Request $request, Room $room, RoomImage $image)
    {
        // Ensure image belongs to the room
        if ($image->room_id !== $room->id) {
            return response()->json([
                'success' => false,
                'message' => 'Image does not belong to this room.',
            ], 422);
        }

        $objectPath = $image->image_url;

        try {
            Storage::disk('gcs')->delete($objectPath);
        } catch (\Throwable $e) {
            // continue deleting db record
        }

        $image->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        }

        return back()->with('success', 'Xóa ảnh phòng thành công.');
    }
}


