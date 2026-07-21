<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\ActivityLog;
use App\Mail\BookingApprovedMail;
use App\Mail\BookingCancelledMail;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\BookingCancelledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function calendar(Request $request)
    {
        // For the view we just pass status counts for the legend summary
        $statusCounts = Booking::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // If it's an AJAX/JSON request return events for FullCalendar
        if ($request->expectsJson() || $request->has('start')) {
            $query = Booking::with(['room'])
                ->when($request->filled('start'), fn($q) => $q->whereDate('check_in', '>=', $request->start))
                ->when($request->filled('end'),   fn($q) => $q->whereDate('check_out', '<=', $request->end));

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $colorMap = [
                'pending'     => '#FFC107',
                'confirmed'   => '#198754',
                'checked_in'  => '#0DCAF0',
                'completed'   => '#0D6EFD',
                'cancelled'   => '#DC3545',
            ];

            $events = $query->get()->map(function (Booking $b) use ($colorMap) {
                $color = $colorMap[$b->status] ?? '#6C757D';
                return [
                    'id'                => $b->id,
                    'title'             => $b->room->name . ' — ' . $b->guest_name,
                    'start'             => $b->check_in->toDateString(),
                    'end'               => $b->check_out->addDay()->toDateString(), // FullCalendar end is exclusive
                    'color'             => $color,
                    'textColor'         => in_array($b->status, ['pending', 'checked_in']) ? '#000' : '#fff',
                    'extendedProps'     => [
                        'booking_number' => $b->booking_number,
                        'guest_name'     => $b->guest_name,
                        'guest_email'    => $b->guest_email,
                        'room'           => $b->room->name,
                        'room_number'    => $b->room->room_number,
                        'check_in'       => $b->check_in->format('M d, Y'),
                        'check_out'      => $b->check_out->subDay()->format('M d, Y'), // display original
                        'nights'         => $b->nights,
                        'total_amount'   => number_format($b->total_amount, 2),
                        'status'         => ucfirst(str_replace('_', ' ', $b->status)),
                        'payment_status' => ucfirst(str_replace('_', ' ', $b->payment_status)),
                        'url'            => route('admin.bookings.show', $b->id),
                    ],
                ];
            });

            return response()->json($events);
        }

        return view('admin.bookings.calendar', compact('statusCounts'));
    }

    public function index(Request $request)
    {
        $query = Booking::with(['room', 'user']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('booking_number', 'like', "%{$request->search}%")
                  ->orWhere('guest_name', 'like', "%{$request->search}%")
                  ->orWhere('guest_email', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'user', 'payments', 'promotion', 'confirmedBy']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $booking->load(['room.roomType', 'user', 'payments', 'promotion']);
        $rooms = Room::with('roomType')->where('status', '!=', 'maintenance')->get();
        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'guest_name'    => 'required|string|max:255',
            'guest_email'   => 'required|email|max:255',
            'guest_phone'   => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'check_in'      => 'required|date',
            'check_out'     => 'required|date|after:check_in',
            'adults'        => 'required|integer|min:1',
            'children'      => 'required|integer|min:0',
            'payment_status'=> 'required|in:unpaid,partially_paid,paid,refunded',
            'status'        => 'required|in:pending,confirmed,checked_in,completed,cancelled',
            'special_requests' => 'nullable|string|max:1000',
            'admin_notes'   => 'nullable|string|max:1000',
        ]);

        // Recalculate nights & totals if dates changed
        $checkIn  = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights   = $checkIn->diffInDays($checkOut);
        $subtotal = $nights * $booking->room_price_per_night;
        $tax      = $subtotal * 0.12;
        $total    = $subtotal - $booking->discount_amount + $tax;

        // Capture old status and payment status for notification logic
        $oldStatus = $booking->status;
        $oldPaymentStatus = $booking->payment_status;

        $booking->update([
            'guest_name'      => $request->guest_name,
            'guest_email'     => $request->guest_email,
            'guest_phone'     => $request->guest_phone,
            'guest_address'   => $request->guest_address,
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'nights'          => $nights,
            'subtotal'        => $subtotal,
            'tax_amount'      => $tax,
            'total_amount'    => $total,
            'adults'          => $request->adults,
            'children'        => $request->children,
            'payment_status'  => $request->payment_status,
            'status'          => $request->status,
            'special_requests'=> $request->special_requests,
            'admin_notes'     => $request->admin_notes,
        ]);

        // Handle status change notifications
        if ($oldStatus !== $request->status) {
            if ($request->status === 'confirmed' && $oldStatus === 'pending') {
                // Send confirmation email and notification
                try {
                    Mail::to($booking->guest_email)->send(new BookingApprovedMail($booking));
                } catch (\Exception $e) {}
                
                try {
                    if ($booking->user) {
                        $booking->user->notify(new BookingConfirmedNotification($booking));
                    }
                } catch (\Exception $e) {}
            } elseif ($request->status === 'cancelled') {
                // Send cancellation notification
                try {
                    if ($booking->user) {
                        $booking->user->notify(new BookingCancelledNotification($booking));
                    }
                } catch (\Exception $e) {}
            }
        }

        // Handle payment status change to refunded
        if ($oldPaymentStatus !== 'refunded' && $request->payment_status === 'refunded') {
            // Send refund notification/email
            try {
                Mail::to($booking->guest_email)->send(new \App\Mail\BookingRefundedMail($booking));
            } catch (\Exception $e) {}
            
            try {
                if ($booking->user) {
                    $booking->user->notify(new \App\Notifications\BookingRefundedNotification($booking));
                }
            } catch (\Exception $e) {}
        }

        // Always send a generic booking updated email
        try {
            Mail::to($booking->guest_email)->send(new \App\Mail\BookingUpdatedMail($booking));
        } catch (\Exception $e) {}

        ActivityLog::log('updated', "Updated booking: {$booking->booking_number}", $booking);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $bookingNumber = $booking->booking_number;

        // Free up room if needed
        if (in_array($booking->status, ['confirmed', 'checked_in'])) {
            $booking->room->update(['status' => 'available']);
        }

        $booking->delete();

        ActivityLog::log('deleted', "Deleted booking: {$bookingNumber}");

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$bookingNumber} has been deleted.");
    }

    public function confirm(Booking $booking)
    {
        $isAjax = request()->wantsJson() || request()->ajax();

        if (!$booking->isPending()) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Only pending bookings can be confirmed.'], 400);
            }
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
        ]);

        // Update room status
        $booking->room->update(['status' => 'reserved']);

        try {
            Mail::to($booking->guest_email)->send(new BookingApprovedMail($booking));
        } catch (\Exception $e) {}

        // Notify customer
        try {
            if ($booking->user) {
                $booking->user->notify(new BookingConfirmedNotification($booking));
            }
        } catch (\Exception $e) {}

        ActivityLog::log('confirmed', "Confirmed booking: {$booking->booking_number}", $booking);

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Booking confirmed successfully',
                'booking' => [
                    'id'             => $booking->id,
                    'status'         => $booking->status,
                    'booking_number' => $booking->booking_number
                ]
            ]);
        }

        return back()->with('success', 'Booking confirmed and email sent to guest.');
    }

    public function checkIn(Booking $booking)
    {
        if (!$booking->isConfirmed()) {
            return back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        $booking->update(['status' => 'checked_in', 'checked_in_at' => now()]);
        $booking->room->update(['status' => 'occupied']);

        ActivityLog::log('checked_in', "Checked in: {$booking->booking_number}", $booking);
        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        if (!$booking->isCheckedIn()) {
            return back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        $booking->update(['status' => 'completed', 'checked_out_at' => now()]);
        $booking->room->update(['status' => 'available']);

        ActivityLog::log('checked_out', "Checked out: {$booking->booking_number}", $booking);
        return back()->with('success', 'Guest checked out successfully.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        $booking->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $request->reason,
            'cancelled_at'        => now(),
        ]);

        if (in_array($booking->room->status, ['reserved', 'occupied'])) {
            $booking->room->update(['status' => 'available']);
        }

        try {
            Mail::to($booking->guest_email)->send(new BookingCancelledMail($booking));
        } catch (\Exception $e) {}

        // Notify customer
        try {
            if ($booking->user) {
                $booking->user->notify(new BookingCancelledNotification($booking));
            }
        } catch (\Exception $e) {}

        ActivityLog::log('cancelled', "Cancelled booking: {$booking->booking_number}", $booking);
        return back()->with('success', 'Booking cancelled.');
    }

    public function printInvoice(Booking $booking)
    {
        $booking->load(['room.roomType', 'payments', 'promotion']);
        $pdf = Pdf::loadView('pdf.invoice', compact('booking'));
        return $pdf->stream('invoice-' . $booking->booking_number . '.pdf');
    }

    public function walkInForm()
    {
        $rooms = \App\Models\Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('name')
            ->get();
        return view('admin.bookings.walk-in', compact('rooms'));
    }

    public function walkInStore(Request $request)
    {
        $validated = $request->validate([
            'guest_name'       => 'required|string|max:255',
            'guest_email'      => 'required|email|max:255',
            'guest_phone'      => 'required|string|max:20',
            'guest_address'    => 'nullable|string|max:500',
            'room_id'          => 'required|exists:rooms,id',
            'check_in'         => 'required|date',
            'check_out'        => 'required|date|after:check_in',
            'adults'           => 'required|integer|min:1',
            'children'         => 'nullable|integer|min:0',
            'payment_method'   => 'required|in:cash,gcash,maya,bank_transfer',
            'payment_status'   => 'required|in:unpaid,paid',
            'special_requests' => 'nullable|string',
            'admin_notes'      => 'nullable|string',
            'status'           => 'required|in:pending,confirmed',
        ]);

        $room   = \App\Models\Room::findOrFail($validated['room_id']);
        $nights = Carbon::parse($validated['check_in'])->diffInDays($validated['check_out']);
        $subtotal = $nights * $room->price_per_night;
        $tax      = round($subtotal * 0.12, 2);
        $total    = $subtotal + $tax;

        $booking = Booking::create([
            'booking_number'       => Booking::generateBookingNumber(),
            'user_id'              => null,
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
            'discount_amount'      => 0,
            'tax_amount'           => $tax,
            'total_amount'         => $total,
            'payment_method'       => $validated['payment_method'],
            'payment_status'       => $validated['payment_status'],
            'status'               => $validated['status'],
            'admin_notes'          => $validated['admin_notes'] ?? null,
            'confirmed_at'         => $validated['status'] === 'confirmed' ? now() : null,
            'confirmed_by'         => $validated['status'] === 'confirmed' ? auth()->id() : null,
        ]);

        // If confirmed, mark room occupied
        if ($validated['status'] === 'confirmed') {
            $room->update(['status' => 'occupied']);
        }

        ActivityLog::log('created', "Walk-in booking created: {$booking->booking_number}", $booking);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Walk-in booking {$booking->booking_number} created successfully!");
    }
}
