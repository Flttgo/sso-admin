<?php

namespace App\Traits\Response;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait APIResponseTrait
{
    protected function success($data = null, $message = 'success'): JsonResponse
    {
        if ($data instanceof Paginator) {
            return $this->pagingSuccess(...func_get_args());
        }

        if (is_string($data) && 1 === count(func_get_args())) {
            $message = $data;
            $data = null;
        }

        return $this->sendResponse($data, $message, APIResponseCode::SUCCESS);
    }

    protected function error($message = 'error', $data = null, $code = APIResponseCode::ERROR): JsonResponse
    {
        return $this->sendResponse($data, $message, $code);
    }

    protected function unauthenticatedError($message = '登录信息已过期, 请重新登录！'): JsonResponse
    {
        return $this->sendResponse(null, $message, APIResponseCode::UNAUTHENTICATED);
    }

    protected function unvalidatedError($message): JsonResponse
    {
        return $this->sendResponse(null, $message, APIResponseCode::UNVALIDATED);
    }

    protected function pagingSuccess(Paginator $paginator, $meta = [], $message = 'success'): JsonResponse
    {
        /* @var \Illuminate\Pagination\AbstractPaginator $paginator*/
        $data = $paginator->getCollection();

        $currentPage = $paginator->currentPage();
        $pageMeta = [
            'page' => $currentPage,
            'page_size' => $paginator->perPage(),
            'has_more' => $paginator->hasMorePages(),
        ];

        if (is_a($paginator, LengthAwarePaginator::class)) {
            $pageMeta['total'] = (int) $paginator->total();
        }

        $meta = array_merge($meta, $pageMeta);

        return $this->sendResponse($data, $message, APIResponseCode::SUCCESS, $meta);
    }

    private function sendResponse($data, $message, $code, $meta = null): JsonResponse
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        if ($meta) {
            $data['meta'] = $meta;
        }

        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
    }
}
