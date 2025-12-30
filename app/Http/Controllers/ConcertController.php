<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahin ini biar kodingan Storage lebih pendek

class ConcertController extends Controller
{
    // --- JARING PENGAMAN ---
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    // 1. CREATE (Nampilin Form Bikin Baru)
    public function create()
    {
        $venues = Venue::all();
        return view('admin.concerts.create', compact('venues'));
    }

    // 2. STORE (Simpan Data Baru)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'venue_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:40960',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('concerts', 'public');
        }

        Concert::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'venue_id' => $request->venue_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Konser berhasil dibuat!');
    }

    // 3. EDIT (Nampilin Form Edit) - INI BARU DITAMBAH
    public function edit(Concert $concert)
    {
        // Kita butuh data venues juga buat dropdown lokasi
        $venues = Venue::all();
        return view('admin.concerts.edit', compact('concert', 'venues'));
    }

    // 4. UPDATE (Simpan Perubahan) - INI BARU DITAMBAH
    public function update(Request $request, Concert $concert)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'venue_id' => 'required',
            // Image jadi 'nullable' (boleh kosong kalau gamau ganti gambar)
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:40960', 
        ]);

        // Ambil semua data input KECUALI image
        $data = $request->except('image');

        // LOGIKA GANTI GAMBAR
        if ($request->hasFile('image')) {
            
            // A. Hapus gambar lama (jika ada)
            if ($concert->image) {
                Storage::disk('public')->delete($concert->image);
            }

            // B. Simpan gambar baru
            $imagePath = $request->file('image')->store('concerts', 'public');
            
            // C. Masukkan path gambar baru ke array data
            $data['image'] = $imagePath;
        }

        // Update Database
        $concert->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Konser berhasil diperbarui!');
    }

    // 5. DESTROY (Hapus Konser)
    public function destroy(Concert $concert)
    {
        // Hapus gambar posternya dulu
        if ($concert->image) {
            Storage::disk('public')->delete($concert->image);
        }

        // Hapus data dari database
        $concert->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Konser berhasil dihapus!');
    }
}