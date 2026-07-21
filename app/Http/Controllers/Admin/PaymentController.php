<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\ActivityLog;
use App\Mail\PaymentReceivedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.room']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.room.roomType']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $payment->update([
            'status'      => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'notes'       => $request->notes,
        ]);

        // Update booking payment status
        $booking = $payment->booking;
        $totalPaid = $booking->payments()->where('status', 'verified')->sum('amount');

        if ($totalPaid >= $booking->total_amount) {
            $booking->update(['payment_status' => 'paid']);
            if ($booking->isPending()) {
                $booking->update(['status' => 'confirmed', 'confirmed_at' => now(), 'confirmed_by' => auth()->id()]);
            }
        } else {
            $booking->update(['payment_status' => 'partially_paid']);
        }

        try {
            Mail::to($booking->guest_email)->send(new PaymentReceivedMail($booking, $payment));
        } catch (\Exception $e) {}

        ActivityLog::log('verified', "Verified payment: {$payment->reference_number}", $payment);
        return back()->with('success', 'Payment verified.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'rejected', 'notes' => $request->notes]);
        ActivityLog::log('rejected', "Rejected payment: {$payment->reference_number}", $payment);
        return back()->with('success', 'Payment rejected.');
    }
}
