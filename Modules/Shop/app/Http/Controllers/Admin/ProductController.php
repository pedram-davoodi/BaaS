<?php

namespace Modules\Shop\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Shop\app\Http\Requests\StoreProductRequest;
use Modules\Shop\app\Resources\ProductResource;
use Modules\Shop\app\Services\ProductService;

class ProductController extends Controller
{
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
}
