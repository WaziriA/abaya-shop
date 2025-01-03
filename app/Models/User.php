<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'country',
        'phone_no',
        'phone_no2',
        'role',
        'photo',
        'IsActive',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function fails(){
        return $this->hasMany(Fail::class);
    }
    public function reviews(){
        return $this->hasMany(Product::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)->withPivot('used_at')->withTimestamps();
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function wishlists()
{
    return $this->hasMany(WishList::class);
}
public function feedbacks(){
    return $this->hasMany(Feedback::class);
}
}
