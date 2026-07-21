<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'booking_number'       => $this->booking_number,
            'room'                 => $this->whenLoaded('room', fn() => new RoomResource($this->room)),
            'guest_name'           => $this->guest_name,
            'guest_email'          => $this->guest_email,
            'guest_phone'          => $this->guest_phone,
            'guest_address'        => $this->guest_address,
            'check_in'             => $this->check_in?->toDateString(),
            'check_out'            => $this->check_out?->toDateString(),
            'adults'               => $this->adults,
            'children'             => $this->children,
            'nights'               => $this->nights,
            'room_price_per_night' => (float) $this->room_price_per_night,
            'subtotal'             => (float) $this->subtotal,
            'discount_amount'      => (float) $this->discount_amount,
            'tax_amount'           => (float) $this->tax_amount,
            'total_amount'         => (float) $this->total_amount,
            'payment_method'       => $this->payment_method,
            'payment_status'       => $this->payment_status,
            'status'               => $this->status,
            'special_requests'     => $this->special_requests,
            'receipt_url'          => route('booking.receipt', $this->id),
            'created_at'           => $this->created_at?->toDateTimeString(),
        ];
    }
}
