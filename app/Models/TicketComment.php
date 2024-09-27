<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $ticket_id
 * @property string $accountable_type
 * @property int $accountable_id
 * @property string $response
 * @property string $created_at
 * @property string $updated_at
 * @property Ticket $ticket
 */
class TicketComment extends Model
{
    protected $fillable = [
        'ticket_id',
        'accountable_type',
        'accountable_id',
        'response',
        'created_at',
        'updated_at',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
