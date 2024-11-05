<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineOrder extends Model
{
    //
    protected $fillable = [
        'customer',
        'product_id',
        'quantity',
        'payment_status',
        'amount',
        'destination',
        'shipping_status',
        
        
    ];
}
