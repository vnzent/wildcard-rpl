<?php

namespace App\Generator;

use App\Generator\Traits\GenerateInfo;
use App\Generator\Traits\GenerateModule;
use App\Generator\Traits\GenerateReadMe;
use Illuminate\Support\Str;
use TomatoPHP\ConsoleHelpers\Traits\HandleFiles;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;

class GenerateTheme
{
    use GenerateInfo;
    use GenerateModule;
    use GenerateReadMe;
    use HandleFiles;
    use HandleStub;

    public function __construct(
        private string $themeName,
        private ?string $themeDescription,
        public ?string $stubPath = null,
        public ?string $themeTitle = null
    ) {
        $this->themeTitle = $themeName;
        $this->themeName = Str::of($themeName)->camel()->ucfirst()->toString();
        $this->stubPath = __DIR__.'/../../stubs/';
        $this->publish = __DIR__.'/../../stubs/';
    }

    public function generate(): void
    {
        $this->generateModule();
        $this->generateReadMe();
        $this->generateInfo();
    }
}
