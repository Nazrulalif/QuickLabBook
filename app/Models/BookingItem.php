<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'stock_id',
        'quantity',

    ];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }
}
