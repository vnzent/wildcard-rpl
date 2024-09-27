<?php

namespace App\Services\Traits;

use App\Models\Order;
use Illuminate\Http\Request;

trait StoreOrder
{
    public function store(Request $request): Order
    {
        $this->handleRequest($request);
        $this->validate($request);
        $this->order->fill($request->all());
        $this->order->save();
        $this->syncItems($request);
        $this->syncMeta($request);

        $this->log(__('Order Has Been Created From Dashboard'));

        return $this->order;
    }
}
