<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource (READ).
     * Menampilkan daftar semua kategori dengan fitur pencarian
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Query dengan pencarian dinamis
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10)
        ->appends(['search' => $search]); // Preserve search param saat pagination

        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource (CREATE).
     * Menampilkan form untuk membuat kategori baru
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage (STORE).
     * Menyimpan data kategori baru ke database
     */
    public function store(Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Generate slug dari nama kategori
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);

        // Menyimpan data menggunakan Model
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource (EDIT).
     * Menampilkan form untuk mengedit kategori
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage (UPDATE).
     * Memperbarui data kategori di database
     */
    public function update(Request $request, Category $category)
    {
        // Validasi dengan pengecualian ID kategori saat ini
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Update slug jika nama berubah
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (DELETE).
     * Menghapus kategori dari database
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
