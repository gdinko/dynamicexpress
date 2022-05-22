<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressTracking
 *
 * @property int $id
 * @property string $carrier_signature
 * @property string $carrier_account
 * @property int $parcel_id
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereCarrierAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereCarrierSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereParcelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressTracking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarrierDynamicExpressTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrier_signature',
        'carrier_account',
        'parcel_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
