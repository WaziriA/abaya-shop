<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'payment_id',
        'payment_method',
        'shipping_status',
        'product_id',
        'quantity'
        
    ];

    public function user(){
        return $this->belongsTo(User::class);
     }
     public function product(){
        return $this->belongsTo(Product::class);
     }

     public function shipping(){
        return $this->hasOne(Shipping::class);
     }
}
