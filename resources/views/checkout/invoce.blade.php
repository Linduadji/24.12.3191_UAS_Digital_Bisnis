@extends('layout.app')
@section('title', 'invoice Tiket')

@section('content')
<main class="max-w-xl mx-auto px-6 py-20">
    <div class="bg-white p-10 rounded-3xl border border-slate-200 shadow-xl" id="invoice-card">
        
        <div class="text-center mb-8 border-b pb-8">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-800">Pembayaran Sukses!</h1>
            <p class="text-slate-500 mt-2">Order ID: <span class="font-bold">{{ $transaction->order_id }}</span></p>
        </div>

        <div class="flex justify-center mb-8">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $transaction->order_id }}" 
                    alt="QR Code Tiket" class="rounded-xl border-4 border-slate-100 p-2 shadow-sm">
        </div>

        <div class="space-y-4 text-slate-600">
            <div class="flex justify-between">
                <span>Nama Event</span>
                <span class="font-bold text-slate-800">{{ $transaction->event->title }}</span>
            </div>
            <div class="flex justify-between">
                <span>Nama Pemesan</span>
                <span class="font-bold text-slate-800">{{ $transaction->customer_name }}</span>
            </div>
            <div class="flex justify-between text-xl font-black pt-4 border-t mt-4">
                <span>Total Dibayar</span>
                <span class="text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-8 flex gap-4 no-print">
        <button onclick="window.print()" class="flex-1 py-4 bg-slate-800 text-white rounded-2xl font-bold shadow-lg hover:bg-slate-900 transition flex justify-center items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download / Cetak PDF
        </button>
        <a href="/" class="flex-1 py-4 bg-slate-100 text-slate-700 rounded-2xl font-bold text-center hover:bg-slate-200 transition">
            Kembali ke Beranda
        </a>
    </div>
</main>

<style>
    @media print {
        body { background-color: white; }
        nav, footer, .no-print { display: none !important; }
        #invoice-card { box-shadow: none; border: 1px solid #e2e8f0; }
    }
</style>
@endsection