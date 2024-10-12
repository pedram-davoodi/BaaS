<?php

namespace Modules\Cart\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        if (!isset($this?->items))
            $items = [];
        else
            $items = json_decode($this?->items);

        return [
            "user_id" => Auth::id(),
            'count' => count($items),
            "items" => $items
        ];
    }
}
