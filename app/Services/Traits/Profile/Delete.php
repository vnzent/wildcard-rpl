<?php

namespace App\Services\Traits\Profile;

use App\Services\Contracts\WebResponse;
use TomatoPHP\FilamentAccounts\Helpers\Response;

trait Delete
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(\Illuminate\Http\Request $request, string $type = 'api'): \Illuminate\Http\JsonResponse|WebResponse
    {
        $user = $request->user();
        $this->model::where('username', $user->username)->delete();

        if ($type === 'api') {
            return Response::success(__('Account Has Been Deleted'));
        } else {
            return WebResponse::make(__('Account Has Been Deleted'))->success();
        }

    }
}
