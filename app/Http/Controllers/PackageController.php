<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Room;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::active()
                          ->valid()
                          ->orderBy('sort_order')
                          ->orderBy('name')
                          ->get();

        return view('packages', compact('packages'));
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)
                         ->active()
                         ->valid()
                         ->firstOrFail();

        return view('packages.show', compact('package'));
    }

    /**
     * Show the booking form pre-filled with package details
     */
    public function book(Request $request, $slug)
    {
        $package = Package::where('slug', $slug)
                         ->active()
                         ->valid()
                         ->firstOrFail();

        $checkIn  = $request->check_in  ?? now()->addDay()->format('Y-m-d');
        $checkOut = $request->check_out ?? now()->addDays(1 + $package->min_nights)->format('Y-m-d');

        // Get available rooms for the package booking
        $rooms = Room::where('status', 'available')
                     ->with('roomType')
                     ->orderBy('price_per_night')
                     ->get();

        return view('packages.book', compact('package', 'checkIn', 'checkOut', 'rooms'));
    }
}
