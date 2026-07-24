<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\SendEmailOtp;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Step 1: Validate credentials
        $request->authenticate();
        $user = Auth::user();

        // Step 2: Block inactive accounts
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        // Step 3: Admin/Staff — bypass OTP
        if (in_array($user->role, ['admin', 'staff'])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Step 4: SKIP_OTP bypass
        $skipOtp = env('SKIP_OTP', false) === true || env('SKIP_OTP', 'false') === 'true';
        if ($skipOtp) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // Step 5: Generate OTP BEFORE invalidating session
        $result = OtpVerification::generateFor($user);
        $code = $result['code'];

        // Step 6: Send OTP email
        try {
            Mail::to($user->email)->send(new OtpMail($code, $user->name));
            Log::info('Login OTP sent to: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Login OTP FAILED for ' . $user->email . ': ' . $e->getMessage());
        }

        // Step 7: Store user ID in session BEFORE logout
        $userId = $user->id;

        // Step 8: Logout and regenerate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Step 9: Save OTP session data AFTER regeneration
        session([
            'otp_user_id' => $userId,
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
