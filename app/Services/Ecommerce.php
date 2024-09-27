<?php

namespace App\Services;

use App\Models\Cart;
use App\Services\Traits\StoreCart;
use App\Services\Traits\UpdateQTY;

class Ecommerce
{
    use StoreCart;
    use UpdateQTY;

    private Cart $cart;

    public function setCart(Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }
}
