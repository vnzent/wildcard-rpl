<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\TomatoProducts\Models\Product;

/**
 * @property int $id
 * @property int $order_id
 * @property int $account_id
 * @property int $product_id
 * @property int $refund_id
 * @property int $warehouse_move_id
 * @property string $item
 * @property float $price
 * @property float $discount
 * @property float $tax
 * @property float $total
 * @property float $returned
 * @property float $qty
 * @property float $returned_qty
 * @property bool $is_free
 * @property bool $is_returned
 * @property mixed $options
 * @property string $created_at
 * @property string $updated_at
 * @property Account $account
 * @property Order $order
 * @property Product $product
 */
class OrdersItem extends Model
{
    protected $fillable = [
        'order_id',
        'account_id',
        'product_id',
        'refund_id',
        'warehouse_move_id',
        'item',
        'price',
        'discount',
        'vat',
        'total',
        'returned',
        'qty',
        'returned_qty',
        'is_free',
        'is_returned',
        'options',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'options' => 'json',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('accounts.model'));
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
