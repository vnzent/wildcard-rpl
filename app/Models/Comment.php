<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property int $content_id
 * @property string $content_type
 * @property string $comment
 * @property float $rate
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'content_id',
        'content_type',
        'comment',
        'rate',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    public function content(): MorphTo
    {
        return $this->morphTo('content');
    }
}
