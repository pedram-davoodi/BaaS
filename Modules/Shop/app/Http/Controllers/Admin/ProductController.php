<?php

namespace Modules\Shop\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Modules\Shop\app\Http\Requests\StoreProductRequest;
use Modules\Shop\app\Resources\ProductCollection;
use Modules\Shop\app\Resources\ProductResource;
use Modules\Shop\app\Services\ProductService;

class ProductController extends Controller
{

    /**
     * Show list of products
     */
    public function index(ProductRepositoryInterface $productRepository): ProductCollection
    {
        return new ProductCollection($productRepository->paginate(10));
    }

    /**
     * create new product
     */
    public function store(StoreProductRequest $request, ProductService $productService): ProductResource
    {
        return new ProductResource($productService->store(
            $request->name,
            $request->product_category_id,
            $request->price,
            saveBase64Files($request->image),
            $request->description
        ));
    }

    /**
     * Delete an existing product
     */
    public function destroy(int $product_id , ProductService $productService): JsonResponse
    {
        $productService->delete($product_id);

        return jsonResponse(message: __('admin.product.deleted'));
    }
}
