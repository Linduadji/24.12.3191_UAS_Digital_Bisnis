@extends('layout.app')

@section('title', 'Edit Item')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Edit Item</h2>

    <form action="{{ route('items.update', $item->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold mb-2">Nama Item</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full border rounded-lg px-4 py-3" required>
            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block font-semibold mb-2">Deskripsi</label>
            <textarea name="description" class="w-full border rounded-lg px-4 py-3" rows="4">{{ old('description', $item->description) }}</textarea>
            @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block font-semibold mb-2">Harga</label>
            <input type="number" name="price" value="{{ old('price', $item->price) }}" class="w-full border rounded-lg px-4 py-3" min="0" required>
            @error('price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('items.index') }}" class="px-5 py-3 rounded-lg border border-gray-300">Batal</a>
            <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-lg">Perbarui</button>
        </div>
    </form>
@endsection
