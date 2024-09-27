<?php

namespace App\Components;

use BladeUI\Icons\Factory;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Type extends Component
{
    public ?string $r = null;

    public ?string $g = null;

    public ?string $b = null;

    public bool $iconExists = false;

    public function __construct(public \App\Models\Type $type, public ?string $label = null)
    {
        [$this->r, $this->g, $this->b] = sscanf($this->type->color, '#%02x%02x%02x');

        if ($this->type->icon) {
            try {
                app(Factory::class)->svg($this->type->icon);
                $this->iconExists = true;
            } catch (Exception $e) {
            }
        }
    }

    public function render(): View
    {
        return view('components.type');
    }
}
