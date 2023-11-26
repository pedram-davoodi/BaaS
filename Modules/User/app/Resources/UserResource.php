<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            "email_verified_at"=> $this->email_verified_at,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
