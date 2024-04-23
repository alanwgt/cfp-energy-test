<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
class UserDetailedResource extends JsonResource
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
            'email' => $this->resource->email,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'username' => $this->resource->username,
            'phone_number' => $this->resource->phone_number,
            'date_of_birth' => $this->resource->date_of_birth,
            'verified' => $this->resource->email_verified_at !== null,
            'role' => $this->resource->role->value,
            'authentication_method' => $this->resource->authentication_method->value,
        ];
    }
}
