<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientSafeException;
use App\Http\Resources\User\UserResource;
use Cache;
use Exception;
use Illuminate\Cache\RedisLock;
use IRedis;

class AuthController extends Controller
{
    /**
     * @throws \App\Exceptions\ClientSafeException
     */
    public function login()
    {
        $account = request('account');
        $credentials = [
            'account' => request('account'),
            'password' => request('password')
        ];
        // 根据登录名字判断
        if (!config('app.enable_login') && $account !== config('app.admin_name')) {
            throw new ClientSafeException('请联系管理员配置登录入口');
        }

        $lock = Cache::lock('login:account:'.$account, 10);

        try {
            if (!$lock->get()) {
                throw new ClientSafeException('服务器繁忙,请稍等片刻！');
            }

            if (! $token = auth('api')->attempt($credentials)) {
                return $this->error('用户名和密码错误');
            }
            $res = $this->loginSuccess($token);
            $lock->release();

            return $this->success($res);
        } catch (Exception $exception) {
            throw new ClientSafeException($exception->getMessage());
        } finally {
            $lock->release();
        }
    }

    public function me()
    {
        return $this->success(new UserResource(user()));
    }

    public function logout()
    {
        auth('api')->logout();

        return $this->success();
    }
}
