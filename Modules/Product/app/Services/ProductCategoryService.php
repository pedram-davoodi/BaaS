<?php

namespace Modules\Product\app\Services;

use App\Events\ProductCategoryDeleted;
use App\Events\ProductCategoryStored;
use App\Events\ProductCategoryUpdated;
use App\ModelInterfaces\ProductCategoryModelInterface;
use App\Repositories\ProductCategoryRepositoryInterface;

class ProductCategoryService
{
    /**
     * Create a new product category
     */
    public function store(string $name): ProductCategoryModelInterface
    {
        $productCategory = app(ProductCategoryRepositoryInterface::class)->create([
            'name' => $name
        ]);
        ProductCategoryStored::dispatch($productCategory);
        return $productCategory;
    }

    /**
     * Update an existing product category
     */
    public function update(int $id , string $name): ProductCategoryModelInterface
    {
        $productCategoryRepository = app(ProductCategoryRepositoryInterface::class);
        app(ProductCategoryRepositoryInterface::class)->update(['name' => $name] , ["id" => $id]);
        ProductCategoryUpdated::dispatch($productCategory = $productCategoryRepository->getOneByIdOrFail($id));
        return $productCategory;
    }

    /**
     * Delete a product category
     */
    public function delete(int $id): bool
    {
        $productCategoryRepository = app(ProductCategoryRepositoryInterface::class);
        $productCategory = $productCategoryRepository->delete(["id" => $id]);
        ProductCategoryDeleted::dispatch($productCategoryRepository->getOneByIdOrFailWithTrashed($id));
        return $productCategory;
    }
}
