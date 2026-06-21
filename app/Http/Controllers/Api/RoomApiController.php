<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Room::query()->with('images');

            if ($request->filled('search')) {
                $search = $request->string('search');
                $query->where(function ($builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            }

            $rooms = $query
                ->where('status', 'available')
                ->latest()
                ->paginate(9)
                ->withQueryString();

            return response()->json($rooms);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 9,
                'total' => 0,
                'message' => 'Khong the tai danh sach phong luc nay.',
            ]);
        }
    }

    public function show(Room $room): JsonResponse
    {
        return response()->json([
            'data' => $room->load('images'),
        ]);
    }
}
