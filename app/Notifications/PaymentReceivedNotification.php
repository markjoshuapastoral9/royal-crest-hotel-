<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification
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
            'type'           => 'payment_received',
            'title'          => 'Payment Received 💳',
            'message'        => "Payment of ₱" . number_format($this->booking->total_amount, 2) . " received for booking {$this->booking->booking_number}.",
            'booking_id'     => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'url'            => route('admin.bookings.show', $this->booking->id),
            'icon'           => 'bi-credit-card',
            'color'          => 'success',
        ];
    }
}
