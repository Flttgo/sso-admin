<?php

namespace App\Exceptions;

class BusinessException extends ResponsibleException
{
    public function toResponse($request)
    {
        return $this->error($this->getMessage() ?: 'Error', null, $this->getCode());
    }
}
