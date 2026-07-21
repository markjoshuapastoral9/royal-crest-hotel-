<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user     = auth()->user();
        $bookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // LAB EXAM REQUIREMENT: Dynamic statistics from database
        $stats = [
            'total'     => Booking::where('user_id', $user->id)->count(),
            'pending'   => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'completed' => Booking::where('user_id', $user->id)->whereIn('status', ['completed', 'checked_out'])->count(),
        ];

        // LAB EXAM: Total Bookings and Total Users (System-wide)
        $totalBookings = Booking::count();  // Total bookings in the system
        $totalUsers = \App\Models\User::count();  // Total registered users

        return view('customer.dashboard', compact('bookings', 'stats', 'totalBookings', 'totalUsers'));
    }

    public function profile()
    {
        return view('customer.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function downloadInvoice(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['room.roomType', 'payments', 'promotion']);

        $pdf = Pdf::loadView('pdf.invoice', compact('booking'));
        return $pdf->download('invoice-' . $booking->booking_number . '.pdf');
    }
}
