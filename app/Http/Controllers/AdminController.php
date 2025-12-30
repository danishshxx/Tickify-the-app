<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Transaction;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Data Statistik (Yang lama)
        $totalConcerts = Concert::count();
        $totalVenues = Venue::count();
        $totalTransactions = Transaction::count();
        $revenue = Transaction::where('status', 'paid')->sum('total_price');

        // TAMBAHAN: Ambil data semua konser buat ditampilkan di tabel
        $concerts = Concert::with('venue')->latest()->get();

        return view('admin.dashboard', compact('totalConcerts', 'totalVenues', 'totalTransactions', 'revenue', 'concerts'));
    }
}