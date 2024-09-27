<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $status
 * @property string $note
 * @property bool $is_closed
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 * @property User $user
 */
class OrderLog extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'status',
        'note',
        'is_closed',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
