<?php

namespace App\Http\Resources;

use Error;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
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
        if ($this->resource instanceof QueryException) {
            $message = 'Database error';
        } elseif ($this->resource instanceof ValidationException) {
            $message = $this->resource->errors();
        } else {
            $message = $this->resource->getMessage();
        }

        return [
            'message' => $message,
        ];
    }
}
