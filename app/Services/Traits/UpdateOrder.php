<?php

namespace App\Services\Traits;

use App\Models\Order;
use Illuminate\Http\Request;

trait UpdateOrder
{
    public function update(Request $request): Order
    {
        $this->handleRequest($request);
        $this->validate($request, true);
        $this->order->update($request->all());
        $this->syncItems($request, true);
        $this->syncMeta($request);

        $this->log(__('Order Has Been Updated'));

        return $this->order;
    }
}
