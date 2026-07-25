@extends('organizer.layout')

@section('title', 'Edit Profil - Organizer')
@section('page_title', 'Edit Profil')
@section('page_subtitle', 'Perbarui informasi akun dan detail organisasi Anda.')

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8">
        <form action="{{ route('organizer.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200" required>
                </div>
                <div>
                    <label class="font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-slate-700">Nama Organisasi</label>
                    <input type="text" name="organization_name" value="{{ old('organization_name', $organization->name) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200" required>
                </div>
                <div>
                    <label class="font-semibold text-slate-700">Website / Link</label>
                    <input type="url" name="organization_website" value="{{ old('organization_website', $organization->website) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200">
                </div>
            </div>

            <div>
                <label class="font-semibold text-slate-700">Deskripsi Organisasi</label>
                <textarea name="organization_description" rows="4" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200">{{ old('organization_description', $organization->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">
                    <p class="text-slate-500 text-sm font-bold uppercase mb-2">Data Organisasi</p>
                    <p class="text-slate-900 font-semibold">{{ $organization->name }}</p>
                    <p class="text-sm text-slate-500 mt-2">{{ $organization->description ?? 'Belum ada deskripsi organisasi.' }}</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">
                    <p class="text-slate-500 text-sm font-bold uppercase mb-2">Website</p>
                    <p class="text-slate-900 font-semibold">{{ $organization->website ?? '-' }}</p>
                    <p class="text-slate-500 text-sm mt-3">Tautan ini akan ditampilkan ke calon peserta event Anda.</p>
                </div>
            </div>
            
            <div class="mt-4 p-6 bg-white rounded-2xl border border-slate-100">
                <h4 class="font-bold mb-2">Ganti Password</h4>
                <p class="text-sm text-slate-500 mb-4">Isi hanya jika ingin mengganti password. Masukkan password sebelumnya untuk konfirmasi.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Password Sebelumnya</label>
                        <input type="password" name="current_password" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('current_password')<p class="text-rose-600 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="font-semibold text-slate-700">Password Baru</label>
                        <input type="password" name="new_password" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('new_password')<p class="text-rose-600 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="font-semibold text-slate-700">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection