<?php

namespace App\Http\Resources;

use Error;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @property Exception|Error|Throwable $resource
 */
class ErrorResource extends JsonResource
{
    public function __construct(Exception|Error|Throwable $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (app()->isLocal()) {
            return [
                'message' => $this->resource->getMessage(),
                'exception' => get_class($this->resource),
                'file' => $this->resource->getFile(),
                'line' => $this->resource->getLine(),
                'trace' => $this->resource->getTrace(),
            ];
        }

        if ($this->resource instanceof QueryException) {
            return [
                'message' => 'Database error',
            ];
        }

        return [
            'message' => $this->resource->getMessage(),
        ];
    }
}
