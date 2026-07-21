<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** POST /api/register */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'role'     => 'customer',
            'is_active'=> true,
        ]);

        $this->sendOtp($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful. Please check your email for the OTP verification code.',
            'data'    => [
                'user_id' => $user->id,
                'email'   => $user->email,
                // Show OTP in local/dev environment for testing purposes
                'otp_for_testing' => app()->isLocal() ? $this->lastOtp : null,
            ],
        ], 201);
    }

    /** POST /api/login */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact support.',
            ], 403);
        }

        // Revoke old tokens
        $user->tokens()->delete();

        $this->sendOtp($user);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email. Please verify to complete login.',
            'data'    => [
                'user_id' => $user->id,
                'email'   => $user->email,
                // Show OTP in local/dev environment for testing purposes
                'otp_for_testing' => app()->isLocal() ? $this->lastOtp : null,
            ],
        ]);
    }

    /** POST /api/verify-otp */
    public function verifyOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp'     => 'required|string|size:6',
        ]);

        $user = User::findOrFail($data['user_id']);
        $record = OtpVerification::where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'No active OTP found. Please request a new one.'], 422);
        }

        if ($record->isExpired()) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.'], 422);
        }

        if ($record->attempts >= 5) {
            return response()->json(['success' => false, 'message' => 'Maximum attempts reached. Please request a new OTP.'], 422);
        }

        // Increment attempts
        $record->increment('attempts');

        if (!$record->verify($data['otp'])) {
            $remaining = 4 - ($record->attempts - 1);
            return response()->json([
                'success' => false,
                'message' => "Invalid OTP. {$remaining} attempt(s) remaining.",
            ], 422);
        }

        // Mark as used
        $record->update(['is_used' => true]);

        // Create Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'data'    => [
                'token' => $token,
                'user'  => new UserResource($user),
            ],
        ]);
    }

    /** POST /api/resend-otp */
    public function resendOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($data['user_id']);

        // Check if there's a recent OTP (within 60 seconds)
        $recent = OtpVerification::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->latest()
            ->first();

        if ($recent) {
            $wait = 60 - now()->diffInSeconds($recent->created_at);
            return response()->json([
                'success' => false,
                'message' => "Please wait {$wait} second(s) before requesting a new OTP.",
            ], 429);
        }

        $this->sendOtp($user);

        return response()->json([
            'success' => true,
            'message' => 'A new OTP has been sent to your email.',
        ]);
    }

    /** POST /api/logout */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    /** GET /api/user */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => new UserResource($request->user()),
        ]);
    }

    private string $lastOtp = '';

    private function sendOtp(User $user): void
    {
        $result = OtpVerification::generateFor($user);
        $this->lastOtp = $result['code'];

        try {
            Mail::to($user->email)->send(new OtpMail($result['code'], $user->name));
        } catch (\Exception $e) {
            \Log::error('OTP mail failed: ' . $e->getMessage());
        }
    }
}
