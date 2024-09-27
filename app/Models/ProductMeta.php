<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property string $key
 * @property mixed $value
 * @property int $model_id
 * @property string $model_type
 * @property string $created_at
 * @property string $updated_at
 * @property Product $product
 */
class ProductMeta extends Model
{
    protected $fillable = [
        'product_id',
        'key',
        'value',
        'model_id',
        'model_type',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
