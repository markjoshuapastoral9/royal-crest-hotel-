<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification
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
            'type'           => 'booking_cancelled',
            'title'          => 'Booking Cancelled',
            'message'        => "Booking {$this->booking->booking_number} for {$this->booking->room->name} has been cancelled.",
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'url'            => route('customer.bookings') . '?booking=' . $this->booking->id,
            'icon'           => 'bi-x-circle',
            'color'          => 'danger',
        ];
    }
}
