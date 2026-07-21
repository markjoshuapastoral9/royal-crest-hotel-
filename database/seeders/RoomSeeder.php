<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;

class RoomSeeder extends Seeder
{
    // Each variant has 5 physical units (A/B/C/D/E).
    // The rooms listing shows ONE card per variant (the "template" room, unit A).
    // Booking auto-assigns the first available unit for the requested dates.
    // Units B/C/D/E share the same name, price, description and thumbnail as unit A.
    private const UNITS = ['A', 'B', 'C', 'D', 'E'];

    public function run(): void
    {
        $types = RoomType::all()->keyBy('slug');
        $amenityIds = Amenity::where('category', 'room')->pluck('id')->toArray();

        // ── variant definitions ──────────────────────────────────────────────
        // 'number' is the BASE number; units get suffix A/B/C/D → 101A, 101B …
        $variants = [
            // Deluxe Rooms — floor 1
            ['type' => 'deluxe-room',        'number' => '101', 'name' => 'Garden Deluxe',         'price' => 3500,  'capacity' => 2, 'beds' => 1, 'floor' => 1, 'view' => 'Garden',    'size' => 28],
            ['type' => 'deluxe-room',        'number' => '102', 'name' => 'Pool Deluxe',            'price' => 3800,  'capacity' => 2, 'beds' => 1, 'floor' => 1, 'view' => 'Pool',      'size' => 28],
            ['type' => 'deluxe-room',        'number' => '103', 'name' => 'City Deluxe',            'price' => 3600,  'capacity' => 2, 'beds' => 1, 'floor' => 1, 'view' => 'City',      'size' => 28],
            ['type' => 'deluxe-room',        'number' => '104', 'name' => 'Twin Deluxe',            'price' => 3700,  'capacity' => 2, 'beds' => 2, 'floor' => 1, 'view' => 'Garden',    'size' => 30],
            ['type' => 'deluxe-room',        'number' => '105', 'name' => 'Corner Deluxe',          'price' => 4000,  'capacity' => 2, 'beds' => 1, 'floor' => 1, 'view' => 'Pool',      'size' => 32],
            // Superior Rooms — floor 2
            ['type' => 'superior-room',      'number' => '201', 'name' => 'Superior Standard',      'price' => 4500,  'capacity' => 2, 'beds' => 1, 'floor' => 2, 'view' => 'Garden',    'size' => 35],
            ['type' => 'superior-room',      'number' => '202', 'name' => 'Superior Pool',          'price' => 5000,  'capacity' => 2, 'beds' => 1, 'floor' => 2, 'view' => 'Pool',      'size' => 35],
            ['type' => 'superior-room',      'number' => '203', 'name' => 'Superior Twin',          'price' => 4800,  'capacity' => 3, 'beds' => 2, 'floor' => 2, 'view' => 'City',      'size' => 38],
            ['type' => 'superior-room',      'number' => '204', 'name' => 'Superior Deluxe',        'price' => 5200,  'capacity' => 2, 'beds' => 1, 'floor' => 2, 'view' => 'Pool',      'size' => 40],
            ['type' => 'superior-room',      'number' => '205', 'name' => 'Superior Corner',        'price' => 5500,  'capacity' => 2, 'beds' => 1, 'floor' => 2, 'view' => 'Garden',    'size' => 42],
            // Premier Rooms — floor 3
            ['type' => 'premier-room',       'number' => '301', 'name' => 'Premier Classic',        'price' => 6500,  'capacity' => 2, 'beds' => 1, 'floor' => 3, 'view' => 'City',      'size' => 45],
            ['type' => 'premier-room',       'number' => '302', 'name' => 'Premier Pool View',      'price' => 7000,  'capacity' => 2, 'beds' => 1, 'floor' => 3, 'view' => 'Pool',      'size' => 45],
            ['type' => 'premier-room',       'number' => '303', 'name' => 'Premier Garden',         'price' => 6800,  'capacity' => 2, 'beds' => 1, 'floor' => 3, 'view' => 'Garden',    'size' => 48],
            ['type' => 'premier-room',       'number' => '304', 'name' => 'Premier Twin',           'price' => 7200,  'capacity' => 3, 'beds' => 2, 'floor' => 3, 'view' => 'City',      'size' => 50],
            ['type' => 'premier-room',       'number' => '305', 'name' => 'Premier Executive',      'price' => 7500,  'capacity' => 2, 'beds' => 1, 'floor' => 3, 'view' => 'City',      'size' => 52],
            // Executive Suites — floor 4
            ['type' => 'executive-suite',    'number' => '401', 'name' => 'Executive Classic',      'price' => 9500,  'capacity' => 2, 'beds' => 1, 'floor' => 4, 'view' => 'City',      'size' => 60, 'minibar' => true],
            ['type' => 'executive-suite',    'number' => '402', 'name' => 'Executive Deluxe',       'price' => 10000, 'capacity' => 2, 'beds' => 1, 'floor' => 4, 'view' => 'Garden',    'size' => 62, 'minibar' => true],
            ['type' => 'executive-suite',    'number' => '403', 'name' => 'Executive Suite',        'price' => 10500, 'capacity' => 2, 'beds' => 1, 'floor' => 4, 'view' => 'Pool',      'size' => 65, 'minibar' => true],
            ['type' => 'executive-suite',    'number' => '404', 'name' => 'Executive Pool Suite',   'price' => 11000, 'capacity' => 4, 'beds' => 2, 'floor' => 4, 'view' => 'Pool',      'size' => 70, 'minibar' => true],
            ['type' => 'executive-suite',    'number' => '405', 'name' => 'Executive Garden Suite', 'price' => 11500, 'capacity' => 4, 'beds' => 2, 'floor' => 4, 'view' => 'Garden',    'size' => 72, 'minibar' => true],
            // Family Suites — floor 5
            ['type' => 'family-suite',       'number' => '501', 'name' => 'Family Suite',           'price' => 13000, 'capacity' => 5, 'beds' => 3, 'floor' => 5, 'view' => 'Garden',    'size' => 80, 'minibar' => true, 'breakfast' => true],
            ['type' => 'family-suite',       'number' => '502', 'name' => 'Family Pool Suite',      'price' => 14500, 'capacity' => 6, 'beds' => 3, 'floor' => 5, 'view' => 'Pool',      'size' => 85, 'minibar' => true, 'breakfast' => true],
            ['type' => 'family-suite',       'number' => '503', 'name' => 'Family Garden Suite',    'price' => 15000, 'capacity' => 6, 'beds' => 3, 'floor' => 5, 'view' => 'Garden',    'size' => 88, 'minibar' => true, 'breakfast' => true],
            // Presidential Suites — floor 6
            ['type' => 'presidential-suite', 'number' => '601', 'name' => 'Honeymoon Suite',        'price' => 20000, 'capacity' => 2, 'beds' => 1, 'floor' => 6, 'view' => 'Garden',    'size' => 100, 'minibar' => true, 'breakfast' => true],
            ['type' => 'presidential-suite', 'number' => '602', 'name' => 'Presidential Suite',     'price' => 25000, 'capacity' => 4, 'beds' => 2, 'floor' => 6, 'view' => 'Panoramic', 'size' => 120, 'minibar' => true, 'breakfast' => true, 'featured' => true],
            ['type' => 'presidential-suite', 'number' => '603', 'name' => 'Penthouse Suite',        'price' => 28000, 'capacity' => 4, 'beds' => 2, 'floor' => 6, 'view' => 'Panoramic', 'size' => 130, 'minibar' => true, 'breakfast' => true, 'featured' => true],
            ['type' => 'presidential-suite', 'number' => '604', 'name' => 'Ocean View Suite',       'price' => 22000, 'capacity' => 2, 'beds' => 1, 'floor' => 6, 'view' => 'Ocean',     'size' => 110, 'minibar' => true, 'breakfast' => true],
            ['type' => 'presidential-suite', 'number' => '605', 'name' => 'Mountain View Suite',    'price' => 21000, 'capacity' => 2, 'beds' => 1, 'floor' => 6, 'view' => 'Mountain',  'size' => 105, 'minibar' => true, 'breakfast' => true],
            ['type' => 'presidential-suite', 'number' => '606', 'name' => 'Pool Access Suite',      'price' => 23000, 'capacity' => 3, 'beds' => 2, 'floor' => 6, 'view' => 'Pool',      'size' => 115, 'minibar' => true, 'breakfast' => true],
            ['type' => 'presidential-suite', 'number' => '607', 'name' => 'Royal Suite',            'price' => 35000, 'capacity' => 6, 'beds' => 3, 'floor' => 6, 'view' => 'Panoramic', 'size' => 150, 'minibar' => true, 'breakfast' => true, 'featured' => true],
        ];

        foreach ($variants as $i => $data) {
            $typeId = $types[$data['type']]?->id;
            if (!$typeId) continue;

            $thumbnail    = $this->matchThumbnailForRoom($data['name']);
            $description  = $this->description($data['name'], $data['type']);
            $isFeatured   = $data['featured'] ?? ($i < 6);

            // Create 4 physical units per variant (A, B, C, D)
            foreach (self::UNITS as $unitIndex => $unit) {
                $roomNumber = $data['number'] . $unit;   // e.g. 102A, 102B …

                $room = Room::firstOrCreate(
                    ['room_number' => $roomNumber],
                    [
                        'room_type_id'       => $typeId,
                        'name'               => $data['name'],
                        'description'        => $description,
                        'price_per_night'    => $data['price'],
                        'capacity'           => $data['capacity'],
                        'beds'               => $data['beds'],
                        'bathrooms'          => $data['beds'] > 2 ? 2 : 1,
                        'floor'              => $data['floor'],
                        'size_sqm'           => $data['size'],
                        'has_wifi'           => true,
                        'has_aircon'         => true,
                        'has_tv'             => true,
                        'has_minibar'        => $data['minibar'] ?? false,
                        'breakfast_included' => $data['breakfast'] ?? false,
                        'view'               => $data['view'],
                        'status'             => 'available',
                        'is_featured'        => $isFeatured && $unitIndex === 0, // only unit-A is featured
                    ]
                );

                // Apply thumbnail to every unit
                if (!$room->thumbnail && $thumbnail) {
                    $room->update(['thumbnail' => $thumbnail]);
                }

                // Assign amenities
                $count = min(count($amenityIds), rand(5, 8));
                $room->amenities()->sync(array_slice($amenityIds, 0, $count));
            }
        }
    }

