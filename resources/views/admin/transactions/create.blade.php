@extends('layout.admin')

@section('title', 'Tambah Transaksi Manual')

@section('page_title', 'Tambah Transaksi')
@section('page_subtitle', 'Masukkan data transaksi baru secara manual ke dalam sistem.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan input:</p>
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Event *</label>
                <select name="event_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pelanggan *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email *</label>
                <input type="email" name="customer_email" value="{{ old('customer_email') }}" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon *</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Harga (Rp) *</label>
                <input type="number" name="total_price" value="{{ old('total_price') }}" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Status Awal *</label>
                <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="success" {{ old('status') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="settlement" {{ old('status') == 'settlement' ? 'selected' : '' }}>Settlement</option>
                    <option value="challenge" {{ old('status') == 'challenge' ? 'selected' : '' }}>Challenge</option>
                    <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="flex gap-3 pt-6 border-t border-slate-100">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
                    Simpan Transaksi
                </button>
                <a href="{{ route('admin.transactions') }}" class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection