<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\TomatoLocations\Models\Area;
use TomatoPHP\TomatoLocations\Models\City;
use TomatoPHP\TomatoLocations\Models\Country;

/**
 * @property int $id
 * @property int $shipping_vendor_id
 * @property int $delivery_id
 * @property int $country_id
 * @property int $city_id
 * @property int $area_id
 * @property string $type
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 * @property Area $area
 * @property City $city
 * @property Country $country
 * @property Delivery $delivery
 * @property ShippingVendor $shippingVendor
 */
class ShippingPrice extends Model
{
    protected $fillable = [
        'shipping_vendor_id',
        'delivery_id',
        'country_id',
        'city_id',
        'area_id',
        'type',
        'price',
        'created_at',
        'updated_at',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(\TomatoPHP\FilamentLocations\Models\Area::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(\TomatoPHP\FilamentLocations\Models\City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(\TomatoPHP\FilamentLocations\Models\Country::class);
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function shippingVendor(): BelongsTo
    {
        return $this->belongsTo(ShippingVendor::class);
    }
}
