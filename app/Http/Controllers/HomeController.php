<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data konser
        $concerts = Concert::with('venue')->latest()->get();
        
        // 2. Ambil data untuk Slider (misal 3 konser terbaru/unggulan)
        $featuredConcerts = $concerts->take(3);

        // 3. Kirim ke tampilan 'welcome'
        return view('welcome', compact('concerts', 'featuredConcerts'));
    }
}