<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $code
 * @property float $counter
 * @property bool $is_activated
 * @property bool $is_public
 * @property string $created_at
 * @property string $updated_at
 * @property Account $account
 */
class ReferralCode extends Model
{
    protected $fillable = [
        'account_id',
        'name',
        'code',
        'counter',
        'is_activated',
        'is_public',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_activated' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(config('accounts.model'));
    }
}
