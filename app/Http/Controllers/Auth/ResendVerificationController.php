<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResendVerificationController extends Controller
{
    /**
     * Resend verification email for a guest (not yet logged in).
     * Accessed from the login page when email is not verified.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with that email address.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('status', 'Your email is already verified. Please log in.');
        }

        // Send verification email using Laravel's built-in notification
        $user->sendEmailVerificationNotification();

        return back()->with('resent', true)
            ->with('status', 'Verification link sent! Check your inbox at ' . $user->email);
    }
}
