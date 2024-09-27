<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Company $company_id
 * @property int $branch_number
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice[] $invoices
 * @property Order[] $orders
 */
class Branch extends Model
{
    protected $fillable = [
        'company_id',
        'branch_number',
        'name',
        'phone',
        'address',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
