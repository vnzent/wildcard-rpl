<?php

namespace App\Generator\Traits;

trait GenerateReadMe
{
    private function generateReadMe(): void
    {
        //Generate Readme.md file
        $this->generateStubs(
            $this->stubPath.'readme.stub',
            base_path('Modules').'/'.$this->themeName.'/README.md',
            [
                'name' => $this->themeName,
                'description' => $this->themeDescription,
            ],
            [
                base_path('Modules'),
                base_path('Modules').'/'.$this->themeName,
            ]
        );
    }
}
