<?php

namespace Modules\Product\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductCategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Modules\Product\app\Http\Requests\StoreProductCategoryRequest;
use Modules\Product\app\Http\Requests\UpdateProductCategoryRequest;
use Modules\Product\app\Resources\ProductCategoryCollection;
use Modules\Product\app\Resources\ProductCategoryResource;
use Modules\Product\app\Services\ProductCategoryService;

class ProductCategoryController extends Controller
{

    /**
     * Show list of product categories
     */
    public function index(
        ProductCategoryRepositoryInterface $productCategoryRepository
    ): ProductCategoryCollection
    {
        return new ProductCategoryCollection($productCategoryRepository->paginate(10));
    }

    /**
     * create new product
     */
    public function store(
        StoreProductCategoryRequest $request,
        ProductCategoryService $ProductCategoryService
    ): ProductCategoryResource
    {
        return new ProductCategoryResource($ProductCategoryService->store(
            $request->get('name')
        ));
    }


    /**
     * create new product category
     */
    public function update(
        $product_category_id ,
        UpdateProductCategoryRequest $request,
        ProductCategoryService $ProductCategoryService
    ): ProductCategoryResource
    {
        return new ProductCategoryResource($ProductCategoryService->update(
            $product_category_id,
            $request->get('name')
        ));
    }


    /**
     * Delete an existing product category
     */
    public function destroy(
        int $product_category_id ,
        ProductCategoryService $ProductCategoryService
    ): JsonResponse
    {
        $ProductCategoryService->delete($product_category_id);
        return jsonResponse(message: __('admin.productCategory.deleted'));
    }
}
