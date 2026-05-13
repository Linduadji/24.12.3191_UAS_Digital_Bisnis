@extends('layout.admin')

@section('title', 'Kelola Partner - Admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Daftar partner yang bekerja sama dengan platform Anda.')

@section('content')
<div class="mb-4 text-right">
    <a href="{{ route('admin.partners.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Partner Baru
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Partner</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <div class="w-20 h-20 rounded-xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50">
                            <img src="{{ $partner->logo_url }}"
                                alt="Logo {{ $partner->name }}"
                                class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/160x160?text=No+Logo'">
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $partner->name }}</p>
                        <p class="text-xs text-slate-400">ID: {{ $partner->id }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-12 text-center text-slate-500">Belum ada partner yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
