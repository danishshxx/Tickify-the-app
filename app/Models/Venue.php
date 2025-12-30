<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Semua kolom boleh diisi kecuali ID

    // Relasi: Venue punya banyak Concert
    public function concerts()
    {
        return $this->hasMany(Concert::class);
    }
}