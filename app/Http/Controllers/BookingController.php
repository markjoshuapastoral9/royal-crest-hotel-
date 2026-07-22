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

        $checkIn  = $request->check_in  ?? now()->addDay()->format('Y-m-d');
        $checkOut = $request->check_out ?? now()->addDays(2)->format('Y-m-d');
        $checkInTime  = $request->check_in_time  ?? '14:00';
        $checkOutTime = $request->check_out_time ?? '11:00';

        $checkInDt  = \Carbon\Carbon::parse("{$checkIn} {$checkInTime}");
        $checkOutDt = \Carbon\Carbon::parse("{$checkOut} {$checkOutTime}");
        $diffHours  = max(1, $checkInDt->diffInHours($checkOutDt));
        $nights     = max(1, (int) ceil($diffHours / 24));

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

        // OPTIMIZATION: Pre-fetch available units for selected dates/times (time-aware)
        $ciDt = \Carbon\Carbon::parse("{$checkIn} {$checkInTime}");
        $coDt = \Carbon\Carbon::parse("{$checkOut} {$checkOutTime}");

        $allUnits = Room::where('name', $displayRoom->name)
            ->where('status', 'available')
            ->with(['bookings' => fn($q) => $q->whereNotIn('status', ['cancelled', 'completed'])])
            ->orderBy('room_number')
            ->get();

        $availableUnits = $allUnits->filter(function ($unit) use ($ciDt, $coDt) {
            return !$unit->bookings->contains(function ($b) use ($ciDt, $coDt) {
                $existStart = \Carbon\Carbon::parse($b->check_in->toDateString()  . ' ' . ($b->check_in_time  ?? '14:00'));
                $existEnd   = \Carbon\Carbon::parse($b->check_out->toDateString() . ' ' . ($b->check_out_time ?? '11:00'));
                return $ciDt->lt($existEnd) && $coDt->gt($existStart);
            });
        });

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
     * Check whether the bookings table has the time columns yet.
     * Cached per request so we only hit the DB once.
     */
    private static ?bool $hasTimeColumns = null;
    private function hasTimeColumns(): bool
    {
        if (self::$hasTimeColumns === null) {
            self::$hasTimeColumns = \Illuminate\Support\Facades\Schema::hasColumn('bookings', 'check_in_time');
        }
        return self::$hasTimeColumns;
    }

    /**
     * Find the first available physical unit of the same variant for given dates AND times.
     * Falls back to date-only overlap when time columns don't exist yet.
     */
    private function findAvailableUnit(Room $room, string $checkIn, string $checkOut, string $checkInTime = '14:00', string $checkOutTime = '11:00', ?int $excludeBookingId = null): ?Room
    {
        $newStart = \Carbon\Carbon::parse("{$checkIn} {$checkInTime}");
        $newEnd   = \Carbon\Carbon::parse("{$checkOut} {$checkOutTime}");
        $hasTimes = $this->hasTimeColumns();

        $units = Room::where('name', $room->name)
            ->where('status', 'available')
            ->when($excludeBookingId, fn($q) => $q->whereDoesntHave('bookings', fn($bq) => $bq->where('id', $excludeBookingId)))
            ->with(['bookings' => fn($q) => $q->whereNotIn('status', ['cancelled', 'completed'])])
            ->orderBy('room_number')
            ->get();

        foreach ($units as $unit) {
            $hasConflict = $unit->bookings->contains(function ($b) use ($newStart, $newEnd, $hasTimes) {
                $ciTime = $hasTimes ? ($b->check_in_time  ?? '14:00') : '14:00';
                $coTime = $hasTimes ? ($b->check_out_time ?? '11:00') : '11:00';
                $existStart = \Carbon\Carbon::parse($b->check_in->toDateString()  . ' ' . $ciTime);
                $existEnd   = \Carbon\Carbon::parse($b->check_out->toDateString() . ' ' . $coTime);
                return $newStart->lt($existEnd) && $newEnd->gt($existStart);
            });

            if (!$hasConflict) {
                return $unit;
            }
        }

        return null;
    }

    /**
     * Get ranges that are FULLY blocked (all units taken), with time info.
     * Gracefully degrades to date-only ranges when time columns don't exist.
     */
    private function getBookedRanges(Room $room): array
    {
        $totalUnits = Room::where('name', $room->name)->where('status', 'available')->count();
        if ($totalUnits === 0) return [];

        $hasTimes = $this->hasTimeColumns();

        // Only select time columns if they exist
        $columns = $hasTimes
            ? ['check_in', 'check_out', 'check_in_time', 'check_out_time', 'room_id']
            : ['check_in', 'check_out', 'room_id'];

        $bookings = Booking::whereIn('room_id',
                Room::where('name', $room->name)->pluck('id')
            )
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->get($columns);

        if ($bookings->isEmpty()) return [];

        $hourCount = [];
        foreach ($bookings as $b) {
            $ciTime = $hasTimes ? ($b->check_in_time  ?? '14:00') : '14:00';
            $coTime = $hasTimes ? ($b->check_out_time ?? '11:00') : '11:00';
            $cur = \Carbon\Carbon::parse($b->check_in->toDateString()  . ' ' . $ciTime);
            $end = \Carbon\Carbon::parse($b->check_out->toDateString() . ' ' . $coTime);
            while ($cur->lt($end)) {
                $key = $cur->format('Y-m-d H:00');
                $hourCount[$key] = ($hourCount[$key] ?? 0) + 1;
                $cur->addHour();
            }
        }

        $fullyBlockedHours = array_keys(array_filter($hourCount, fn($c) => $c >= $totalUnits));
        if (empty($fullyBlockedHours)) return [];

        sort($fullyBlockedHours);

        $ranges = [];
        $rangeStart = $fullyBlockedHours[0];
        $prev       = $fullyBlockedHours[0];

        foreach (array_slice($fullyBlockedHours, 1) as $hour) {
            $expected = \Carbon\Carbon::parse($prev)->addHour()->format('Y-m-d H:00');
            if ($hour === $expected) {
                $prev = $hour;
            } else {
                $ranges[] = $this->buildRange($rangeStart, $prev);
                $rangeStart = $hour;
                $prev       = $hour;
            }
        }
        $ranges[] = $this->buildRange($rangeStart, $prev);

        return $ranges;
    }

    /** Helper: build a range array from two hour-strings */
    private function buildRange(string $startHour, string $endHour): array
    {
        $s = \Carbon\Carbon::parse($startHour);
        $e = \Carbon\Carbon::parse($endHour)->addHour(); // end is exclusive
        return [
            'from'    => $s->toDateString(),
            'to'      => $e->toDateString(),
            'ci_time' => $s->format('H:i'),
            'co_time' => $e->format('H:i'),
        ];
    }

    /** Store new booking */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'package_id'       => 'nullable|exists:packages,id',
            'guest_name'       => 'required|string|max:255',
            'guest_email'      => 'required|email|max:255',
            'guest_phone'      => 'required|string|max:20',
            'guest_address'    => 'nullable|string',
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after_or_equal:check_in',
            'check_in_time'    => 'required|string',
            'check_out_time'   => 'required|string',
            'adults'           => 'required|integer|min:1|max:10',
            'children'         => 'nullable|integer|min:0|max:10',
            'special_requests' => 'nullable|string',
            'payment_method'   => 'required|in:cash,gcash,maya,bank_transfer',
            'payment_proof'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'promo_code'       => 'nullable|string',
            'terms'            => 'required|accepted',
        ]);

        $checkInTime  = $validated['check_in_time']  ?? '14:00';
        $checkOutTime = $validated['check_out_time'] ?? '11:00';

        // If time columns don't exist yet, use default times silently
        if (!$this->hasTimeColumns()) {
            $checkInTime  = '14:00';
            $checkOutTime = '11:00';
        }

        // Validate that checkout datetime is strictly after checkin datetime
        $checkInDt  = \Carbon\Carbon::parse("{$validated['check_in']} {$checkInTime}");
        $checkOutDt = \Carbon\Carbon::parse("{$validated['check_out']} {$checkOutTime}");

        if ($checkOutDt->lte($checkInDt)) {
            return back()
                ->withErrors(['check_out_time' => 'Check-out date/time must be after check-in date/time.'])
                ->withInput();
        }

        $room = Room::findOrFail($validated['room_id']);

        // Time-aware unit assignment
        $assignedRoom = $this->findAvailableUnit(
            $room,
            $validated['check_in'],
            $validated['check_out'],
            $checkInTime,
            $checkOutTime
        );
        if (!$assignedRoom) {
            return back()->with('error', 'Sorry, all units of this room are fully booked for the selected dates and times. Please adjust your check-in or check-out time.')->withInput();
        }
        $room = $assignedRoom;

        // ── Nights = ceil of total hours / 24 ─────────────────────────────────
        $diffHours = $checkInDt->diffInHours($checkOutDt);
        $nights    = max(1, (int) ceil($diffHours / 24));
        $subtotal = $nights * $room->price_per_night;
        $discount = 0;
        $promotion = null;

        // Apply package price override if package selected
        $package = null;
        if (!empty($validated['package_id'])) {
            $package  = \App\Models\Package::find($validated['package_id']);
            if ($package) {
                // Use package price as subtotal, override room nightly calc
                $subtotal = $package->price;
                // Apply package savings as discount
                if ($package->savings > 0) {
                    $discount = $package->savings;
                }
            }
        }

        // Apply promo code (on top of package if any)
        if (!empty($validated['promo_code'])) {
            $promotion = Promotion::where('code', $validated['promo_code'])->first();
            if ($promotion && $promotion->isValid() && $nights >= $promotion->minimum_nights) {
                $discount += $promotion->calculateDiscount($subtotal);
            }
        }

        $tax   = round(($subtotal - $discount) * 0.12, 2);
        $total = $subtotal - $discount + $tax;

        DB::beginTransaction();
        try {
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            $bookingData = [
                'booking_number'       => Booking::generateBookingNumber(),
                'user_id'              => auth()->id(),
                'room_id'              => $room->id,
                'package_id'           => $package?->id ?? null,
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
            ];

            // Only save time columns if they exist in DB
            if ($this->hasTimeColumns()) {
                $bookingData['check_in_time']  = $checkInTime;
                $bookingData['check_out_time'] = $checkOutTime;
            }

            // Only save package_id if column exists
            if (\Illuminate\Support\Facades\Schema::hasColumn('bookings', 'package_id')) {
                $bookingData['package_id'] = $package?->id ?? null;
            } else {
                unset($bookingData['package_id']);
            }

            $booking = Booking::create($bookingData);

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
            'room_id'        => 'required|exists:rooms,id',
            'check_in'       => 'required|date',
            'check_out'      => 'required|date|after_or_equal:check_in',
            'check_in_time'  => 'nullable|string',
            'check_out_time' => 'nullable|string',
        ]);

        $checkInTime  = $request->check_in_time  ?? '14:00';
        $checkOutTime = $request->check_out_time ?? '11:00';

        $room      = Room::findOrFail($request->room_id);
        $available = $room->isAvailableFor(
            $request->check_in,
            $request->check_out,
            $checkInTime,
            $checkOutTime
        );

        $checkInDt  = \Carbon\Carbon::parse("{$request->check_in} {$checkInTime}");
        $checkOutDt = \Carbon\Carbon::parse("{$request->check_out} {$checkOutTime}");
        $diffHours  = max(1, $checkInDt->diffInHours($checkOutDt));
        $nights     = max(1, (int) ceil($diffHours / 24));

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

