<?php

namespace Modules\Order\app\Providers;


use App\Repositories\OrderItemRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Order\app\Repository\Eloquent\OrderItemRepository;
use Modules\Order\app\Repository\Eloquent\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(OrderItemRepositoryInterface::class, fn () => new OrderItemRepository(new OrderItem()));
        $this->app->singleton(OrderRepositoryInterface::class, fn () => new OrderRepository(new Order()));
    }
}
