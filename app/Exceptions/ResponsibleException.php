<?php

namespace App\Exceptions;

use App\Traits\Response\APIResponseTrait;
use Exception;
use Illuminate\Contracts\Support\Responsable;

abstract class ResponsibleException extends Exception implements Responsable
{
    use APIResponseTrait;
}
