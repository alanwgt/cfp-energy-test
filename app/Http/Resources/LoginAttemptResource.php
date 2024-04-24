<?php

namespace App\Http\Resources;

use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property LoginAttempt $resource
 */
class LoginAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'ip_address' => $this->resource->ip_address,
            'user_agent' => $this->resource->user_agent,
            'attempted_at' => $this->resource->attempted_at,
            'succeeded' => $this->resource->succeeded,
        ];
    }
}
