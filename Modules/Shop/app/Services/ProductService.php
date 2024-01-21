<?php

namespace Modules\Shop\app\Services;

use \App\Events\ProductStored;
use Modules\Shop\app\Models\Product;

class ProductService
{

    /**
     * Create a new product
     */
    public function store($name, $product_category_id, $price, $image, $description = null):Product
    {
        $product = Product::create([
            "name" => $name,
            "product_category_id" => $product_category_id,
            "price" => $price,
            "image" => $image,
            "description" => $description
        ]);

        ProductStored::dispatch($product);

        return $product;
    }
}
