<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Kebalikan hasMany adalah belongsTo
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function ticketCategories()
    {
        return $this->hasMany(TicketCategory::class);
    }
}