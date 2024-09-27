<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $account_id
 * @property int $product_id
 * @property string $session_id
 * @property string $item
 * @property float $price
 * @property float $discount
 * @property float $vat
 * @property float $qty
 * @property float $total
 * @property string $note
 * @property mixed $options
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property Account $account
 * @property Product $product
 */
class Cart extends Model
{
    protected $fillable = [
        'account_id',
        'product_id',
        'session_id',
        'item',
        'price',
        'discount',
        'vat',
        'qty',
        'total',
        'note',
        'options',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'options' => 'json',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('filament-accounts.model'));
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
