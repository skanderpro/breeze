<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
			'companyId' => $this->resource->companyId,
            'name' => $this->name,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'created_at' => $this->resource->created_at,
        ];
    }
}
