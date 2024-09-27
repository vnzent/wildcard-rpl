<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property int $user_id
 * @property int $account_request_id
 * @property int $model_id
 * @property string $model_type
 * @property string $key
 * @property mixed $value
 * @property bool $is_approved
 * @property string $is_approved_at
 * @property bool $is_rejected
 * @property string $is_rejected_at
 * @property string $rejected_reason
 * @property string $created_at
 * @property string $updated_at
 * @property AccountRequest $accountRequest
 * @property User $user
 */
class AccountRequestMeta extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'account_request_id',
        'model_id',
        'model_type',
        'key',
        'value',
        'is_approved',
        'is_approved_at',
        'is_rejected',
        'is_rejected_at',
        'rejected_reason',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'value' => 'json',
        'is_approved' => 'boolean',
    ];

    public function accountRequest(): BelongsTo
    {
        return $this->belongsTo(AccountRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
