<?php

namespace App\Services\Traits;

use APp\Models\Order;

trait InteractsWithOrders
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
