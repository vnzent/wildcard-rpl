<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TomatoPHP\FilamentLocations\Models\Area;
use TomatoPHP\FilamentLocations\Models\City;
use TomatoPHP\FilamentLocations\Models\Country;
use TomatoPHP\FilamentLocations\Models\Location;

/**
 * @property int $id
 * @property int $user_id
 * @property int $country_id
 * @property int $area_id
 * @property int $city_id
 * @property int $address_id
 * @property int $account_id
 * @property int $cashier_id
 * @property int $coupon_id
 * @property int $shipper_id
 * @property int $shipping_vendor_id
 * @property int $branch_id
 * @property string $uuid
 * @property string $type
 * @property string $name
 * @property string $phone
 * @property string $flat
 * @property string $address
 * @property string $source
 * @property string $shipper_vendor
 * @property float $total
 * @property float $discount
 * @property float $shipping
 * @property float $vat
 * @property string $status
 * @property bool $is_approved
 * @property bool $is_closed
 * @property bool $is_on_table
 * @property string $table
 * @property string $notes
 * @property bool $has_returns
 * @property float $return_total
 * @property string $reason
 * @property bool $is_payed
 * @property string $payment_method
 * @property string $payment_vendor
 * @property string $payment_vendor_id
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice[] $invoices
 * @property OrderLog[] $orderLogs
 * @property OrderMeta[] $orderMetas
 * @property Account $customer
 * @property Location $location
 * @property Area $area
 * @property Branch $branch
 * @property User $user
 * @property City $city
 * @property Country $country
 * @property Coupon $coupon
 * @property Delivery $delivery
 * @property ShippingVendor $shippingVendor
 * @property User $cashier
 * @property OrdersItem[] $ordersItems
 */
class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'company_id',
        'user_id',
        'country_id',
        'area_id',
        'city_id',
        'address_id',
        'account_id',
        'cashier_id',
        'coupon_id',
        'shipper_id',
        'shipping_vendor_id',
        'branch_id',
        'uuid',
        'type',
        'name',
        'phone',
        'flat',
        'address',
        'source',
        'shipper_vendor',
        'total',
        'discount',
        'shipping',
        'vat',
        'status',
        'is_approved',
        'is_closed',
        'is_on_table',
        'table',
        'notes',
        'has_returns',
        'return_total',
        'reason',
        'is_payed',
        'payment_method',
        'payment_vendor',
        'payment_vendor_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_approved' => 'bool',
        'is_closed' => 'bool',
        'is_on_table' => 'bool',
        'has_returns' => 'bool',
        'is_payed' => 'bool',
    ];

    public function orderLogs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }

    public function orderMetas(): HasMany
    {
        return $this->hasMany(OrderMeta::class);
    }

    /**
     * @param  string|null  $value
     * @return Model|string
     */
    public function meta(string $key, mixed $value = null): mixed
    {
        if ($value) {
            return $this->orderMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
        } else {
            return $this->orderMetas()->where('key', $key)->firstOrCreate()?->value;
        }
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('accounts.model'), 'account_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'address_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function shipper(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'shipper_id');
    }

    public function shippingVendor(): BelongsTo
    {
        return $this->belongsTo(ShippingVendor::class, 'shipping_vendor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ordersItems(): HasMany
    {
        return $this->hasMany(OrdersItem::class);
    }
}
