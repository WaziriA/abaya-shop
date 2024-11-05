<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    //
    protected $fillable = [
        'image',
        'name',
        'description',
        'specialization',
        'company'
    ];
}
