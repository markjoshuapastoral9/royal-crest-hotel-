<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo   = $request->date_to   ?? now()->format('Y-m-d');

        $bookings = Booking::with(['room', 'user'])
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->get();

        $revenue = $bookings->whereIn('status', ['confirmed','checked_in','checked_out','completed'])->sum('total_amount');

        $stats = [
            'total_bookings'   => $bookings->count(),
            'confirmed'        => $bookings->where('status', 'confirmed')->count(),
            'cancelled'        => $bookings->where('status', 'cancelled')->count(),
            'completed'        => $bookings->whereIn('status', ['completed','checked_out'])->count(),
            'total_revenue'    => $revenue,
            'avg_booking_value'=> $bookings->count() ? round($revenue / $bookings->count(), 2) : 0,
        ];

        // Most popular rooms
        $popularRooms = Booking::selectRaw('room_id, COUNT(*) as bookings_count, SUM(total_amount) as revenue')
            ->with('room')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->whereIn('status', ['confirmed','checked_in','checked_out','completed'])
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->take(10)
            ->get();

        // Monthly revenue for chart
        $monthlyRevenue = Booking::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['confirmed','checked_in','checked_out','completed'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        return view('admin.reports.index', compact('stats', 'bookings', 'popularRooms', 'monthlyRevenue', 'dateFrom', 'dateTo'));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo   = $request->date_to   ?? now()->format('Y-m-d');

        $bookings = Booking::with(['room', 'user'])
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->get();

        $revenue = $bookings->whereIn('status', ['confirmed','checked_in','checked_out','completed'])->sum('total_amount');

        $pdf = Pdf::loadView('pdf.report', compact('bookings', 'revenue', 'dateFrom', 'dateTo'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("report-{$dateFrom}-to-{$dateTo}.pdf");
    }
}
