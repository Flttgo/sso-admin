<?php

namespace App\Traits;

use Carbon\Carbon;

trait LoginTrait
{
    protected function loginSuccess($token)
    {
        /** @var \App\Models\User $user */
        $user = user();

        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        if ($userToken = $user->last_token_id) {
            $guard = auth('api');
            /** @var \Tymon\JWTAuth\Providers\JWT\Lcobucci $lco */
            $lco = app('tymon.jwt.provider.jwt.lcobucci');
            $res = $lco->decode($userToken)['exp'] ?? 0;
            if ($res) {
                $blackTTL = config('jwt.blacklist_grace_period');
                $oldTime = Carbon::parse($res + $blackTTL);
                // 如果重新登录之前的token  如果还在黑名单保护期，则无效掉
                if ($oldTime->isFuture()) {
                    $guard->setToken($userToken)->invalidate();
                }
            }
        }
        // 登录之后存入新的token
        $user->update([
            'last_token_id' => $token
        ]);

        $ttl = auth('api')->factory()->getTTL();

        $leeway = config('jwt.leeway');


        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expire_in' => ($ttl * 60) + $leeway,
            'sso_home' => config('app.sso_home_url')
        ];
    }
}
