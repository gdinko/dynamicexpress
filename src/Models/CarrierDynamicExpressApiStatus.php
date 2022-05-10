<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressApiStatus
 *
 * @property int $id
 * @property int $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressApiStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarrierDynamicExpressApiStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];
}
