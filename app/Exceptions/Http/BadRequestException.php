<?php

namespace App\Exceptions\Http;

use App\Support\CFPException;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends CFPException
{
    public function __construct(string $message = 'Bad Request')
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
