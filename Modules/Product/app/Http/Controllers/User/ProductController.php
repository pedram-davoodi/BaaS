<?php

namespace Modules\Product\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositoryInterface;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Resources\ProductCollection;
use Modules\Product\app\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Show list of all available products
     *
     * @param ProductRepositoryInterface $productRepository
     * @return ProductCollection
     */
    public function index(ProductRepositoryInterface $productRepository): ProductCollection
    {
        return new ProductCollection($productRepository->paginate(10));
    }

    /**
     * show a single product detail
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
