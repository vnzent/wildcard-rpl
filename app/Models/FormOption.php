<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class FormOption extends Model
{
    use HasTranslations;

    protected $fillable = [
        'sub_form',
        'form_id',
        'type',
        'group',
        'label',
        'name',
        'placeholder',
        'required_message',
        'hint',
        'default',
        'has_options',
        'has_validation',
        'is_required',
        'is_multi',
        'created_at',
        'updated_at',
        'is_reactive',
        'reactive_field',
        'reactive_where',
        'is_relation',
        'relation_name',
        'relation_column',
        'options',
        'validation',
        'meta',
        'order',
    ];

    protected $casts = [
        'default' => 'json',
        'options' => 'array',
        'validation' => 'array',
        'lable' => 'array',
        'hint' => 'array',
        'placeholder' => 'array',
        'required_message' => 'array',
        'reactive_where' => 'array',
        'has_options' => 'boolean',
        'has_validation' => 'boolean',
        'is_required' => 'boolean',
        'is_multi' => 'boolean',
        'is_reactive' => 'boolean',
        'is_from_table' => 'boolean',
    ];

    public array $translatable = [
        'label',
        'hint',
        'placeholder',
        'required_message',
    ];

    public function subForm(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'sub_form', 'id');
    }
}
