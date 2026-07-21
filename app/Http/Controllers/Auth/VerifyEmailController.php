<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Already verified — log them in and go to dashboard
            return $this->redirectToDashboard($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // After verification — go straight to dashboard with success message
        return $this->redirectToDashboard($request);
    }

    private function redirectToDashboard(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', '✅ Email verified! Welcome, ' . $user->name . '!');
        }

        return redirect()->route('customer.dashboard')
            ->with('success', '✅ Email verified! Welcome to Monarch Hotel, ' . $user->name . '!');
    }
}
