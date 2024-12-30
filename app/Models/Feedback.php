<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $fillable = [
        'order_id',
        'user_id',
        
        'comment',
    ];

    // Define the relationship between Feedback and Order (Feedback belongs to an Order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Define the relationship between Feedback and User (Feedback belongs to a User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
