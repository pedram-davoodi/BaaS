<?php

namespace Modules\Shop\app\Services;

use App\Events\ProductDeleted;
use \App\Events\ProductStored;
use App\Events\ProductUpdated;
use App\ModelInterfaces\ProductModelInterface;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{

    /**
     * Create a new product
     */
    public function store($name, $product_category_id, $price, $image, $description): ProductModelInterface
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
     * Update an existing product
     */
    public function update($product_id, $name, $product_category_id, $price, $image, $description): ProductModelInterface
    {
        app(ProductRepositoryInterface::class)->update([
                "name" => $name,
                "product_category_id" => $product_category_id,
                "price" => $price,
                "image_path" => $image,
                "description" => $description
            ],
            [
                'id' => $product_id
            ]
        );
        ProductUpdated::dispatch($product = app(ProductRepositoryInterface::class)->getOneById($product_id));

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
