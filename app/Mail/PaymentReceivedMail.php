<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking, public Payment $payment) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Payment Verified - ' . $this->booking->booking_number);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-received');
    }
}
