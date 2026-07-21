<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $galleries = $query->orderBy('sort_order')->paginate(20)->withQueryString();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*'  => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category'  => 'required|in:hotel,rooms,facilities,restaurant,pool,events',
            'title'     => 'nullable|string|max:255',
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('gallery/' . $request->category, 'public');
            Gallery::create([
                'title'    => $request->title,
                'image'    => $path,
                'category' => $request->category,
            ]);
        }

        return back()->with('success', count($request->file('images')) . ' image(s) uploaded.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return back()->with('success', 'Image deleted.');
    }

    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);
        return back()->with('success', 'Updated.');
    }
}
