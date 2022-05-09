<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierDynamicExpressOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'dynamic_express_id',
        'name',
        'office_type',
        'country_iso',
        'site_id',
        'city',
        'post_code',
        'address',
        'lat',
        'lng',
        'parcel_pickup',
        'parcel_acceptance',
        'max_parcel_dimensions_w',
        'max_parcel_dimensions_h',
        'max_parcel_dimensions_l',
        'max_parcel_weight',
        'business_hours_d1',
        'business_hours_d2',
        'business_hours_d3',
        'business_hours_d4',
        'business_hours_d5',
        'business_hours_d6',
        'business_hours_d7',
        'info',
        'distance',
        'subcon_id',
        'office_ref',
    ];
}
