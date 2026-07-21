<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')->get();
        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:room_types',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
        ]);
        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = true;
        RoomType::create($validated);
        return back()->with('success', 'Room type created!');
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:room_types,name,' . $roomType->id,
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
        ]);
        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $roomType->update($validated);
        return back()->with('success', 'Room type updated!');
    }

    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->count() > 0) {
            return back()->with('error', 'Cannot delete room type with existing rooms.');
        }
        $roomType->delete();
        return back()->with('success', 'Room type deleted.');
    }
}
