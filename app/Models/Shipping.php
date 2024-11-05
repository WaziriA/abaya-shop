<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    //
    protected $fillable = [
        'order_id',   // Foreign key to relate to order table
        'first_name',
        'last_name',
        'country',
        'town',
        'district',
        'street',
        'zip_code',
        'note'
    ];

    public function order(){
        return $this->belongTo(Order::class);
    }
}
