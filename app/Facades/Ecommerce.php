<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\Ordering order()
 * @method static \App\Services\Ecommerce cart()
 * @method static \App\Services\ProductsServices product()
 * @method static \App\Services\Coupons coupon()
 */
class Ecommerce extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ecommerce';
    }
}
