<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['roomType', 'amenities'])
            ->where('status', 'available');

        // Filters
        if ($request->filled('type')) {
            $query->whereHas('roomType', fn($q) => $q->where('slug', $request->type));
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

        $checkIn  = $request->check_in;
        $checkOut = $request->check_out;

        if ($checkIn && $checkOut) {
            // Only exclude a variant when ALL its units are booked for those dates.
            // Keep rooms where at least one same-name unit is available.
            $query->where(function ($q) use ($checkIn, $checkOut) {
                // Room is available if it has no conflicting active booking
                $q->whereDoesntHave('bookings', function ($bq) use ($checkIn, $checkOut) {
                    $bq->whereNotIn('status', ['cancelled', 'completed'])
                       ->where(function ($dq) use ($checkIn, $checkOut) {
                           $dq->whereBetween('check_in', [$checkIn, $checkOut])
                              ->orWhereBetween('check_out', [$checkIn, $checkOut])
                              ->orWhere(fn($q3) => $q3->where('check_in', '<=', $checkIn)
                                                       ->where('check_out', '>=', $checkOut));
                       });
                });
            });
        }

        // Deduplicate: show ONE card per distinct room name.
        // We keep the unit-A row (room_number ends in 'A') as the display representative.
        // If there's no unit-A (old data), fall back to the lowest id.
        $allRooms = $query->orderBy('room_number')->get();

        // Group by name, pick the representative (unit A preferred)
        $seen       = [];
        $deduplicated = collect();
        foreach ($allRooms as $room) {
            if (isset($seen[$room->name])) continue;
            $seen[$room->name] = true;
            $deduplicated->push($room);
        }

        // Attach "available units" count for the chosen dates to each representative
        $deduplicated->each(function (Room $room) use ($checkIn, $checkOut) {
            $unitQuery = Room::where('name', $room->name)
                ->where('status', 'available');

            if ($checkIn && $checkOut) {
                $unitQuery->whereDoesntHave('bookings', function ($bq) use ($checkIn, $checkOut) {
                    $bq->whereNotIn('status', ['cancelled', 'completed'])
                       ->where(function ($dq) use ($checkIn, $checkOut) {
                           $dq->whereBetween('check_in', [$checkIn, $checkOut])
                              ->orWhereBetween('check_out', [$checkIn, $checkOut])
                              ->orWhere(fn($q3) => $q3->where('check_in', '<=', $checkIn)
                                                       ->where('check_out', '>=', $checkOut));
                       });
                });
            }

            $room->available_units = $unitQuery->count();
            $room->total_units     = Room::where('name', $room->name)->where('status', 'available')->count();
        });

        // Manual pagination on the deduplicated collection
        $perPage     = 9;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $items       = $deduplicated->forPage($currentPage, $perPage)->values();
        $rooms       = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $deduplicated->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $roomTypes = RoomType::where('is_active', true)->get();

        return view('rooms.index', compact('rooms', 'roomTypes', 'request'));
    }

    public function show(Room $room)
    {
        $room->load(['roomType', 'amenities', 'galleries']);
        $relatedRooms = Room::where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('rooms.show', compact('room', 'relatedRooms'));
    }
}
