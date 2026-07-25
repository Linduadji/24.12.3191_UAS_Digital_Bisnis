<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    @php
        $currentUser = Auth::check() ? Auth::user() : null;
        $displayName = $currentUser?->name ?? 'Guest';
        $roleLabel = match ($currentUser?->role ?? 'guest') {
            'admin' => 'Administrator',
            'partner' => 'Partner',
            default => 'Pengguna',
        };
        $loginStatus = Auth::check() ? 'Sedang Login' : 'Belum Login';
        $loginStatusClass = Auth::check() ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600';
    @endphp
    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
        </div>

        <div class="rounded-2xl border border-indigo-800 bg-indigo-800/70 p-4">
            <p class="text-[10px] uppercase tracking-[0.3em] text-indigo-300">Akun Saat Ini</p>
            <p class="mt-2 font-semibold text-white">{{ $displayName }}</p>
            <p class="text-sm text-indigo-300">{{ $roleLabel }}</p>
            <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $loginStatusClass }}">{{ $loginStatus }}</span>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Main Menu</p>
            
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Dashboard
            </a>

            <a href="{{ route('admin.organizers.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.organizers.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Manajemen Organizer
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Manajemen Kategori Event
            </a>

            <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.partners.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Manajemen Partner
            </a>

            {{-- Laporan --}}
            <a href="{{ route('admin.transactions') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.transactions') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Laporan
            </a>
        </nav>
        <div class="pt-6 border-t border-indigo-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">@yield('page_title')</h1>
                <p class="text-slate-500 font-medium">@yield('page_subtitle')</p>
            </div>
            <div class="flex items-center gap-4">
                @include('partials.profile_dropdown')
            </div>
        </header>

        {{-- Menampilkan Alert Sukses jika ada flash message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>