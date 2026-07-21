<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $user = $request->user();
            if (in_array($user->role, ['admin', 'staff'])) {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('customer.dashboard'));
        }

        return view('auth.verify-email', [
            'email' => $request->user()->email,
        ]);
    }
}
