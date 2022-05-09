<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierDynamicExpressCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'iso',
        'iso_alpha2',
        'name',
    ];
}
