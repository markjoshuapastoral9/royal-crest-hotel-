<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'           => 'booking_confirmed',
            'title'          => 'Booking Confirmed! ✅',
            'message'        => "Your booking {$this->booking->booking_number} for {$this->booking->room->name} has been confirmed.",
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'url'            => route('customer.bookings') . '?booking=' . $this->booking->id,
            'icon'           => 'bi-check-circle',
            'color'          => 'success',
        ];
    }
}
