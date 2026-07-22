<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiningController extends Controller
{
    /**
     * Display the main restaurant page
     */
    public function restaurant()
    {
        return view('dining.restaurant');
    }

    /**
     * Display the menu page
     */
    public function menu()
    {
        return view('dining.menu');
    }

    /**
     * Display the private dining page
     */
    public function privateDining()
    {
        return view('dining.private-dining');
    }

    /**
     * Display the room service page
     */
    public function roomService()
    {
        return view('dining.room-service');
    }

    /**
     * Handle private dining reservation form submission
     */
    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'room'     => 'required|string',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'required|string|max:30',
            'occasion' => 'required|string',
            'date'     => 'required|date|after:today',
            'time'     => 'required|string',
            'guests'   => 'required|integer|min:1|max:20',
            'duration' => 'required|string',
            'message'  => 'nullable|string|max:1000',
        ]);

        // Notify admin + send confirmation to guest
        try {
            $emailData = [
                'room'     => $validated['room'],
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'],
                'occasion' => $validated['occasion'],
                'date'     => $validated['date'],
                'time'     => $validated['time'],
                'guests'   => $validated['guests'],
                'duration' => $validated['duration'],
                'message'  => $validated['message'] ?? 'None',
            ];

            // 1️⃣ Notify admin
            \Illuminate\Support\Facades\Mail::send(
                'emails.private-dining-reservation',
                ['data' => $emailData],
                function ($message) use ($validated) {
                    $message->to(config('mail.from.address', 'admin@royalcresthotel.com'))
                            ->subject('🍽️ New Private Dining Reservation — ' . $validated['name']);
                }
            );

            // 2️⃣ Send confirmation copy to guest
            \Illuminate\Support\Facades\Mail::send(
                'emails.private-dining-reservation',
                ['data' => $emailData],
                function ($message) use ($validated) {
                    $message->to($validated['email'])
                            ->subject('Your Private Dining Reservation — The Royal Crest');
                }
            );
        } catch (\Exception $e) {
            // Email failure won't block the flow
        }

        return redirect()
            ->route('dining.private')
            ->with('reservation_success', true);
    }
}
