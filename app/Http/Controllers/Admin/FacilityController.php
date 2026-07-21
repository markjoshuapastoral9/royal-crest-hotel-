<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('sort_order')->paginate(15);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'icon'            => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'operating_hours' => 'nullable|string|max:255',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
            'sort_order'      => 'nullable|integer',
        ]);

        $validated['slug']       = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('facilities', 'public');
        }

        Facility::create($validated);
        return redirect()->route('admin.facilities.index')->with('success', 'Facility created!');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'icon'            => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'operating_hours' => 'nullable|string|max:255',
            'sort_order'      => 'nullable|integer',
        ]);

        $validated['slug']       = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($facility->image) Storage::disk('public')->delete($facility->image);
            $validated['image'] = $request->file('image')->store('facilities', 'public');
        }

        $facility->update($validated);
        return redirect()->route('admin.facilities.index')->with('success', 'Facility updated!');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->image) Storage::disk('public')->delete($facility->image);
        $facility->delete();
        return back()->with('success', 'Facility deleted.');
    }
}
