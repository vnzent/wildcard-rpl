<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\TomatoProducts\Models\Product;

/**
 * @property int $id
 * @property int $account_id
 * @property int $product_id
 * @property mixed $compare_with
 * @property string $created_at
 * @property string $updated_at
 * @property Account $account
 * @property Product $product
 */
class Comparison extends Model
{
    protected $fillable = [
        'account_id',
        'product_id',
        'compare_with',
        'created_at',
        'updated_at',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('tomato-crm.model'));
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
