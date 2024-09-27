<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $contact_person
 * @property string $phone
 * @property string $address
 * @property bool $is_activated
 * @property mixed $integration
 * @property string $created_at
 * @property string $updated_at
 * @property Order[] $orders
 * @property ShippingPrice[] $shippingPrices
 */
class ShippingVendor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'price',
        'name',
        'delivery_estimation',
        'contact_person',
        'phone',
        'address',
        'is_activated',
        'integration',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_activated' => 'boolean',
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function shippingPrices(): HasMany
    {
        return $this->hasMany(ShippingPrice::class);
    }
}
