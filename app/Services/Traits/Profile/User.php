<?php

namespace App\Services\Traits\Profile;

use App\Services\Contracts\WebResponse;
use TomatoPHP\FilamentAccounts\Helpers\Response;

trait User
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(\Illuminate\Http\Request $request, string $type = 'api'): \Illuminate\Http\JsonResponse|WebResponse
    {
        $user = $request->user();
        if ($this->resource) {
            $user = $this->resource::make($user);
        }

        return Response::data($user, __('Profile Data Load'));
    }
}
