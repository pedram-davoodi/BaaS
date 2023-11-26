<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockedAccountResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->user->email,
            'description' => $this->description,
            'blocked_at' => $this->created_at,
            'expired_at' => $this->expired_at,
        ];
    }
}
