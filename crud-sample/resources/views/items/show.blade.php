@extends('layout.app')

@section('title', 'Detail Item')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-3">{{ $item->name }}</h2>
        <p class="text-gray-600 mb-4">{{ $item->description ?? 'Tidak ada deskripsi.' }}</p>
        <p class="font-semibold text-lg mb-6">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</p>

        <a href="{{ route('items.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">Kembali</a>
    </div>
@endsection
