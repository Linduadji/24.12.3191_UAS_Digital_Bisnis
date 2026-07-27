@extends('layout.app')

@section('title', 'Berikan Ulasan - ' . $event->title)

@section('content')
<div class="max-w-3xl mx-auto p-8">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <div class="mb-8">
            <a href="{{ route('ticket') }}" class="text-indigo-600 font-semibold mb-4 inline-block">← Kembali ke Tiketku</a>
            <h1 class="text-3xl font-black mb-2">Berikan Ulasan</h1>
            <p class="text-slate-600">Bagikan pengalaman Anda di acara <strong>{{ $event->title }}</strong></p>
        </div>

        <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
            <div class="flex gap-4">
                @if($event->poster_path)
                    <img src="{{ Storage::disk('public')->exists($event->poster_path) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/96x128' }}" alt="{{ $event->title }}" class="w-24 h-32 object-cover rounded-xl">
                @else
                    <div class="w-24 h-32 bg-slate-200 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="font-bold text-lg mb-1">{{ $event->title }}</h3>
                    <p class="text-sm text-slate-600 mb-2">{{ $event->category->name }} • {{ $event->date->format('d M Y') }}</p>
                    <p class="text-sm text-slate-600"> Lokasi : {{ $event->location }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Rating Acara (1-5 Bintang)</label>
                <div class="flex flex-wrap gap-3">
                    @for($i = 5; $i >= 1; $i--)
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" {{ old('rating') == $i ? 'checked' : '' }}>
                            <!-- Kotak Rating -->
                            <div class="w-16 h-16 flex items-center justify-center rounded-2xl border-2 border-slate-700 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/20 hover:border-indigo-400 transition">
                                <span class="text-xl font-bold flex items-center gap-1">
                                    ⭐ {{ $i }}
                                </span>
                            </div>
                        </label>
                    @endfor
                </div>
                @error('rating') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Komentar / Testimoni (Opsional)</label>
                <textarea name="comment" rows="5" placeholder="Ceritakan pengalaman Anda mengikuti acara ini. Apa yang paling Anda suka? Apa yang bisa ditingkatkan?"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">{{ old('comment') }}</textarea>
                @error('comment') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('ticket') }}" class="px-6 py-3 text-slate-500 font-bold hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>
@endsection
