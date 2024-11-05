<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'discount_value', 'expires_at', 'code'];

    // Automatically generate a unique code on creation
    protected static function booted()
    {
        static::creating(function ($coupon) {
            $coupon->code = strtoupper(Str::random(8));
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('used_at')->withTimestamps();
    }
    public function usedBy()
    {
        return $this->belongsToMany(User::class, 'coupon_user')->withTimestamps();
    }
}
