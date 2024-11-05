<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fail extends Model
{
    //
    protected $fillable = [
        'product_id',
        'product_id',
        'reason',
        'date'
    ];
    public function product(){
        return $this->belongTo(Product::class);
    }
    public function user(){
        return $this->belongTo(User::class);
    }
}
