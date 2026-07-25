<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(\App\Models\Event $event) {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        // Me-render view dengan membawa data kategori dan data spesifik acara tersebut
        return view('event-detail', compact('categories', 'event'));
    }

public function checkout() {
    return view('layout.checkout');
}

public function ticket() {
    $transactions = \App\Models\Transaction::with('event', 'event.category')
        ->where('user_id', auth()->id())
        ->whereIn('status', ['success', 'settlement', 'capture'])
        ->latest()
        ->get();

    return view('my-tickets', compact('transactions'));
}
}
