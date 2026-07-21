<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Promotion;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /** GET /api/bookings */
    public function index(Request $request): JsonResponse
    {
        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => BookingResource::collection($bookings),
            'meta'    => [
                'total'        => $bookings->total(),
                'per_page'     => $bookings->perPage(),
                'current_page' => $bookings->currentPage(),
                'last_page'    => $bookings->lastPage(),
            ],
        ]);
    }

    /** POST /api/bookings */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'guest_name'       => 'required|string|max:255',
            'guest_email'      => 'required|email|max:255',
            'guest_phone'      => 'required|string|max:20',
            'guest_address'    => 'nullable|string',
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'adults'           => 'required|integer|min:1|max:10',
            'children'         => 'nullable|integer|min:0|max:10',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method'   => 'required|in:cash,gcash,maya,bank_transfer',
            'promo_code'       => 'nullable|string',
        ]);

        $room = Room::findOrFail($data['room_id']);

        if (!$room->isAvailableFor($data['check_in'], $data['check_out'])) {
            return response()->json([
                'success' => false,
                'message' => 'Room is not available for the selected dates.',
            ], 422);
        }

        $nights   = \Carbon\Carbon::parse($data['check_in'])->diffInDays($data['check_out']);
        $subtotal = $nights * $room->price_per_night;
        $discount = 0;
        $promotion = null;

        if (!empty($data['promo_code'])) {
            $promotion = Promotion::where('code', strtoupper($data['promo_code']))->first();
            if ($promotion && $promotion->isValid() && $nights >= $promotion->minimum_nights) {
                $discount = $promotion->calculateDiscount($subtotal);
            }
        }

        $tax   = round(($subtotal - $discount) * 0.12, 2);
        $total = $subtotal - $discount + $tax;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'booking_number'       => Booking::generateBookingNumber(),
                'user_id'              => $request->user()->id,
                'room_id'              => $room->id,
                'guest_name'           => $data['guest_name'],
                'guest_email'          => $data['guest_email'],
                'guest_phone'          => $data['guest_phone'],
                'guest_address'        => $data['guest_address'] ?? null,
                'check_in'             => $data['check_in'],
                'check_out'            => $data['check_out'],
                'adults'               => $data['adults'],
                'children'             => $data['children'] ?? 0,
                'special_requests'     => $data['special_requests'] ?? null,
                'nights'               => $nights,
                'room_price_per_night' => $room->price_per_night,
                'subtotal'             => $subtotal,
                'discount_amount'      => $discount,
                'tax_amount'           => $tax,
                'total_amount'         => $total,
                'promotion_id'         => $promotion?->id,
                'payment_method'       => $data['payment_method'],
                'status'               => 'pending',
                'payment_status'       => 'unpaid',
            ]);

            if ($promotion) {
                $promotion->increment('used_count');
            }

            DB::commit();

            try {
                Mail::to($booking->guest_email)->send(new BookingConfirmationMail($booking));
            } catch (\Exception $e) {
                \Log::error('Booking mail failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'data'    => new BookingResource($booking->load('room.roomType')),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Booking failed. Please try again.',
            ], 500);
        }
    }

    /** GET /api/bookings/{id} */
    public function show(Booking $booking): JsonResponse
    {
        if (Gate::denies('view', $booking)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'success' => true,
            'data'    => new BookingResource($booking->load('room.roomType')),
        ]);
    }

    /** PUT /api/bookings/{id} */
    public function update(Request $request, Booking $booking): JsonResponse
    {
        if (Gate::denies('update', $booking)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if (!in_array($booking->status, ['pending'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only pending bookings can be updated.',
            ], 422);
        }

        $data = $request->validate([
            'guest_name'       => 'sometimes|string|max:255',
            'guest_phone'      => 'sometimes|string|max:20',
            'guest_address'    => 'nullable|string',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method'   => 'sometimes|in:cash,gcash,maya,bank_transfer',
        ]);

        $booking->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully.',
            'data'    => new BookingResource($booking->load('room.roomType')),
        ]);
    }

    /** DELETE /api/bookings/{id} */
    public function destroy(Booking $booking): JsonResponse
    {
        if (Gate::denies('delete', $booking)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if (!in_array($booking->status, ['pending', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only pending or cancelled bookings can be deleted.',
            ], 422);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully.',
        ]);
    }
}
