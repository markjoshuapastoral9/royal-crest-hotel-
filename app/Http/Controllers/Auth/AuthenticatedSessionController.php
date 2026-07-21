<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\SendEmailOtp;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\OtpVerification;
use App\Mail\OtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Step 1: Validate credentials via Fortify/Laravel Auth
        $request->authenticate();

        $user = Auth::user();

        // Step 2: Block inactive accounts
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        // Step 3: Admin/Staff — bypass OTP, go directly to dashboard
        if (in_array($user->role, ['admin', 'staff'])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Step 4: SKIP_OTP bypass - reads directly from .env file
        $skipOtp = trim(file_get_contents(base_path('.env')));
        $skipOtp = preg_match('/^SKIP_OTP\s*=\s*true/im', $skipOtp);

        if ($skipOtp) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Log out temporarily (OTP must be verified before granting access)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Use our Jetstream Email OTP Action (Laravel Mail — no PHPMailer)
        (new SendEmailOtp())->send($user);

        // Store in session for OTP verification step
        session([
            'otp_user_id' => $user->id,
            'otp_sent_at' => now()->timestamp,
        ]);

        return redirect()->route('otp.verify')
            ->with('status', 'A 6-digit verification code has been sent to ' . $user->email);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
