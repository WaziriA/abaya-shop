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
        'currency',
        'payment_id',
        'payment_method',
        'shipping_status',
        'product_id',
        'quantity',
        'shipping_cost'  // Add this line
        
    ];

    public function user(){
        return $this->belongsTo(User::class);
     }
     /*public function product(){
        return $this->belongsTo(Product::class);
     }*/

     public function products()
{
    return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity');
}


     public function shipping(){
        return $this->hasOne(Shipping::class);
     }
     public function feedbacks(){
      return $this->hasMany(Feedback::class);
  }
  
}
