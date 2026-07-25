@extends('layout.admin')

@section('title', 'Edit Transaksi')

@section('page_title', 'Edit Transaksi')
@section('page_subtitle', 'Ubah detail transaksi')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Order ID (Read-only) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Order ID</label>
                    <input type="text" value="{{ $transaction->order_id }}" disabled 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-600 font-mono">
                </div>

                <!-- Event (Read-only) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Event</label>
                    <input type="text" value="{{ $transaction->event->title ?? '-' }}" disabled 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-600">
                </div>

                <!-- Nama Pelanggan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pelanggan</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $transaction->customer_name) }}" 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required>
                    @error('customer_name')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', $transaction->customer_email) }}" 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required>
                    @error('customer_email')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="customer_phone" value="{{ old('customer_phone', $transaction->customer_phone) }}" 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required>
                    @error('customer_phone')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Total Harga -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Total Harga (Rp)</label>
                    <input type="number" name="total_price" value="{{ old('total_price', $transaction->total_price) }}" 
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        required>
                    @error('total_price')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                        <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ $transaction->status === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="settlement" {{ $transaction->status === 'settlement' ? 'selected' : '' }}>Settlement</option>
                        <option value="challenge" {{ $transaction->status === 'challenge' ? 'selected' : '' }}>Challenge</option>
                        <option value="failed" {{ $transaction->status === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex gap-3 pt-6">
                    <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.transactions') }}" class="flex-1 px-6 py-3 border border-slate-300 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
