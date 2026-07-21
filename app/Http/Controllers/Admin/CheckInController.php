<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct(private QrCodeService $qrCodeService) {}

    /**
     * Show the QR scan page.
     */
    public function scan()
    {
        return view('admin.checkin.scan');
    }

    /**
     * Verify a QR payload and return booking details as JSON.
     */
    public function verify(Request $request)
    {
        $request->validate(['payload' => 'required|string']);

        $booking = $this->qrCodeService->verify($request->payload);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Invalid or tampered QR code.'], 422);
        }

        $booking->load('room');

        return response()->json([
            'success' => true,
            'booking' => [
                'id'             => $booking->id,
                'booking_number' => $booking->booking_number,
                'guest_name'     => $booking->guest_name,
                'guest_email'    => $booking->guest_email,
                'guest_phone'    => $booking->guest_phone,
                'room_name'      => $booking->room->name ?? 'N/A',
                'room_number'    => $booking->room->room_number ?? 'N/A',
                'check_in'       => $booking->check_in->format('M d, Y'),
                'check_out'      => $booking->check_out->format('M d, Y'),
                'nights'         => $booking->nights,
                'total_amount'   => number_format($booking->total_amount, 2),
                'status'         => $booking->status,
                'payment_status' => $booking->payment_status,
                'can_checkin'    => $booking->isConfirmed(),
            ],
        ]);
    }

    /**
     * Verify a booking by booking number and return booking details as JSON.
     */
    public function verifyByBookingNumber(Request $request)
    {
        $request->validate(['booking_number' => 'required|string']);

        $booking = Booking::where('booking_number', trim($request->booking_number))->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found. Please check the booking number and try again.'], 404);
        }

        $booking->load('room');

        return response()->json([
            'success' => true,
            'booking' => [
                'id'             => $booking->id,
                'booking_number' => $booking->booking_number,
                'guest_name'     => $booking->guest_name,
                'guest_email'    => $booking->guest_email,
                'guest_phone'    => $booking->guest_phone,
                'room_name'      => $booking->room->name ?? 'N/A',
                'room_number'    => $booking->room->room_number ?? 'N/A',
                'check_in'       => $booking->check_in->format('M d, Y'),
                'check_out'      => $booking->check_out->format('M d, Y'),
                'nights'         => $booking->nights,
                'total_amount'   => number_format($booking->total_amount, 2),
                'status'         => $booking->status,
                'payment_status' => $booking->payment_status,
                'can_checkin'    => $booking->isConfirmed(),
            ],
        ]);
    }

    /**
     * Check in a booking and mark the room as occupied.
     */
    public function checkIn(Request $request, Booking $booking)
    {
        if (!$booking->isConfirmed()) {
            return response()->json([
                'success' => false,
                'message' => 'Booking must be in confirmed status to check in. Current status: ' . $booking->status,
            ], 422);
        }

        $booking->update([
            'status'        => 'checked_in',
            'checked_in_at' => now(),
        ]);

        // Mark the room as occupied
        if ($booking->room) {
            $booking->room->update(['status' => 'occupied']);
        }

        return response()->json([
            'success' => true,
            'message' => "Guest {$booking->guest_name} checked in successfully.",
        ]);
    }
}
