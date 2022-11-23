<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressOffice
 *
 * @property int $id
 * @property int|null $dynamic_express_id
 * @property string $name
 * @property string $office_type
 * @property int $country_iso
 * @property int|null $site_id
 * @property \Gdinko\DynamicExpress\Models\CarrierDynamicExpressCity|null $city
 * @property string|null $post_code
 * @property string|null $address
 * @property string $lat
 * @property string $lng
 * @property array|null $meta
 * @property string|null $distance
 * @property int $subcon_id
 * @property string|null $office_ref
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereCountryIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereDynamicExpressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereOfficeRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereSubconId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $city_uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\Gdinko\DynamicExpress\Models\CarrierCityMap[] $cityMap
 * @property-read int|null $city_map_count
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressOffice whereCityUuid($value)
 */
class CarrierDynamicExpressOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'dynamic_express_id',
        'name',
        'office_type',
        'country_iso',
        'site_id',
        'city_uuid',
        'city',
        'post_code',
        'address',
        'lat',
        'lng',
        'meta',
        'distance',
        'subcon_id',
        'office_ref',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(
            CarrierDynamicExpressCity::class,
            'site_id',
            'site_id'
        );
    }

    /**
     * cityMap
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityMap()
    {
        return $this->hasMany(
            CarrierCityMap::class,
            'uuid',
            'city_uuid'
        );
    }
}
