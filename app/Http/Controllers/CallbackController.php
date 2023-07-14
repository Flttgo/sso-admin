<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessCode;
use App\Exceptions\BusinessException;
use App\Exceptions\ClientSafeException;
use App\Exceptions\RemoteHttpException;
use Cache;
use Exception;
use Http;
use Illuminate\Cache\RedisLock;
use IRedis;
use Log;

class CallbackController extends Controller
{
    //
    /**
     * @throws \App\Exceptions\BusinessException
     */
    public function valid()
    {
        $serialNumber = request('sid');

        $lock = Cache::lock('callback:valid:'.$serialNumber, 10);
        try {
            if (!$serialNumber) {
                throw new ClientSafeException('缺少验证用户信息参数');
            }

            if (!$lock->get()) {
                throw new ClientSafeException('服务器繁忙，请稍后重试');
            }

            // 发送请求交换用户验证信息


            $credentials = [
                'account' => $serialNumber,
                // 控制自定义驱动的参数
                'is_callback' => true,
            ];

            if (! $token = auth('api')->attempt($credentials)) {
                throw new ClientSafeException('风控用户认证失败');
            }

            $res = $this->loginSuccess($token);

            $lock->release();

            return $this->success($res);
        } catch (Exception $exception) {
            Log::error('用户认证失败:'.$serialNumber, format_exception($exception));
            throw new BusinessException($exception->getMessage(), BusinessCode::CLIENT_UAC_AUTH);
        } finally {
            // 释放锁
            $lock->release();
        }
    }
}
