<?php

namespace App\Services\Traits;

use App\Models\Cart;
use App\Models\ProductReview;
use App\Models\Wishlist;

trait InteractsWithEcommerce
{
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
