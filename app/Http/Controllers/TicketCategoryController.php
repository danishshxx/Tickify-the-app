<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    // 1. Tampilkan Form Tambah Tiket
    // Kita butuh data $concert biar tahu ini tiket buat konser siapa
    public function create(Concert $concert)
    {
        return view('admin.tickets.create', compact('concert'));
    }

    // 2. Simpan Tiket ke Database
    public function store(Request $request, Concert $concert)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'total_qty' => 'required|integer|min:1',
        ]);

        // Simpan via relasi (cara cepat & aman)
        $concert->ticketCategories()->create([
            'type' => $request->type,
            'price' => $request->price,
            'total_qty' => $request->total_qty,
        ]);

        // Balik lagi ke dashboard admin
        return redirect()->route('admin.dashboard')->with('success', 'Kategori tiket berhasil ditambahkan!');
    }
}