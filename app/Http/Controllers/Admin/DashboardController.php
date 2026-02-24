<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TicketOrder;
use App\Models\TicketOrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {
        $activeStatuses = ['pending', 'confirmed'];

        $totalTicketsSold = TicketOrderItem::whereHas('order', function (Builder $query) use ($activeStatuses) {
            $query->whereIn('status', $activeStatuses);
        })->count();

        $monthlyTicketSales = TicketOrder::whereIn('status', $activeStatuses)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthlyBookings = Booking::whereIn('status', $activeStatuses)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $monthlyRevenue = $monthlyTicketSales + Booking::whereIn('status', $activeStatuses)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $months = [];
        $ticketData = [];
        $bookingData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');

            $ticketData[] = TicketOrderItem::whereHas('order', function (Builder $query) use ($date, $activeStatuses) {
                $query->whereYear('visit_date', $date->year)
                    ->whereMonth('visit_date', $date->month)
                    ->whereIn('status', $activeStatuses);
            })->count();

            $bookingData[] = Booking::whereYear('booking_date', $date->year)
                ->whereMonth('booking_date', $date->month)
                ->whereIn('status', $activeStatuses)
                ->count();
        }

        $statusData = [
            TicketOrder::where('status', 'pending')->count() + Booking::where('status', 'pending')->count(),
            TicketOrder::where('status', 'confirmed')->count() + Booking::where('status', 'confirmed')->count(),
            TicketOrder::where('status', 'rejected')->count() + Booking::where('status', 'rejected')->count(),
        ];

        $hasTransactionData = array_sum($statusData) > 0;

        return view('admin.dashboard', compact(
            'totalTicketsSold',
            'monthlyTicketSales',
            'monthlyBookings',
            'monthlyRevenue',
            'months',
            'ticketData',
            'bookingData',
            'statusData',
            'hasTransactionData'
        ));
    }
}

