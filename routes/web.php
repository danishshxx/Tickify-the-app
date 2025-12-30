<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController; // <--- INI YANG KURANG BANG! Tambahin ya.
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Landing Page) - Bisa diakses siapa aja
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Dashboard USER (Pembeli)
// Kalau user login, masuknya ke sini (localhost:8000/dashboard)
// 2. Dashboard USER & TRANSAKSI
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard User (Tiket Saya)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ticket/{transaction}', [\App\Http\Controllers\TransactionController::class, 'showTicket'])->name('ticket.show');

    // --- TAMBAHAN: Detail Konser & Checkout ---
    
    // 1. Halaman Detail Konser (Klik dari Home)
    Route::get('/concert/{concert}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('concert.detail');

    // 2. Proses Beli Tiket (Checkout)
    Route::post('/concert/{concert}/checkout', [\App\Http\Controllers\TransactionController::class, 'store'])->name('concert.checkout');
    Route::get('/transaction/{transaction}/payment', [\App\Http\Controllers\TransactionController::class, 'payment'])->name('transaction.payment');

});

// 3. Dashboard ADMIN
// Kalau mau masuk sini harus ketik manual: localhost:8000/admin
// 3. Dashboard ADMIN
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    Route::get('/transactions', [\App\Http\Controllers\AdminTransactionController::class, 'index'])->name('admin.transactions');
    Route::patch('/transactions/{transaction}/confirm', [\App\Http\Controllers\AdminTransactionController::class, 'confirm'])->name('admin.transactions.confirm');
    Route::patch('/transactions/{transaction}/reject', [\App\Http\Controllers\AdminTransactionController::class, 'reject'])->name('admin.transactions.reject');
    
    // 1. Dashboard Admin
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

    // 2. Konser Resource
    Route::resource('concerts', \App\Http\Controllers\ConcertController::class);

    // 3. TIKET (Pastikan 2 baris ini ADA!)
    Route::get('/concerts/{concert}/tickets/create', [\App\Http\Controllers\TicketCategoryController::class, 'create'])->name('concerts.tickets.create');
    Route::post('/concerts/{concert}/tickets', [\App\Http\Controllers\TicketCategoryController::class, 'store'])->name('concerts.tickets.store');

});

// 4. Setting Profile (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/transactions/{transaction}/upload', [\App\Http\Controllers\TransactionController::class, 'uploadProof'])->name('transactions.upload');
});

require __DIR__.'/auth.php';