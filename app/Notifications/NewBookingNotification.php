<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
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
            'type'           => 'new_booking',
            'title'          => 'New Booking Received',
            'message'        => "{$this->booking->guest_name} booked {$this->booking->room->name} ({$this->booking->booking_number})",
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'url'            => route('admin.bookings.show', $this->booking->id),
            'icon'           => 'bi-calendar-plus',
            'color'          => 'warning',
        ];
    }
}
