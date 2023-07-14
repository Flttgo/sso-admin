<?php

namespace App\Traits\Response;

class APIResponseCode
{
    /**
     * 成功状态码，非0都表示失败.
     */
    public const SUCCESS = 0;

    /**
     * 错误状态码
     */
    public const ERROR = 1;

    /**
     * 未登录状态码
     */
    public const UNAUTHENTICATED = -1;

    /**
     * 请求验证未通过.
     */
    public const UNVALIDATED = 422;
}
