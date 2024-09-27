<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $type_id
 * @property int $status_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property bool $active
 * @property string $created_at
 * @property string $updated_at
 * @property Status $status
 * @property Type $type
 * @property ContactsMeta[] $contactsMetas
 */
class Contact extends Model
{
    protected $fillable = [
        'type',
        'status',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function contactsMetas(): HasMany
    {
        return $this->hasMany(ContactsMeta::class);
    }
}
