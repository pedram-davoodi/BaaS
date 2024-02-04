<?php

namespace Modules\Shop\app\Providers;


use App\Repositories\ProductCategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;
use Modules\Shop\app\Repository\Eloquent\ProductCategoryRepository;
use Modules\Shop\app\Repository\Eloquent\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(ProductCategoryRepositoryInterface::class, fn () => new ProductCategoryRepository(new ProductCategory()));
        $this->app->singleton(ProductRepositoryInterface::class, fn () => new ProductRepository(new Product()));
    }
}
