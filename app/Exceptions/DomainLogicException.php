<?php

namespace App\Exceptions;

use App\Support\CFPException;
use Symfony\Component\HttpFoundation\Response;

class DomainLogicException extends CFPException
{
    /** @var int */
    protected $code = Response::HTTP_NOT_ACCEPTABLE;
}
