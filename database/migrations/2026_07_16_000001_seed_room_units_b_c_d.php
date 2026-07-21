<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Creates B, C, D physical units for every existing room that currently
 * has only a single-letter-free room_number (e.g. "102", "201").
 * After this migration every variant has exactly 5 units: 102A, 102B, 102C, 102D, 102E.
 * Rooms that already have letter suffixes (102A etc.) are left untouched.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Grab all "base" rooms — those whose room_number contains no letter suffix
        $baseRooms = DB::table('rooms')
            ->get()
            ->filter(fn($r) => preg_match('/^\d+$/', $r->room_number)); // pure numbers only

        foreach ($baseRooms as $base) {
            // Rename the existing room to unit A
            DB::table('rooms')
                ->where('id', $base->id)
                ->update(['room_number' => $base->room_number . 'A']);

            // Create B, C, D, E copies
            foreach (['B', 'C', 'D', 'E'] as $unit) {
                $newNumber = $base->room_number . $unit;

                // Skip if it already exists (idempotent)
                $exists = DB::table('rooms')->where('room_number', $newNumber)->exists();
                if ($exists) continue;

                $newId = DB::table('rooms')->insertGetId([
                    'room_type_id'       => $base->room_type_id,
                    'room_number'        => $newNumber,
                    'name'               => $base->name,
                    'description'        => $base->description,
                    'price_per_night'    => $base->price_per_night,
                    'capacity'           => $base->capacity,
                    'beds'               => $base->beds,
                    'bathrooms'          => $base->bathrooms,
                    'floor'              => $base->floor,
                    'size_sqm'           => $base->size_sqm,
                    'has_wifi'           => $base->has_wifi,
                    'has_aircon'         => $base->has_aircon,
                    'has_tv'             => $base->has_tv,
                    'has_minibar'        => $base->has_minibar,
                    'breakfast_included' => $base->breakfast_included,
                    'view'               => $base->view,
                    'status'             => 'available',
                    'thumbnail'          => $base->thumbnail,
                    'is_featured'        => 0, // only unit A is featured
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);

                // Copy amenities from unit A to the new unit
                $amenities = DB::table('amenity_room')
                    ->where('room_id', $base->id)
                    ->pluck('amenity_id');

                foreach ($amenities as $amenityId) {
                    DB::table('amenity_room')->insert([
                        'room_id'    => $newId,
                        'amenity_id' => $amenityId,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // Remove all B/C/D/E units and rename A units back to base numbers
        $unitA = DB::table('rooms')
            ->get()
            ->filter(fn($r) => preg_match('/^\d+A$/', $r->room_number));

        foreach ($unitA as $room) {
            $base = rtrim($room->room_number, 'A');

            // Delete B, C, D, E
            foreach (['B', 'C', 'D', 'E'] as $unit) {
                $toDelete = DB::table('rooms')->where('room_number', $base . $unit)->first();
                if ($toDelete) {
                    DB::table('amenity_room')->where('room_id', $toDelete->id)->delete();
                    DB::table('rooms')->where('id', $toDelete->id)->delete();
                }
            }

            // Rename A back to base
            DB::table('rooms')->where('id', $room->id)
                ->update(['room_number' => $base]);
        }
    }
};
