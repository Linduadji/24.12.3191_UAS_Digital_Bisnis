<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    <aside class="w-72 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-indigo-300">Organizer Panel</p>
                <span class="text-xl font-bold tracking-tight">Organizer Hub</span>
            </div>
        </div>

        <div class="rounded-2xl border border-indigo-800 bg-indigo-800/70 p-4">
            <p class="text-[10px] uppercase tracking-[0.3em] text-indigo-300">Akun Organizer</p>
            <p class="mt-2 font-semibold text-white">{{ Auth::user()->name }}</p>
            <p class="text-sm text-indigo-300">{{ Auth::user()->organization->name ?? 'Organisasi' }}</p>
            <p class="text-xs text-slate-200 mt-2 leading-relaxed">Kelola event, transaksi, dan profil organisasi Anda di satu tempat.</p>
            <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold bg-emerald-100 text-emerald-700">Sedang Login</span>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Main Menu</p>
            <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">Dashboard</a>
            <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">Kelola Event</a>
            <a href="{{ route('organizer.transactions') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.transactions') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">Laporan</a>
            <a href="{{ route('organizer.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.profile.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">Edit Profil</a>
        </nav>

        <div class="pt-6 border-t border-indigo-800">
            <form action="{{ route('organizer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium">Keluar</button>
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
                <div class="text-right hidden md:block">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ Auth::user()->organization->name ?? 'Organisasi' }}</p>
                </div>
                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" class="rounded-xl" alt="Avatar">
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
    </main>
    @stack('scripts')
    </body>
</html>
