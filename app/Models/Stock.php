<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'lab_id',
        'is_available',
        'picture',
    ];

    public function lab(){
        return $this->belongsTo(Lab::class);
    }
    
    public function bookingItem(){
        return $this->hasMany(BookingItem::class);
    }

}
