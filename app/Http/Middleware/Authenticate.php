<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessCode;
use App\Exceptions\BusinessException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //if (! $request->expectsJson()) {
        //    return route('login');
        //}
    }

    protected function unauthenticated($request, array $guards)
    {
       throw new BusinessException('当前登录已过期，请重新登录', BusinessCode::CLIENT_AUTH_FAIL);
    }
}
