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
        'price_usd',
        'price_gbp',
        'price_eur',
        'price_aed',
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
    /*public function orders(){
        return $this->hasMany(Order::class);
     }*/

     public function orders()
{
    return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity');
}

     public function wishlists()
{
    return $this->hasMany(WishList::class);
}
public function isOnSale()
{
    // Example logic to determine if the product is on sale
    return $this->sale_price > 0 && $this->sale_price < $this->regular_price;
}
}
