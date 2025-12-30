<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Kita pakai $fillable biar jelas kolom apa aja yang boleh diisi
    protected $fillable = [
        'user_id',
        'ticket_category_id',
        'qty',
        'total_price',
        'status',
        'payment_proof',
        'transaction_date',
        
        // DATA DIRI PEMBELI (BARU)
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'buyer_nik',
    ];

    // Relasi ke User (Akun yang login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori Tiket
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}