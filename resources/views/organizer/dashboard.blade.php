@extends('organizer.layout')

@section('title', 'Dashboard Organizer')
@section('page_title', 'Dashboard Organizer')
@section('page_subtitle', 'Kelola acara dan pantau performa organisasi Anda.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase">Total Pendapatan</p>
                    <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue,0,',','.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase">Tiket Terjual</p>
                    <h3 class="text-2xl font-black">{{ number_format($ticketsSold,0,',','.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase">Event Aktif</p>
                    <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-400 text-sm font-bold uppercase">Pesanan Pending</p>
                    <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
                </div>
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="font-black text-xl">Transaksi Terakhir</h3>
            <a href="{{ route('organizer.transactions') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest"><tr>
                    <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr></thead>
                <tbody class="divide-y border-t">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-6 text-sm text-slate-600">{{ $trx->created_at->format('d M Y - H:i') }}<br><span class="text-xs text-slate-400 font-mono">#{{ $trx->order_id }}</span></td>
                        <td class="px-8 py-6"><p class="font-bold uppercase tracking-wide text-sm">{{ $trx->customer_name }}</p><p class="text-xs text-slate-400">{{ $trx->customer_email }}</p></td>
                        <td class="px-8 py-6 font-medium text-slate-600">{{ $trx->event->title ?? '-' }}</td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @php $status = strtolower(trim($trx->status)); @endphp
                            @if(in_array($status, ['success', 'settlement', 'capture']))
                                <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">Success</span>
                            @elseif(in_array($status, ['pending','challenge']))
                                <span class="px-3 py-1 bg-amber-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">{{ ucfirst($status) }}</span>
                            @else
                                <span class="px-3 py-1 bg-rose-500 text-white rounded-lg text-xs font-bold uppercase shadow-sm">{{ ucfirst($status) }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 font-black text-indigo-600 text-right">Rp {{ number_format($trx->total_price,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-10 text-center text-slate-500 font-medium">Belum ada transaksi terakhir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-black text-xl">Pertumbuhan Bulanan (Tiket & Event)</h3>
                <p class="text-slate-500 text-sm">Grafik tren tiket terjual dan event yang dibuat organisasi Anda.</p>
            </div>
        </div>
        <div style="height:320px;">
            <canvas id="orgGrowthChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function(){
                const labels = {!! json_encode(array_keys($ticketsGrowth->toArray())) !!};
                const tickets = {!! json_encode(array_values($ticketsGrowth->toArray())) !!};
                const events = {!! json_encode(array_values($eventGrowth->toArray())) !!};

                const ctx = document.getElementById('orgGrowthChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            { label: 'Tiket Terjual', data: tickets, borderColor: '#4f46e5', backgroundColor: 'rgba(79,70,229,0.08)', tension:0.3, fill:true, pointRadius:3 },
                            { label: 'Event Dibuat', data: events, borderColor: '#059669', backgroundColor: 'rgba(5,150,105,0.08)', tension:0.3, fill:true, pointRadius:3 }
                        ]
                    },
                    options: { responsive:true, maintainAspectRatio:false, scales:{ x:{ ticks:{ color:'#64748b' } }, y:{ ticks:{ color:'#64748b' }, beginAtZero:true } }, plugins:{ legend:{ position:'top' }, tooltip:{ mode:'index', intersect:false } } }
                });
            })();
        </script>
    @endpush
@endsection
