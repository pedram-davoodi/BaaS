<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlockedAccountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection
        ];
    }
}
