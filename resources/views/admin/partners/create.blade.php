@extends('layout.admin')

@section('title', 'Tambah Partner - Admin')

@section('page_title', 'Tambah Partner Baru')
@section('page_subtitle', 'Isi data partner untuk ditambahkan ke daftar mitra.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Input Nama Partner --}}
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-3">Nama Partner *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('name') border-rose-500 @enderror"
                    placeholder="Contoh: Nike, Adidas, Sony"
                    value="{{ old('name') }}"
                    required
                />
                @error('name')
                    <p class="text-rose-600 text-sm font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Logo URL --}}
            <div>
                <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-3">Logo URL *</label>
                <input 
                    list="logo-options" 
                    type="url" 
                    id="logo_url" 
                    name="logo_url" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('logo_url') border-rose-500 @enderror"
                    placeholder="https://example.com/logo.png"
                    value="{{ old('logo_url', 'https://placehold.co/200x200') }}"
                    required
                />
                <datalist id="logo-options">
                    <option value="https://placehold.co/200x200?text=Partner+1"></option>
                    <option value="https://placehold.co/200x200?text=Partner+2"></option>
                    <option value="https://placehold.co/200x200?text=Partner+3"></option>
                </datalist>
                @error('logo_url')
                    <p class="text-rose-600 text-sm font-semibold mt-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-500 mt-2">Gunakan URL gambar yang valid (http:// atau https://)</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex gap-3 pt-6 border-t border-slate-100">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition"
                >
                    Simpan Partner
                </button>
                <a 
                    href="{{ route('admin.partners.index') }}" 
                    class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
