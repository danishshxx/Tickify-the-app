<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    // 1. Fungsi INDEX (Ini yang tadi HILANG bikin Error)
    public function index()
    {
        // Ambil transaksi, urutkan dari yang terbaru
        $transactions = Transaction::with(['user', 'ticketCategory.concert'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // 2. Fungsi TERIMA (Validasi)
    public function confirm(Transaction $transaction)
    {
        $transaction->update(['status' => 'paid']);
        return redirect()->back()->with('success', 'Transaksi disetujui!');
    }
    
    // 3. Fungsi TOLAK
    public function reject(Transaction $transaction)
    {
        $transaction->update(['status' => 'rejected']);
        return redirect()->back()->with('error', 'Transaksi ditolak.');
    }
}