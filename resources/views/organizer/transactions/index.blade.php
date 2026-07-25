@extends('organizer.layout')

@section('title', 'Laporan Transaksi - Organizer')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Lihat ringkasan transaksi dan detail pesanan dari event Anda.')

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="font-black text-xl">Transaksi Event</h3>
            <p class="text-slate-500 text-sm">Total pendapatan: <span class="font-semibold text-slate-800">Rp {{ number_format($totalRevenue,0,',','.') }}</span></p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('organizer.dashboard') }}" class="px-5 py-3 bg-slate-50 text-slate-700 rounded-2xl font-semibold hover:bg-slate-100 transition">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tiket</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 text-sm text-slate-600">{{ $transaction->created_at->format('d M Y') }}<br><span class="text-xs text-slate-400">#{{ $transaction->order_id }}</span></td>
                    <td class="px-8 py-6 font-medium text-slate-700">{{ $transaction->event->title ?? '-' }}</td>
                    <td class="px-8 py-6 text-slate-500">1 tiket</td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @php $status = strtolower(trim($transaction->status)); @endphp
                        @if(in_array($status, ['success', 'settlement', 'capture']))
                            <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-xs font-bold uppercase">Berhasil</span>
                        @elseif(in_array($status, ['pending','challenge']))
                            <span class="px-3 py-1 bg-amber-500 text-white rounded-lg text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-rose-500 text-white rounded-lg text-xs font-bold uppercase">Gagal</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 text-right">Rp {{ number_format($transaction->total_price,0,',','.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-500">Belum ada transaksi untuk ditampilkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $transactions->links() }}
    </div>
</div>
@endsection