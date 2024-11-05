<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    //
    protected $fillable = [
        'agent_name',
        'destination_country',
        'from',
        'to',
        'cost'
    ];
}
