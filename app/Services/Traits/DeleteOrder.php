<?php

namespace App\Services\Traits;

trait DeleteOrder
{
    public function delete(): void
    {
        $this->order->ordersItems()->delete();
        $this->order->delete();
    }
}
