<?php

namespace Modules\User\app\Providers;

use App\ModelInterfaces\UserModelInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\UserRepository;
use Modules\User\app\Services\AdminService;
use Modules\User\app\Services\UserService;

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