    private function matchThumbnailForRoom(string $name): ?string
    {
        $normalizedTarget = $this->normalizeRoomName($name);
        $directory = public_path('images/rooms');
        if (!is_dir($directory)) {
            return null;
        }

        foreach (glob($directory . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE) as $path) {
            $filename = basename($path);
            $stem = pathinfo($filename, PATHINFO_FILENAME);
            // Strip leading number prefix like "1. ", "12. " etc.
            $stem = preg_replace('/^\d+\.\s*/', '', $stem);
            $normalizedFile = $this->normalizeRoomName($stem);
            if ($normalizedFile === $normalizedTarget) {
                return 'images/rooms/' . $filename;
            }
        }

        return null;
    }

    private function normalizeRoomName(string $value): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', ' ', strtolower($value)));
    }

    private function description(string $name, string $type): string
    {
        $specific = [
            'Premier Executive'      => "The Premier Executive room combines business-class comfort with elegant design. Featuring a dedicated work area, premium bedding, and sweeping city views — perfect for the modern professional.",
            'Executive Deluxe'       => "The Executive Deluxe suite offers an upgraded experience with rich furnishings, a generous living space, and garden views that create a serene, private retreat.",
            'Executive Garden Suite' => "Step into the Executive Garden Suite and enjoy lush garden views from your private balcony. Spacious, serene, and complete with butler service and a fully stocked mini bar.",
            'Family Garden Suite'    => "The Family Garden Suite is your home away from home. Featuring three sleeping areas, a garden-facing terrace, and every amenity to keep the whole family comfortable.",
            'Honeymoon Suite'        => "Crafted for romance, the Honeymoon Suite features a king bed draped in fine linens, a private Jacuzzi, and breathtaking garden views — the perfect start to forever.",
            'Penthouse Suite'        => "The Penthouse Suite crowns Monarch Hotel with its floor-to-ceiling panoramic windows, private terrace, butler service, and world-class luxury at every turn.",
            'Ocean View Suite'       => "Wake up to the sound of the sea. The Ocean View Suite delivers unobstructed ocean vistas, premium coastal décor, and an atmosphere of pure relaxation.",
            'Mountain View Suite'    => "Nestled high above the city, the Mountain View Suite frames dramatic mountain landscapes. Ideal for those seeking tranquility, space, and majestic natural beauty.",
            'Pool Access Suite'      => "Step straight from your suite into the infinity pool. The Pool Access Suite offers direct pool access, a sun terrace, and resort-style luxury at your doorstep.",
            'Royal Suite'            => "The Royal Suite is the pinnacle of Monarch Hotel. An entire floor of unparalleled grandeur — private dining, a dedicated butler team, and panoramic views that define luxury.",
        ];

        if (isset($specific[$name])) {
            return $specific[$name];
        }

        $descriptions = [
            'deluxe-room'        => "The {$name} offers a warm, welcoming retreat with carefully curated furnishings. Enjoy modern comforts including high-speed WiFi, flat-screen TV, and a luxurious private bathroom.",
            'superior-room'      => "Experience elevated comfort in our {$name}. Featuring refined décor, a spacious layout, and premium bedding that ensures a restful night's sleep.",
            'premier-room'       => "The {$name} defines understated luxury. Indulge in generous living space, premium amenities, and stunning views that set the tone for an unforgettable stay.",
            'executive-suite'    => "Our {$name} is perfect for the discerning business traveler or leisure guest seeking extra space. Enjoy a separate living area, mini bar, and exclusive butler service.",
            'family-suite'       => "Designed with families in mind, the {$name} provides ample space, multiple sleeping areas, and all the comforts of home in a luxurious hotel setting.",
            'presidential-suite' => "The pinnacle of Monarch Hotel luxury. The {$name} offers an unparalleled experience with panoramic views, grand living spaces, and world-class personalized service.",
        ];
        return $descriptions[$type] ?? "A beautifully appointed {$name} designed for your comfort and relaxation.";
    }
}
