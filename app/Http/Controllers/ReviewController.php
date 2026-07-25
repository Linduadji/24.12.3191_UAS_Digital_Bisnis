<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show form to create a review for an event
     */
    public function create(Event $event)
    {
        // Check if user attended this event (has completed transaction)
        $attendedEvent = Transaction::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['success', 'settlement', 'capture'])
            ->exists();

        if (!$attendedEvent) {
            return redirect()->back()->with('error', 'Hanya peserta yang bisa memberikan ulasan.');
        }

        // Check if already reviewed
        $existingReview = Review::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('info', 'Anda sudah memberikan ulasan untuk acara ini.');
        }

        // Check if event has ended
        if ($event->date->isFuture()) {
            return redirect()->back()->with('error', 'Acara belum berakhir. Ulasan dapat diberikan setelah acara selesai.');
        }

        return view('reviews.create', compact('event'));
    }

    /**
     * Store a review
     */
    public function store(Request $request, Event $event)
    {
        // Check if user attended this event
        $attendedEvent = Transaction::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['success', 'settlement', 'capture'])
            ->exists();

        if (!$attendedEvent) {
            return redirect()->back()->with('error', 'Hanya peserta yang bisa memberikan ulasan.');
        }

        // Check if already reviewed
        $existingReview = Review::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('info', 'Anda sudah memberikan ulasan untuk acara ini.');
        }

        // Validate
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create review
        Review::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'organization_id' => $event->organization_id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('ticket')->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
