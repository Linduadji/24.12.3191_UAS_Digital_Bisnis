@extends('layout.admin')

@section('title', 'Kelola Partner - Admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Daftar partner yang bekerja sama dengan platform Anda.')

@section('content')
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
