<?php

use Illuminate\Support\Facades\Route;

// Import Controller User
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController as PartnerAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE USER AREA
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('event')->group(function () {
    Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
    Route::get('/{id?}', [EventController::class, 'show'])->name('events.show');
});

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// RUTE ADMIN AREA (Sesuai Modul 5)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Halaman Utama Admin (Dashboard)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Halaman list partner admin
    Route::get('/partners', [PartnerAdminController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [PartnerAdminController::class, 'create'])->name('partners.create');
    Route::post('/partners', [PartnerAdminController::class, 'store'])->name('partners.store');
    Route::get('/partners/{partner}/edit', [PartnerAdminController::class, 'edit'])->name('partners.edit');
    Route::put('/partners/{partner}', [PartnerAdminController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{partner}', [PartnerAdminController::class, 'destroy'])->name('partners.destroy');

    // RUTE RESOURCE (Otomatis: index, create, store, edit, update, destroy)
    Route::resource('events', EventAdminController::class);
    
    // Laporan Transaksi (Nama disesuaikan dengan sidebar kamu)
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
});