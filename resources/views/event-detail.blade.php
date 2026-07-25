@extends('layout.app')

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-12">
        {{-- Wadah Putih Utama --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">
                
                {{-- KOLOM KIRI: Poster & Info Penyelenggara --}}
                <div class="space-y-6">
                    {{-- Bingkai Foto Sesuai Gambar 2 --}}
                    <div class="bg-slate-50 rounded-3xl overflow-hidden border border-slate-200/60 p-2 shadow-inner">
                        <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/' . $event->poster_path)
                        : 'https://placehold.co/400x533?text=200x600' }}" alt="{{ $event->title }}" 
                        class="w-full rounded-2xl object-cover aspect-3/4">
                    </div>

                    {{-- Informasi Penyelenggara --}}
                    <div class="bg-slate-50/50 rounded-2xl border border-slate-100 p-5">
                        <h4 class="text-sm font-black text-slate-800 mb-3">Penyelenggara</h4>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                AH
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-800 text-sm">ABP Productions</p>
                                <p class="text-[11px] text-indigo-600 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a.75.75 0 00-.708.522L4.05 8.5H1.75a.75.75 0 000 1.5h2.55l1.25 4.163a.75.75 0 001.416-.04l1.516-5.306 1.157 3.472a.75.75 0 001.422-.046l1.833-6.111 1.054 2.634A.75.75 0 0015.25 9.5h3a.75.75 0 000-1.5h-2.541l-1.51-3.776a.75.75 0 00-1.393.047L10.93 10.51l-1.164-3.493a.75.75 0 00-1.425.043L6.267 3.455z" clip-rule="evenodd"/>
                                    </svg>
                                    Verified Organizer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Kategori, Judul, Meta, Deskripsi, Banner Tombol --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Kategori Badge --}}
                    <div>
                        <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-black uppercase tracking-wider">
                            {{ $event->category->name }}
                        </span>
                    </div>

                    {{-- Judul Event --}}
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ $event->title }}
                    </h1>

                    {{-- Metadata Waktu & Tempat --}}
                    <div class="flex flex-wrap gap-6 text-sm text-slate-500 font-bold">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $event->location }}
                        </div>
                    </div>

                    {{-- Deskripsi Event --}}
                    <div class="space-y-2 pt-2">
                        <h3 class="text-lg font-black text-slate-950">Deskripsi Event</h3>
                        <p class="text-slate-600 leading-relaxed text-base font-medium">
                            {{ $event->description }}
                        </p>
                    </div>

                    {{-- BANNER PEMBAYARAN HORIZONTAL (Sesuai Persis Gambar 2) --}}
                    <div class="bg-linear-to-r from-indigo-600 to-blue-600 rounded-3xl p-6 text-white flex flex-col sm:flex-row justify-between items-center gap-6 shadow-xl shadow-indigo-100">
                        <div class="space-y-2">
                            <p class="text-[11px] font-black uppercase tracking-widest text-slate-950">Harga Tiket</p>
                            <h2 class="text-3xl font-black leading-tight text-slate-950">
                                @if($event->price == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($event->price, 0, ',', '.') }}<span class="text-xs font-normal text-slate-950">/ orang</span>
                                @endif
                            </h2>
                            <p class="text-sm text-indigo-100 mt-2 font-medium">
                                @if($event->stock > 0)
                                    <span class="underline font-bold text-slate-950">Sisa {{ $event->stock }} Tiket lagi!</span>
                                @else
                                    <span class="font-bold text-rose-200">Tiket Sudah Habis</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            @if($event->stock > 0)
                                <a href="{{ url('checkout/' . $event->id) }}" 
                                    class="inline-block px-7 py-3 bg-white text-indigo-600 font-black rounded-2xl shadow-lg hover:bg-slate-50 transition active:scale-95 text-base whitespace-nowrap">
                                    Pesan Sekarang
                                </a>
                            @else
                                <button disabled 
                                        class="inline-block px-7 py-3 bg-slate-300 text-slate-500 font-black rounded-2xl cursor-not-allowed text-base whitespace-nowrap">
                                    Tiket Habis
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Kebijakan Tiket Sesuai Gambar 2 --}}
                    <div class="space-y-3 pt-4 border-t border-slate-100">
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-wide">Kebijakan Tiket</h4>
                        <ul class="space-y-2.5 text-sm text-slate-500 font-medium">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Tiket yang sudah dibeli tidak dapat dibatalkan atau di-refund secara sepihak.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        {{-- Navigasi Eksplorasi Kategori Lain --}}
        @if($categories->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200">
                <h3 class="text-2xl font-black mb-6 tracking-tight">Jelajahi Kategori Lain</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach($categories as $cat)
                        <a href="{{ url('/?category=' . $cat->slug) }}" 
                            class="p-5 bg-slate-50 rounded-2xl hover:bg-indigo-50 hover:shadow-md transition text-center border border-slate-100">
                            <p class="font-extrabold text-indigo-600 text-sm">{{ $cat->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection