@extends('layout.admin')

@section('title', 'Edit Kategori - Admin')

@section('page_title', 'Edit Kategori')
@section('page_subtitle', 'Perbarui informasi kategori event Anda.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input Nama Kategori --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-3">Nama Kategori *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('name') border-rose-500 @enderror"
                    placeholder="Contoh: Music Festival, Sports, Conference"
                    value="{{ old('name', $category->name) }}"
                    required
                />
                @error('name')
                    <p class="text-rose-600 text-sm font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Informasi Slug (Read-only) --}}
            <div class="mb-6">
                <label for="slug" class="block text-sm font-bold text-slate-700 mb-3">Slug (Otomatis)</label>
                <input 
                    type="text" 
                    id="slug" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-slate-600"
                    value="{{ $category->slug }}"
                    disabled
                />
                <p class="text-xs text-slate-500 mt-2">Slug dihasilkan otomatis dari nama kategori.</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition"
                >
                    Perbarui Kategori
                </button>
                <a 
                    href="{{ route('admin.categories.index') }}" 
                    class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
