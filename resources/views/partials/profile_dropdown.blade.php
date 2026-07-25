@php
    $user = Auth::user();
    $displayName = $user?->name ?? 'Guest';
    $email = $user?->email ?? null;
    $role = $user?->role ?? 'guest';
    // choose logout route based on current route name/prefix or role
    if (request()->routeIs('admin.*') || $role === 'admin') {
        $logoutRoute = route('admin.logout');
    } elseif (request()->routeIs('organizer.*') || $role === 'organizer') {
        $logoutRoute = route('organizer.logout');
    } else {
        $logoutRoute = route('user.logout');
    }
    $avatarUrl = $displayName ? 'https://ui-avatars.com/api/?name='.urlencode($displayName).'&background=6366f1&color=fff' : '';
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click.prevent="open = !open" class="flex items-center gap-3 focus:outline-none">
        <div class="w-10 h-10 bg-white rounded-full overflow-hidden shadow-sm">
            <img src="{{ $avatarUrl }}" alt="Avatar" class="w-full h-full object-cover">
        </div>
    </button>

    <div x-show="open" @click.away="open = false" style="display:none"
         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-lg border py-3 z-50">
        <div class="px-4 pb-3 border-b">
            <p class="font-semibold text-slate-900">{{ $displayName }}</p>
            @if($email)
                <p class="text-xs text-slate-500 truncate">{{ $email }}</p>
            @endif
            <p class="text-[11px] text-slate-400 mt-2">{{ ucfirst($role) }}</p>
        </div>
        <div class="py-2">
            <a href="#" class="block px-4 py-2 hover:bg-slate-50">Kelola Profil</a>
            <a href="#" class="block px-4 py-2 hover:bg-slate-50">Pengaturan Akun</a>
        </div>
        <div class="px-4 pt-2 border-t">
            <form action="{{ $logoutRoute }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-red-50">Keluar</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
