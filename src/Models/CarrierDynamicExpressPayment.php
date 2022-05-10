<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressPayment
 *
 * @property int $id
 * @property string $num
 * @property string $rid
 * @property string $pay_type
 * @property string $pay_date
 * @property string $amount
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereRid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarrierDynamicExpressPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'rid',
        'pay_type',
        'pay_date',
        'amount',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
