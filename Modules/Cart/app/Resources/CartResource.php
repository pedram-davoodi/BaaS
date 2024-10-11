<?php

namespace Modules\Cart\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $items = json_decode($this->items);
        return [
            "user_id" => $this->user_id,
            'count' => count($items),
            "items" => $items
        ];
    }
}
