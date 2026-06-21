<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomImageSignedUrlController extends Controller
{
    /**
     * GET /admin/rooms/{room}/images/signed-url?path=rooms/{roomId}/{filename}
     */
    public function signedUrl(Request $request, Room $room)
    {
        $path = $request->query('path');
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = ltrim($path, '/');

        // basic sanity
        if (!Str::startsWith($path, 'rooms/')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid object path.',
            ], 422);
        }

        $projectId = config('filesystems.disks.gcs.project_id') ?? env('GCS_PROJECT_ID');
        $keyFilePath = config('filesystems.disks.gcs.key_file') ?? env('GCS_KEY_FILE');
        $bucketName = config('filesystems.disks.gcs.bucket') ?? env('GCS_BUCKET');

        if (!$projectId || !$keyFilePath || !$bucketName) {
            return response()->json([
                'success' => false,
                'message' => 'Missing GCS env/config (GCS_PROJECT_ID, GCS_KEY_FILE, GCS_BUCKET).',
            ], 500);
        }

        $expiresAt = now()->addMinutes(15);

        $storage = new StorageClient([
            'projectId' => $projectId,
            'keyFilePath' => $keyFilePath,
        ]);

        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($path);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'Object not found.',
            ], 404);
        }

        try {
            $url = $object->signedUrl($expiresAt, [
                'version' => 'v4',
                'method' => 'GET',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create signed URL.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}


