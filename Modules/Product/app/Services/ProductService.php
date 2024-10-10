<?php

namespace Modules\Product\app\Services;

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
    public function store(string $name, int $product_category_id, int $price, string $image, string $description , ?int $stock = 0): ProductModelInterface
    {
        $product = app(ProductRepositoryInterface::class)->create([
            "name" => $name,
            "product_category_id" => $product_category_id,
            "price" => $price,
            "image_path" => $image,
            "stock" => $stock,
            "description" => $description
        ]);

        ProductStored::dispatch($product);

        return $product;
    }

    /**
     * Update an existing product
     */
    public function update(int $product_id, string $name, int $product_category_id, int $price, string $image, string $description , ?int $stock= 0): ProductModelInterface
    {
        app(ProductRepositoryInterface::class)->update([
                "name" => $name,
                "product_category_id" => $product_category_id,
                "price" => $price,
                "image_path" => $image,
                "stock" => $stock,
                "description" => $description
            ],
            [
                'id' => $product_id
            ]
        );
        ProductUpdated::dispatch($product = app(ProductRepositoryInterface::class)->getOneByIdOrFail($product_id));

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
        ProductDeleted::dispatch(app(ProductRepositoryInterface::class)->getOneByIdOrFailWithTrashed($id));
        return true;
    }
}
