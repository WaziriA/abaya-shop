<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transpoter extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'transpoter_name'
    ];
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
}
