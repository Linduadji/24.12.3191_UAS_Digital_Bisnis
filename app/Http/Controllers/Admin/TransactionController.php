<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event; // <-- TAMBAHAN: Untuk mengambil daftar event
use Illuminate\Support\Str; // <-- TAMBAHAN: Untuk membuat Order ID otomatis
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. Menampilkan Laporan (Index)
    public function index()
    {
        $transactions = Transaction::with('event')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    // 2. Menampilkan Form Tambah (Create)
    public function create()
    {
        // Ambil semua data event untuk dikirim ke dropdown di file create.blade.php
        $events = Event::all();
        return view('admin.transactions.create', compact('events'));
    }

    // 3. Menyimpan Data Baru (Store)
    public function store(Request $request)
    {
        // Validasi input dari form create
        $validated = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'total_price'    => 'required|numeric|min:0',
            'status'         => 'required|in:pending,success,settlement,challenge,failed',
        ]);

        // Otomatis buat Order ID (Contoh: TRX-A1B2C3D4)
        $validated['order_id'] = 'TRX-' . strtoupper(Str::random(8));

        // Perintah WAJIB untuk menyimpan ke database MySQL
        Transaction::create($validated);

        // Kembali ke index dengan pesan sukses
        return redirect()->route('admin.transactions')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit (Edit)
    public function edit(Transaction $transaction)
    {
        // Memanggil file edit.blade.php yang baru saja kamu buat
        return view('admin.transactions.edit', compact('transaction'));
    }

    // 5. Memproses Perubahan Data (Update)
    public function update(Request $request, Transaction $transaction)
    {
        // Validasi input dari form edit kamu
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'total_price' => 'required|numeric',
            'status' => 'required|in:Pending,Success,Expired,Failed',
        ]);

        // Simpan perubahan ke database
        $transaction->update($validated);

        // Kembali ke index dengan pesan sukses
        return redirect()->route('admin.transactions')->with('success', 'Data transaksi berhasil diperbarui!');
    }

    // 6. Menghapus Data (Destroy)
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions')->with('success', 'Data transaksi berhasil dihapus!');
    }
}