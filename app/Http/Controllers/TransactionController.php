<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Transaction;
use App\Models\TicketCategory; // Tambahin ini biar rapi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Halaman Detail Konser
    public function show(Concert $concert)
    {
        $concert->load('ticketCategories');
        return view('concerts.show', compact('concert'));
    }

    // Proses Beli Tiket (Checkout)
    public function store(Request $request, Concert $concert)
    {
        // 1. Validasi Input (Termasuk Data Diri)
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'quantity' => 'required|integer|min:1|max:4',
            // VALIDASI DATA DIRI
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required|numeric',
            'buyer_nik' => 'required|numeric|digits:16', 
        ]);

        $ticket = TicketCategory::findOrFail($request->ticket_category_id);

        // --- BAGIAN INI WAJIB ADA (JANGAN DIHAPUS) ---

        // 2. Cek Stok Tersedia
        if ($ticket->total_qty < $request->quantity) {
            return back()->withErrors(['quantity' => "Waduh, tiket tinggal sisa {$ticket->total_qty} biji bang!"]);
        }

        // 3. Cek Riwayat Beli User (Anti-Calo: Max 4 tiket per akun)
        $userBought = Transaction::where('user_id', Auth::id())
                        ->where('ticket_category_id', $ticket->id)
                        ->where('status', '!=', 'rejected') 
                        ->sum('qty');

        if (($userBought + $request->quantity) > 4) {
            return back()->withErrors(['quantity' => "Maksimal cuma boleh punya 4 tiket per akun! Kamu udah punya {$userBought} tiket."]);
        }

        // ---------------------------------------------

        // 4. Hitung Total (Harga + PPN 11% + Admin)
        $subtotal = $ticket->price * $request->quantity;
        $tax = $subtotal * 0.11;
        $adminFee = 5000;
        $grandTotal = $subtotal + $tax + $adminFee;

        // 5. Simpan ke Database
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            // SIMPAN DATA DIRI PEMILIK TIKET
            'buyer_name' => $request->buyer_name,
            'buyer_email' => $request->buyer_email,
            'buyer_phone' => $request->buyer_phone,
            'buyer_nik' => $request->buyer_nik,
            // -------------------------------
            'ticket_category_id' => $ticket->id,
            'qty' => $request->quantity,
            'total_price' => $grandTotal,
            'status' => 'pending',
            'transaction_date' => now(),
        ]);

        // 6. Kurangi Stok Tiket
        $ticket->decrement('total_qty', $request->quantity);

        return redirect()->route('transaction.payment', $transaction->id);
    }

    public function uploadProof(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->file('payment_proof')) {
            $imagePath = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $transaction->update([
                'payment_proof' => $imagePath,
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Tunggu verifikasi admin.');
    }

    public function showTicket(Transaction $transaction)
    {
        if ($transaction->status !== 'paid') {
            return redirect()->route('dashboard')->with('error', 'Tiket belum lunas!');
        }

        return view('tickets.show', compact('transaction'));
    }

    public function payment(Transaction $transaction)
    {
        return view('transaction.payment', compact('transaction'));
    }
}