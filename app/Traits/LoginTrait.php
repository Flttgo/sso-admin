<?php

namespace App\Traits;

use Carbon\Carbon;
use Str;

trait LoginTrait
{
    protected function loginSuccess($token)
    {
        /** @var \App\Models\User $user */
        $user = user();

        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        if ($userToken = $user->user_token_id) {
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
            'user_token_id' => $token
        ]);

        $ttl = auth('api')->factory()->getTTL();

        $leeway = config('jwt.leeway');

        $username = $user->user_username;
        $name = base64_encode($username).'.'.Str::random(12);

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expire_in' => ($ttl * 60) + $leeway,
            'code' => $name,
            'username' => $username,
            'auth_key' => $user->user_auth_key,
            'sso_home' => config('app.sso_home_url')
        ];
    }
}
