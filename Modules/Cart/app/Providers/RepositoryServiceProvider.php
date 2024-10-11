<?php

namespace Modules\Cart\app\Providers;


use App\Repositories\CartRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Cart\app\Models\Cart;
use Modules\Cart\app\Repository\Eloquent\CartRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(CartRepositoryInterface::class, fn () => new CartRepository(new Cart()));
    }
}
