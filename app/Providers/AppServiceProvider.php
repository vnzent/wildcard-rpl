<?php

namespace App\Providers;

use App\Services\TypesRegister;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('types', function () {
            return new TypesRegister;
        });
    }

    public function boot(): void
    {
        //
    }
}
