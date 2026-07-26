@extends('layout.app')
@section('title', 'Pembayaran Berhasil')
@section('content')
<main class="max-w-4xl mx-auto px-6 py-16">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm">
        {{-- Header Success --}}
        <div class="text-center mb-12">
            <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-2">Pembayaran Berhasil</h2>
            <p class="text-slate-500">Terima kasih, pembayaran Anda sudah kami terima dan akan segera diproses.</p>
        </div>

        {{-- Order Details --}}
        <div class="grid md:grid-cols-2 gap-8 mb-10">
            {{-- Kolom Kiri: Order & Customer Info --}}
            <div class="space-y-6">
                {{-- Order ID --}}
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase mb-1">Order ID</p>
                    <p class="text-xl font-black text-indigo-600">{{ $transaction->order_id }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">SUCCESS</span>
                </div>

                {{-- Event Title --}}
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase mb-1">Nama Event</p>
                    <p class="text-lg font-bold text-slate-900">{{ $transaction->event->title ?? '-' }}</p>
                    @if($transaction->event)
                    <p class="text-xs text-slate-500 mt-1">{{ $transaction->event->date->format('d M Y') }} - {{ $transaction->event->location }}</p>
                    @endif
                </div>

                {{-- Customer Email --}}
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase mb-1">Email Terdaftar</p>
                    <p class="text-slate-700 font-medium">{{ $transaction->customer_email }}</p>
                    <p class="text-xs text-slate-500 mt-1">E-Ticket akan dikirim ke email ini</p>
                </div>
            </div>

            {{-- Kolom Kanan: Customer Details & Total --}}
            <div class="space-y-6">
                {{-- Nama Pemesan --}}
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase mb-1">Nama Pemesan</p>
                    <p class="text-lg font-bold text-slate-900">{{ $transaction->customer_name }}</p>
                </div>

                {{-- No. WhatsApp --}}
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase mb-1">No. WhatsApp</p>
                    <p class="text-slate-700 font-medium">{{ $transaction->customer_phone }}</p>
                </div>

                {{-- Total Pembayaran --}}
                <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-100">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-2">Total Pembayaran</p>
                    <p class="text-3xl font-black text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-4 justify-center pt-6 border-t">
            <a href="{{ route('home') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kembali ke Beranda
            </a>
            <a href="{{ route('ticket.show', $transaction->order_id) }}" class="px-8 py-4 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition">
                Lihat E-Ticket
            </a>
        </div>
    </div>
</main>
@endsection

