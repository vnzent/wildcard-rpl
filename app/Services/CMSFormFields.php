<?php

namespace App\Services;

use App\Services\Contracts\CmsFormFieldType;
use Illuminate\Support\Collection;

class CMSFormFields
{
    public static array $formFields = [];

    public static function register(CmsFormFieldType|array $field): void
    {
        if (is_array($field)) {
            foreach ($field as $type) {
                self::register($type);
            }

            return;
        }
        self::$formFields[] = $field;
    }

    public static function getOptions(): Collection
    {
        return collect(self::$formFields);
    }
}
