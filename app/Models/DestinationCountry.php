<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationCountry extends Model
{
    //
    protected $fillable = [
        'country_name'
    ];
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
}
