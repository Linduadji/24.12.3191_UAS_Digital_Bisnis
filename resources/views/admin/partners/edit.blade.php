@extends('layout.admin')

@section('title', 'Edit Partner - Admin')

@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Perbarui informasi partner yang sudah terdaftar.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Input Nama Partner --}}
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-3">Nama Partner *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('name') border-rose-500 @enderror"
                    value="{{ old('name', $partner->name) }}"
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
                    value="{{ old('logo_url', $partner->logo_url) }}"
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

            {{-- Preview Logo Saat Ini --}}
            @if($partner->logo_url)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-sm font-bold text-slate-700 mb-3">Preview Logo Saat Ini</p>
                    <div class="w-24 h-24 rounded-xl overflow-hidden shadow-sm border border-slate-100 bg-white">
                        <img src="{{ $partner->logo_url }}" 
                             alt="Logo {{ $partner->name }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://placehold.co/200x200?text=No+Logo'">
                    </div>
                </div>
            @endif

            {{-- Tombol Submit --}}
            <div class="flex gap-3 pt-6 border-t border-slate-100">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition"
                >
                    Perbarui Partner
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
