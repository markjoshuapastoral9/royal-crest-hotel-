<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'code'            => 'required|string|max:50|unique:promotions',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'discount_type'   => 'required|in:percentage,fixed',
            'discount_value'  => 'required|numeric|min:0',
            'minimum_nights'  => 'nullable|numeric|min:1',
            'minimum_amount'  => 'nullable|numeric|min:0',
            'valid_from'      => 'nullable|date',
            'valid_until'     => 'nullable|date|after_or_equal:valid_from',
            'usage_limit'     => 'nullable|integer|min:1',
        ]);

        $validated['code']      = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($validated);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created!');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_nights' => 'nullable|numeric|min:1',
            'minimum_amount' => 'nullable|numeric|min:0',
            'valid_from'     => 'nullable|date',
            'valid_until'    => 'nullable|date|after_or_equal:valid_from',
            'usage_limit'    => 'nullable|integer|min:1',
        ]);

        $validated['code']      = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($promotion->image) Storage::disk('public')->delete($promotion->image);
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($validated);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated!');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image) Storage::disk('public')->delete($promotion->image);
        $promotion->delete();
        return back()->with('success', 'Promotion deleted.');
    }
}
