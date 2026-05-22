@extends('layout.admin')

@section('title', 'Kelola Kategori - Admin')

@section('page_title', 'Kelola Kategori')
@section('page_subtitle', 'Atur kategori event Anda di sini.')

@section('content')
<div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
    {{-- Search Form --}}
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2 flex-1 md:flex-none md:w-80">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nama kategori..." 
            value="{{ $search ?? '' }}"
            class="flex-1 px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
        />
        <button 
            type="submit" 
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition"
        >
            Cari
        </button>
        @if($search)
            <a href="{{ route('admin.categories.index') }}" 
                class="px-4 py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition">
                Reset
            </a>
        @endif
    </form>

    {{-- Add Button --}}
    <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap">
        + Tambah Kategori Baru
    </a>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Slug</th>
                    <th class="px-8 py-4">Dibuat Pada</th>
                    <th class="px-8 py-4">Diperbarui Pada</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $categories->firstItem() + $index }}
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $category->name }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg">
                            {{ $category->slug }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-600">
                        {{ $category->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-600">
                        {{ $category->updated_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-12 text-center text-slate-500">Belum ada kategori yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination (jika ada) --}}
@if($categories->hasPages())
<div class="mt-6">
    {{ $categories->links() }}
</div>
@endif

@endsection
