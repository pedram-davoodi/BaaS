<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'mobile' => $this->mobile,
            'address' => $this->address,
        ];
    }
}
