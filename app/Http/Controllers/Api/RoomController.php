<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /** GET /api/rooms */
    public function index(Request $request): JsonResponse
    {
        $query = Room::with(['roomType', 'amenities'])
            ->where('status', 'available');

        // Optional filters
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $query->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereNotIn('status', ['cancelled', 'completed'])
                  ->where(function ($q2) use ($request) {
                      $q2->whereBetween('check_in', [$request->check_in, $request->check_out])
                         ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                         ->orWhere(function ($q3) use ($request) {
                             $q3->where('check_in', '<=', $request->check_in)
                                ->where('check_out', '>=', $request->check_out);
                         });
                  });
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', $request->capacity);
        }

        $rooms = $query->paginate(12);

        return response()->json([
            'success' => true,
            'data'    => RoomResource::collection($rooms),
            'meta'    => [
                'total'        => $rooms->total(),
                'per_page'     => $rooms->perPage(),
                'current_page' => $rooms->currentPage(),
                'last_page'    => $rooms->lastPage(),
            ],
        ]);
    }

    /** GET /api/rooms/{id} */
    public function show(Room $room): JsonResponse
    {
        $room->load(['roomType', 'amenities']);

        return response()->json([
            'success' => true,
            'data'    => new RoomResource($room),
        ]);
    }
}
