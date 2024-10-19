<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'code',
        'total_amount',
        'discount',
        'grand_total',
        'cashier_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $lastId = self::latest('id')->first()->id ?? 0;

            $model->code = sprintf('XNX-%s-%s', date('Ymd'), str_pad(++$lastId, 3, '0', STR_PAD_LEFT));
        });
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
