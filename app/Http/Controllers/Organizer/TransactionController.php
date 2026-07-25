<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $organizationId = Auth::user()->organization_id;
        $transactions = Transaction::with('event')
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->latest()
            ->paginate(20);

        $totalRevenue = Transaction::whereIn('status', ['success', 'settlement', 'capture'])
            ->whereHas('event', fn($query) => $query->where('organization_id', $organizationId))
            ->sum('total_price');

        return view('organizer.transactions.index', compact('transactions', 'totalRevenue'));
    }
}
