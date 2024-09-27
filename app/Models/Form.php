<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $key
 * @property string $endpoint
 * @property string $method
 * @property string $description
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class Form extends Model
{
    use HasTranslations;

    protected $fillable = [
        'type',
        'name',
        'key',
        'endpoint',
        'method',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public array $translatable = [
        'title',
        'description',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(FormOption::class, 'form_id', 'id')->orderBy('order');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(FormRequest::class, 'form_id', 'id');
    }
}
