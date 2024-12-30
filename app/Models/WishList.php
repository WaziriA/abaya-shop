<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    //
    protected $fillable = [
        'product_id',
        'user_id'
    ];
       // Relationship to Product model
       public function product()
       {
           return $this->belongsTo(Product::class);
       }
   
       // Relationship to User model
       public function user()
       {
           return $this->belongsTo(User::class);
       }
}
