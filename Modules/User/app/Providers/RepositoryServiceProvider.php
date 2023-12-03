<?php

namespace Modules\User\app\Providers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\User\app\Repository\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, fn () => new UserRepository());

    }
}
