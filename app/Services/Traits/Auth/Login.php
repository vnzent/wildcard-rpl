<?php

namespace App\Services\Traits\Auth;

use App\Helpers\Response;
use App\Services\Contracts\WebResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait Login
{
    public function login(Request $request, string $type = 'api'): Model|JsonResponse|WebResponse
    {
        $request->validate([
            $this->loginBy => 'required|string|max:191',
            'password' => 'required|string|min:6|max:191',
            'remember_me' => 'nullable|bool',
        ]);

        $check = auth($this->guard)->attempt([
            'username' => $request->get($this->loginBy),
            'password' => $request->get('password'),
        ]);

        if ($check) {
            $user = auth($this->guard)->user();
            if ($user->is_active && $this->otp) {
                $token = $user->createToken($this->guard)->plainTextToken;
                $user->token = $token;

                if ($type === 'api') {
                    return $user;
                } else {
                    return WebResponse::make(__('Login Success'))->success();
                }
            } elseif (! $user->is_active && $this->otp) {
                auth($this->guard)->logout();

                if ($type === 'api') {
                    return Response::errors(__('Your account is not active yet'));
                } else {
                    return WebResponse::make(__('Your account is not active yet'));
                }

            } elseif (! $this->otp) {
                if ($type === 'api') {
                    $token = $user->createToken($this->guard)->plainTextToken;
                    $user->token = $token;
                    if ($this->resource) {
                        $user = $this->resource::make($user);
                    }

                    return Response::data($user, __('Login Success'));
                } else {
                    return WebResponse::make(__('Login Success'))->success();
                }
            }
        }

        if ($type === 'api') {
            return Response::errors(__('Username Or Password Is Not Correct'));
        } else {
            return WebResponse::make(__('Username Or Password Is Not Correct'));
        }

    }
}
