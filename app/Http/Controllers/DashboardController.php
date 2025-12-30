<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // CEGATAN ADMIN
        // Kalau yang login role-nya admin, tendang ke halaman admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Kalau User Biasa, baru jalanin logika tiket ini
        $transactions = Transaction::with(['ticketCategory', 'ticketCategory.concert'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('dashboard', compact('transactions'));
    }
}