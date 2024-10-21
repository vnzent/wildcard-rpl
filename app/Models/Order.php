<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_number',
        'status',
    ];

    protected $casts = [
        'status' => OrderStatus::class, // Cast the 'status' field to the OrderStatus enum
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $lastId = self::withTrashed()->latest('id')->first()->id ?? 0;

            $model->order_number = sprintf('JAV-%s-%s', date('Ymd'), str_pad(++$lastId, 3, '0', STR_PAD_LEFT));
        });
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function transactions(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function hasTransaction(): bool
    {
        return $this->transactions()->exists();
    }
}
