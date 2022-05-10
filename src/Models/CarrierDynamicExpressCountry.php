<?php

namespace Gdinko\DynamicExpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Gdinko\DynamicExpress\Models\CarrierDynamicExpressCountry
 *
 * @property int $id
 * @property int $iso
 * @property string $iso_alpha2
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Gdinko\DynamicExpress\Models\CarrierDynamicExpressCity[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Gdinko\DynamicExpress\Models\CarrierDynamicExpressOffice[] $offices
 * @property-read int|null $offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereIsoAlpha2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarrierDynamicExpressCountry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarrierDynamicExpressCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'iso',
        'iso_alpha2',
        'name',
    ];

    public function cities()
    {
        return $this->hasMany(
            CarrierDynamicExpressCity::class,
            'country_iso',
            'iso'
        );
    }

    public function offices()
    {
        return $this->hasMany(
            CarrierDynamicExpressOffice::class,
            'country_iso',
            'iso'
        );
    }
}
