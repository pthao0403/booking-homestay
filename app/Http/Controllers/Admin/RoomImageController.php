<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    /**
     * Upload nhiều ảnh cho phòng lên Google Cloud Storage (disk: gcs)
     */
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);


        $files = $request->file('images');
        $disk = Storage::disk('gcs');

        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('room_', true) . '.' . $extension;
            $objectPath = 'rooms/' . $room->id . '/' . $filename;

            // upload raw file
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
}

