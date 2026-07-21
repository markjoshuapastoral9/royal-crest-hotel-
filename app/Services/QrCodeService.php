<?php

namespace App\Services;

use App\Models\Booking;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeService
{
    /**
     * Generate a base64 SVG data URI for the given booking.
     */
    public function generate(Booking $booking): string
    {
        $payload = $this->buildPayload($booking->booking_number);

        $renderer = new ImageRenderer(
            new RendererStyle(200, 2),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svg    = $writer->writeString($payload);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Verify a QR payload and return the matching Booking, or null if invalid.
     */
    public function verify(string $payload): ?Booking
    {
        try {
            $json = json_decode(base64_decode(strtr($payload, '-_', '+/')), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable) {
            return null;
        }

        if (empty($json['booking_number']) || empty($json['hash'])) {
            return null;
        }

        $expected = hash_hmac('sha256', $json['booking_number'], config('app.key'));

        if (!hash_equals($expected, $json['hash'])) {
            return null;
        }

        return Booking::where('booking_number', $json['booking_number'])->first();
    }

    /**
     * Build the signed, base64url-encoded payload string.
     */
    public function buildPayload(string $bookingNumber): string
    {
        $hash = hash_hmac('sha256', $bookingNumber, config('app.key'));
        $json = json_encode(['booking_number' => $bookingNumber, 'hash' => $hash]);
        return rtrim(strtr(base64_encode($json), '+/', '-_'), '=');
    }
}
