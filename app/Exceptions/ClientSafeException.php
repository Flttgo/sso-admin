<?php

namespace App\Exceptions;

use App\Traits\Response\APIResponseCode;

class ClientSafeException extends ResponsibleException
{
    public function toResponse($request)
    {
        return $this->error($this->getMessage() ?: 'Error');
    }
}
