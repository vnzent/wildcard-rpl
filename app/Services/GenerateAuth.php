<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateAuth
{
    public function __construct(
        public string $guard,
        public string $loginBy,
        public string $loginType,
        public string $model,
        public ?bool $checkOTP = false,
        public ?bool $moduleBase = false,
        public ?string $moduleName = null,
    ) {}

    public function generate(): void
    {
        $loginByValidationCreate = '';
        $loginByValidationUpdate = '';

        if ($this->loginType === 'email') {
            $loginByValidationCreate = 'required|email|max:191|string';
            $loginByValidationUpdate = 'sometimes|email|max:191|string';
        } elseif ($this->loginType === 'tel') {
            $loginByValidationCreate = 'required|max:14|string';
            $loginByValidationUpdate = 'sometimes|max:14|string';
        } elseif ($this->loginType === 'text') {
            $loginByValidationCreate = 'required|max:191|string';
            $loginByValidationUpdate = 'sometimes|max:191|string';
        }

        if ($this->moduleBase) {
            $namespace = 'TomatoPHP\\'.$this->moduleName.'\\Http\\Controllers\\API\\Auth';
            $path = module_path($this->moduleName).'/Http/Controllers/API/Auth';
            $this->checkFolder(module_path($this->moduleName).'/Http/Controllers/API');
            $this->checkFolder(module_path($this->moduleName).'/Http/Controllers/API/Auth');
        } else {
            $namespace = 'App\\Http\\Controllers\\API\\Auth';
            $path = app_path('/Http/Controllers/API/Auth');
            $this->checkFolder(app_path('/Http/Controllers/API'));
            $this->checkFolder(app_path('/Http/Controllers/API/Auth'));
        }

        $this->copyStubToApp('BuilderController', $path.'/'.Str::ucfirst(Str::camel($this->guard)).'AuthController.php', [
            'namespacePath' => $namespace,
            'controllerName' => Str::ucfirst(Str::camel($this->guard)).'AuthController',
            'loginBy' => $this->loginBy,
            'loginType' => $this->loginType,
            'model' => $this->model,
            'guard' => $this->guard,
            'otp' => $this->checkOTP ? 'true' : 'false',
            'loginByValidationCreate' => $loginByValidationCreate,
            'loginByValidationUpdate' => $loginByValidationUpdate,
        ]);

        $this->generateRoutes();
        Artisan::call('route:clear');
    }

    protected function generateRoutes(): void
    {
        if ($this->moduleBase) {
            $namespace = 'TomatoPHP\\'.$this->moduleName.'\\Http\\Controllers\\API\\Auth';
            $path = module_path($this->moduleName).'/Routes/api.php';
        } else {
            $namespace = 'App\\Http\\Controllers\\API\\Auth';
            $path = base_path('/routes/api.php');
        }
        $api = File::get($path);
        $apiString = Str::of($api);

        $value = "\io3x1\LaravelAuthBuilder\Helpers\AuthRoutes::load('users', ".$namespace.'\\'.Str::ucfirst(Str::camel($this->guard)).'AuthController::class);';

        if (! $apiString->contains($value)) {
            File::append($path, "\n\n".$value);
        }
    }

    protected function checkFolder(string $path): void
    {
        $checkPath = File::exists($path);
        if (! $checkPath) {
            File::makeDirectory($path);
        }
    }

    protected function copyStubToApp(string $stub, string $targetPath, array $replacements = [], string $customPath = '/../../stubs/'): void
    {
        $stubPath = __DIR__.$customPath.$stub.'.stub';
        $checkDirectory = File::exists(__DIR__.$customPath.$stub.'.stub');
        if ($checkDirectory) {
            $stub = Str::of(File::get($stubPath));

            foreach ($replacements as $key => $replacement) {
                $stub = $stub->replace("{{ {$key} }}", $replacement);
            }

            $stub = (string) $stub;

            $this->writeFile($targetPath, $stub);
        }
    }

    protected function writeFile(string $path, string $contents): void
    {
        $filesystem = app(Filesystem::class);

        $filesystem->ensureDirectoryExists(
            (string) Str::of($path)
                ->beforeLast('/'),
        );

        $filesystem->put($path, $contents);
    }
}
