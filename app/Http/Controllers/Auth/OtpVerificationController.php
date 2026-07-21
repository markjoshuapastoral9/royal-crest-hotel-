<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /** Show OTP verification page */
    public function show(Request $request): View|RedirectResponse
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp-verify');
    }

    /** Verify submitted OTP */
    public function verify(Request $request): RedirectResponse
    {
        // Add CSRF token check with better error message
        try {
            $request->validate([
                'otp' => 'required|string|size:6',
            ]);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            return redirect()->route('login')->withErrors(['otp' => 'Your session has expired. Please login again.']);
        }

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please login again.']);
        }

        $user = User::findOrFail($userId);

        $record = OtpVerification::where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'No active OTP found. Please request a new one.']);
        }

        if ($record->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($record->attempts >= 5) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Too many failed attempts. Please login again.']);
        }

        $record->increment('attempts');

        if (!$record->verify($request->otp)) {
            $remaining = 5 - $record->attempts;
            return back()->withErrors([
                'otp' => "Invalid OTP code. {$remaining} attempt(s) remaining.",
            ]);
        }

        // Mark OTP as used
        $record->update(['is_used' => true]);

        // Clear OTP session data
        session()->forget(['otp_user_id', 'otp_sent_at']);

        // Log in the user
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect by role
        if (in_array($user->role, ['admin', 'staff'])) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return redirect()->intended(route('customer.dashboard'))
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /** Resend OTP */
    public function resend(Request $request): RedirectResponse
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        // Check 60s cooldown
        $sentAt = session('otp_sent_at');
        if ($sentAt && (now()->timestamp - $sentAt) < 60) {
            $wait = 60 - (now()->timestamp - $sentAt);
            return back()->withErrors(['otp' => "Please wait {$wait} seconds before requesting a new OTP."]);
        }

        $result = OtpVerification::generateFor($user);
        try {
            Mail::to($user->email)->send(new OtpMail($result['code'], $user->name));
        } catch (\Exception $e) {
            \Log::error('OTP resend failed: ' . $e->getMessage());
        }

        session(['otp_sent_at' => now()->timestamp]);

        return back()->with('status', 'A new OTP has been sent to your email.');
    }
}
