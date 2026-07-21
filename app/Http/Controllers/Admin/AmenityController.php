<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::withCount('rooms')->get();
        return view('admin.amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'icon'     => 'nullable|string|max:100',
            'category' => 'required|in:room,hotel',
        ]);
        $validated['is_active'] = true;
        Amenity::create($validated);
        return back()->with('success', 'Amenity created!');
    }

    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'icon'     => 'nullable|string|max:100',
            'category' => 'required|in:room,hotel',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $amenity->update($validated);
        return back()->with('success', 'Amenity updated!');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        return back()->with('success', 'Amenity deleted.');
    }
}
