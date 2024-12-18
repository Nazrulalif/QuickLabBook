<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'no_matric',
        'phone',
        'level_study',
        'year_study',
        'status',
        'start_at',
        'end_at',
        'purpose',
        'comment'
    ];

    public function bookingItem(){
        return $this->hasMany(BookingItem::class);
    }

    public function itemName(){
        return $this->hasManyThrough(
            Stock::class,           // The model you want to access through the intermediate model
            BookingItem::class,     // The intermediate model
            'booking_id',           // Foreign key on the intermediate model (BookingItem)
            'id',                    // Foreign key on the target model (Stock)
            'id',                    // Local key on the current model (Booking)
            'stock_id'               // Local key on the intermediate model (BookingItem)
        );
    }

}
