<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property bool $is_activated
 * @property string $created_at
 * @property string $updated_at
 * @property Order[] $orders
 * @property ShippingPrice[] $shippingPrices
 */
class Delivery extends Model
{
    protected $fillable = [
        'shipping_vendor_id',
        'name',
        'phone',
        'address',
        'is_activated',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_activated' => 'boolean',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(ShippingVendor::class, 'shipping_vendor_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shipper_id');
    }

    public function shippingPrices(): HasMany
    {
        return $this->hasMany(ShippingPrice::class, 'shipper_id');
    }
}
