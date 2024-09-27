<?php

namespace App\Services\Traits\Profile;

use App\Services\Contracts\WebResponse;
use TomatoPHP\FilamentAccounts\Helpers\Response;

trait Logout
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(\Illuminate\Http\Request $request, string $type = 'api'): \Illuminate\Http\JsonResponse|WebResponse
    {
        auth($this->guard)->logout();

        if ($type === 'api') {
            $user = $this->model::find($request->user()->id);
            $user->tokens()->delete();

            return Response::success('Logout Success');
        } else {
            return WebResponse::make(__('Logout Success'))->success();
        }
    }
}
