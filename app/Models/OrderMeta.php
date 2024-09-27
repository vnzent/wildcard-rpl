<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @property string $key
 * @property mixed $value
 * @property string $type
 * @property string $group
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 */
class OrderMeta extends Model
{
    protected $fillable = [
        'order_id',
        'key',
        'value',
        'type',
        'group',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
