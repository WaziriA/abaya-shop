<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable= [
        'category_id',
        'name',
        'description',
        'brand',
        'price',
        'sku',
        'stock',
        'availability_status',
        'color',
        'size',
        'view_count',
        'status',
        'location',
        'image'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function fail(){
        return $this->hasMany(Fail::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
     }
}
