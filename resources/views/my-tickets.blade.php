@extends('layout.app')

@section('title', 'Tiketku - AmikomEventHub')

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-black mb-2">Tiketku</h1>
            <p class="text-slate-600">Kelola tiket dan berikan review untuk acara yang telah kamu hadiri</p>
        </div>

        @forelse($transactions as $transaction)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-6">
                {{-- Header with Event Info --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6 md:p-8">
                    {{-- Poster --}}
                    <div class="md:col-span-1">
                        <div class="relative">
                            <div class="bg-slate-100 rounded-2xl overflow-hidden aspect-video flex items-center justify-center border border-slate-200">
                                @if($transaction->event->poster_path)
                                    <img src="{{ asset('storage/' . $transaction->event->poster_path) }}" alt="{{ $transaction->event->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>

                            {{-- Status Badge --}}
                            @php
                                $eventPassed = $transaction->event->date->isPast();
                                $hasReview = \App\Models\Review::where('event_id', $transaction->event->id)->where('user_id', auth()->id())->exists();
                            @endphp

                            @if($eventPassed && $hasReview)
                                <div class="absolute top-2 right-2 bg-emerald-500 text-white px-3 py-1 rounded-lg text-xs font-bold">✓ Direview</div>
                            @elseif($eventPassed)
                                <div class="absolute top-2 right-2 bg-amber-500 text-white px-3 py-1 rounded-lg text-xs font-bold">Perlu Review</div>
                            @else
                                <div class="absolute top-2 right-2 bg-indigo-500 text-white px-3 py-1 rounded-lg text-xs font-bold">Belum Dimulai</div>
                            @endif
                        </div>
                    </div>

                    {{-- Event Details --}}
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase mb-1">{{ $transaction->event->category->name ?? 'Event' }}</p>
                            <h3 class="text-xl font-black text-slate-900">{{ $transaction->event->title }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Tanggal & Waktu</p>
                                <p class="text-slate-700 font-semibold">{{ $transaction->event->date->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Lokasi</p>
                                <p class="text-slate-700 font-semibold">{{ $transaction->event->location }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Order ID</p>
                                <p class="text-slate-700 font-mono font-bold">{{ $transaction->order_id }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Harga</p>
                                <p class="text-indigo-600 font-black">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="md:col-span-1 flex flex-col gap-3 justify-center">
                        <a href="{{ route('ticket.show', $transaction->order_id) }}" class="px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold text-center hover:bg-indigo-700 transition text-sm">
                            🎫 Lihat E-Ticket
                        </a>

                        @if($eventPassed)
                            @if($hasReview)
                                <button class="px-4 py-3 bg-emerald-50 text-emerald-600 rounded-xl font-bold hover:bg-emerald-100 transition text-sm border border-emerald-200" disabled>
                                    ✓ Sudah Direview
                                </button>
                            @else
                                <a href="{{ route('reviews.create', $transaction->event->id) }}" class="px-4 py-3 bg-amber-600 text-white rounded-xl font-bold text-center hover:bg-amber-700 transition text-sm">
                                    ⭐ Tulis Review
                                </a>
                            @endif
                        @else
                            <button class="px-4 py-3 bg-slate-100 text-slate-500 rounded-xl font-bold cursor-not-allowed text-sm" disabled>
                                Review Tersedia Nanti
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Review Section (if exists) --}}
                @if($hasReview)
                    @php
                        $review = \App\Models\Review::where('event_id', $transaction->event->id)->where('user_id', auth()->id())->first();
                    @endphp
                    <div class="bg-slate-50 border-t border-slate-200 p-6 md:p-8">
                        <h4 class="font-bold text-slate-700 mb-4">Reviewmu untuk Event Ini</h4>
                        <div class="bg-white rounded-2xl border border-slate-100 p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-bold text-slate-800">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $review->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-amber-500 font-bold text-lg">{{ str_repeat('⭐', $review->rating) }}</div>
                            </div>
                            @if($review->comment)
                                <p class="text-slate-700 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-12 text-center">
                <svg class="w-24 h-24 mx-auto mb-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                <h3 class="text-2xl font-black text-slate-800 mb-2">Belum Ada Tiket</h3>
                <p class="text-slate-600 mb-6">Kamu belum membeli tiket apapun. Jelajahi event menarik dan pesan sekarang!</p>
                <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
                    Jelajahi Event
                </a>
            </div>
        @endforelse
    </section>
@endsection
