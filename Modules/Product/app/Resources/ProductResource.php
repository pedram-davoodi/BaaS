<?php

namespace Modules\Product\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            "name" => $this->name,
            "product_category_id" => $this->product_category_id,
            "price" => $this->price,
            "image_url" => Storage::disk('public')->url($this->image_path),
            "description" => $this->description
        ];
    }
}
