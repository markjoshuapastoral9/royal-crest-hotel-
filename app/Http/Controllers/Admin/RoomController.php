<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\Gallery;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('roomType');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('room_number', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('room_type_id', $request->type);
        }

        $rooms     = $query->latest()->paginate(15)->withQueryString();
        $roomTypes = RoomType::all();

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->where('category', 'room')->get();
        return view('admin.rooms.create', compact('roomTypes', 'amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id'       => 'required|exists:room_types,id',
            'room_number'        => 'required|string|unique:rooms',
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'price_per_night'    => 'required|numeric|min:0',
            'capacity'           => 'required|integer|min:1',
            'beds'               => 'required|integer|min:1',
            'bathrooms'          => 'required|integer|min:1',
            'floor'              => 'nullable|integer',
            'size_sqm'           => 'nullable|numeric',
            'has_wifi'           => 'boolean',
            'has_aircon'         => 'boolean',
            'has_tv'             => 'boolean',
            'has_minibar'        => 'boolean',
            'breakfast_included' => 'boolean',
            'view'               => 'nullable|string',
            'status'             => 'required|in:available,occupied,reserved,maintenance',
            'is_featured'        => 'boolean',
            'thumbnail'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'amenities'          => 'nullable|array',
            'amenities.*'        => 'exists:amenities,id',
            'gallery_images.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('rooms', 'public');
        }

        // Booleans default false
        foreach (['has_wifi','has_aircon','has_tv','has_minibar','breakfast_included','is_featured'] as $field) {
            $validated[$field] = $request->boolean($field);
        }

        $room = Room::create($validated);

        // Sync amenities
        if (!empty($validated['amenities'])) {
            $room->amenities()->sync($validated['amenities']);
        }

        // Gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('gallery/rooms', 'public');
                Gallery::create([
                    'image'          => $path,
                    'category'       => 'rooms',
                    'imageable_type' => Room::class,
                    'imageable_id'   => $room->id,
                ]);
            }
        }

        ActivityLog::log('created', "Created room: {$room->name}", $room);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    public function show(Room $room)
    {
        $room->load(['roomType', 'amenities', 'galleries']);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $room->load(['amenities', 'galleries']);
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->where('category', 'room')->get();
        return view('admin.rooms.edit', compact('room', 'roomTypes', 'amenities'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id'       => 'required|exists:room_types,id',
            'room_number'        => 'required|string|unique:rooms,room_number,' . $room->id,
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'price_per_night'    => 'required|numeric|min:0',
            'capacity'           => 'required|integer|min:1',
            'beds'               => 'required|integer|min:1',
            'bathrooms'          => 'required|integer|min:1',
            'floor'              => 'nullable|integer',
            'size_sqm'           => 'nullable|numeric',
            'view'               => 'nullable|string',
            'status'             => 'required|in:available,occupied,reserved,maintenance',
            'thumbnail'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'amenities'          => 'nullable|array',
            'gallery_images.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($room->thumbnail) Storage::disk('public')->delete($room->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('rooms', 'public');
        }

        foreach (['has_wifi','has_aircon','has_tv','has_minibar','breakfast_included','is_featured'] as $field) {
            $validated[$field] = $request->boolean($field);
        }

        $room->update($validated);
        $room->amenities()->sync($request->amenities ?? []);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('gallery/rooms', 'public');
                Gallery::create([
                    'image'          => $path,
                    'category'       => 'rooms',
                    'imageable_type' => Room::class,
                    'imageable_id'   => $room->id,
                ]);
            }
        }

        ActivityLog::log('updated', "Updated room: {$room->name}", $room);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        if ($room->thumbnail) Storage::disk('public')->delete($room->thumbnail);
        foreach ($room->galleries as $g) {
            Storage::disk('public')->delete($g->image);
            $g->delete();
        }
        $room->delete();
        ActivityLog::log('deleted', "Deleted room: {$room->name}");
        return back()->with('success', 'Room deleted successfully!');
    }

    public function deleteGallery(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return back()->with('success', 'Image deleted.');
    }
}
