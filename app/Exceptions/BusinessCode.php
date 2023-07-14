<?php

namespace App\Exceptions;

class BusinessCode
{
    public const CLIENT_ERROR = 100400;
    public const CLIENT_AUTH_FAIL = 100401;
    public const CLIENT_AUTH_LOGIN = 100404;

    // uac 验证异常
    public const CLIENT_UAC_AUTH = 100402;
    // 远程server 错误
    public const REMOTE_SERVER_FAIL = 100500;
}
