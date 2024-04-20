<?php

namespace App\Exceptions\Http;

use App\Support\CFPException;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenException extends CFPException
{
    public function __construct(string $message = 'Forbidden')
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}
