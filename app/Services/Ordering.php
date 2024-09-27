<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Traits\CheckBalance;
use App\Services\Traits\DeleteOrder;
use App\Services\Traits\FindOrder;
use App\Services\Traits\GenerateUUID;
use App\Services\Traits\GetShippingPrice;
use App\Services\Traits\HandleRequest;
use App\Services\Traits\InventoryCheck;
use App\Services\Traits\Logger;
use App\Services\Traits\Shipping;
use App\Services\Traits\StatusUpdate;
use App\Services\Traits\StoreOrder;
use App\Services\Traits\StoreWebOrder;
use App\Services\Traits\SyncCart;
use App\Services\Traits\SyncItems;
use App\Services\Traits\SyncMeta;
use App\Services\Traits\UpdateAccountMeta;
use App\Services\Traits\UpdateOrder;
use App\Services\Traits\ValidateOrder;

class Ordering
{
    use CheckBalance;
    use DeleteOrder;
    use FindOrder;
    use GenerateUUID;
    use GetShippingPrice;
    use HandleRequest;
    use InventoryCheck;
    use Logger;
    use Shipping;
    use StatusUpdate;
    use StoreOrder;
    use StoreWebOrder;
    use SyncCart;
    use SyncItems;
    use SyncMeta;
    use UpdateAccountMeta;
    use UpdateOrder;
    use ValidateOrder;

    private Order $order;

    public function __construct()
    {
        $this->order = new Order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
