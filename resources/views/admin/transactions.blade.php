@extends('layout.admin')

@section('title', 'Laporan Transaksi')

@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
    <div class="mb-6 flex justify-end gap-4">
        <button class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-white hover:border-indigo-600 hover:text-indigo-600 transition">
            Ekspor Excel
        </button>
        <button class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
            Unduh PDF
        </button>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-75">
                <input type="text" placeholder="Cari Order ID, Nama, atau Email..."
                    class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase text-sm font-medium tracking-wide">
            </div>
            <div class="flex gap-2">
                <select class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold">
                    <option>Semua Status</option>
                    <option class="text-green-600">Success</option>
                    <option class="text-orange-600">Pending</option>
                    <option class="text-rose-600">Expired</option>
                </select>
                <select class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold">
                    <option>Bulan Ini</option>
                    <option>Bulan Lalu</option>
                    <option>Tahun 2026</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Detail Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    {{-- LOOPING DATA DINAMIS DARI DATABASE --}}
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6">
                                <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">
                                    #{{ $transaction->order_id }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-800">{{ $transaction->customer_name }}</p>
                                <p class="text-xs text-slate-500">{{ $transaction->customer_email }}</p>
                            </td>
                            <td class="px-8 py-6">
                                {{-- Menampilkan judul event dari relasi tabel, jika terhapus tampilkan tanda strip --}}
                                <p class="font-medium text-slate-700">{{ $transaction->event->title ?? '-' }}</p>
                            </td>
                            <td class="px-8 py-6 text-sm text-slate-500">
                                {{ $transaction->created_at->format('d M Y, H:i') }}
                            </td>
                            
                            {{-- BAGIAN YANG DIPERBAIKI --}}
                            <td class="px-8 py-6">
                        @php
                            // Hilangkan spasi gaib dan ubah ke huruf kecil
                            $status = strtolower(trim($transaction->status));
                        @endphp

                        @if($status === 'success' || $status === 'settlement' || $status === 'capture')
                            <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">
                                {{ $transaction->status }}
                            </span>
                        @elseif($status === 'pending')
                            <span class="px-3 py-1 bg-orange-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">
                                {{ $transaction->status }}
                            </span>
                        @else
                            <span class="px-3 py-1 bg-rose-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">
                                {{ $transaction->status }}
                            </span>
                        @endif
                    </td>
                            
                            <td class="px-8 py-6 text-right font-black text-slate-900">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-slate-500 font-medium">
                                Belum ada data transaksi yang masuk ke sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI UNTUK LINK LARAVEL --}}
        <div class="px-8 py-6 bg-slate-50/50 border-t">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection