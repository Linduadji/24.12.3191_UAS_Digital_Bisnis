@extends('layout.admin')

@section('title', 'Manajemen Organizer - Admin')

@section('page_title', 'Manajemen Organizer')
@section('page_subtitle', 'Pantau organisasi penyelenggara dan status aktivitas mereka.')

@section('content')
<div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
    <form action="{{ route('admin.organizers.index') }}" method="GET" class="flex gap-2 flex-1 md:flex-none md:w-80">
        <input
            type="text"
            name="search"
            placeholder="Cari nama organisasi..."
            value="{{ $search ?? '' }}"
            class="flex-1 px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
        />
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Cari</button>
    </form>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    @forelse($organizers as $organizer)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-3xl bg-indigo-50 text-indigo-600 font-black flex items-center justify-center text-xl">{{ strtoupper(substr($organizer->name, 0, 1)) }}</div>
                <div class="flex-1">
                    <h3 class="text-xl font-black text-slate-900">{{ $organizer->name }}</h3>
                    <p class="text-slate-500 mt-1">Status: <span class="font-bold text-emerald-600">Aktif</span></p>
                    <p class="text-slate-500 text-sm mt-2">Jumlah event: <span class="font-semibold text-slate-900">{{ $organizer->total_events }}</span></p>
                    <p class="text-slate-500 text-sm">Event aktif: <span class="font-semibold text-slate-900">{{ $organizer->active_events }}</span></p>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#" class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Detail</a>
                <a href="#" class="px-5 py-3 bg-slate-100 text-slate-700 rounded-2xl font-semibold hover:bg-slate-200 transition">Verifikasi</a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center text-slate-500 font-medium">Belum ada organizer yang terdaftar.</div>
    @endforelse
</div>

<div class="mt-8">{{ $organizers->links() }}</div>
@endsection
