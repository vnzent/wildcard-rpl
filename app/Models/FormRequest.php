<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property int $form_id
 * @property string $model_type
 * @property int $model_id
 * @property string $service_type
 * @property int $service_id
 * @property string $description
 * @property string $date
 * @property string $time
 * @property string $status
 * @property mixed $payload
 * @property string $created_at
 * @property string $updated_at
 * @property Form $form
 */
class FormRequest extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'form_id',
        'model_type',
        'model_id',
        'service_type',
        'service_id',
        'description',
        'date',
        'time',
        'status',
        'payload',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function formRequestsMetas(): HasMany
    {
        return $this->hasMany(FormRequestMeta::class, 'form_request_id');
    }

    public function meta(string $key, ?string $value = null): Model|string|null
    {
        if ($value) {
            return $this->formRequestsMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
        } else {
            return $this->formRequestsMetas()->where('key', $key)->first()?->value;
        }
    }

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function serviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
