<?php

namespace App\Services;

use App\Services\Traits\Auth\Login;
use App\Services\Traits\Auth\Otp;
use App\Services\Traits\Auth\Register;
use App\Services\Traits\Auth\ResetPassword;
use App\Services\Traits\Profile\Delete;
use App\Services\Traits\Profile\Logout;
use App\Services\Traits\Profile\Update;
use App\Services\Traits\Profile\User;

class BuildAuth
{
    use Delete;
    use Login;
    use Logout;
    use Otp;
    use Register;
    use ResetPassword;
    use Update;
    use User;

    public function __construct(
        /**
         * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?string $guard = 'web',
        /**
         * @var bool|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?bool $otp = true,
        /**
         * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?string $model = "App\Models\User",
        /**
         * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?string $loginBy = 'email',
        /**
         * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?string $loginType = 'email',
        public ?string $resource = null,
        /**
         * @var array|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
         */
        public ?array $createValidation = [],
        public ?array $updateValidation = [],
    ) {}

    public function guard(string $guard): static
    {
        $this->guard = $guard;

        return $this;
    }

    public function requiredOtp(bool $otp): static
    {
        $this->otp = $otp;

        return $this;
    }

    public function model(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function loginBy(string $loginBy): static
    {
        $this->loginBy = $loginBy;

        return $this;
    }

    public function loginType(string $loginType): static
    {
        $this->loginType = $loginType;

        return $this;
    }

    public function resource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function createValidation(array $createValidation): static
    {
        $this->createValidation = $createValidation;

        return $this;
    }

    public function updateValidation(array $updateValidation): static
    {
        $this->updateValidation = $updateValidation;

        return $this;
    }
}
