<?php

namespace Modules\Shop\app\Services;

use App\Events\ProductDeleted;
use \App\Events\ProductStored;
use App\Repositories\ProductRepositoryInterface;
use Modules\Shop\app\Models\Product;

class ProductService
{

    /**
     * Create a new product
     */
    public function store($name, $product_category_id, $price, $image, $description):Product
    {
        $product = app(ProductRepositoryInterface::class)->create([
            "name" => $name,
            "product_category_id" => $product_category_id,
            "price" => $price,
            "image_path" => $image,
            "description" => $description
        ]);

        ProductStored::dispatch($product);

        return $product;
    }

    /**
     * Delete a product
     */
    public function delete(int $id): bool
    {
        app(ProductRepositoryInterface::class)->delete([
            'id' => $id
        ]);
        ProductDeleted::dispatch(app(ProductRepositoryInterface::class)->getOneByIdWithTrashed($id));
        return true;
    }
}
