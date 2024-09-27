<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $type_id
 * @property string $accountable_type
 * @property int $accountable_id
 * @property string $name
 * @property string $phone
 * @property string $subject
 * @property string $code
 * @property string $message
 * @property string $last_update
 * @property bool $is_closed
 * @property string $created_at
 * @property string $updated_at
 * @property TicketComment[] $ticketComments
 * @property Type $type
 */
class Ticket extends Model
{
    protected $fillable = [
        'type_id',
        'accountable_type',
        'accountable_id',
        'name',
        'phone',
        'subject',
        'code',
        'message',
        'last_update',
        'is_closed',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    public function ticketComments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
}
