<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment'
        
    ];
    public function user(){
       return $this->belongTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
     }
}
