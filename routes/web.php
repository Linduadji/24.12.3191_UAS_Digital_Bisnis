<?php

use Illuminate\Support\Facades\Route;

// Import Controller User
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

// Import Controller Admin
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController as PartnerAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;

// Import Controller Socialite
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Organizer\AuthController as OrganizerAuthController;
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\TransactionController as OrganizerTransactionController;
use App\Http\Controllers\Organizer\ProfileController as OrganizerProfileController;
use App\Http\Middleware\OrganizerMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE USER AREA (PUBLIK)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/ticket/{order_id}', [EventController::class, 'showTicket'])->name('ticket.show');

// Rute Review (Publik untuk view, auth untuk create/store)
Route::get('/events/{event}/reviews/create', [ReviewController::class, 'create'])->middleware('auth')->name('reviews.create');
Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

// Rute Proses Checkout & Pembayaran (Harus bisa diakses publik)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Rute Webhook Midtrans
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.callback');

// ==========================================
// RUTE SSO GOOGLE (Harus diluar Middleware Auth & Admin)
// ==========================================
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// ==========================================
// RUTE USER AUTH (Publik)
// ==========================================
// Halaman login publik (user) dengan opsi Google
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');


// ==========================================
// RUTE ADMIN AREA 
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute Login (Tanpa Middleware Auth)
    // Ingat, URL-nya adalah http://localhost:8000/admin/login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Pengamanan Rute Administrasi di balik Middleware
    Route::middleware(['auth', 'admin'])->group(function () {

        // Halaman Utama Admin (Dashboard)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.root');

        // Laporan Transaksi 
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

        // Halaman list partner admin
        Route::get('/partners', [PartnerAdminController::class, 'index'])->name('partners.index');
        Route::get('/partners/create', [PartnerAdminController::class, 'create'])->name('partners.create');
        Route::post('/partners', [PartnerAdminController::class, 'store'])->name('partners.store');
        Route::get('/partners/{partner}/edit', [PartnerAdminController::class, 'edit'])->name('partners.edit');
        Route::put('/partners/{partner}', [PartnerAdminController::class, 'update'])->name('partners.update');
        Route::delete('/partners/{partner}', [PartnerAdminController::class, 'destroy'])->name('partners.destroy');

        // RUTE RESOURCE (Events & Categories)
        Route::get('/organizers', [OrganizerController::class, 'index'])->name('organizers.index');
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryAdminController::class);
    });
});


// ==========================================
// RUTE ORGANIZER AREA (Login terpisah)
// ==========================================
Route::prefix('organizer')->name('organizer.')->group(function () {
    Route::get('login', [OrganizerAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [OrganizerAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [OrganizerAuthController::class, 'logout'])->name('logout');

    // Registration for new organizer accounts
    Route::get('register', [OrganizerAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [OrganizerAuthController::class, 'register'])->name('register.post');

    // Protected organizer routes
    Route::middleware(['auth', OrganizerMiddleware::class])->group(function () {
        Route::get('/', [OrganizerDashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', OrganizerEventController::class)->except(['show']);

        Route::get('/transactions', [OrganizerTransactionController::class, 'index'])->name('transactions');

        Route::get('/profile/edit', [OrganizerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [OrganizerProfileController::class, 'update'])->name('profile.update');
    });
});