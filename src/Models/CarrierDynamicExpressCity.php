<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressCity
 *
 * @property int $id
 * @property int $country_iso
 * @property int $site_id
 * @property string $name
 * @property string|null $region
 * @property string|null $municipality
 * @property string|null $site_type
 * @property string $post_code
 * @property string|null $eknm
 * @property string|null $delivery_weekdays
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Gdinko\DynamicExpress\Models\CarrierDynamicExpressOffice[] $offices
 * @property-read int|null $offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereCountryIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereDeliveryWeekdays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereEknm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereMunicipality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereSiteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function offices()
    {
        return $this->hasMany(
            CarrierDynamicExpressOffice::class,
            'site_id',
            'site_id'
        );
    }
}
