<?php

namespace App\Http\Resources\Admin\Security;

use Carbon\Carbon;
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
            'id'         => $this->resource->id,
            'name'       => $this->resource->name,
            'email'      => $this->resource->email,
            'created_at' => (string) Carbon::parse($this->resource->created_at)->format('m-d-Y'),
            'isDeleted'  => $this->resource->isDeleted,
            'role'       => $this->whenLoaded('roles', fn()=> RoleResource::make($this->resource->roles[0])),
        ];
    }
}
