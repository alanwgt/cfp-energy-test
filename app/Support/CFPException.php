<?php

namespace App\Support;

use App\Http\Resources\ErrorResource;
use Illuminate\Http\JsonResponse;

abstract class CFPException extends \Exception implements \Throwable
{
    public function render(): JsonResponse
    {
        return response()->json(ErrorResource::make($this), $this->getCode());
    }

    public function getStatusCode(): int
    {
        return $this->getCode();
    }
}
