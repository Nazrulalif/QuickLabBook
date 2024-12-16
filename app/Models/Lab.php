<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'location',
        'picture',
    ];

    public function stock(){
        return $this->hasMany(Stock::class);
    }
}
