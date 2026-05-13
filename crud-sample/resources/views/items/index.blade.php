@extends('layout.app')

@section('title', 'Daftar Item')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Daftar Item</h2>
        <a href="{{ route('items.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tambah Item</a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $item->name }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('items.show', $item->id) }}" class="text-blue-600">Lihat</a>
                            <a href="{{ route('items.edit', $item->id) }}" class="text-yellow-600">Edit</a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada item.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
