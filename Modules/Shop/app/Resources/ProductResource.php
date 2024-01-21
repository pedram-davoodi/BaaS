<?php

namespace Modules\Shop\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "image" => $this->image,
            "description" => $this->description
        ];
    }
}
