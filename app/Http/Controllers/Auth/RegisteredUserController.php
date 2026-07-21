<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\SendEmailOtp;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'role'      => 'customer',
            'is_active' => true,
        ]);

        event(new Registered($user));

        // Use Jetstream Email OTP Action (Laravel Mail — no PHPMailer)
        (new SendEmailOtp())->send($user);

        session([
            'otp_user_id' => $user->id,
            'otp_sent_at' => now()->timestamp,
        ]);

        return redirect()->route('otp.verify')
            ->with('status', 'Account created! A 6-digit code has been sent to ' . $user->email);
    }
}
