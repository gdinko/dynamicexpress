<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierDynamicExpressCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_iso',
        'site_id',
        'name',
        'region',
        'municipality',
        'site_type',
        'post_code',
        'eknm',
        'delivery_weekdays',
    ];
}
