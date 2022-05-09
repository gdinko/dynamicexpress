<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierDynamicExpressApiStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];
}
