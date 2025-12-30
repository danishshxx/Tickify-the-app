<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
use App\Models\Concert;
use App\Models\TicketCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin Akun Admin
        User::create([
            'name' => 'Admin Tickify',
            'email' => 'admin@tickify.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Bikin Akun User Biasa
        User::create([
            'name' => 'User Hore',
            'email' => 'user@tickify.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 3. Bikin Data Venue (Lokasi)
        $venue = Venue::create([
            'name' => 'Gelora Bung Karno (GBK)',
            'address' => 'Jl. Pintu Satu Senayan, Jakarta Pusat',
        ]);

        // 4. Bikin Data Konser
        $concert = Concert::create([
            'venue_id' => $venue->id,
            'name' => 'Coldplay: Music of the Spheres',
            'description' => 'Konser megah band asal Inggris yang paling ditunggu-tunggu.',
            'date' => '2025-11-15',
            'image' => null, // Nanti bisa diisi path gambar
        ]);

        // 5. Bikin Kategori Tiket untuk Konser di atas
        TicketCategory::create([
            'concert_id' => $concert->id,
            'type' => 'VIP Ultimate',
            'price' => 5000000,
            'total_qty' => 100,
        ]);

        TicketCategory::create([
            'concert_id' => $concert->id,
            'type' => 'Festival A',
            'price' => 1500000,
            'total_qty' => 500,
        ]);

        TicketCategory::create([
            'concert_id' => $concert->id,
            'type' => 'Tribun Atas',
            'price' => 750000,
            'total_qty' => 1000,
        ]);
    }
}