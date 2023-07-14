<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessCode;
use App\Exceptions\BusinessException;
use Closure;
use Exception;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class RefreshToken extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {

        // 使用 try 包裹，以捕捉 token 过期所抛出的 TokenExpiredException  异常
        try {
            // 检查此次请求中是否带有 token，如果没有则抛出异常。
            $this->checkForToken($request);
            // 检测用户的登录状态，如果正常则通过
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            throw new BusinessException('您当前还未登录，请前往登录', BusinessCode::CLIENT_AUTH_LOGIN);
        } catch (TokenExpiredException $exception) {
            // 此处捕获到了 token 过期所抛出的 TokenExpiredException 异常，我们在这里需要做的是刷新该用户的 token 并将它添加到响应头中
            /*
             * token在刷新期内，是可以自动执行刷新获取新的token的
             * 当JWT_BLACKLIST_ENABLED=false时，可以在JWT_REFRESH_TTL时间内，无限次刷新使用旧的token换取新的token
             * 当JWT_BLACKLIST_ENABLED=true时，刷新token后旧的token即刻失效，被放入黑名单
             * */
            // 刷新用户的 token
            try {
                $token = $this->auth->refresh();
                // 使用一次性登录以保证此次请求的成功
                auth('api')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
            } catch (Exception $exception) {
                if ($exception instanceof JWTException) {
                    throw new BusinessException('刷新Token无效，请重新登录', BusinessCode::CLIENT_AUTH_FAIL);
                }

                throw $exception;
            }

        } catch (TokenBlacklistedException $exception) {
            throw new BusinessException('Token无效，请重新登录', BusinessCode::CLIENT_AUTH_FAIL);
        } catch (JWTException $exception) {
            throw new BusinessException('您当前还未登录，请前往登录', BusinessCode::CLIENT_AUTH_LOGIN);
        }

        // 在响应头中返回新的 token
        return $this->setAuthenticationHeader($next($request), $token ?? null);
    }

    protected function setAuthenticationHeader($response, $token = null)
    {
        $token = $token ?: $this->auth->refresh();
        $response->headers->set('Authorization', $token);

        return $response;
    }
}
