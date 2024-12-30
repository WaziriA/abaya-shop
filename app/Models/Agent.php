<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'transpoter_id',
        'shipment_method_id',
        'destination_country_id',
        'from',
        'to',
        'cost'
    ];
    public function transpoter(){
        return $this->belongsTo(Transpoter::class);
    }

    public function shipment_method()
    {
        return $this->belongsTo(ShipmentMethod::class, 'shipment_method_id');
    }

    public function destination_country()
    {
        return $this->belongsTo(DestinationCountry::class, 'destination_country_id');
    }

     // Define relationships with ShipmentMethod and DestinationCountry
     public function shipmentMethod()
     {
         return $this->belongsTo(ShipmentMethod::class);
     }
 
     public function destinationCountry()
     {
         return $this->belongsTo(DestinationCountry::class);
     }
}
