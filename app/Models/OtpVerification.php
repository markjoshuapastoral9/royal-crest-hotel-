<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class OtpVerification extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
        'attempts',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used'    => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired() && $this->attempts < 5;
    }

    public function verify(string $otp): bool
    {
        return Hash::check($otp, $this->otp);
    }

    /** Generate a new OTP record for a user (invalidates old ones) */
    public static function generateFor(User $user): array
    {
        // Expire all previous OTPs for this user
        static::where('user_id', $user->id)->update(['is_used' => true]);

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        static::create([
            'user_id'    => $user->id,
            'otp'        => Hash::make($code),
            'expires_at' => now()->addMinutes(5),
            'attempts'   => 0,
            'is_used'    => false,
        ]);

        return ['code' => $code];
    }
}
