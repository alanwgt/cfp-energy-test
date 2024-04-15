<?php

namespace App\Exceptions\Http;

use App\Support\CFPException;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends CFPException
{
    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED);
    }
}
