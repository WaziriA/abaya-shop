<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentMethod extends Model
{
    //
    protected $fillable = [
        'method_name'
    ];

    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'country_id');
    }
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

}
