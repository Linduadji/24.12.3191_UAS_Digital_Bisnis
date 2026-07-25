<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EventTicketMail;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);

        // Jika acara gratis (harga 0), bypass Midtrans: tidak ada biaya tambahan
        if ((int) $event->price === 0) {
            $totalPrice = 0;

            $transaction = Transaction::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price' => $totalPrice,
                'status' => 'success', // langsung sukses untuk event gratis
            ]);

            // Kurangi stok dan kirim e-ticket segera
            if ($event->stock > 0) {
                try {
                    $event->decrement('stock');
                } catch (Exception $e) {
                    Log::error('Gagal mengurangi stok event (gratis): ' . $e->getMessage());
                }
            } else {
                return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
            }

            try {
                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
            } catch (Exception $e) {
                Log::error('Gagal mengirim email E-Ticket (gratis): ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $transaction->order_id)->with('success', 'Pendaftaran berhasil. E-Ticket telah dikirim.');
        }

        // Untuk acara berbayar, lanjutkan alur Midtrans
        $totalPrice = $event->price + 5000;

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(), // Set user_id jika user sedang login
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'pending', // Status awal adalah pending
        ]);

        // Konfigurasi Kredensial Environment Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isSanitized = true;
        Config::$isProduction = false; // SUDAH DIPERBAIKI: Mode Sandbox
        Config::$is3ds = true;

        // Susun Paket Array Data Transaksi 
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = Snap::getSnapToken($params);
            
            // Update rekaman kita bahwa transaksi terkait sudah memiliki id 
            $transaction->update(['snap_token' => $snapToken]);
            
            // Redirect ke halaman antarmuka pembayaran final pelanggan 
            return redirect()->route('checkout.payment', $transaction->order_id);
            
        } catch (Exception $e) { 
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        // Jika transaksi sudah berstatus success (mis. event gratis) atau total_price == 0,
        // lewati pemeriksaan Midtrans dan tampilkan halaman sukses langsung.
        if ($transaction->total_price == 0 || $transaction->status === 'success') {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        // Validasi status pembayaran asli dari Midtrans (Mencegah manipulasi URL)
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // SUDAH DIPERBAIKI: Mode Sandbox

        try {
            $midtransStatus = MidtransTransaction::status($order_id);

            // Pengecekan aman agar tidak error 'Trying to get property of non-object'
            if (is_object($midtransStatus) && isset($midtransStatus->transaction_status)) {
                // Simpan status sebelumnya untuk mencegah proses ganda
                $previousStatus = $transaction->status;

                // Hanya ubah status menjadi success jika Midtrans mengonfirmasi pembayaran lunas
                if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                    $transaction->update(['status' => 'success']);

                    // Jika sebelumnya belum diproses sebagai success/settlement, lakukan post-processing
                    if (!in_array($previousStatus, ['settlement', 'success'])) {
                        $event = $transaction->event;
                        if ($event && $event->stock > 0) {
                            try {
                                $event->decrement('stock');
                            } catch (Exception $e) {
                                Log::error('Gagal mengurangi stok event: ' . $e->getMessage());
                            }

                            // Kirim email E-Ticket
                            try {
                                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                            } catch (Exception $e) {
                                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
                            }
                        } else {
                            Log::warning('Stock habis setelah pembayaran berhasil (Order: ' . $transaction->order_id . ')');
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // Jika error (transaksi tidak ada di Midtrans, koneksi terputus), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}