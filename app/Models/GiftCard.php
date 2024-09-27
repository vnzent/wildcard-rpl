<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $code
 * @property float $balance
 * @property string $currency
 * @property bool $is_activated
 * @property bool $is_expired
 * @property string $created_at
 * @property string $updated_at
 * @property Account $account
 */
class GiftCard extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'account_id',
        'name',
        'code',
        'balance',
        'currency',
        'is_activated',
        'is_expired',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_activated' => 'boolean',
        'is_expired' => 'boolean',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('accounts.model'));
    }
}
