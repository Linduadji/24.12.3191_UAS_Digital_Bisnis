<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $organizationId = Auth::user()->organization_id;

        $totalRevenue = Transaction::where('status', 'success')
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->sum('total_price');

        $ticketsSold = Transaction::where('status', 'success')
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->count();

        $activeEvents = Event::where('organization_id', $organizationId)
            ->where('date', '>=', now())
            ->count();

        $pendingOrders = Transaction::where('status', 'pending')
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->count();

        $recentTransactions = Transaction::with('event')
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->latest()
            ->take(5)
            ->get();

        // Grafik pertumbuhan: tiket terjual dan event dibuat oleh organisasi selama 6 bulan terakhir
        $periods = collect(range(0, 5))->map(fn($monthsAgo) => now()->subMonths($monthsAgo)->startOfMonth())->reverse();

        $ticketsGrowth = $periods->mapWithKeys(function ($date) use ($organizationId) {
            $count = Transaction::where('status', 'success')
                ->whereHas('event', fn($q) => $q->where('organization_id', $organizationId))
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            return [$date->format('M Y') => $count];
        });

        $eventGrowth = $periods->mapWithKeys(function ($date) use ($organizationId) {
            $count = Event::where('organization_id', $organizationId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            return [$date->format('M Y') => $count];
        });

        return view('organizer.dashboard', compact('totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions', 'ticketsGrowth', 'eventGrowth'));
    }
}
