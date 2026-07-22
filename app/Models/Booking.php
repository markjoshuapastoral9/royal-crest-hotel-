<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number', 'user_id', 'room_id', 'package_id',
        'guest_name', 'guest_email', 'guest_phone', 'guest_address',
        'check_in', 'check_in_time', 'check_out', 'check_out_time',
        'adults', 'children', 'special_requests', 'nights',
        'room_price_per_night', 'subtotal', 'discount_amount', 'tax_amount', 'total_amount',
        'promotion_id', 'status', 'payment_method', 'payment_status', 'payment_proof',
        'cancellation_reason', 'cancelled_at', 'confirmed_at', 'checked_in_at', 'checked_out_at',
        'confirmed_by', 'admin_notes',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'cancelled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'room_price_per_night' => 'decimal:2',
    ];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /** Status helpers */
    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isConfirmed(): bool  { return $this->status === 'confirmed'; }
    public function isCheckedIn(): bool  { return $this->status === 'checked_in'; }
    public function isCheckedOut(): bool { return $this->status === 'checked_out'; }
    public function isCancelled(): bool  { return $this->status === 'cancelled'; }
    public function isCompleted(): bool  { return $this->status === 'completed'; }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'warning',
            'confirmed'   => 'success',
            'checked_in'  => 'info',
            'checked_out' => 'secondary',
            'cancelled'   => 'danger',
            'completed'   => 'primary',
            default       => 'secondary',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'unpaid'          => 'danger',
            'partially_paid'  => 'warning',
            'paid'            => 'success',
            'refunded'        => 'info',
            default           => 'secondary',
        };
    }

    /** Generate unique booking number */
    public static function generateBookingNumber(): string
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->count() + 1;
        return 'SUB-' . $year . '-' . str_pad($last, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get check-in datetime (date + time combined as Carbon)
     */
    public function getCheckInDatetimeAttribute(): \Carbon\Carbon
    {
        $time = $this->attributes['check_in_time'] ?? '14:00';
        return \Carbon\Carbon::parse(
            $this->check_in->toDateString() . ' ' . $time
        );
    }

    /**
     * Get check-out datetime (date + time combined as Carbon)
     */
    public function getCheckOutDatetimeAttribute(): \Carbon\Carbon
    {
        $time = $this->attributes['check_out_time'] ?? '11:00';
        return \Carbon\Carbon::parse(
            $this->check_out->toDateString() . ' ' . $time
        );
    }

    /**
     * Get formatted check-in time (12h format) — safe when column missing
     */
    public function getCheckInTimeFormattedAttribute(): string
    {
        $time = $this->attributes['check_in_time'] ?? '14:00';
        try {
            return \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A');
        } catch (\Exception $e) {
            return '2:00 PM';
        }
    }

    /**
     * Get formatted check-out time (12h format) — safe when column missing
     */
    public function getCheckOutTimeFormattedAttribute(): string
    {
        $time = $this->attributes['check_out_time'] ?? '11:00';
        try {
            return \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A');
        } catch (\Exception $e) {
            return '11:00 AM';
        }
    }

    /**
     * Check if this booking overlaps with a given datetime range.
     */
    public function overlapsWithDatetime(\Carbon\Carbon $newStart, \Carbon\Carbon $newEnd): bool
    {
        return $newStart->lt($this->check_out_datetime) && $newEnd->gt($this->check_in_datetime);
    }

    /** Scopes */
    public function scopePending($query)     { return $query->where('status', 'pending'); }
    public function scopeConfirmed($query)   { return $query->where('status', 'confirmed'); }
    public function scopeCheckedIn($query)   { return $query->where('status', 'checked_in'); }
    public function scopeToday($query)       { return $query->whereDate('created_at', today()); }
    public function scopeThisMonth($query)   { return $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year); }
}
