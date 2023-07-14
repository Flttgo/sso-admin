<?php

namespace App\Exceptions;

use App\Traits\Response\APIResponseTrait;
use Arr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    use APIResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
        ClientSafeException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpException && ! $this->shouldReturnJson($request, $e)) {
            return parent::render($request, $e);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($this->mapException($e));

        return $this->prepareJsonResponse($request, $e);
    }

    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        if ($e instanceof AuthenticationException || $e instanceof JWTException) {
            return $this->unauthenticatedError($e->getMessage());
        }

        if ($e instanceof UnauthorizedException) {
            return $this->error('无操作权限');
        }

        if ($e instanceof NotFoundHttpException) {
            if ($e->getPrevious() && $e->getPrevious() instanceof ModelNotFoundException) {
                return $this->error('数据不存在！');
            }

            if ($e->getPrevious() && $e->getPrevious() instanceof RecordsNotFoundException) {
                return $this->error('数据未找到！');
            }
        }

        if ($e instanceof ValidationException) {
            return $this->unvalidatedError(implode(' ', Arr::flatten($e->errors())));
        }

        if ($e instanceof ThrottleRequestsException) {
            return $this->error('尝试次数超过限制，请稍后重试！');
        }

        $data = $this->convertExceptionToArray($e);

        return $this->error($data['message'], $data['data'] ?? null);
    }

    protected function convertExceptionToArray(Throwable $e): array
    {
        return \config('app.debug') ? [
            'message' => $e->getMessage() ?: '服务端发生异常',
            'data' => format_exception($e, [
                'url' => sprintf('[%s] %s', request()->method(), request()->url()),
                'trace' => collect($e->getTrace())->map(function ($trace) {
                    $trace = Arr::except($trace, ['args']);

                    if (isset($trace['file'])) {
                        $trace['file'] = str_replace(base_path(), '', $trace['file']);
                    }

                    return $trace;
                })->all(),
            ]),
        ] :
            ['message' => $this->isHttpException($e) ? $e->getStatusCode() : '服务器发生了未知的异常，请稍后再试'];
    }
}
