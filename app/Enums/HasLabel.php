<?php

namespace App\Enums;

trait HasLabel
{
    public function getLabel(): string
    {
        return str($this->name)->upper()->replace('_', ' ')->toString();
    }
}
