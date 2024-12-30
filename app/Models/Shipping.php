<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    //
    protected $fillable = [
        'order_id',   // Foreign key to relate to order table
        'transpoter_id',
        'shipment_method_id',
        'country_id',
        'town',
        'district',
        'street',
        'zip_code',
        'note'
    ];

    public function order(){
        return $this->belongTo(Order::class);
    }
    public function transpoter()
    {
        return $this->belongsTo(Transpoter::class);
    }

    public function shipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class);
    }

    public function country()
    {
        return $this->belongsTo(DestinationCountry::class, 'country_id');
    }
}
