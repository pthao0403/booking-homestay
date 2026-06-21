<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageSignedUrlController extends Controller
{
    /**
     * Trả signed URL cho image path trong GCS
     * GET /admin/rooms/{room}/images/signed-url?path=rooms/{roomId}/{filename}
     */
    public function signedUrl(Request $request, Room $room)
    {
        $path = $request->query('path');
        $request->validate([
            'path' => 'required|string',
        ]);

        $expiresAt = now()->addMinutes(15);
        $disk = Storage::disk('gcs');

        // Flysystem driver may support temporaryUrl for GCS depending on configuration.
        // If not supported, we return empty and UI should handle fallback.

        try {
            // Some Flysystem adapters may not implement temporaryUrl.
            $url = method_exists($disk, 'temporaryUrl') ? $disk->temporaryUrl($path, $expiresAt) : null;

        } catch (\Throwable $e) {
            $url = null;
        }

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}

