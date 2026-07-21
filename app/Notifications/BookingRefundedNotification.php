<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingRefundedNotification extends Notification
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
            'type'           => 'booking_refunded',
            'title'          => 'Booking Refunded 💰',
            'message'        => "Your booking {$this->booking->booking_number} has been refunded. Amount: ₱" . number_format($this->booking->total_amount, 2),
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'url'            => route('customer.bookings') . '?booking=' . $this->booking->id,
            'icon'           => 'bi-cash-coin',
            'color'          => 'info',
        ];
    }
}
