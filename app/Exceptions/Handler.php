<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use App\Support\CFPException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'otp',
    ];

    /**
     * @param  Request  $request
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($request->expectsJson()) {
            return $this->prepareJsonResponse($request, $e);
        }

        return parent::render($request, $e);
    }

    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        $status = 500;
        if ($e instanceof HttpExceptionInterface || $e instanceof CFPException) {
            $status = $e->getStatusCode();
        } elseif ($e instanceof AuthenticationException) {
            $status = Response::HTTP_UNAUTHORIZED;
        } elseif ($e instanceof ValidationException) {
            $status = Response::HTTP_BAD_REQUEST;
        }

        return response()->json(ErrorResource::make($e), $status);
    }
}
