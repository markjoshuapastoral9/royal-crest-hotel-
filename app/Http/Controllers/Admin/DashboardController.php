<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        // Summary cards
        $stats = [
            'today_bookings'       => Booking::whereDate('created_at', $today)->count(),
            'available_rooms'      => Room::where('status', 'available')->count(),
            'occupied_rooms'       => Room::where('status', 'occupied')->count(),
            'pending_reservations' => Booking::where('status', 'pending')->count(),
            'confirmed_today'      => Booking::where('status', 'confirmed')->whereDate('confirmed_at', $today)->count(),
            'cancelled_this_month' => Booking::where('status', 'cancelled')->whereMonth('cancelled_at', now()->month)->count(),
            'total_guests'         => User::where('role', 'customer')->count(),
            'monthly_revenue'      => Booking::whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'completed'])
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('total_amount'),
        ];

        // Monthly revenue chart (last 12 months)
        $revenueChart = Booking::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'completed'])
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Bookings per month
        $bookingsChart = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent bookings
        $recentBookings = Booking::with(['room', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Room occupancy
        $roomStats = Room::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');

        return view('admin.dashboard', compact('stats', 'revenueChart', 'bookingsChart', 'recentBookings', 'roomStats'));
    }
}
