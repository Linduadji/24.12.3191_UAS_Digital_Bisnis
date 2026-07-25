<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Organization;
use App\Models\Partner;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        
        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();
        
        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = Event::where('date', '>=', now())->count();
        
        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Ringkasan manajemen
        $totalOrganizers = Organization::count();
        $totalPartners = Partner::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        // 6. Grafik pertumbuhan pengguna dan event selama 6 bulan terakhir
        $periods = collect(range(0, 5))->map(fn($monthsAgo) => now()->subMonths($monthsAgo)->startOfMonth())->reverse();

        $userGrowth = $periods->mapWithKeys(function ($date) {
            return [$date->format('M Y') => User::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count()];
        });

        $eventGrowth = $periods->mapWithKeys(function ($date) {
            return [$date->format('M Y') => Event::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count()];
        });
        
        // 7. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'totalOrganizers',
            'totalPartners',
            'totalCategories',
            'totalUsers',
            'userGrowth',
            'eventGrowth',
            'recentTransactions'
        ));
    }
}