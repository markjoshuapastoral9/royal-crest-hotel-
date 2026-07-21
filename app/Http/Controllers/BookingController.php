<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Promotion;
use App\Mail\BookingConfirmationMail;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /** Show booking form for a specific room */
    public function create(Request $request, Room $room = null)
    {
        // If no room specified, redirect to rooms page
        if (!$room) {
            return redirect()->route('rooms.index')->with('warning', 'Please select a room to book.');
        }

        $checkIn  = $request->check_in ?? now()->addDay()->format('Y-m-d');
        $checkOut = $request->check_out ?? now()->addDays(2)->format('Y-m-d');

        $nights = max(1, \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)));

        // Use the representative (unit A / first available) for display,
        // but find an available unit for the selected dates to show correct availability
        $displayRoom = $this->findDisplayRoom($room);
        
        // Eager load roomType relationship to avoid N+1 queries
        $displayRoom->load('roomType');

        // Booked ranges: a date is "fully blocked" only when all 4 units are taken
        $bookedRanges = $this->getBookedRanges($displayRoom);

        // Total units of this variant (cached for 5 minutes)
        $totalUnits = \Cache::remember("room_units_{$displayRoom->name}", 300, function() use ($displayRoom) {
            return Room::where('name', $displayRoom->name)->where('status', 'available')->count();
        });
        $totalUnits = max($totalUnits, 1);

        // OPTIMIZATION: Pre-fetch available units for selected dates (moved from view)
        $availableUnits = Room::where('name', $displayRoom->name)
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->whereNotIn('status', ['cancelled', 'completed'])
                  ->where(function ($q2) use ($checkIn, $checkOut) {
                      $q2->whereBetween('check_in', [$checkIn, $checkOut])
                         ->orWhereBetween('check_out', [$checkIn, $checkOut])
                         ->orWhere(function ($q3) use ($checkIn, $checkOut) {
                             $q3->where('check_in', '<=', $checkIn)
                                ->where('check_out', '>=', $checkOut);
                         });
                  });
            })
            ->orderBy('room_number')
            ->get();

        return view('booking.create', compact('room', 'displayRoom', 'checkIn', 'checkOut', 'nights', 'bookedRanges', 'totalUnits', 'availableUnits'));
    }

    /** Return booked date ranges for a room as JSON (used by booking form JS) */
    public function bookedDates(Room $room)
    {
        return response()->json($this->getBookedRanges($room));
    }

    /**
     * Get the unit-A (display) representative for a given room.
     * If the room passed IS already unit-A, return it directly.
     */
    private function findDisplayRoom(Room $room): Room
    {
        // If room_number ends in A it's already the representative
        if (str_ends_with($room->room_number, 'A')) {
            return $room;
        }
        // Find the unit-A sibling
        $base = rtrim($room->room_number, 'ABCDE');
        $unitA = Room::where('room_number', $base . 'A')->first();
        return $unitA ?? $room;
    }

    /**
     * Find the first available physical unit of the same variant for given dates.
     * Returns null if all units are booked.
     */
    private function findAvailableUnit(Room $room, string $checkIn, string $checkOut, ?int $excludeBookingId = null): ?Room
    {
        return Room::where('name', $room->name)
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut, $excludeBookingId) {
                $q->whereNotIn('status', ['cancelled', 'completed'])
                  ->when($excludeBookingId, fn($q) => $q->where('id', '!=', $excludeBookingId))
                  ->where(function ($q2) use ($checkIn, $checkOut) {
                      $q2->whereBetween('check_in', [$checkIn, $checkOut])
                         ->orWhereBetween('check_out', [$checkIn, $checkOut])
                         ->orWhere(fn($q3) => $q3->where('check_in', '<=', $checkIn)
                                                   ->where('check_out', '>=', $checkOut));
                  });
            })
            ->orderBy('room_number')
            ->first();
    }

    /**
     * Get date ranges that are FULLY blocked (all units taken).
     * A date range is returned only when every unit of this variant is booked for it.
     */
    private function getBookedRanges(Room $room): array
    {
        $totalUnits = Room::where('name', $room->name)->where('status', 'available')->count();
        if ($totalUnits === 0) return [];

        // Gather all active bookings across all units of this variant
        $bookings = Booking::whereIn('room_id',
                Room::where('name', $room->name)->pluck('id')
            )
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->get(['check_in', 'check_out', 'room_id']);

        if ($bookings->isEmpty()) return [];

        // Find date ranges where the booking count per day equals total units
        // Build a day → count map
        $dayCount = [];
        foreach ($bookings as $b) {
            $cur = \Carbon\Carbon::parse($b->check_in);
            $end = \Carbon\Carbon::parse($b->check_out); // exclusive
            while ($cur->lt($end)) {
                $key = $cur->toDateString();
                $dayCount[$key] = ($dayCount[$key] ?? 0) + 1;
                $cur->addDay();
            }
        }

        // Collect only days where ALL units are booked
        $fullyBooked = array_keys(array_filter($dayCount, fn($c) => $c >= $totalUnits));
        if (empty($fullyBooked)) return [];

        sort($fullyBooked);

        // Collapse consecutive days into ranges
        $ranges = [];
        $start  = $fullyBooked[0];
        $prev   = $fullyBooked[0];
        foreach (array_slice($fullyBooked, 1) as $day) {
            $expected = \Carbon\Carbon::parse($prev)->addDay()->toDateString();
            if ($day === $expected) {
                $prev = $day;
            } else {
                $ranges[] = ['from' => $start, 'to' => \Carbon\Carbon::parse($prev)->addDay()->toDateString()];
                $start = $day;
                $prev  = $day;
            }
        }
        $ranges[] = ['from' => $start, 'to' => \Carbon\Carbon::parse($prev)->addDay()->toDateString()];

        return $ranges;
    }

    /** Store new booking */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'guest_name'       => 'required|string|max:255',
            'guest_email'      => 'required|email|max:255',
            'guest_phone'      => 'required|string|max:20',
            'guest_address'    => 'nullable|string',
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'adults'           => 'required|integer|min:1|max:10',
            'children'         => 'nullable|integer|min:0|max:10',
            'special_requests' => 'nullable|string',
            'payment_method'   => 'required|in:cash,gcash,maya,bank_transfer',
            'payment_proof'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'promo_code'       => 'nullable|string',
            'terms'            => 'required|accepted',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Auto-assign the first available unit of this variant for the requested dates
        $assignedRoom = $this->findAvailableUnit($room, $validated['check_in'], $validated['check_out']);
        if (!$assignedRoom) {
            return back()->with('error', 'Sorry, all units of this room are fully booked for the selected dates. Please choose different dates.')->withInput();
        }
        $room = $assignedRoom;

        $nights   = \Carbon\Carbon::parse($validated['check_in'])->diffInDays($validated['check_out']);
        $subtotal = $nights * $room->price_per_night;
        $discount = 0;
        $promotion = null;

        // Apply promo code
        if (!empty($validated['promo_code'])) {
            $promotion = Promotion::where('code', $validated['promo_code'])->first();
            if ($promotion && $promotion->isValid() && $nights >= $promotion->minimum_nights) {
                $discount = $promotion->calculateDiscount($subtotal);
            }
        }

        $tax   = round(($subtotal - $discount) * 0.12, 2); // 12% VAT
        $total = $subtotal - $discount + $tax;

        DB::beginTransaction();
        try {
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            $booking = Booking::create([
                'booking_number'       => Booking::generateBookingNumber(),
                'user_id'              => auth()->id(),
                'room_id'              => $room->id,
                'guest_name'           => $validated['guest_name'],
                'guest_email'          => $validated['guest_email'],
                'guest_phone'          => $validated['guest_phone'],
                'guest_address'        => $validated['guest_address'] ?? null,
                'check_in'             => $validated['check_in'],
                'check_out'            => $validated['check_out'],
                'adults'               => $validated['adults'],
                'children'             => $validated['children'] ?? 0,
                'special_requests'     => $validated['special_requests'] ?? null,
                'nights'               => $nights,
                'room_price_per_night' => $room->price_per_night,
                'subtotal'             => $subtotal,
                'discount_amount'      => $discount,
                'tax_amount'           => $tax,
                'total_amount'         => $total,
                'promotion_id'         => $promotion?->id,
                'payment_method'       => $validated['payment_method'],
                'payment_proof'        => $proofPath,
                'status'               => 'pending',
                'payment_status'       => $proofPath ? 'partially_paid' : 'unpaid',
            ]);

            // Increment promo usage
            if ($promotion) {
                $promotion->increment('used_count');
            }

            DB::commit();

            // Send confirmation email
            try {
                Mail::to($booking->guest_email)->send(new BookingConfirmationMail($booking));
            } catch (\Exception $e) {
                // Email failure shouldn't block booking
            }

            // Send payment instructions for GCash, Maya, or Bank Transfer
            if (in_array($booking->payment_method, ['gcash', 'maya', 'bank_transfer'])) {
                try {
                    Mail::to($booking->guest_email)->send(new \App\Mail\PaymentInstructionsMail($booking));
                } catch (\Exception $e) {
                    // Email failure shouldn't block booking
                }
            }

            // Notify all admins of new booking
            try {
                $admins = \App\Models\User::where('role', 'admin')->orWhere('role', 'staff')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new NewBookingNotification($booking));
                }
            } catch (\Exception $e) {}

            return redirect()->route('booking.success', $booking)
                ->with('success', 'Your booking has been submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed. Please try again.')->withInput();
        }
    }

    public function success(Booking $booking)
    {
        // Only the guest or admin can see this
        if (auth()->check() && auth()->id() !== $booking->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $booking->load('room.roomType');

        // Generate QR code for all bookings (not just confirmed)
        $qrDataUri = null;
        try {
            $qrCodeService = app(\App\Services\QrCodeService::class);
            $qrDataUri = $qrCodeService->generate($booking);
        } catch (\Throwable $e) {
            // QR generation is non-critical; proceed without it
        }

        return view('booking.success', compact('booking', 'qrDataUri'));
    }

    /** Customer: booking calendar view */
    public function calendar(Request $request)
    {
        // JSON events for FullCalendar
        if ($request->expectsJson() || $request->has('start')) {
            $colorMap = [
                'pending'     => '#D4A853',
                'confirmed'   => '#4ade80',
                'checked_in'  => '#38bdf8',
                'completed'   => '#818cf8',
                'cancelled'   => '#f87171',
            ];

            $bookings = Booking::with('room')
                ->where('user_id', auth()->id())
                ->when($request->filled('start'), fn($q) => $q->whereDate('check_in', '>=', $request->start))
                ->when($request->filled('end'),   fn($q) => $q->whereDate('check_out', '<=', $request->end))
                ->get();

            $events = $bookings->map(function (Booking $b) use ($colorMap) {
                return [
                    'id'            => $b->id,
                    'title'         => $b->room->name,
                    'start'         => $b->check_in->toDateString(),
                    'end'           => $b->check_out->addDay()->toDateString(),
                    'color'         => $colorMap[$b->status] ?? '#A6824A',
                    'textColor'     => in_array($b->status, ['pending']) ? '#101111' : '#fff',
                    'extendedProps' => [
                        'booking_number' => $b->booking_number,
                        'room'           => $b->room->name,
                        'room_number'    => $b->room->room_number,
                        'check_in'       => $b->check_in->format('M d, Y'),
                        'check_out'      => $b->check_out->subDay()->format('M d, Y'),
                        'nights'         => $b->nights,
                        'total_amount'   => number_format($b->total_amount, 2),
                        'status'         => ucfirst(str_replace('_', ' ', $b->status)),
                        'payment_status' => ucfirst(str_replace('_', ' ', $b->payment_status)),
                        'url'            => route('booking.show', $b->id),
                    ],
                ];
            });

            return response()->json($events);
        }

        // Summary counts for current user
        $statusCounts = Booking::where('user_id', auth()->id())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('customer.calendar', compact('statusCounts'));
    }

    /** Customer: list own bookings */
    public function myBookings()
    {
        $bookings = Booking::with('room.roomType')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }

    /** Customer: view booking detail */
    public function show(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $booking->load(['room.roomType', 'payments', 'promotion']);
        return view('customer.booking-detail', compact('booking'));
    }

    /** Customer: cancel booking */
    public function cancel(Request $request, Booking $booking)
    {
        if (auth()->id() !== $booking->user_id) abort(403);

        if (!$booking->isPending() && !$booking->isConfirmed()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $request->validate(['reason' => 'nullable|string|max:500']);

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $request->reason,
            'cancelled_at'        => now(),
        ]);

        return back()->with('success', 'Your booking has been cancelled.');
    }

    /** Customer: submit payment proof */
    public function submitPayment(Request $request, Booking $booking)
    {
        if (auth()->id() !== $booking->user_id) abort(403);

        $request->validate([
            'reference_number' => 'required|string|max:100',
            'method'           => 'required|in:cash,gcash,maya,bank_transfer',
            'amount'           => 'required|numeric|min:1',
            'proof_image'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $proofPath = $request->file('proof_image')->store('payment-proofs', 'public');

        $payment = \App\Models\Payment::create([
            'booking_id'       => $booking->id,
            'reference_number' => $request->reference_number,
            'amount'           => $request->amount,
            'method'           => $request->method,
            'proof_image'      => $proofPath,
            'status'           => 'pending',
        ]);

        // Update booking payment status
        $booking->update(['payment_status' => 'partially_paid']);

        // Notify admins
        try {
            $admins = \App\Models\User::where('role', 'admin')->orWhere('role', 'staff')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewBookingNotification($booking));
            }
        } catch (\Exception $e) {}

        return back()->with('success', 'Payment proof submitted! We will verify your payment shortly.');
    }

    /** Check availability via AJAX */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room      = Room::findOrFail($request->room_id);
        $available = $room->isAvailableFor($request->check_in, $request->check_out);
        $nights    = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);

        return response()->json([
            'available' => $available,
            'nights'    => $nights,
            'subtotal'  => $nights * $room->price_per_night,
        ]);
    }

    /** Apply promo code via AJAX */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'code'    => 'required|string',
            'amount'  => 'required|numeric',
            'nights'  => 'required|integer',
        ]);

        $promo = Promotion::where('code', strtoupper($request->code))->first();

        if (!$promo || !$promo->isValid() || $request->nights < $promo->minimum_nights) {
            return response()->json(['valid' => false, 'message' => 'Invalid or expired promo code.']);
        }

        $discount = $promo->calculateDiscount($request->amount);

        return response()->json([
            'valid'    => true,
            'discount' => $discount,
            'message'  => "Promo applied! You save ₱" . number_format($discount, 2),
        ]);
    }

    /** Download booking receipt */
    public function downloadReceipt(Booking $booking)
    {
        // Only the guest or admin can download
        if (auth()->check() && auth()->id() !== $booking->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['room.roomType', 'promotion', 'payments']);
        
        return view('booking.receipt', compact('booking'));
    }
}

