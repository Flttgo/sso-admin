<?php

use Illuminate\Validation\UnauthorizedException;


if (! function_exists('is_local')) {
    function is_local(): bool
    {
        return app()->environment('local');
    }
}

if (! function_exists('is_prod')) {
    function is_prod(): bool
    {
        return app()->environment('production');
    }
}

if (! function_exists('can')) {
    /**
     * 检测用户操作权限.如: user.index 参考 permission-setting 配置文件.
     *
     * @param $abilities
     * @param  bool  $throw
     * @return bool
     *
     * @throw UnauthorizedException
     */
    function can($abilities, bool $throw = true): bool
    {
        $bool = optional(\user())->can($abilities);

        if ($bool) {
            return true;
        }

        if (! $throw) {
            return false;
        }

        throw new UnauthorizedException($abilities);
    }
}

if (! function_exists('throw_can')) {
    /**
     * 检测用户操作权限.
     *
     * @param  bool  $bool
     * @return bool
     *
     * @throws \Throwable
     * @throw UnauthorizedException
     */
    function throw_can(bool $bool = false)
    {
        throw_if(! $bool, new UnauthorizedException('无操作权限'));

        return true;
    }
}

if (! function_exists('user')) {
    /**
     * 获取后台当前登录用户.
     */
    function user()
    {
        return auth('api')->user();
    }
}

if (! function_exists('user_id')) {
    /**
     * 获取后台当前登录用户ID.
     */
    function user_id()
    {
        return optional(user())->id;
    }
}

if (! function_exists('format_exception')) {
    /**
     * 格式化异常数据.
     */
    function format_exception(Throwable $e, array $appends = []): array
    {
        return array_merge([
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => sprintf('%s:%s', str_replace(base_path(), '', $e->getFile()), $e->getLine()),
        ], $appends);
    }
}

if (! function_exists('clusters')) {
    function clusters()
    {
        $envHosts = env('REDIS_CLUSTER_HOSTS');
        $envPort = env('REDIS_CLUSTER_PORTS');
        $envPass = env('REDIS_CLUSTER_PASSWORD');

        $hosts = explode(',', $envHosts);


        if (count($hosts) < 3) {
            throw new Exception('redis 配置错误');
        }

        $clusters = [];
        foreach ($hosts as$host) {
            $clusters[] = [
                'host' => $host,
                'password' => $envPass,
                'port' => $envPort,
                'database' => 0,
            ];
        }

        return $clusters;
    }
}
