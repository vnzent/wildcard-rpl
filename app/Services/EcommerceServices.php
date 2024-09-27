<?php

namespace App\Services;

use App\Services\Cart\ProductsServices;

class EcommerceServices
{
    public function order(): Ordering
    {
        return new Ordering;
    }

    public function cart(): Ecommerce
    {
        return new Ecommerce;
    }

    public function product(): ProductsServices
    {
        return new ProductsServices;
    }

    public function coupon(): Coupons
    {
        return new Coupons;
    }
}
